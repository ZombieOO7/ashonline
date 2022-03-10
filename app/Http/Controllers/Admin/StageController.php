<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StageHelper;
use App\Http\Requests\Admin\StageFormRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;

class StageController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.stages.';
    public function __construct(StageHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }
    /**
     * -------------------------------------------------
     * | Display Stages list                           |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $statusList = $this->statusList();
        return view($this->viewConstant . 'index', ['statusList' => @$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Get Stage datatable date                      |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $stages = $this->helper->stageList();
            $stageList = $stages->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            })->get();
            return Datatables::of($stageList)
                ->addColumn('action', function ($stage) {
                    return $this->getPartials($this->viewConstant . '_add_action', ['stage' => $stage]);
                })
                ->editColumn('status', function ($stage) {
                    return $this->getPartials($this->viewConstant . '_add_status', ['stage' => $stage]);
                })
                ->editColumn('created_at', function ($stage) {
                    return $stage->proper_created_at;
                })
                ->addColumn('checkbox', function ($stage) {
                    return $this->getPartials($this->viewConstant . '_add_checkbox', ['stage' => $stage]);
                })
                ->rawColumns(['created_at', 'checkbox', 'action', 'status'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Stage page                             |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($uuid = null)
    {
        // check if uuid is not null
        if (isset($uuid)) {
            $stage = $this->helper->detail($uuid);
        }
        $title = isset($uuid) ? trans('formname.stage.update') : trans('formname.stage.create');
        return view($this->viewConstant . 'create', ['stage' => @$stage, 'title' => @$title]);
    }

    /**
     * -------------------------------------------------
     * | Store Stage details                           |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(StageFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            // check if request has id or not null
            if ($request->has('id') && $request->id != '') {
                $msg = __('admin_messages.action_msg', ['action' => __('admin_messages.updated'), 'type' => __('formname.test_papers.stage')]);
            } else {
                $msg = __('admin_messages.action_msg', ['action' => __('admin_messages.created'), 'type' => __('formname.test_papers.stage')]);
            }
            $this->helper->dbEnd();
            return Redirect::route('stage_index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            abort('404');
        }
    }
    /**
     * -------------------------------------------------
     * | Delete Stage details                          |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        // check if request has id
        if (isset($request->id)) {
            $this->helper->delete($request->id);
            return response()->json(['msg' => __('formname.stage.delete'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }
    /**
     * -------------------------------------------------
     * | Delete multiple Stage                         |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multidelete(Request $request)
    {
        $this->helper->multiDelete($request);
        // check if request action is active, inactive or delete
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            return response()->json(['msg' => __('formname.stage.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.stage.delete'), 'icon' => __('admin_messages.icon_success')]);
    }
    /**
     * -------------------------------------------------
     * | Update Stage status details                   |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        // check if request has id 
        if (isset($request->id)) {
            $this->helper->statusUpdate($request->id);
            return response()->json(['msg' => __('formname.stage.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

}
