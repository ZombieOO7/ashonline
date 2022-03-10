<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FaqHelper;
use App\Http\Requests\Admin\FAQFormRequest;
use Exception;
use Illuminate\Http\Request;
use Lang;
use Redirect;
use Yajra\Datatables\Datatables;

class FaqController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.faqs.';
    public function __construct(FaqHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');

    }
    /**
     * -------------------------------------------------
     * | Display FAQ list                              |
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
            $draw = intval($request->draw) + 1 ;
            $limit = @$request->length?? 10;
            $start = @$request->start ?? 0;
            $faqs = $this->helper->faqList();
            $itemQuery = $faqs->where(function ($query) use ($request) {
                // check if request has status
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $faqList = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return Datatables::of($faqList)
                ->addColumn('action', function ($faq) {
                    return $this->getPartials($this->viewConstant .'_add_action',['stage'=>@$faq]);
                })
                ->editColumn('faq_category_id', function ($faq) {
                    return ($faq->category) ? $faq->category->title : '--';
                })
                ->editColumn('status', function ($faq) {
                    return $this->getPartials($this->viewConstant .'_add_status',['stage'=>@$faq]);
                })
                ->editColumn('created_at', function ($faq) {
                    return $faq->proper_created_at;
                })
                ->addColumn('checkbox', function ($faq) {
                    return $this->getPartials($this->viewConstant .'_add_checkbox',['stage'=>@$faq]);
                })
                ->with(["draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total, "recordsFiltered" => $count_filter])
                ->rawColumns(['created_at', 'checkbox', 'action', 'status', 'faq_category_id'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create FAQ page                               |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($uuid = null)
    {
        // check if request has uuid or not
        if (isset($uuid)) {
            $faq = $this->helper->detail($uuid);
        }
        $faqCategories = $this->helper->faqCategoryList();
        $title = isset($uuid) ? trans('formname.faq.update') : trans('formname.faq.create');
        return view($this->viewConstant . 'create', ['faq' => @$faq, 'title' => @$title, 'faqCategories' => @$faqCategories]);
    }

    /**
     * -------------------------------------------------
     * | Store Stage details                           |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(FAQFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            $msg = __('admin_messages.action_msg', ['action' => isset($request->id)?__('admin_messages.updated'):__('admin_messages.created'), 'type' => __('formname.faq_text')]);
            $this->helper->dbEnd();
            return Redirect::route('faq_index')->with('message', $msg);
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
        // check if request has id or not
        if (isset($request->id)) {
            $this->helper->delete($request->id);
            return response()->json(['msg' => __('admin_messages.action_msg', ['action' =>__('admin_messages.deleted'),'type'=>__('formname.faq_text')]), 'icon' => __('admin_messages.icon_success')]);
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
            return response()->json(['msg' => __('formname.action_msg',['type'=>__('formname.faq_text'),'action'=>($request->action == config('constant.inactive')?__('formname.inactivated'):__('formname.activated'))]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.email_template.delete'), 'icon' => __('admin_messages.icon_success')]);
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
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>($status == config('constant.status_active_value'))?__('admin_messages.activated'):__('admin_messages.inactivated'),'type' => __('formname.faq_text')]), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }
}
