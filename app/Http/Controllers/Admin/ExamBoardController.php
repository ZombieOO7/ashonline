<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ExamBoardHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExamBoardFormRequest;
use App\Http\Requests\Admin\FAQFormRequest;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class ExamBoardController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.examboard.';
    public function __construct(ExamBoardHelper $helper)
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
            $faqs = $this->helper->list();
            $faqList = $faqs->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            })->get();
            return DataTables::of($faqList)
                ->addColumn('action', function ($faq) {
                    return $this->getPartials($this->viewConstant .'_add_action',['stage'=>@$faq]);
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
                ->rawColumns(['created_at', 'checkbox', 'action', 'status'])
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
        $title = isset($uuid) ? trans('formname.examBoard.update') : trans('formname.examBoard.create');
        return view($this->viewConstant . 'create', ['faq' => @$faq, 'title' => @$title]);
    }

    /**
     * -------------------------------------------------
     * | Store Stage details                           |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(ExamBoardFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            $msg = isset($request->id)?__('formname.examBoard.updated'):__('formname.examBoard.created');
            $this->helper->dbEnd();
            return Redirect::route('examboard.index')->with('message', $msg);
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
            return response()->json(['msg' => __('formname.examBoard.deleted'), 'icon' => __('admin_messages.icon_success')]);
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
            return response()->json(['msg' => __('formname.examBoard.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.examBoard.deleted'), 'icon' => __('admin_messages.icon_success')]);
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
            return response()->json(['msg' => __('formname.examBoard.status'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }
}
