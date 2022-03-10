<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SubjectHelper;
use App\Http\Requests\Admin\SubjectFormRequest;
use App\Models\Paper;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Redirect;
use Yajra\Datatables\Datatables;

class SubjectController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.subject.';
    public function __construct(SubjectHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * -------------------------------------------------
     * | Display Subjects list                         |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $data = $this->statusList();
        $subjects = $this->helper->subjectList()->get();
        return view($this->viewConstant . 'index', ['statusList' => @$data,'subjects' => $subjects]);
    }

    /**
     * -------------------------------------------------
     * | Get subject datatable date                    |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $subjects = $this->helper->subjectList();
            $subjectList = $subjects->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            })->get();
            return Datatables::of($subjectList)
                ->addColumn('action', function ($subject) {
                    return $this->getPartials($this->viewConstant . '_add_action', ['subject' => $subject]);
                })
                ->editColumn('created_at', function ($subject) {
                    return $subject->proper_created_at;
                })
                ->addColumn('checkbox', function ($subject) {
                    return $this->getPartials($this->viewConstant . '_add_checkbox', ['subject' => $subject]);
                })
                ->rawColumns(['created_at', 'checkbox', 'action'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create subject page                           |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($id = null)
    {
        if (isset($id)) {
            $subject = $this->helper->detailById($id);
            $selectedCategories = $this->helper->categoryDetailById($id);
        }
        $title = isset($id) ? trans('formname.subjects.update') : trans('formname.subjects.create');
        $paperCategories = $this->helper->productCategories();
        return view($this->viewConstant . 'create_subject', ['title' => @$title, 'paperCategories' => @$paperCategories, 'selectedCategories' => @$selectedCategories, 'subject' => @$subject]);
    }

    /**
     * -------------------------------------------------
     * | Store Subject details                         |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(SubjectFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            $msg = __('admin_messages.action_msg', ['action' => isset($request->id)? __('admin_messages.updated'):__('admin_messages.created'), 'type' => __('admin_messages.subject')]);
            $this->helper->dbEnd();
            return Redirect::route('subject_index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Delete Subject details                        |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroySubject(Request $request)
    {
        if (isset($request->id)) {
            // Inactive papers
            $subject = $this->helper->detail($request->id);
            Paper::where('subject_id', $subject->id)->update(['status' => 0]);
            $this->helper->delete($request->id);
            return response()->json(['msg' => __('formname.subjects.delete'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Delete multiple Subjects                      |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multiDeleteSubject(Request $request)
    {
        $this->helper->multiDelete($request);
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            return response()->json(['msg' => __('formname.subjects.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.subjects.delete'), 'icon' => __('admin_messages.icon_success')]);
    }

    /**
     * -------------------------------------------------
     * | Update Subject status details                 |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        if (isset($request->id)) {
            $this->helper->statusUpdate($request->id);
            return response()->json(['msg' => __('formname.subjects.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * -------------------------------------------------
     * | Show Subject details                          |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function show($uuid = null)
    {
        $subject = $this->helper->detail($uuid);
        return view($this->viewConstant . '.detail_subject', ['subject' => @$subject]);
    }

    /**
     * -------------------------------------------------
     * | Sort Order Sequence                           |
     * |                                               |
     * | @param Request $request                       |
     * |------------------------------------------------
     */
    public function sorting(Request $request) 
    {
        $request->sorting = $request->sorting + 1;
        $subject = Subject::whereId($request->id)->first();
        $subject->update(['order_seq' => $request->sorting]);
    }
}
