<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PracticeExamHelper;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PracticeExamFormRequest;
use App\Models\Question;
use App\Models\Topic;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

class PracticeExamController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.practice-exam.';
    public $route = 'practice-exam.';

    public function __construct(PracticeExamHelper $helper, Question $question)
    {
        $this->question = $question;
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * -------------------------------------------------
     * | Display Test Assessment list                  |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        try {
            // $this->helper->disableMockExam();
            $statusList = $this->properStatusList();
            return view($this->viewConstant . 'index', ['statusList' => @$statusList]);
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * -------------------------------------------------
     * | Get Test Assessment datatable                 |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $practiceExam = $this->helper->list();
            $practiceExamList = $practiceExam->where(function ($query) use ($request) {
                                    // check if request has id or not
                                    if ($request->status != null) {
                                        $query->activeSearch($request->status);
                                    }
                                })
                                ->get();
            return DataTables::of($practiceExamList)
                ->addColumn('action', function ($practiceExam) {
                    return $this->getPartials($this->viewConstant . '_add_action', ['testAssessment' => @$practiceExam]);
                })
                ->editColumn('status', function ($practiceExam) {
                    return $this->getPartials($this->viewConstant . '_add_status', ['testAssessment' => @$practiceExam]);
                })
                ->editColumn('exam_board_id', function ($practiceExam) {
                    return @$practiceExam->examBoard->title;
                })
                ->editColumn('grade_id', function ($practiceExam) {
                    return @$practiceExam->grade->title;
                })
                ->editColumn('created_at', function ($practiceExam) {
                    return @$practiceExam->proper_created_at;
                })
                ->editColumn('title', function ($practiceExam) {
                    return $this->getPartials($this->viewConstant . '_add_message', ['testAssessment' => $practiceExam, 'title' => __('formname.practice-exam.title')]);
                })
                ->addColumn('checkbox', function ($practiceExam) {
                    return $this->getPartials($this->viewConstant . '_add_checkbox', ['testAssessment' => @$practiceExam]);
                })
                ->rawColumns(['title', 'created_at', 'checkbox', 'action', 'status'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Test Assessment page                   |
     * |                                               |
     * | @param $id |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($uuid = null)
    {
        try {
            $routeName = Route::currentRouteName();
            $title = __('formname.practice-exam.create');
            // check if uuid not null
            if (isset($uuid)) {
                $practiceExam = $this->helper->detail($uuid);
                $title = __('formname.practice-exam.update');
            }
            if ($routeName == 'practice-exam.copy') {
                $title = __('formname.practice-exam.copy');
                $route = 'practice-exam.copy-exam';
            }
            $statusList = $this->properStatusList();
            $subjectList = $this->practiceSubjectList();
            $topics = Topic::whereActive(1)->get()->pluck('title_text','id');
            $yearList = $this->yearList();
            return view($this->viewConstant . 'create', ['yearList'=>@$yearList,'practiceExam' => @$practiceExam, 'title' => @$title, 'statusList' => @$statusList, 'subjectList' => $subjectList, 'route' => @$route,'topics'=>@$topics]);
        } catch (Exception $e) {
            abort(404);
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    /**
     * -------------------------------------------------
     * | Store Test Assessment details                 |
     * |                                               |
     * | @param MockTestFormRequest $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(PracticeExamFormRequest $request, $uuid = null)
    {
        // dd($request->all());
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            $this->helper->dbEnd();
            $routeName = Route::currentRouteName();
            // check if route is use to copy mock exam
            if ($routeName == 'practice-exam.copy-exam') {
                $msg = __('formname.action_msg', ['action' => __('formname.copied'), 'type' => __('formname.practice_exam_id')]);
            } elseif ($request->has('id') && !empty($request->id)) {
                $msg = __('formname.action_msg', ['action' => __('formname.updated'), 'type' => __('formname.practice_exam_id')]);
            } else {
                $msg = __('formname.action_msg', ['action' => __('formname.created'), 'type' => __('formname.practice_exam_id')]);
            }
            return redirect()->route($this->route . 'index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return Redirect::back()->with('error', $e->getMessage());
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Delete Test Assessment details                |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        $this->helper->dbStart();
        try {
            // check if request has id or not
            if (isset($request->id)) {
                $this->helper->delete($request->id);
                $this->helper->dbEnd();
                $msg = __('formname.action_msg', ['action' => __('formname.deleted'), 'type' => __('formname.practice_exam_id')]);
                return response()->json(['msg' => $msg, 'icon' => 'success']);
            }
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Delete multiple Test Assessment               |
     * | @param Request $request |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multidelete(Request $request)
    {
        $this->helper->dbStart();
        try {
            $this->helper->dbEnd();
            $this->helper->multiDelete($request);
            // check if request action is active, inactive or delete
            if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
                $action = ($request->action == config('constant.active')) ? __('formname.activated') : __('formname.inactivated');
                $msg = __('formname.action_msg', ['action' => $action, 'type' => __('formname.practice_exam_id')]);
                return response()->json(['msg' => $msg, 'icon' => 'success']);
            }
            $msg = __('formname.action_msg', ['action' => __('formname.deleted'), 'type' => __('formname.practice_exam_id')]);
            return response()->json(['msg' => @$msg, 'icon' => 'success']);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Update Test Assessment status                 |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        $this->helper->dbStart();
        try {
            // check if request has id or not
            if (isset($request->id)) {
                $msg = $this->helper->statusUpdate($request->id);
                $this->helper->dbEnd();
                return response()->json(['msg' => @$msg, 'icon' => 'success']);
            }
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Test Assessment subject detail                |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getTopicInputs(Request $request)
    {
        try {
            // check if request has subject ids
            if ($request->ids) {
                $topics = $this->helper->getTopicByIds(json_decode($request->ids));
                $data['status'] = 'success'; 
                $data['html'] = view($this->viewConstant . '_time', ['topics'=>@$topics])->render();
                return response()->json($data);
            } else {
                $data['status'] = 'false'; 
                return;
            }
        } catch (Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Test Assessment detail                        |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function detail($uuid)
    {
        $testAssessment = $testAssessment = $this->helper->detail($uuid);
        $subjectIds = $testAssessment->subjects->pluck('subject_id');
        $statusList = $this->statusList();
        $subjectList = $this->subjectList();
        $gradeList = $this->gradeList();
        $boardList = $this->boardList();
        $schoolList = $this->schoolList();
        $title = __('formname.practice-exam.detail');
        return view($this->viewConstant . '_detail', ['testAssessment' => @$testAssessment, 'title' => @$title, 'statusList' => @$statusList,
            'subjectList' => $subjectList, 'gradeList' => $gradeList, 'boardList' => $boardList, 'schoolList' => @$schoolList,
            'subjectIds' => @$subjectIds]);
    }
}
