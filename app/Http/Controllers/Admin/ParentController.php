<?php

namespace App\Http\Controllers\Admin;

use App\Models\ParentUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;
use App\Http\Requests\Admin\ParentFormRequest;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportParentFile;
use App\Models\ParentAddress;
use Illuminate\Support\Facades\DB;
use Session;

class ParentController extends BaseController
{
    public $viewConstant = 'admin.parents.';

    /**
     * ---------------------------------------
     * | Display list of all tuition parents |
     * |                                     |
     * | @return View                        |
     * ---------------------------------------
     */
    public function index()
    {
        $statusList = $this->properStatusActiveList();
        return view('admin.parents.index', ['statusList' => @$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Get Parent datatable                          |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $draw = intval($request->draw) + 1 ;
            $limit = @$request->length?? 10;
            $start = @$request->start ?? 0;
            $itemQuery = ParentUser::orderBy('created_at', 'DESC')
                ->where(function ($query) use ($request) {
                    // check status is not null
                    if ($request->status) {
                        $query->activeSearch($request->status);
                    }
                    // check parent is tution paprent or not
                    if ($request->is_tuition_parent) {
                        $query->where('is_tuition_parent', ($request->is_tuition_parent == config('constant.yes') ? config('constant.status_active_value') : config('constant.status_inactive_value')));
                    }
                });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $parents = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            $deactivate = $parents->where('last_sign_in_at', '<', Carbon::now()->subYears(2));
            $activates = [];
            foreach ($deactivate as $activate) {
                $activate->ExpiredStatusUpdated($activate->id);
            }
            return Datatables::of($parents)
                ->addColumn('action', function ($parent) {
                    return View::make($this->viewConstant . '_add_action', ['parent' => @$parent]);
                })
                ->editColumn('created_at', function ($parent) {
                    return @$parent->proper_created_at;
                })
                ->editColumn('status', function ($parent) {
                    return View::make($this->viewConstant . '_add_status', ['parent' => @$parent]);
                })
                ->addColumn('checkbox', function ($parent) use ($request) {
                    return View::make($this->viewConstant . '_add_checkbox', ['parent' => @$parent])->render();
                })
                ->editColumn('is_tuition_parent', function ($parent) {
                    return ($parent->is_tuition_parent==1)?'Yes':'No';
                })
                ->with(["draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total, "recordsFiltered" => $count_filter])
                ->rawColumns(['action', 'status', 'created_at', 'is_tuition_parent', 'checkbox'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create/Edit Parent page                       |
     * |                                               |
     * | @param $id |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($uuid = null)
    {
        if (isset($uuid)) {
            $parent = ParentUser::whereUuid($uuid)->first();
            $parentAddress = ParentAddress::whereParentId($parent->id)->orderBy('id', 'asc')->first();
        }
        $countryList = DB::table('countries')->orderBy('name','asc')->pluck('name', 'id');
        $autoPassword = $this->generateRandomString();
        $title = isset($uuid) ? __('admin_messages.edit_parent') : __('admin_messages.add_parent');
        return view($this->viewConstant . 'create', ['countryList' => @$countryList, 'parentAddress' => @$parentAddress, 'title' => @$title, 'parent' => @$parent, 'autoPassword' => $autoPassword]);
    }
    /** 
     * -----------------------------------------------------
     * | Get Random String                                 |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * -------------------------------------------------
     * | Store Parent details                          |
     * |                                               |
     * | @param SubjectFormRequest $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(ParentFormRequest $request, $uuid = null)
    {

        $this->dbStart();
        try {
            $msg = __('formname.action_msg', ['action' => isset($request->id) ? __('formname.updated') : __('formname.created'), 'type' => __('admin_messages.parent.parent')]);
            if ($request->id == null) {
                $parent = ParentUser::create($request->all());
            } else {
                $parent = ParentUser::where('id', $request->id)->first();
                $parent->update($request->all());
            }
            $address = ParentAddress::whereParentId($parent->id)->orderBy('id', 'asc')->first();
            if ($address) {
                $address->update($request->all());
            } else {
                array_set($request, 'parent_id', $parent->id);
                $address = ParentAddress::create($request->all());
            }
            $UpdateDate = Carbon::createFromFormat('Y-m-d H:i:s', $parent->updated_at)->format('Y-m-d H:i:s');
            $parent->update(['last_sign_in_at' => $UpdateDate]);
            $this->dbCommit();
            return Redirect::route('parent_index')->with('message', $msg);
        } catch (Exception $e) {
            $this->dbRollBack();
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Update Parent status details                  |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        // check if request has id or not null
        if (isset($request->id)) {
            $parent = ParentUser::whereUuid($request->id)->first();
            $status = $parent->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $parent->update(['status' => $status]);
            return response()->json(['msg' => __('admin_messages.action_msg', ['action' => ($status == config('constant.status_active_value')) ? __('admin_messages.activated') : __('admin_messages.inactivated'), 'type' => __('admin_messages.parent.parent')]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * -------------------------------------------------
     * | Delete Parent                                 |
     * |                                               |
     * | @param Request $request |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        // check if request has id or not null
        if (isset($request->id)) {
            $parent = ParentUser::whereUuid($request->id)->first();
            $parent->delete();
            $msg = __('formname.action_msg', ['action' => __('formname.deleted'), 'type' => __('admin_messages.parent.parent')]);
            return response()->json(['msg' => $msg, 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Multiple Action                               |
     * |                                               |
     * | @param Request $request |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function bulkAction(Request $request)
    {
        $parentIdArray = $request->input('ids');
        $parents = ParentUser::whereIn('id', $parentIdArray);
        $action = $request->action;
        // check if request action is active, inactive or delete
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $parents->update(['status' => $status]);
            $this->performMultipleAction($parents->get(), $action, $status);
            return response()->json(['msg' => __('admin_messages.action_msg', ['action' => ($status == config('constant.status_active_value')) ? __('admin_messages.activated') : __('admin_messages.inactivated'), 'type' => __('admin_messages.parent.parent')]), 'icon' => __('admin_messages.icon_success')]);
        } else {
            $this->performMultipleAction($parents->get(), $action);
            $parents->delete();
            return response()->json(['msg' => __('admin_messages.parent.deleted_msg'), 'icon' => __('admin_messages.icon_success')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Common funtion for multiple actions           |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function performMultipleAction($parents, $action, $status = null)
    {
        foreach ($parents as $val) {
            $parent = ParentUser::find($val->id);
            if ($action == config('constant.delete')) {
                $parent->childs()->delete();
            } else {
                $parent->childs()->update(['active' => $status]);
            }
        }
    }

    /**
     * -------------------------------------------------
     * | Import File View                              |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function import()
    {
        return view('admin.parents.import');
    }

    /**
     * -------------------------------------------------
     * | Insert Imported records                       |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function insert(Request $request)
    {
        // check if request has file
        if ($request->hasFile('import_file')) {
            Excel::import(new ImportParentFile, request()->file('import_file'));
        }
        $errorMessage = Session::get('error');
        if ($errorMessage) {
            return redirect()->route('parent_import')->withError(__('formname.not_found'));
        }
        return Redirect::route('parent_index')->with('message', __('admin_messages.import_success_msg'));
    }


}
