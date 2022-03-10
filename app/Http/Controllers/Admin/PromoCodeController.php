<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PromoCodeHelper;
use App\Http\Requests\Admin\PromoCodeFormRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;

class PromoCodeController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.promo_codes.';
    public function __construct(PromoCodeHelper $helper)
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
            $stages = $this->helper->promoCodeList();
            $stageList = $stages->where(function ($query) use ($request) {
                // check if request has status
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            })->get();
            return Datatables::of($stageList)
                ->addColumn('action', function ($stage) {
                    return $this->getPartials($this->viewConstant .'_add_action',['stage' => $stage]);
                })
                ->editColumn('status', function ($stage) {
                    return $this->getPartials($this->viewConstant .'_add_status',['stage' => $stage]);
                })
                ->editColumn('start_date', function ($stage) {
                    return $stage->start_date_text;
                })
                ->editColumn('end_date', function ($stage) {
                    return $stage->end_date_text;
                })
                ->editColumn('amount_1', function ($stage) {
                    return $stage->amount1_text;
                })
                ->editColumn('discount_1', function ($stage) {
                    return $stage->discount1_text;
                })
                ->editColumn('amount_2', function ($stage) {
                    return $stage->amount2_text;
                })
                ->editColumn('discount_2', function ($stage) {
                    return $stage->discount2_text;
                })
                ->editColumn('created_at', function ($stage) {
                    return $stage->proper_created_at;
                })
            // ->addColumn('checkbox', function ($stage) {
            //     return View::make($this->viewConstant.'._add_checkbox', ['stage'=>$stage])->render();
            // })
                ->rawColumns(['action', 'status', 'start_date', 'end_date', 'created_at'])
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
        // check if request has uuid
        if (isset($uuid)) {
            $stage = $this->helper->detail($uuid);
        }
        $title = isset($uuid) ? trans('formname.promo_codes.update') : trans('formname.promo_codes.create');
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
    public function store(PromoCodeFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            // check if request has id or not null
            $msg = __('admin_messages.action_msg', ['action' => isset($request->id) ? __('admin_messages.updated'):__('admin_messages.created'), 'type' => __('formname.web_setting.promo_code')]);
            $this->helper->dbEnd();
            return Redirect::route('promo_code_index')->with('message', $msg);
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
            return response()->json(['msg' => Lang::get('formname.promo_codes.delete'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => Lang::get('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
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
        // if request action is active, inactive or delelte
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            return response()->json(['msg' => Lang::get('formname.promo_codes.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => Lang::get('formname.promo_codes.delete'), 'icon' => __('admin_messages.icon_success')]);
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
            return response()->json(['msg' => Lang::get('formname.promo_codes.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => Lang::get('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }
}
