<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SubscriptionHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubscriptionFormRequest;
use App\Http\Requests\Admin\TopicFormRequest;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.subscription.';
    public function __construct(SubscriptionHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * -------------------------------------------------
     * | Display Topic list                            |
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
     * | Get Topic datatable data                      |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $faqs = $this->helper->list();
            $subscriptionList = $faqs->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeStatus($request->status);
                }
            })->get();
            return DataTables::of($subscriptionList)
                ->addColumn('action', function ($subscription) {
                    return $this->getPartials($this->viewConstant .'_add_action',['subscription'=>@$subscription]);
                })
                ->editColumn('status', function ($subscription) {
                    return $this->getPartials($this->viewConstant .'_add_status',['subscription'=>@$subscription]);
                })
                ->editColumn('created_at', function ($subscription) {
                    return $subscription->proper_created_at;
                })
                ->addColumn('checkbox', function ($subscription) {
                    return $this->getPartials($this->viewConstant .'_add_checkbox',['subscription'=>@$subscription]);
                })
                ->rawColumns(['created_at', 'checkbox', 'action', 'status'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Topic page                             |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($uuid = null)
    {
        // check if request has uuid or not
        if (isset($uuid)) {
            $subscription = $this->helper->detail($uuid);
        }
        $statusList = $this->properStatusList();
        $title = isset($uuid) ? trans('formname.subscription.update') : trans('formname.subscription.create');
        return view($this->viewConstant . 'create', ['subscription' => @$subscription, 'title' => @$title, 'statusList'=>@$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Store Topic details                           |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(SubscriptionFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            $msg = isset($request->id)?__('formname.subscription.updated'):__('formname.subscription.created');
            $this->helper->dbEnd();
            return Redirect::route('subscription.index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            abort('404');
        }
    }
    /**
     * -------------------------------------------------
     * | Delete Topic details                          |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        // check if request has id or not
        if (isset($request->id)) {
            $this->helper->delete($request->id);
            return response()->json(['msg' => __('formname.subscription.deleted'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
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
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            return response()->json(['msg' => __('formname.subscription.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.subscription.deleted'), 'icon' => __('admin_messages.icon_success')]);
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
        // check if request has id or not
        if (isset($request->id)) {
            $status = $this->helper->statusUpdate($request->id);
            return response()->json(['msg' => __('formname.subscription.status'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }
}
