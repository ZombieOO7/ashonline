<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ExamTypeHelper;
use App\Http\Requests\Admin\ExamTypeFormRequest;
use App\Models\Paper;
use Exception;
use Illuminate\Http\Request;
use Lang;
use Redirect;
use Yajra\Datatables\Datatables;

class ExamTypeController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.examtypes.';
    public function __construct(ExamTypeHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');

    }
    /**
     * -------------------------------------------------
     * | Display Exam type list                        |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $data['statusList'] = $this->statusList();
        return view($this->viewConstant . 'index', $data);
    }

    /**
     * -------------------------------------------------
     * | Get Exam type datatable date                  |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $examTypes = $this->helper->examTypeList();
            $examTypeList = $examTypes->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            })->get();
            return Datatables::of($examTypeList)
                ->addColumn('action', function ($examType) {
                    return $this->getPartials($this->viewConstant .'_add_action',['examType'=>@$examType]);
                })
                ->addColumn('checkbox', function ($examType) {
                    return $this->getPartials($this->viewConstant .'_add_checkbox',['examType'=>@$examType]);
                })
                ->editColumn('created_at', function ($examType) {
                    return $examType->proper_created_at;
                })
                ->editColumn('paper_category', function ($examType) {
                    return @$examType->category->title;
                })
                ->rawColumns(['paper_category', 'created_at', 'checkbox', 'action'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Exam type page                         |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($id = null)
    {
        // check if request has id or not
        if (isset($id)) {
            $examType = $this->helper->detailById($id);
        }
        $title = isset($id) ? trans('formname.examtypes.update') : trans('formname.examtypes.create');
        $paperCategories = $this->helper->paperCategories();
        return view($this->viewConstant . 'create', ['title' => $title, 'examType' => @$examType, 'paperCategories' => @$paperCategories]);
    }

    /**
     * -------------------------------------------------
     * | Store Exam type details                       |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(ExamTypeFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            $msg = __('admin_messages.action_msg', ['action' => isset($request->id)?__('admin_messages.updated'):__('admin_messages.created'), 'type' => __('formname.test_papers.exam_type')]);
            $this->helper->dbEnd();
            return Redirect::route('exam_types_index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            abort('404');
        }
    }
    /**
     * -------------------------------------------------
     * | Delete Exam type details                      |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        // check if request has id or not
        if (isset($request->id)) {
            $examType = $this->helper->detail($request->id);
            Paper::where('exam_type_id', $examType->id)->update(['status' => 0]);
            $this->helper->delete($request->id);
            return response()->json(['msg' => __('admin_messages.action_msg', ['action' =>__('admin_messages.deleted'), 'type' => __('formname.test_papers.exam_type')]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }
    /**
     * -------------------------------------------------
     * | Delete multiple Exam type                     |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multidelete(Request $request)
    {
        $this->helper->multiDelete($request);
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            return response()->json(['msg' => __('formname.action_msg',['type'=>__('formname.test_papers.exam_type'),'action'=>($request->action == config('constant.inactive')?__('formname.inactivated'):__('formname.activated'))]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('admin_messages.action_msg', ['action' =>__('admin_messages.deleted'), 'type' => __('formname.test_papers.exam_type')]), 'icon' => __('admin_messages.icon_success')]);
    }
    /**
     * -------------------------------------------------
     * | Update Exam type status details               |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        if (isset($request->id)) {
            $status = $this->helper->statusUpdate($request->id);
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>($status == config('constant.status_active_value'))?__('admin_messages.activated'):__('admin_messages.inactivated'),'type' => __('formname.test_papers.exam_type')]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

}
