<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TestAssessmentHelper;
use App\Http\Requests\Admin\TestAssessmentFormRequest;
use App\Models\Question;
use App\Models\Topic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Route;

class TestAssessmentController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.test-assessment.';
    public $route = 'test-assessment.';

    public function __construct(TestAssessmentHelper $helper, Question $question)
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
            $draw = intval($request->draw) + 1 ;
            $limit = @$request->length?? 10;
            $start = @$request->start ?? 0;    
            $testAssessment = $this->helper->list();
            $itemQuery = $testAssessment->where(function ($query) use ($request) {
                // check if request has id or not
                if ($request->status != null) {
                    $query->activeSearch($request->status);
                }
            });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $mockTestList = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return DataTables::of($mockTestList)
                ->addColumn('action', function ($testAssessment) {
                    return $this->getPartials($this->viewConstant . '_add_action', ['testAssessment' => @$testAssessment]);
                })
                ->editColumn('status', function ($testAssessment) {
                    return $this->getPartials($this->viewConstant . '_add_status', ['testAssessment' => @$testAssessment]);
                })
                ->editColumn('school_year', function ($testAssessment) {
                    return @config('constant.school_year')[@$testAssessment->school_year];
                })
                ->editColumn('created_at', function ($testAssessment) {
                    return @$testAssessment->proper_created_at;
                })
                ->editColumn('start_date', function ($testAssessment) {
                    return @$testAssessment->proper_start_date;
                })
                ->editColumn('end_date', function ($testAssessment) {
                    return @$testAssessment->proper_end_date;
                })
                ->editColumn('title', function ($testAssessment) {
                    return $this->getPartials($this->viewConstant . '_add_message', ['testAssessment' => $testAssessment, 'title' => __('formname.test-assessment.title')]);
                })
                ->addColumn('checkbox', function ($testAssessment) {
                    return $this->getPartials($this->viewConstant . '_add_checkbox', ['testAssessment' => @$testAssessment]);
                })
                ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
                ->rawColumns(['school_year','end_date', 'start_date', 'title', 'created_at', 'checkbox', 'action', 'status'])
                ->skipPaging()
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
            $title = __('formname.test-assessment.create');
            // check if uuid not null
            if (isset($uuid)) {
                $testAssessment = $this->helper->detail($uuid);
                $subjects = $testAssessment->subjects->pluck('subject_id');
                if($subjects){
                    $subjectIds = array_unique($subjects->toArray());
                }
                // $parentIds = $testAssessment->parentMockTest->pluck('parent_id');
                $title = __('formname.test-assessment.update');
            }
            if ($routeName == 'test-assessment.copy') {
                $title = __('formname.test-assessment.copy');
                $route = 'test-assessment.copy-exam';
            }
            $statusList = $this->properStatusList();
            $subjectList = $this->subjectList();
            $weekList = $this->helper->weekList();
            $yearList = $this->yearList();
            return view($this->viewConstant . 'create', ['yearList'=>@$yearList,'weekList' => @$weekList, 'testAssessment' => @$testAssessment, 'title' => @$title, 'statusList' => @$statusList, 'subjectList' => $subjectList,'subjectIds' => @$subjectIds, 'route' => @$route]);
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
    public function store(TestAssessmentFormRequest $request, $uuid = null)
    {
        // dd($request->all());
        $this->helper->dbStart();
        // try {
            $testAssessment = $this->helper->store($request, $uuid);
            if(isset($testAssessment['error']) && $testAssessment['error'] != null){
                return redirect()->back()->with('error',$testAssessment['error']);
            }
            $this->helper->dbEnd();
            $routeName = Route::currentRouteName();
            // check if route is use to copy mock exam
            if ($routeName == 'test-assessment.copy-exam') {
                $msg = __('formname.action_msg', ['action' => __('formname.copied'), 'type' => __('formname.test_assessment_id')]);
            } elseif ($request->has('id') && !empty($request->id)) {
                $msg = __('formname.action_msg', ['action' => __('formname.updated'), 'type' => __('formname.test_assessment_id')]);
            } else {
                $msg = __('formname.action_msg', ['action' => __('formname.created'), 'type' => __('formname.test_assessment_id')]);
            }
            // return redirect()->route($this->route . 'index')->with('message', $msg);
            return redirect()->route($this->route . 'detail',['uuid'=>@$testAssessment->uuid])->with('message', $msg);
        // } catch (Exception $e) {
            $this->helper->dbRollBack();
            return Redirect::back()->with('error', $e->getMessage());
        // }
    }

    /**
     * -------------------------------------------------
     * | Delete Test Assessment details                |
     * |                                               |
     * | @param Request $request |
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
                $msg = __('formname.action_msg', ['action' => __('formname.deleted'), 'type' => __('formname.test_assessment_id')]);
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
                $msg = __('formname.action_msg', ['action' => $action, 'type' => __('formname.test_assessment_id')]);
                return response()->json(['msg' => $msg, 'icon' => 'success']);
            }
            $msg = __('formname.action_msg', ['action' => __('formname.deleted'), 'type' => __('formname.test_assessment_id')]);
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
    public function subjectDetail(Request $request)
    {
        try {
            // check if request has subject ids
            if ($request->subject_ids) {
                $subjects = $this->helper->subjectDetail($request);
                return view($this->viewConstant . '_time', ['subjects' => @$subjects[0], 'mockTestDetail' => @$subjects[1]]);
            } else {
                return;
            }
        } catch (Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Test Assessment question list                 |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function questionList(Request $request)
    {
        $questions = $this->question::select('id','question_type','type','question_title','topic_id','active')
            ->where(function($q) use ($request){
                if($request->topic_id != null){
                    $q->whereIn('topic_id',$request->topic_id);
                }
            })
            ->whereSubjectId($request->subject_id)
            ->where('question_type', 1)
            ->whereActive(1)
            ->orderBy('created_at','desc')
            ->get();
        return DataTables::of($questions)
            ->editColumn('type', function ($testAssessment) {
                return @config('constant.question_type')[$testAssessment->type];
            })
            ->editColumn('question_type', function ($testAssessment) {
                return @config('constant.questionSubType')[$testAssessment->question_type];
            })
            ->editColumn('question_title', function ($questionData) {

                return $this->getPartials('admin.question_management._add_message', ['questionData' => $questionData,'title'=>__('formname.question.question_title')]);
            })
            ->editColumn('topic', function ($testAssessment) {
                return @$testAssessment->topic->title;
            })
            ->addColumn('checkbox', function ($testAssessment) {
                return $this->getPartials($this->viewConstant . '_add_checkbox', ['testAssessment' => @$testAssessment]);
            })
            ->rawColumns(['question_title', 'type', 'checkbox'])
            ->make(true);
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
        $title = __('formname.test-assessment.detail');
        return view($this->viewConstant . '_detail', ['testAssessment' => @$testAssessment, 'title' => @$title, 'statusList' => @$statusList,
            'subjectList' => $subjectList, 'gradeList' => $gradeList, 'boardList' => $boardList, 'schoolList' => @$schoolList,
            'subjectIds' => @$subjectIds]);
    }
    /**
     * -------------------------------------------------
     * | Image Get student Papers                      |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
  

    public function imageGet(Request $request)
    {
        $imageGet = commonImageId($request->image_id);
        $id = $imageGet->id;
        $imageShow = $imageGet->path;
        $image = $imageGet->image_path;
        
        return view('admin.test-assessment._image_show', ['image'=>@$image,'imageShow' => @$imageShow, 'id' => @$id]);

    }

    /**
     * -------------------------------------------------
     * | Image Get student Papers                      |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
  
    public function getImage(Request $request)
    {
        try {
            $stages = $this->commonImageIdCheck();
            $imageId = $request->image_id;
            $stageList = $stages->where(function ($query) use ($request) {
                // check if request has status


            })->get();
            return DataTables::of($stageList)
                ->addColumn('path', function ($list) {
                    return '<img src="' . @$list->image_path . '" alt="' . @$list->image_path . '" width="70" height="70" >';
                })->addColumn('checkbox', function ($testAssessment) use ($imageId) {
                    return $this->getPartials($this->viewConstant . '_add_image_action_checkbox', ['testAssessment' => @$testAssessment, 'image_id' => @$imageId]);
                })
                ->rawColumns(['checkbox', 'path'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }
}
