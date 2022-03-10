<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EmailTemplateHelper;
use App\Http\Requests\Admin\EmailTemplateRequest;
use Exception;
use Illuminate\Http\Request;
use Lang;
use Redirect;
use Yajra\Datatables\Datatables;

class EmailTemplateController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.email-template.';
    public function __construct(EmailTemplateHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');

    }
    /**
     * -------------------------------------------------
     * | Display Email Template list                   |
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
     * | Get Email Template datatable date             |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $emailTemplates = $this->helper->templateList();
            $emailTemplateList = $emailTemplates->where(function ($query) use ($request) {
                // check if request has status
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            })->get();
            return Datatables::of($emailTemplateList)
                ->addColumn('action', function ($emailTemplate) {
                    return $this->getPartials($this->viewConstant .'_add_action',['emailTemplate'=>@$emailTemplate]);

                })
                ->editColumn('status', function ($emailTemplate) {
                    return $this->getPartials($this->viewConstant .'_add_status',['emailTemplate'=>@$emailTemplate]);
                })
                ->editColumn('created_at', function ($emailTemplate) {
                    return $emailTemplate->proper_created_at;
                })
                ->addColumn('checkbox', function ($emailTemplate) {
                    return $this->getPartials($this->viewConstant .'_add_checkbox',['emailTemplate'=>@$emailTemplate]);
                })
                ->editColumn('title', function ($emailTemplate) {
                    return $emailTemplate->title_text;
                })
                ->editColumn('subject', function ($emailTemplate) {
                    return $emailTemplate->subject_text;
                })
                ->rawColumns(['title', 'subject', 'created_at', 'checkbox', 'action', 'status'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Email Template page                    |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($uuid = null)
    {
        // check if request has uuid
        if (isset($uuid)) {
            $emailTemplate = $this->helper->detail($uuid);
        }
        $title = isset($uuid) ? __('formname.email_template.update') : __('formname.email_template.create');
        return view($this->viewConstant . 'create', ['emailTemplate' => @$emailTemplate, 'title' => @$title]);
    }

    /**
     * -------------------------------------------------
     * | Store Email Template details                  |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(EmailTemplateRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            $msg = __('admin_messages.action_msg', ['action' => isset($request->id)?__('admin_messages.updated'):__('admin_messages.created'), 'type' => __('formname.email_template.lable')]);
            $this->helper->dbEnd();
            return Redirect::route('email_template_index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            abort('404');
        }
    }
    /**
     * -------------------------------------------------
     * | Delete Email Template details                 |
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
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('admin_messages.deleted'),'type' => __('formname.email_template.lable')]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }
    /**
     * -------------------------------------------------
     * | Delete multiple Email Template                |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multidelete(Request $request)
    {
        $this->helper->multiDelete($request);
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            return response()->json(['msg' => __('formname.action_msg',['type'=>__('formname.email_template.lable'),'action'=>($request->action == config('constant.inactive')?__('formname.inactivated'):__('formname.activated'))]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.email_template.delete'), 'icon' => __('admin_messages.icon_success')]);
    }
    /**
     * -------------------------------------------------
     * | Update Email Template status details          |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        // check if request has id
        if (isset($request->id)) {
            $status = $this->helper->statusUpdate($request->id);
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>($status == config('constant.status_active_value'))?__('admin_messages.activated'):__('admin_messages.inactivated'),'type' => __('formname.email_template.lable')]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

}
