<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Subject;
use App\Models\MockTest;
use App\Models\MockTestSubjectDetail;
use App\Models\ParentUser;
use App\Models\StudentTest;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\PurchasedMockTest;
use App\Models\Question;
use App\Models\StudentTestResults;
use App\Models\QuestionList;
use App\Models\StudentTestPaper;
use Illuminate\Support\Facades\Route;
use App\Models\StudentTestQuestionAnswer;
use Exception;
use Illuminate\Support\Facades\Storage;

class StudentTestController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mockTests = MockTest::get();
        $studentList = $this->studentList();
        return view('admin.student-test.index', ['studentList' => @$studentList, 'mockTests' => $mockTests]);
    }
    /**
     * -------------------------------------------------
     * |  Show Data using Datatables                   |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
  
    public function getMockData(Request $request)
    {
        $studentTests = StudentTest::whereProjectType(1)->whereStudentId($request->student_id)
                        ->whereHas('mockTest')
                        ->orderBy('start_date', 'desc');
        $fromDate = $toDate = "";
        if ($request->from_date_filter != "" && $request->to_date_filter != "") {
            $fromDate = Carbon::parse($request->from_date_filter)->format('Y-m-d');
            $toDate = Carbon::parse($request->to_date_filter)->format('Y-m-d');
        } elseif ($request->from_date_filter != "") {
            $fromDate = Carbon::parse($request->from_date_filter)->format('Y-m-d');
            $toDate = Carbon::parse($request->from_date_filter)->format('Y-m-d');
        } elseif ($request->to_date_filter != "") {
            $fromDate = Carbon::parse($request->to_date_filter)->format('Y-m-d');
            $toDate = Carbon::parse($request->to_date_filter)->format('Y-m-d');
        }
        if ($fromDate && $toDate) {
            $studentTests = $studentTests->whereRaw("(start_date >= ? AND end_date <= ?)", [$fromDate . " 00:00:00", $toDate . " 23:59:59"]);
        }
        if (isset($request->select_mock_title_filter) && $request->select_mock_title_filter != "all") {
            $studentTests = $studentTests->where('mock_test_id', $request->select_mock_title_filter);
        }
        $studentTests = $studentTests->get();
        return Datatables::of($studentTests)
            ->addColumn('action', function ($studentTest) {
                // $route = route('student_test_detail', [@$studentTest->uuid]);
                $route = route('student_test_papers', [@$studentTest->uuid]);
                return \View::make('admin.student-test.test_action', ['route' => $route, 'studentTest' => $studentTest, 'type' => config('constant.col_action')])->render();
            })
            ->addColumn('student_no', function ($studentTest) {
                return @$studentTest->student->student_no;
            })
            ->addColumn('mock_test_title', function ($studentTest) {
                return @$studentTest->mockTest->title;
            })
            ->editColumn('start_date', function ($studentTest) {
                return @$studentTest->start_date_text;
            })
            ->editColumn('end_date', function ($studentTest) {
                return @$studentTest->end_date_text;
            })
            ->editColumn('no_of_attempt', function ($studentTest) {
                return @$studentTest->attempt_count;
            })
            ->editColumn('mock_completion', function ($studentTest) {
                $ratio = 0;
                $attemptedCount = 0;
                if (isset($studentTest->studentTestResult)) {
                    $attemptedCount = @$studentTest->attempted;
                    $totalQuestion = @$studentTest->questions;
                    if ($attemptedCount > 0 && $totalQuestion > 0) {
                        $ratio = ($attemptedCount * 100) / $totalQuestion;
                    }
                }
                return $ratio . '%';
            })
            ->rawColumns(['student_no', 'mock_test_title', 'start_date', 'end_date', 'action', 'mock_completion'])
            ->make(true);
    }
     /**
     * -------------------------------------------------
     * |  Get Student Data                             |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function getData(Request $request)
    {
        $studentTests = StudentTest::whereStudentId($request->student_id)
                        ->whereHas('mockTest')
                        ->whereProjectType(1)
                        ->orderBy('start_date', 'desc');
        $fromDate = $toDate = "";
        if ($request->from_date_filter != "" && $request->to_date_filter != "") {
            $fromDate = Carbon::parse($request->from_date_filter)->format('Y-m-d 00:00:00');
            $toDate = Carbon::parse($request->to_date_filter)->format('Y-m-d 23:59:59');
        } elseif ($request->from_date_filter != "") {
            $fromDate = Carbon::parse($request->from_date_filter)->format('Y-m-d 00:00:00');
            $toDate = Carbon::parse($request->from_date_filter)->format('Y-m-d 23:59:59');
        } elseif ($request->to_date_filter != "") {
            $fromDate = Carbon::parse($request->to_date_filter)->format('Y-m-d 00:00:00');
            $toDate = Carbon::parse($request->to_date_filter)->format('Y-m-d 23:59:59');
        }
        // $fromDate = date('Y-m-d 00:00:00',strtotime($request->start_date));
        // $toDate = date('Y-m-d 23:59:59',strtotime($request->end_date));
        if ($fromDate && $toDate) {
            $studentTests = $studentTests->whereRaw("(start_date >= ? AND end_date <= ?)", [$fromDate, $toDate]);
        }
        if (isset($request->select_mock_title_filter) && $request->select_mock_title_filter != "all") {
            $studentTests = $studentTests->where('mock_test_id', $request->select_mock_title_filter);
        }
        $studentIds = $studentTests->pluck('student_id');
        $students = Student::whereIn('id', $studentIds)
            ->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            })
            ->get();
        return Datatables::of($students)
            ->addColumn('action', function ($student)  use($fromDate,$toDate) {
                $route = route('student_test_show', [@$student->uuid,'fromDate'=>$fromDate,'toDate'=>@$toDate]);
                return \View::make('admin.student-test.action', ['route' => @$route, 'studentTest' => $student, 'type' => config('constant.col_action')])->render();
            })
            ->editColumn('parent_name', function ($student) {
                return @$student->parents->full_name;
            })->editColumn('student_no', function ($student) {
                return @$student->ChildIdText;
            })
            ->editColumn('no_of_test', function ($student) use($fromDate,$toDate) {
                return @$student->studentTestCount($fromDate,$toDate);
            })
            ->rawColumns(['no_of_test', 'parent_name', 'action'])
            ->make(true);
    }
    /**
     * -------------------------------------------------
     * |  Show Student Test detail                     |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    
    public function studentMock($uuid,$fromDate=null,$toDate=null)
    {
        try{
            $student = Student::whereUuid($uuid)->first();
            $studentTest = StudentTest::whereProjectType(1)
                            ->whereRaw("(start_date >= ? AND end_date <= ?)", [$fromDate, $toDate])
                            ->whereHas('mockTest')
                            ->whereStudentId($student->id)
                            ->get();
            $studentTestMockIds = StudentTest::whereProjectType(1)
                                    ->whereRaw("(start_date >= ? AND end_date <= ?)", [$fromDate, $toDate])
                                    ->whereHas('mockTest')
                                    ->whereStudentId($student->id)
                                    ->pluck('mock_test_id');
            $mockTests = MockTest::whereIn('id', $studentTestMockIds)->get();
            return view('admin.student-test.mock-detail', ['student' => @$student, 'mockTests' => @$mockTests, 'studentTest' => @$studentTest,'fromDate'=>@$fromDate, 'toDate'=>@$toDate]);
        }catch(Exception $e){
            return redirect()->route('student_test_index');
        }
    }
    /**
     * -------------------------------------------------
     * | Reset Attempt Test detail                     |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */

    public function resetAttempt($uuid = null)
    {
        $this->dbStart();
        try{
            $studentTestPaper = StudentTestPaper::whereUuid($uuid)->first();
            $studentTest = $studentTestPaper->studentTest;
            $purchasedMock = PurchasedMockTest::where(['mock_test_id' => $studentTest->mock_test_id, 'student_id' => $studentTest->student_id])->update(['status' => 1]);
            $studentTest->update(['status' => 0]);
            if($studentTestPaper){
                $studentTestPaper->update(['time_taken'=>0,'is_reset' => '1']);
            }
            $result = StudentTestResults::where(['student_test_paper_id' => @$studentTestPaper->id,'student_id'=>$studentTest->student_id])
                        ->where('is_reset','0')
                        ->orderBy('id', 'desc')
                        ->first();
            if($result){
                $result->update(['is_reset' => '1']);
                $studentTest->update(['attempted'=>0,'correctly_answered'=>0,'obtained_marks'=>0,'overall_result'=>0,'attempted'=>0,'unanswered'=>0]); 
                $studentTestPaper->update(['attempted'=>0,'correctly_answered'=>0,'obtained_marks'=>0,'overall_result'=>0,'attempted'=>0,'unanswered'=>0]); 
                // StudentTestResults::where(['student_test_paper_id' => @$studentTestPaper->id,'student_id'=>$studentTest->student_id])->delete();
            }
            $this->dbCommit();
            return response()->json(['msg' => 'Test Reseted successfully', 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            $this->dbRollBack();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }
    /**
     * -------------------------------------------------
     * | Show Student Test detail                      |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
   
    public function show($uuid)
    {
        try{
            ini_set('max_execution_time', 500);
            $routeName = Route::currentRouteName();
            $studentTestPaper = StudentTestPaper::whereUuid($uuid)->first();
            if($studentTestPaper->is_greater_then_end_date == true){
                // manually update rank
                // $data = $this->generateResult($studentTestPaper);
            }
            $student = Student::whereId($studentTestPaper->student_id)->first();
            $mockTest = @$studentTestPaper->paper->mockTest;
            // dd($studentTestPaper->studentResultWithReset);
            if($studentTestPaper->studentResultWithReset == null){
                return redirect()->back()->with('error','Result Not Found !');
            }
            $studentTestResults = @$studentTestPaper->studentResultsWithReset;
            $resultData = @$studentTestPaper->studentResultsWithReset;
            $totalQuestions = $mockTest->mockTestSubjectDetail->sum('questions');
            $totalMarks = $mockTest->mockTestSubjectQuestion->sum('total_marks');
            $mockTestPaper = @$studentTestPaper->paper;
            $studentTestResult = @$studentTestPaper->studentResultWithReset;
            $totalStudentAttemptTest = @$data[0];
            $questions = $studentTestPaper->studentResultWithReset->currentStudentTestQuestionAnswers()->paginate(5);
            return view('admin.student-test.detail')->with(['questions'=>@$questions,'studentTestResult'=>@$studentTestResult,'mockTestPaper'=>@$mockTestPaper,'totalQuestions'=>@$totalQuestions,'totalMarks'=>@$totalMarks,'resultData'=>@$resultData, 'mockTest' => @$mockTest, 'student' => @$student, 'studentTest' => @$studentTestPaper, 'studentTestResults' => @$studentTestResults, 'totalStudentAttemptTest' => @$totalStudentAttemptTest]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    /**
     * -------------------------------------------------
     * | Send student report email to parent           |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
  
    public function emailReport($uuid)
    {
        try {
            $studentTestPaper = StudentTestPaper::whereUuid($uuid)->first();
            $student = $studentTestPaper->student;
            $mockTest = $studentTestPaper->paper->mockTest;
            $studentTestResults = StudentTestResults::where(['student_test_paper_id' => @$studentTestPaper->id, 'is_reset' => 0])->orderBy('id', 'desc')->first();
            $resetAttempt = StudentTestResults::where(['student_test_paper_id' => @$studentTestPaper->id, 'is_reset' => 1])->count();
            $subjectIds = StudentTestQuestionAnswer::where(['mock_test_id' => $mockTest->id, 'student_id' => $student->id])->pluck('subject_id');
            $subjects = Subject::whereIn('id', $subjectIds)->get();
            $studentTestQuestionAnswers = StudentTestQuestionAnswer::where(['mock_test_id' => $mockTest->id, 'student_id' => $student->id])->get();
            if ($studentTestResults) {
                $attemptedCount = StudentTestQuestionAnswer::whereStudentTestResultId($studentTestResults->id)->whereIsAttempted(1)->count('is_attempted');
                $totalQuestion = $mockTest->mockTestSubjectQuestion->count();
                $attemptedCount = ($attemptedCount==0)?1:$attemptedCount;
                $totalQuestion = ($totalQuestion==0)?1:$totalQuestion;
                $ratio = ($attemptedCount * 100) / $totalQuestion;
            } else {
                $ratio = 0;
                $attemptedCount = 0;
            }
            $userdata = ParentUser::find($student->parent_id);
            $view = 'admin.student-test.__sendmail';
            $this->sendMail($view, ['studentTestQuestionAnswers' => @$studentTestQuestionAnswers, 'mockTest' => @$mockTest, 'student' => $student, 'studentTest' => $studentTestPaper, 'studentTestResults' => $studentTestResults, 'subjects' => $subjects, 'ratio' => $ratio, 'resetAttempt' => $resetAttempt], null, 'Exam Report', @$userdata);
            // return redirect()->back();
            return response()->json(['status' => __('admin_messages.icon_success')]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * -------------------------------------------------
     * | Send student Papers                           |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
  

    public function papers($uuid){
        $studentTest = StudentTest::whereUuid($uuid)->first();
        $student = $studentTest->student;
        $mockTest = $studentTest->mockTest;
        return view('admin.student-test.paper', ['student' => @$student, 'mockTest' => @$mockTest, 'studentTest' => @$studentTest]);
    }

    /**
     * -------------------------------------------------------
     * | question detail                                     |
     * |                                                     |
     * | @param questionId                                   |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function questionDetail(Request $request){
        try{
            $question = Question::where('uuid',$request->uuid)->firstOrFail();
            $studentTestQuestionAnswer = StudentTestQuestionAnswer::where('uuid',$request->id)->first();
            $mockTest = @$studentTestQuestionAnswer->mockTest;
            $html = $this->getPartials('newfrontend.paper._question_detail', ['question' => @$question,'studentTestQuestionAnswer'=>@$studentTestQuestionAnswer,'mockTest'=>@$mockTest]);
            return response()->json(['html'=>$html,'status'=>'success']);
        }catch(Exception $e){
            return response()->json(['status'=>'info']);
        }
    }

    /**
     * -------------------------------------------------------
     * | show paper section correct and incorrect questions  |
     * |                                                     |
     * | @param resultId,sctionId,questionId                 |
     * | @return view                                        |
     * -------------------------------------------------------
     */
    public function viewQuestion($uuid=null,$sectionId=null,$questionId=null){
        $studentTestResults = StudentTestResults::where(['uuid'=>$uuid])->first();
        $startDate = date('Y-m-01',strtotime($studentTestResults->created_at));
        $endDate = date('Y-m-t',strtotime($studentTestResults->created_at));
        $studentTestPaper = $studentTestResults->studentTestPaper;
        $totalStudentAttemptTest = StudentTestPaper::where(['mock_test_paper_id'=>$studentTestPaper->mock_test_paper_id,'is_completed'=>1])
                                    ->select('id','mock_test_paper_id','is_completed')
                                    ->whereBetween('updated_at',[$startDate,$endDate])
                                    ->count();
        $student = $studentTestPaper->student;
        $mockTest = $studentTestResults->mockTest;
        $paper = $studentTestPaper->paper;
        $sectionData = MockTestSubjectDetail::find($sectionId);
        $limit = null;
        if($sectionData){
            $limit = $sectionData->report_question;
        }
        $questionList = $sectionData->questionList3()
                        ->orderBy('id', 'asc')
                        // ->paginate(5);
                        // ->limit($limit)
                        ->get();
        $routeName = Route::currentRouteName();
        if($routeName=='view-result-incorrect-questions'){
            $studentTestQuestionAnswerIds = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResults->id)
                                            ->where(['section_id'=>$sectionId])
                                            ->where('is_correct','!=','1')
                                            ->orderBy('id', 'asc')
                                            // ->limit($limit)
                                            ->pluck('id');
        }else{
            $studentTestQuestionAnswerIds = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResults->id)
                                            ->where(['section_id'=>$sectionId])
                                            ->orderBy('is_correct', 'desc')
                                            // ->limit($limit)
                                            ->pluck('id');
        }
        $studentTestQuestionAnswers = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResults->id)
                                        ->whereIn('id',$studentTestQuestionAnswerIds)
                                        ->orderBy('id','asc')
                                        ->paginate(5);

        $title = ($routeName=='view-result-incorrect-questions')?__('formname.view_incorrect_question'):__('formname.view_all_question');
        return view('admin.student-test.questions', ['title'=>@$title,'questionList' => @$questionList, 'mockTest' => @$mockTest,
        'student' => $student, 'studentTest' => $studentTestPaper,'questionData' => @$questionData,
        'studentTestResults' => $studentTestResults,'totalStudentAttemptTest'=>@$totalStudentAttemptTest,'studentTestQuestionAnswers' => @$studentTestQuestionAnswers]);
    }
}
