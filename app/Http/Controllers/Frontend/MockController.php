<?php

namespace App\Http\Controllers\Frontend;

use DB;
use Session;
use DateTime;
use App\Models\Cart;
use App\Models\Grade;
use App\Models\Order;
use App\Models\Answer;
use App\Models\Schools;
use App\Models\Student;
use App\Models\Subject;
use App\Models\MockTest;
use App\Models\Question;
use App\Models\ExamBoard;
use App\Models\OrderItem;
use App\Models\ParentUser;
use App\Models\StudentTest;
use Illuminate\Support\Str;
use App\Helpers\OrderHelper;
use App\Models\QuestionList;
use Illuminate\Http\Request;
use App\Models\QuestionMedia;
use App\Helpers\MockTestHelper;
use App\Models\CMS;
use App\Models\MockTestPaper;
use App\Models\StandardExamTest;
use Yajra\DataTables\DataTables;
use App\Models\PurchasedMockTest;
use App\Models\StandardExamStatus;
use App\Models\StudentTestResults;
use Illuminate\Support\Facades\Auth;
use App\Models\MockTestSubjectDetail;
use App\Models\MockTestSubjectQuestion;
use App\Models\ParentPayment;
use App\Models\PurchasedMockTestRating;
use App\Models\StudentTestPaper;
use App\Models\StudentTestQuestionAnswer;
use Exception;
use Cache;

class MockController extends BaseController
{
    public $mockTests;
    public $examBoard;
    protected $viewConstant = 'newfrontend.e_mock.';

    public function __construct(MockTest $mockTests, ExamBoard $examBoard, OrderHelper $orderHelper, MockTestHelper $mockTestHelper, QuestionMedia $questionMedia)
    {
        $this->mockTests = $mockTests;
        $this->examBoard = $examBoard;
        $this->orderHelper = $orderHelper;
        $this->mockTestHelper = $mockTestHelper;
        $this->questionMedia = $questionMedia;
    }

    /**
     * -------------------------------------------------------
     * | Mock Detail Page                                    |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function detail($uuid)
    {
        try{
            $mockTest = $this->mockTests->whereUuid($uuid)->with(['mockTestSubjectDetail', 'examBoard'])->firstOrFail();
            $examBoard = $this->examBoard->where('id', $mockTest->exam_board_id)->with('mockTests')
                        ->with(['mockTests' => function ($query) use ($mockTest) {
                            $query->where('id', '!=', $mockTest->id);
                        }])->first();
            $checkProductInSession = Cart::whereParentId(Auth::guard('parent')->id())->whereMockTestId($mockTest->id)->get();
            $orderIds = Order::whereParentId(Auth::guard('parent')->id())->pluck('id');
            $orderItems = OrderItem::whereIn('order_id', $orderIds)->whereMockTestId($mockTest->id)->count();
            $flag = true;
            if ($orderItems > 0) {
                $flag = false;
            }
            if (Auth::guard('student')->user() != null) {
                $flag = false;
            }
            return view('newfrontend.e_mock.detail', ['flag' => @$flag, 'mockTest' => $mockTest, 'examBoard' => $examBoard, 'checkProductInSession' => @$checkProductInSession]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Mock Categories Page                                |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function category()
    {
        try{
            $examBoards = $this->examBoard->get();
            return view($this->viewConstant . 'category', ['examBoards' => @$examBoards]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Exam board Mock Exam List group by grade        |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function boardExam($slug = null)
    {
        try{
            $today = date('Y-m-d');
            $examBoardBoth = $this->examBoard->with('mockTests')->orderBy('id','desc')->get();
            $examBoardEveryOne = $this->examBoard->with(['mockTests' => function ($q) {
                $q->where('show_mock', '=', 2);
            }])->orderBy('id','asc')->get();
            $examBoard = $this->examBoard->whereSlug($slug)->first();
            if ($examBoard) {
                $gradeIds = $examBoard->mockTests->pluck('grade_id');
                $grades = Grade::whereIn('id', $gradeIds)->get();
                foreach ($grades as $gkey => $grade) {
                    $query = MockTest::whereGradeId($grade->id)
                            ->where('end_date', '!=', null)
                            ->whereDate('end_date', '>=', $today)
                            ->active()
                            ->whereExamBoardId($examBoard->id);
                    if ($slug == 'super_selective') {
                        $schoolIds = $query->pluck('school_id');
                        $schools = Schools::whereIn('id', $schoolIds)->get();
                        $grades[$gkey]['schools'] = $schools;
                    } else {
                        $grades[$gkey]['mockTest'] = $query->get();
                    }
                }
            }
            return view($this->viewConstant . 'exams', ['examBoardBoth'=>@$examBoardBoth,'examBoardEveryOne'=>@$examBoardEveryOne,'subjects' => @$subjects, 'grades' => @$grades, 'examBoard' => @$examBoard]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Exam board mock exam list                       |
     * |                                                     |
     * | @return Datatable                                   |
     * -------------------------------------------------------
     */
    public function getData(Request $request)
    {
        $today = date('Y-m-d');
        $examBoard = $this->examBoard->find($request->exam_board_id);
        $query = MockTest::active()
            ->where('end_date', '!=', null)
            ->whereDate('end_date', '>=', $today)
            ->whereExamBoardId($request->exam_board_id)
            ->where(function($q) use($request){
                if($request->school_id != null){
                    $q->whereSchoolId($request->school_id);
                }
            })->orderBy('created_at','desc');
        if ($examBoard->slug == 'super_selective') {
            $mockTestList = $query->whereGradeId($request->grade_id)
                            ->where(function($q) use($request){
                                if($request->exam_type != null){
                                    $q->whereStageId($request->exam_type);
                                }
                            })
                            ->get();
        } else {
            $mockTestList = $query->whereGradeId($request->grade_id)->get();
        }
        return DataTables::of($mockTestList)
            ->addColumn('action', function ($mockTest) {
                return $this->getPartials($this->viewConstant . '_add_action', ['mockTest' => @$mockTest]);
            })
            ->editColumn('price', function ($mockTest) {
                return config('constant.default_currency_symbol') . @$mockTest->price;
            })
            ->addColumn('date', function ($mockTest) {
                return @$mockTest->proper_start_date_and_end_date;
            })
            ->addColumn('time', function ($mockTest) {
                return @$mockTest->total_paper_time;
            })
            ->editColumn('image', function ($mockTest) {
                return $this->getPartials($this->viewConstant . '_add_image', ['mockTest' => @$mockTest]);
            })
            ->editColumn('exam_name', function ($mockTest) {
                return $this->getPartials($this->viewConstant . '_add_exam', ['mockTest' => @$mockTest]);
            })
            ->rawColumns(['image', 'exam_name', 'date', 'time', 'action'])
            ->make(true);
    }

    /**
     * -------------------------------------------------------
     * | Get Parent purchased mock page                      |
     * | Get My Mock list and completed mock list            |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function purchasedMock()
    {
        try{
            // get login parent data
            $parent = Auth::guard('parent')->user();
            $studentId = @$parent->child->id;
            $date = date('Y-m-d');
            // get parent order ids
            $orderIds = Order::select('id','parent_id')->whereParentId($parent->id)->orderBy('id','desc')->pluck('id');
            // get mock test ids which are not assigned to child based on status 
            $mockTestIds = PurchasedMockTest::whereParentId($parent->id)
                            ->whereHas('mockTest',function($query) use($date){
                                $query->whereStatus('1');
                            })
                            ->where('status','!=',1)
                            ->pluck('mock_test_id');

            // get my mocks 
            $items = OrderItem::wherePaperId(null)
                    ->whereNotIn('mock_test_id', $mockTestIds)
                    ->whereIn('order_id', $orderIds)
                    ->orderBy('order_id','desc')
                    ->whereHas('mockTest',function($query) use($date){
                        $query->whereStatus('1');
                    })
                    ->get();

            $studentIds = $parent->childs->pluck('id');
            // get my completed mocks
            $completedMocks = StudentTest::whereIn('student_id',$studentIds)
                                ->whereProjectType(1)
                                ->orderBy('updated_at','desc')
                                ->whereHas('mockTest',function($query) use($date){
                                    $query->whereStatus('1');
                                    // $query->whereDate('end_date','>',$date);
                                })
                                ->whereHas('completedStudentTestPapers')
                                ->get();

            $parentRatingArr = $parent->mockRatings->pluck('mock_test_id')->toArray();
            @$cms = CMS::where('page_slug','purchased-mocks')->first();
            $evaluatedMocks = [];
            return view('newfrontend.user.purchased_mocks', ['items' => @$items,
                'completedMocks' => @$completedMocks,'cms' =>@$cms,
                'evaluatedMocks' => @$evaluatedMocks, 'parentRatingArr' => $parentRatingArr,'studentId' => @$studentId]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | assign purchased mock to child and also check that  |
     * | exam is not ongoing or not alredy assigned          |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function assignMock(Request $request)
    {
        $parent = Auth::guard('parent')->user();
        $studentId = $request->student_id;
        $purchasedMock = PurchasedMockTest::whereParentId($parent->id)
                        ->whereMockTestId($request->mock_test_id)
                        ->whereStatus(1)
                        ->first();
        // get completed student test 
        $studentTest = StudentTest::where(['mock_test_id'=>$request->mock_test_id,'status'=>1,'student_id'=>@$request->student_id])->first();
        // check that exam is not inprogress or not alredy assigned
        if ($purchasedMock == null && $studentTest == null) {
                array_set($request, 'student_id', $studentId);
                array_set($request, 'status', 1);
                array_set($request, 'project_type', 1);
                $purchasedMock = new PurchasedMockTest();
                $purchasedMock->fill($request->all())->save();
                return response()->json(['msg' => __('frontend.parentmock.success_status'), 'icon' => __('admin_messages.icon_success')]);
        }elseif($studentTest == null){
            $purchasedMock->fill($request->all())->save();
            return response()->json(['msg' => __('frontend.parentmock.success_status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('frontend.parentmock.info_status'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * -------------------------------------------------------
     * | Get student exams                                   |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function studentMocks()
    {
        try{
            $student = Student::whereId(Auth::guard('student')->id())->first();
            $date = date('Y-m-d');
            // student mocks which are assigned to students
            $myMocks = PurchasedMockTest::whereStudentId($student->id)
                        ->whereHas('mockTest')
                        ->orderBy('updated_at','desc')
                        ->get();
            foreach($myMocks as $mock){
                $mockTest = $mock->mockTest;
                $mockTestPaperIds = $mockTest->papers->pluck('id') ?? [];
                $mockTestPaperCount = $mockTest->papers->count() ?? 0;
                $studentTest = StudentTest::where('mock_test_id',$mock->mock_test_id)
                                ->where('student_id',$mock->student_id)
                                ->orderBy('id','desc')
                                ->first();
                $query = StudentTestPaper::where('student_id',$student->id)
                            ->whereIn('mock_test_paper_id',$mockTestPaperIds)
                            ->where('is_reset','0')
                            ->whereHas('studentResult')
                            ->orderBy('id','desc');
                $studentTestPapers = $query->get();
                $testPaperCount = $query->count();
                if($studentTestPapers){
                    $query->update(['is_completed'=>'1']);
                }
                if($testPaperCount == $mockTestPaperCount){
                    if($mockTest->stage_id == 1){
                        $status = 2;
                    }else{
                        $status = 3;
                    }
                    $studentTest->update(['status'=>$status]);
                    $mock->update(['status'=>$status]);
                }
            }
            $myMocks = PurchasedMockTest::whereStudentId($student->id)
                        ->whereHas('mockTest',function($query) use($date){
                            $query->whereDate('end_date','>=',$date);
                            $query->whereStatus('1');
                        })
                        ->where('status','=','1')
                        ->orderBy('updated_at','desc')
                        ->get();
            $completedMocks = StudentTest::whereStudentId($student->id)
                                ->whereProjectType(1)
                                ->where('status','!=',1)
                                ->where('status','!=',0)
                                ->orderBy('updated_at','desc')
                                ->get();
            $inprgExam = StudentTestPaper::whereStudentId(Auth::guard('student')->id())
                                ->whereHas('paper',function($query){
                                    $query->whereNull('deleted_at');
                                    $query->whereHas('mockTest');
                                })
                                ->whereIsCompleted('0')
                                ->where('is_reset','0')
                                ->whereHas('studentTest')
                                ->count();
            return view('newfrontend.child.my_mocks', ['inprgExam'=>@$inprgExam,'myMocks' => @$myMocks, 'completedMocks' => @$completedMocks]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get parent exams                                    |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function mockExam($uuid)
    {
        $this->dbStart();
        try{
            $student = Auth::guard('student')->user();
            $mockTest = MockTest::whereUuid($uuid)->firstOrFail();
            $paper = $mockTest->papers()->orderBy('id','asc')->first();
            $subjects = $paper->mockTestSubjectQuestion()->orderBy('subject_id','asc')->get();
            $questionIds = $subjects->pluck('question_id');
            $questionList = QuestionList::whereIn('question_id', $questionIds)->orderBy('question_id', 'asc');
            $questionListIds = $questionList->pluck('id');
            $totalQuestions = $questionList->count();
            $totalMarks = $questionList->sum('marks');
            $subjectDetail = $paper->mockTestSubjectDetail;
            $examTotalTime = $paper->mockTestSubjectDetail()->sum('time');
            // $examTotalTime = @$subjectDetail[0]->time;
            $time = 0;
            foreach($mockTest->papers as $key => $paperData){
                $timeArray[$key]['paper_id'] = $paperData->id;
                // $time += ($detail->time * 60);
                $timeArray[$key]['time'] = $paperData->mockTestSubjectDetail()->sum('time');
            }
            $examTotalSeconds = $examTotalTime * 60;
            $studentTest = StudentTest::where(['student_id' => $student->id,'mock_test_id' => $mockTest->id,'status'=>1])->first();
            if($studentTest != NULL || $totalQuestions == 0){
                $testPaper = StudentTestPaper::where([
                    'student_id' => $student->id,
                    'mock_test_paper_id' => $paper->id,
                    'is_reset' => 0,
                ])->first();
                if($testPaper){
                    $studentTestResultsData = StudentTestResults::where([
                        'student_id' => $student->id,
                        'student_test_id' => $studentTest->id,
                        'mock_test_id' => $mockTest->id,
                        'student_test_paper_id' => $testPaper->id,
                        'is_reset' => 0,
                    ])->first();
                    $query = StudentTestQuestionAnswer::whereStudentTestResultId($studentTestResultsData->id)->whereStudentId($student->id)->whereMockTestId($mockTest->id);
                    $unanswered = $query->whereIsAttempted(0)->count();
                    $studentTestResultsData->update([
                        'unanswered' => $unanswered,
                    ]);
                }
                $purchasedMock = PurchasedMockTest::whereMockTestId($mockTest->id)->whereStudentId($student->id)->where('status', '<>', 2)->first();
                if ($purchasedMock) {
                    $purchasedMock->update(['status' => 2]);
                }
                // $testPaper->update(['is_completed'=>1]);
                $studentTest->update(['status' => 2]);
                if($totalQuestions == 0){
                    return redirect()->route('student-mocks')->withErrors(['msg','No questions found in this mock']);
                }
                return redirect()->route('student-mocks')->withErrors(['msg','This mock exam ended']);
            }
            // allAudios
            $firstAudio = '';
            $secondAudio = '';
            $thirdAudio = '';
            $forthAudio = '';
            $secondAudioPlayTime = 0;
            $thirdAudioPlayTime = 0;
            $forthAudioPlayTime = 0;
            if (count($mockTest->mockAudio) > 0) {
                $firstAudio = $mockTest->mockAudio->where('seq', 1)->first();
                $secondAudio = $mockTest->mockAudio->where('seq', 3)->first();
                $thirdAudio = $mockTest->mockAudio->where('seq', 4)->first();
                $forthAudio = $mockTest->mockAudio->where('seq', 2)->first();
    
                $secondAudioPlayTime = ($examTotalSeconds / 2) * 1000;
                $thirdAudioPlayTime = ($examTotalSeconds - 60) * 1000;
                $forthAudioPlayTime = ($examTotalSeconds - 1) * 1000;
            }

            $questions = $paper->mockTestSubjectDetail()->sum('questions');
            $totalMarks = $paper->mockTestSubjectQuestion->sum('total_marks');

            $studentTest = StudentTest::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'mock_test_id' => $mockTest->id,
                ], [
                    'student_id' => $student->id,
                    'mock_test_id' => $mockTest->id,
                    'start_date' => date('Y-m-d', strtotime(now())),
                    'end_date' => date('Y-m-d', strtotime(now())),
                    'status' => 1,
                    'duration' => 1,
                    'project_type' => 1,
                    'questions' => $questions,
                    'attempted' => 0,
                    'correctly_answered' => 0,
                    'unanswered' => $questions,
                    'overall_result' => 0,
                    'total_marks' => $totalMarks,
                    'obtained_marks' =>0,
                ]);
            $attemptCount = $studentTest->attempt_count + 1;
            $studentTest->update(['attempt_count'=>$attemptCount]);
            foreach($mockTest->papers as $paperKey => $paperData){
                $paperQuestionIds = $paperData->mockTestSubjectQuestion->pluck('question_id');
                $questionList = QuestionList::whereIn('question_id', $paperQuestionIds)->orderBy('question_id', 'asc');
                $paperTotalQuestions = $questionList->count();
                $totalMarks = $questionList->sum('marks');
                $testPaperData = StudentTestPaper::create([
                    'student_id' => $student->id,
                    'mock_test_id' => $mockTest->id,
                    'mock_test_paper_id' => $paperData->id,
                    'student_test_id' => $studentTest->id,
                    'questions' => $questions,
                    'attempted' => 0,
                    'unanswered' => $questions,
                    'correctly_answered' => 0,
                    'obtained_marks' => 0,
                    'overall_result' => 0,
                    'total_marks' => $totalMarks,
                    'is_completed' => 0,
                ]);
                $testPaperId[] = $testPaperData->id;
                $studentTestResult = StudentTestResults::create([
                    'student_id' => $student->id,
                    'student_test_id' => $studentTest->id,
                    'mock_test_id' => $mockTest->id,
                    'questions' => $paperTotalQuestions,
                    'attempted'=>0,
                    'unanswerd'=>0,
                    'overall_result'=>0,
                    'obtained_marks'=>0,
                    'questions' => $paperTotalQuestions,
                    'correctly_answered' => 0,
                    'unanswered' =>$paperTotalQuestions,
                    'total_marks' => $totalMarks,
                    'student_test_paper_id' => $testPaperData->id,
                ]);
                StudentTestQuestionAnswer::where(
                    [
                        'student_id' => $student->id,
                        'mock_test_id' => $mockTest->id,
                        'student_test_result_id' => $studentTestResult->id,
                    ])->delete();
                $subjectsData = $paperData->mockTestSubjectQuestion()->orderBy('subject_id','asc')->get();
                foreach($subjectsData as $key => $subject){
                    $questionList = QuestionList::where('question_id', $subject->question_id)->select('id','question_id')->get();
                    foreach($questionList as $key => $question){
                        $testQnA = StudentTestQuestionAnswer::create(
                            [
                                'student_id' => $student->id,
                                'mock_test_id' => $subject->mock_test_id,
                                'question_id' => $question->question_id,
                                'mark_as_review' =>0,
                                'subject_id' =>$subject->subject_id,
                                'is_correct' =>0,
                                'is_attempted' =>0,
                                'time_taken' =>0,
                                'answer_id'=>null,
                                'student_test_result_id' => $studentTestResult->id,
                                'question_list_id'=>$question->id,
                            ]);
                        // $answers[] = $testQnA;
                        if($paperKey==0 && $key == 0){
                            Session::put('question_answer_id',$testQnA->id);
                            Session::put('questionNo',1);
                        }
                    }
                }
            }
            $testPaper = StudentTestPaper::where([
                'student_id' => $student->id,
                'mock_test_paper_id' => $paper->id,
                'student_test_id' => $studentTest->id,
            ])->first();
            $studentTestResult = StudentTestResults::where([
                'student_id' => $student->id,
                'student_test_id' => $studentTest->id,
                'mock_test_id' => $mockTest->id,
                'is_reset' => 0,
                'student_test_paper_id' => $testPaperId[0],
            ])->first();
            $questionList = StudentTestQuestionAnswer::where([
                            'student_test_result_id' => $studentTestResult->id,
                            ])->orderBy('id','asc')->get();
            $currentQuestion = $questionList[0];
            $attempted = isset($studentTestResult->attempted)?$studentTestResult->attempted:0;
            $answers = Answer::whereQuestionListId(@$currentQuestion->question_list_id)->get();
            // get previous user id
            $prevQuestionId = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResult->id)->where('id', '<', $currentQuestion->id)->max('id');
            // get next user id
            $nextQuestionId = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResult->id)->where('id', '>', $currentQuestion->id)->min('id');
            session()->put('isExam','yes');
            session()->put('paper_id',null);
            $nextSubjectId = @$timeArray[1]['paper_id'];
            $nextSubjectTime = @$timeArray[1]['time'];
            $currentSubject = MockTestPaper::where('id',$timeArray[0]['paper_id'])->first();
            $nextSubject = MockTestPaper::where('id',$nextSubjectId)->first();
            $this->dbCommit();
            // return view('newfrontend.child.mock_exam',['subject_id' => $question->subject_id,'mockTest'=>@$mockTest,'student' => $student,'ip' => \Request::ip(),'firstQuestion' => $firstQuestion,'answers' => $answers,'time_left' => hoursAndMins($examTotalTime),'examTotalTimeSeconds' => $examTotalTime * 60,'nextQuestionId' => $nextQuestionId,'prevQuestionId' => $prevQuestionId,'total_subjects' => count($subjects),'totalQuestions' => $totalQuestions,'studentTest'=>@$studentTest,'studentTestResult'=>@$studentTestResult]);
            return view('newfrontend.child.mock_exam', ['questionListIds' => $questionListIds, 'subject_id' => $currentQuestion->subject_id,
                'mockTest' => @$mockTest, 'student' => $student, 'ip' => \Request::ip(), 'firstQuestion' => $currentQuestion,'nextSubjectTime'=>@$nextSubjectTime,
                'answers' => $answers, 'time_left' => hoursAndMins($examTotalTime), 'examTotalTimeSeconds' => $examTotalSeconds,'nextSubjectTime' => @$nextSubjectTime,
                'nextQuestionId' => $nextQuestionId, 'prevQuestionId' => $prevQuestionId, 'total_subjects' => count($subjects),'nextSubject'=>@$nextSubject,
                'totalQuestions' => $totalQuestions, 'studentTest' => @$studentTest, 'studentTestResult' => @$studentTestResult,'currentSubject'=>@$currentSubject,
                'firstAudio' => @$firstAudio, 'secondAudio' => @$secondAudio, 'thirdAudio' => @$thirdAudio, 'forthAudio' => @$forthAudio,
                'secondAudioPlayTime' => @$secondAudioPlayTime, 'thirdAudioPlayTime' => @$thirdAudioPlayTime,'nextSubjectId' => @$nextSubjectId,
                'forthAudioPlayTime' => @$forthAudioPlayTime,'qno'=>@$qno,'attempted'=>@$attempted,'timeArray'=>@$timeArray,'inBetweenTime'=>@$inBetweenTime]);
        }catch(Exception $e){
            $this->dbRollBack();
            return redirect()->back();
        }
    }

    /**
     * -------------------------------------------------------
     * | Get child result                                    |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function ViewChildResult($mockTestId,$studentId){
        try{
            $mockTest = MockTest::whereUuid($mockTestId)->firstOrFail();
            $studentTest = StudentTest::where(['mock_test_id' => $mockTest->id,'student_id'=>$studentId])->first();
            $student = Student::whereId($studentId)->first();
            $studentTestResults = StudentTestResults::where(['student_test_id' => $studentTest->id, 'mock_test_id' => $mockTest->id, 'student_id' => $student->id, 'is_reset' => 0])->orderBy('id', 'desc')->get();
            $questions = $studentTestResults->sum('questions');
            $attempted = $studentTestResults->sum('attempted');
            $correctlyAnswered = $studentTestResults->sum('correctly_answered');
            $unanswered = $studentTestResults->sum('unanswered');
            $totalMarks = $studentTestResults->sum('total_marks');
            $obtainedMarks = $studentTestResults->sum('obtained_marks');
            $overAllResult = 0;
            if ($attempted > 0 && $totalMarks > 0) {
                $overAllResult = ($obtainedMarks * 100) / $totalMarks;
                $overAllResult = number_format($overAllResult,2);
            }
            $studentTest->update([
                'questions' => $questions,
                'attempted' => $attempted,
                'correctly_answered' => $correctlyAnswered,
                'unanswered' => $unanswered,
                'overall_result' => $overAllResult,
                'total_marks' => $totalMarks,
                'obtained_marks' =>$obtainedMarks,
            ]);
            $studentTest = StudentTest::where(['mock_test_id' => $mockTest->id, 'student_id' => $student->id])->first();
            $subjectIds = $mockTest->subjects->pluck('subject_id');
            $resetAttempt = StudentTestResults::where(['student_test_id' => @$studentTest->id])->count();
            $rank = 0;
            $query = StudentTest::where(['mock_test_id' => @$studentTest->mock_test_id]);
            $testResults = $query->orderBy('overall_result', 'desc')->get();
            if ($testResults) {
                foreach ($testResults as $result) {
                    $rank++;
                }
            }
            $totalStudentAttemptTest = count(@$testResults);
            $studentTest->update(['rank'=>$rank]);
            $totalStudentAttemptTest = count(@$testResults);
            return view('newfrontend.user.view_child_result', ['mockTest' => @$mockTest,
                'resetAttempt' => @$resetAttempt,'student' => $student, 'studentId' => @$studentId,
                    'rank' => @$rank, 'totalStudentAttemptTest' => @$totalStudentAttemptTest,
                'studentTest' => $studentTest, 'studentTestResults' => $studentTestResults, 'subjects' => @$subjects]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }



    /**
     * -------------------------------------------------------
     * | Get student result                                  |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function mockResult($uuid)
    {
        $this->dbStart();
        try{
            $student = Student::whereId(Auth::guard('student')->id())->first();
            $mockTest = MockTest::whereUuid($uuid)->firstOrFail();
            $studentTest = StudentTest::where(['mock_test_id' => $mockTest->id, 'student_id' => $student->id])->first();
            $studentTestResults = StudentTestResults::where(['student_test_id' => $studentTest->id, 'mock_test_id' => $mockTest->id, 'student_id' => $student->id, 'is_reset' => 0])->orderBy('id', 'desc')->get();
            foreach($studentTestResults as $key=> $result){
                $attemptedCount = $result->currentStudentTestQuestionAnswers()
                                    ->where('is_attempted','1')
                                    ->count();
                $correctlyAnswered = $result->currentStudentTestQuestionAnswers()
                                    ->where('is_correct','1')
                                    ->count();
                $unAnswered = $result->currentStudentTestQuestionAnswers()
                                    ->where('is_attempted','0')
                                    ->count();
                $unAnswered = $result->currentStudentTestQuestionAnswers()
                                    ->where('is_attempted','0')
                                    ->count();
                $questionIds = $result->currentStudentTestQuestionAnswers()->where('is_correct','1')->pluck('question_list_id');
                $obtainedMark = QuestionList::whereIn('id', $questionIds)->sum('marks');
                $overAllResult = 0;
                if ($attemptedCount > 0 && $result->total_marks > 0 && $obtainedMark >0) {
                    $overAllResult = ($obtainedMark * 100) / $result->total_marks;
                    $overAllResult = number_format($overAllResult,2);
                }
                $result = $result->update([
                    'attempted' => $attemptedCount,
                    'correctly_answered' => $correctlyAnswered,
                    'unanswered' => $unAnswered,
                    'obtained_marks' => $obtainedMark,
                    'overall_result' => $overAllResult,
                ]);
            }
            $questions = $studentTestResults->sum('questions');
            $attempted = $studentTestResults->sum('attempted');
            $correctlyAnswered = $studentTestResults->sum('correctly_answered');
            $unanswered = $studentTestResults->sum('unanswered');
            $totalMarks = $studentTestResults->sum('total_marks');
            $obtainedMarks = $studentTestResults->sum('obtained_marks');
            $overAllResult = 0;
            if ($attempted > 0 && $totalMarks > 0) {
                $overAllResult = ($obtainedMarks * 100) / $totalMarks;
                $overAllResult = number_format($overAllResult,2);
            }
            $studentTest->update([
                'questions' => $questions,
                'attempted' => $attempted,
                'correctly_answered' => $correctlyAnswered,
                'unanswered' => $unanswered,
                'overall_result' => $overAllResult,
                'total_marks' => $totalMarks,
                'obtained_marks' =>$obtainedMarks,
                'status' => 2,
            ]);
            $studentTest = StudentTest::where(['mock_test_id' => $mockTest->id, 'student_id' => $student->id])->first();
            $subjectIds = $mockTest->subjects->pluck('subject_id');
            $resetAttempt = StudentTestResults::where(['student_test_id' => @$studentTest->id])->count();
            $rank = 0;
            $query = StudentTest::where(['mock_test_id' => @$studentTest->mock_test_id]);
            $testResults = $query->orderBy('overall_result', 'desc')->get();
            if ($testResults) {
                foreach ($testResults as $result) {
                    $rank++;
                }
            }
            $totalStudentAttemptTest = count(@$testResults);
            $studentTest->update(['rank'=>$rank]);
            if(session()->has('isExam')){
                $isExam = 'yes';
            }else{
                $isExam = 'no';
            }
            $this->dbCommit();
            return view('newfrontend.child.mock_result', ['mockTest' => @$mockTest,
                'resetAttempt' => @$resetAttempt,'isExam' =>@$isExam,
                'student' => $student, 'rank' => @$rank, 'totalStudentAttemptTest' => @$totalStudentAttemptTest,
                'studentTest' => $studentTest, 'studentTestResults' => $studentTestResults, 'subjects' => @$subjects]);
        }catch(Exception $e){
            $this->dbRollBack();
            abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | Get student questions                               |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function viewQuestions($uuid)
    {
        try{
            $student = Student::whereId(Auth::guard('student')->id())->first();
            $mockTest = MockTest::whereUuid($uuid)->firstOrFail();
            $questionIds = $mockTest->mockTestSubjectQuestion->pluck('question_id');
            $studentTest = StudentTest::where(['mock_test_id' => $mockTest->id, 'student_id' => $student->id])->first();
            $studentTestResults = StudentTestResults::where(['student_test_id' => $studentTest->id, 'is_reset' => 0])->orderBy('id', 'desc')->get();
            $studentTestResultIds = $studentTestResults->pluck('id')->toArray();
            $subjectIds = StudentTestQuestionAnswer::whereIn('student_test_result_id', $studentTestResultIds)->pluck('subject_id');
            $studentTestQuestionAnswers = StudentTestQuestionAnswer::whereIn('student_test_result_id', $studentTestResultIds)->orderBy('question_list_id', 'asc')->paginate(5);
            if (count($studentTestQuestionAnswers) == 0) {
                $questionList = QuestionList::whereIn('question_id', $questionIds)->orderBy('question_id', 'asc')->paginate(5);
                $subjectIds = $mockTest->subjects->pluck('subject_id');
            }
            $subjects = Subject::whereIn('id', $subjectIds)->get();
            $resetAttempt = StudentTestResults::where(['student_test_id' => @$studentTest->id])->count();
            /** Get student rank */
            $studentRanks = $this->mockTestHelper->getMockTestStudentRank($mockTest, $student);
            $query = StudentTestResults::where(['mock_test_id' => @$studentTest->mock_test_id, 'is_reset' => 0]);
            $testResults = $query->orderBy('overall_result', 'desc')->get();
            $totalStudentAttemptTest = count(@$testResults);
            $title = __('formname.view_all_question');
            return view('newfrontend.child.view_questions', ['title'=>@$title,'questionList' => @$questionList, 'mockTest' => @$mockTest,
                'student' => $student, 'studentTest' => $studentTest, 'resetAttempt' => $resetAttempt,
                'studentTestResults' => $studentTestResults,'totalStudentAttemptTest'=>@$totalStudentAttemptTest, 'subjects' => $subjects, 'studentTestQuestionAnswers' => $studentTestQuestionAnswers, 'studentRanks' => $studentRanks]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get child results questions                         |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function viewQuestionsResult($uuid)
    {
        try{
            $studentTest = StudentTest::whereUuid($uuid)->first();
            $student = $studentTest->student;
            $mockTest = $studentTest->mockTest;
            $studentTest = $studentTest;
            $resultIds = StudentTestResults::where(['student_test_id' => $studentTest->id,'is_reset' => 0])->orderBy('id', 'desc')->pluck('id'); 
            $subjectIds = StudentTestQuestionAnswer::whereIn('student_test_result_id', $resultIds)->pluck('subject_id');
            $studentTestQuestionAnswers = StudentTestQuestionAnswer::whereIn('student_test_result_id', $resultIds)->orderBy('question_list_id', 'asc')->paginate(5);
            if (count($studentTestQuestionAnswers) == 0) {
                $questionIds = StudentTestQuestionAnswer::whereIn('student_test_result_id', $resultIds)->pluck('question_id');
                $questionList = QuestionList::whereIn('question_id', $questionIds)->orderBy('question_id', 'asc')->paginate(5);
                $subjectIds = $mockTest->subjects->pluck('subject_id');
            }
            $subjects = Subject::whereIn('id', $subjectIds)->get();
            $resetAttempt = StudentTestResults::where(['student_test_id' => @$studentTest->id])->count();
            /** Get student rank */
            $studentRanks = $this->mockTestHelper->getMockTestStudentRank($mockTest, $student);
            $title = __('formname.view_all_question');
            return view('newfrontend.child.view_questions', ['title'=> @$title,'questionList' => @$questionList, 'mockTest' => @$mockTest,
                'student' => $student, 'studentTest' => $studentTest, 'resetAttempt' => $resetAttempt,
                'studentTestResults' => @$studentTestResults, 'subjects' => $subjects, 'studentTestQuestionAnswers' => $studentTestQuestionAnswers, 'studentRanks' => $studentRanks]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get child results questions                         |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function viewIncorrectQuestionsResult($id)
    {
        try{
            $studentTestResults = StudentTestResults::find($id);
            $mockTest = $studentTestResults->mockTest;
            $questionIds = $studentTestResults->studentTestQuestionAnswers->pluck('question_list_id');
            $studentTest = $studentTestResults->studentTest;
            $student = Student::whereId($studentTest->student_id)->first();
            $subjectIds = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResults->id])->pluck('subject_id');
            $studentTestQuestionAnswers = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResults->id])->where('is_correct','!=',1)->orderBy('question_list_id', 'asc')->paginate(5);
            if (count($studentTestQuestionAnswers) == 0) {
                $questionList = QuestionList::whereIn('question_id', $questionIds)->orderBy('question_id', 'asc')->paginate(5);
                $subjectIds = $mockTest->subjects->pluck('subject_id');
            }
            $subjects = Subject::whereIn('id', $subjectIds)->get();
            $resetAttempt = StudentTestResults::where(['student_test_id' => @$studentTest->id])->count();
            /** Get student rank */
            $studentRanks = $this->mockTestHelper->getMockTestStudentRank($mockTest, $student);
            $query = StudentTestResults::where(['mock_test_id' => @$studentTest->mock_test_id, 'is_reset' => 0]);
            $testResults = $query->orderBy('overall_result', 'desc')->get();
            $totalStudentAttemptTest = count(@$testResults);
            $title = __('formname.view_incorrect_question');
            return view('newfrontend.child.view_questions', ['title'=>@$title,'questionList' => @$questionList, 'mockTest' => @$mockTest,
                'student' => $student, 'studentTest' => $studentTest, 'resetAttempt' => $resetAttempt,'totalStudentAttemptTest'=>@$totalStudentAttemptTest,
                'studentTestResults' => $studentTestResults, 'subjects' => $subjects, 'studentTestQuestionAnswers' => $studentTestQuestionAnswers, 'studentRanks' => $studentRanks]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }



    /**
     * -------------------------------------------------------
     * | Mock Exam Review                                    |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function mockExamReview($uuid)
    {
        try{
            $mockTest = MockTest::whereUuid($uuid)->firstOrFail();
            $studentTest = StudentTest::where(['mock_test_id' => $mockTest->id, 'student_id' => Auth::guard('student')->id()])->first();
            // dd($studentTest);
            if($studentTest != NULL){
                if($studentTest->status== 2 || $studentTest->status== 3){
                    return redirect()->route('student-mocks');
                }
            }
            $studentTestResult = StudentTestResults::where(['student_test_id' => $studentTest->id, 'mock_test_id' => $mockTest->id, 'is_reset' => 0])->orderBy('id', 'asc')->first();
            $student = Student::whereId(Auth::guard('student')->id())->first();
            $query = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResult->id, 'mark_as_review' => 1]);
            $studentTestQuestionAnswer = $query->count();
            $firstStudentTestQuestionAnswer = $query->orderBy('id', 'asc')->first();
            if ($firstStudentTestQuestionAnswer) {
                $firstQuestion = $firstStudentTestQuestionAnswer;
                // get previous user id
                $prevQuestionId = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResult->id,'mark_as_review'=>1])->where('id', '<', $firstQuestion->id)->max('id');
                // get next user id
                $nextQuestionId = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResult->id,'mark_as_review'=>1])->where('id', '>', $firstQuestion->id)->min('id');
                $answers = Answer::whereQuestionListId(@$firstQuestion->question_list_id)->get();
            }
            session()->put('isExam','yes');
            return view('newfrontend.child.mock_exam_review', ['studentTestResult' => @$studentTestResult, 'studentTest' => @$studentTest, 'mockTest' => @$mockTest, 'student' => @$student, 'ip' => \Request::ip(), 'studentTestQuestionAnswer' => @$studentTestQuestionAnswer, 'firstQuestion' => @$firstQuestion, 'answers' => @$answers, 'firstStudentTestQuestionAnswer' => @$firstStudentTestQuestionAnswer, 'prevQuestionId' => @$prevQuestionId, 'nextQuestionId' => @$nextQuestionId]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Prev/Next Exam Review Questions                     |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function reviewPrevNextQuestion(Request $request)
    {
        $mockTest = MockTest::find($request->mock_test_id);
        if ($request->type == 'next') { // Clicked next question button
            $question = StudentTestQuestionAnswer::find($request->next_question_id);
            $questionList = StudentTestQuestionAnswer::find($request->next_question_id);
            $questionNo = (int)$request->question_number + 1;
        } else { // Clicked previous question button
            $question = StudentTestQuestionAnswer::find($request->prev_question_id);
            $questionList = StudentTestQuestionAnswer::find($request->prev_question_id);
            $questionNo = (int)$request->question_number - 1;
            if ($questionNo == 0) {
                $questionNo = 2;
            }
        }
        $answers = Answer::whereQuestionListId(@$questionList->question_list_id)->get();
        $data = $question;
        $arr = [
            'question' => $question,
            'answers' => $answers,
            'mockTest' => $mockTest,
            'prev_selected_ans' => @$data->answer_id,
            'review' => true,
            'questionNo' => $questionNo,
        ];

        // get previous user id
        $prevQuestionId = StudentTestQuestionAnswer::where(['student_test_result_id'=>$question->student_test_result_id,'mark_as_review'=>1])->where('id', '<', $question->id)->max('id');
        // get next user id
        $nextQuestionId = StudentTestQuestionAnswer::where(['student_test_result_id'=>$question->student_test_result_id,'mark_as_review'=>1])->where('id', '>', $question->id)->min('id');
        $detailArr = [
            'subject_id' => $question->subject_id,
            'question' => $question,
            'current_question_id' => $question->id,
            'prev_question_id' => $prevQuestionId,
            'nextQuestionId' => $nextQuestionId,
            'mockTest' => $mockTest
        ];
        $nextButton = view('newfrontend.child.next_question', $detailArr)->render();
        $prevButton = view('newfrontend.child.prev_question', $detailArr)->render();
        $completeButton = view('newfrontend.child.review_complete_mock_btn', $detailArr)->render();
        $testDetail = view('newfrontend.child.mock_exam_questions', $arr)->render();
        return response()->json(['testDetail' => $testDetail, 'completeButton' => $completeButton, 'nextButton' => $nextButton, 'prevButton' => $prevButton]);
    }

    /**
     * -------------------------------------------------------
     * | Prev/Next Questions                                 |
     * |                                                     |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function prevNextQuestion(Request $request)
    {
        if ($request->type == 'next' && $request->next_question_id != "") { // Clicked next question button
            $question = StudentTestQuestionAnswer::find($request->next_question_id);
            $questionNo = (int)$request->question_number + 1;
            Session::put('question_answer_id',$request->next_question_id);
        } else { // Clicked previous question button here
            $question = StudentTestQuestionAnswer::find($request->prev_question_id);
            $questionNo = (int)$request->question_number - 1;
            if ($questionNo == 0) {
                $questionNo = 2;
            }
            Session::put('question_answer_id',$request->prev_question_id);
        }
        Session::put('questionNo',$questionNo);
        $answers = Answer::whereQuestionListId(@$question->question_list_id)->get();
        $mockTest = MockTest::find($request->mock_test_id);
        $studentId = Auth::guard('student')->id();

        $studentTest = StudentTest::where(['id' => @$request->student_test_id])->first();

        // recalculate taken time
        $timeTaken = isset($request->time_taken) ? $request->time_taken : 0;
        if (isset($data) && $data->answer_id != null && $request->answer_id != null && $data->answer_id != $request->answer_id) {
            $timeTaken = $data->time_taken + $request->time_taken;
        }
        $arr = [
            'question' => $question,
            'answers' => $answers,
            'mockTest' => $mockTest,
            'prev_selected_ans' => @$question->answer_id,
            'questionNo' => $questionNo,
            'review' => true,
            'time_taken' => $timeTaken,
        ];
        $answer = Answer::find($request->answer);
        // Save UnAttempted Questions
        if ($request->type == 'next' || $request->type == 'prev') {
            $crtAns = StudentTestQuestionAnswer::updateOrCreate(
                [
                    'id' => @$request->current_question_id,
                ],
                [
                    'answer_id' => $request->answer,
                    'subject_id' => $question->questionData->subject_id,
                    'is_attempted' => ($request->answer != '')? 1 : 0,
                    'mark_as_review' => ($request->mark_as_review == 1)? 1 : 0,
                    'time_taken' => $timeTaken,
                    'is_correct' => @$answer->is_correct ? $answer->is_correct : 0,
                ]
            );
        }
        $markAsReview = (isset($question) && $question->mark_as_review == 1) ? 1 :0;
        // get previous user id
        $prevQuestionId = StudentTestQuestionAnswer::where(['student_test_result_id'=>$question->student_test_result_id,'subject_id'=>$request->subject_id])->where('id', '<', $question->id)->max('id');
        // get next user id
        $nextQuestionId = StudentTestQuestionAnswer::where(['student_test_result_id'=>$question->student_test_result_id,'subject_id'=>$request->subject_id])->where('id', '>', $question->id)->min('id');
        $testDetail = view('newfrontend.child.mock_exam_questions', $arr)->render();
        $detailArr = ['nextSubjectId'=>$request->next_subject_id,'subject_id' => $question->questionData->subject_id, 'question' => $question, 'current_question_id' => $question->id, 'prev_question_id' => $prevQuestionId, 'nextQuestionId' => $nextQuestionId, 'mockTest' => $mockTest];
        $nextButton = view('newfrontend.child.next_question', $detailArr)->render();
        $prevButton = view('newfrontend.child.prev_question', $detailArr)->render();
        $completeButton = view('newfrontend.child.complete_mock_btn', $detailArr)->render();
        $attemptedCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())->where(['student_test_result_id'=>$question->student_test_result_id])->whereMockTestId($mockTest->id)->whereIsAttempted(1)->count('is_attempted');
        $subjectId = @$question->questionData->subject_id;
        $subjectName = @$question->questionData->subject->title;
        $topicName = @$question->questionData->topic->title;
        $time =  MockTestSubjectDetail::whereMockTestId(@$mockTest->id)->where('subject_id',$subjectId)->sum('time');
        $totalTime = hoursAndMins($time);
        return response()->json(['nextQuestionId' => $nextQuestionId,'mark_as_review' => $markAsReview,'testDetail' => $testDetail, 'nextButton' => $nextButton, 'prevButton' => $prevButton, 'attemptedCount' => $attemptedCount, 'completeButton' => $completeButton, 'student_test_id' => $studentTest->id,'subject_id'=>@$subjectId,'subjectName'=>@$subjectName,'topicName'=>@$topicName,'totalTime'=>@$totalTime]);
    }

    /**
     * -------------------------------------------------------
     * | Store Test Questions & Answers                      |
     * |                                                     |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function saveTestQuestionAnswers(Request $request)
    {
        $this->dbStart();
        try {
            $data = StudentTestQuestionAnswer::find($request->current_question_id);
            if (isset($data) && $data->answer_id != null && $request->answer_id != null && $data->answer_id != $request->answer_id) {
                $timeTaken = $data->time_taken + $request->time_taken;
            } else {
                $timeTaken = isset($request->time_taken) ? $request->time_taken : 0;
            }
            $answer = Answer::find($request->answer_id);

            $studentId = Auth::guard('student')->id();
            // Store student tests details
            $studentTest = StudentTest::where(['id' => @$request->student_test_id])->first();;

            $studentTestResult = StudentTestResults::updateOrCreate(
                [
                    'id' => $request->student_test_result_id,
                    'student_test_id' => $studentTest->id,
                    'is_reset' => 0,
                ], [
                'student_id' => $studentId,
                'student_test_id' => $studentTest->id,
                'mock_test_id' => $request->mock_test_id,
            ]);

            $markData = $this->getObtainedMarks($request->mock_test_id, $studentTestResult->id);
            $obtainedMark = $markData[0];
            $totalMarks = $markData[1];
            $overAllResult = $markData[2];
            $questionList = StudentTestQuestionAnswer::find($request->current_question_id);
            // Store Student Test Question Answers
            $questionAnswer = StudentTestQuestionAnswer::updateOrCreate(
                [
                    'id' => $request->current_question_id,
                ], [
                    'student_id' => Auth::guard('student')->id(),
                    'question_id' => $questionList->question_id,
                    'mock_test_id' => $request->mock_test_id,
                    'answer_id' => $request->answer_id,
                    'subject_id' => $questionList->questionData->subject_id,
                    'is_correct' => @$answer->is_correct ? $answer->is_correct : 0,
                    'is_attempted' => isset($request->answer_id) ? 1 : 0,
                    'mark_as_review' => isset($request->mark_as_review) ? $request->mark_as_review : 0,
                    'time_taken' => $timeTaken,
                    'student_test_result_id' => $studentTestResult->id,
                ]
            );
            session()->put('question_answer_id',$request->current_question_id);
            session()->put('isExam','yes');
            // $attemptedCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())->whereMockTestId($request->mock_test_id)->whereIsAttempted(1)->count('is_attempted');
            $query = StudentTestQuestionAnswer::whereStudentTestResultId($studentTestResult->id)
                    ->whereStudentId($studentId)
                    ->whereMockTestId($request->mock_test_id);
            $questions = $query->count();
            $attemptedCount = $query->where(['subject_id'=>$request->subject_id])->whereIsAttempted(1)->count();
            $attemptedCount2 = $query->whereIsAttempted(1)->count();
            $correctlyAnswered = $query->whereIsCorrect(1)->count();
            $unanswered = StudentTestQuestionAnswer::whereStudentTestResultId($studentTestResult->id)
                            ->whereStudentId($studentId)
                            ->whereMockTestId($request->mock_test_id)
                            ->whereIsAttempted(0)->count();
            $studentTestResult = StudentTestResults::updateOrCreate(
                [
                    'student_test_id' => $studentTest->id,
                ], [
                'student_id' => $studentId,
                'student_test_id' => $studentTest->id,
                'mock_test_id' => $request->mock_test_id,
                // 'questions' => $questions,
                'attempted' => $attemptedCount2,
                'correctly_answered' => $correctlyAnswered,
                'unanswered' => $unanswered,
                'obtained_marks' => $obtainedMark,
                'total_marks' => $totalMarks,
                'overall_result' => $overAllResult,
            ]);
            $this->dbCommit();
            return response()->json(['success' => true, 'attemptedCount' => $attemptedCount, 'student_test_id' => $studentTest->id,'mark_as_review'=>@$questionAnswer->mark_as_review]);
        } catch (\Exception $e) {
            $this->dbRollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Parent purchased mock                           |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function purchasedPaper()
    {
        try{
            $parent = Auth::guard('parent')->user();
            $orderIds = Order::whereParentId($parent->id)->pluck('id');
            $items = OrderItem::whereIn('order_id', $orderIds)
                    ->orderBy('order_id','desc')
                    ->whereHas('paper')
                    ->whereMockTestId(null)
                    ->get();
            $userReviewArray = $parent->paperReviews->pluck('paper_id')->toArray();
            return view('newfrontend.user.puchased_papers', ['items' => @$items, 'userReviewArray' => @$userReviewArray]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Parent purchased mock                           |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function invoice()
    {
        try{
            $parent = Auth::guard('parent')->user();
            $orderIds = Order::whereParentId($parent->id)->pluck('id');
            $paperItems = OrderItem::whereIn('order_id', $orderIds)->whereMockTestId(null)->get();
            $mockTestItems = OrderItem::whereIn('order_id', $orderIds)->wherePaperId(null)->get();
            return view('newfrontend.user.invoice', ['paperItems' => @$paperItems, 'mockTestItems' => @$mockTestItems]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    /** 
     * -------------------------------------------------------
     * | Get Mock Invoice Data                               |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function getMockInvoiceData(Request $request)
    {
        $fromDate = null;
        $toDate = null;
        if ($request->from_date != null) {
            $fromDate = date('Y-m-d', strtotime($request->from_date));
            if ($request->to_date == null) {
                $date = new DateTime();
                $toDate = $date->modify("+1 day");
            }
        }
        if ($request->to_date != null) {
            $toDate = date('Y-m-d', strtotime($request->to_date . ' +1 day'));
            if ($request->from_date == null) {
                $fromDate = date('Y-m-d');
            }
        }
        $parent = Auth::guard('parent')->user();
        $orders = Order::whereParentId($parent->id)
            ->where(function ($q) use ($fromDate, $toDate) {
                if ($fromDate != null && $toDate != null) {
                    $q->whereBetween('created_at', [$fromDate, $toDate]);
                }
            })
            ->get();
        return Datatables::of($orders)
            ->addColumn('action', function ($order) {
                $data['invoiceRoute'] = route('view.invoice',['uuid' => @$order->uuid]);
                $data['downloadRoute'] = route('download.invoice',['uuid' => @$order->uuid]);
                $data['data'] = @$order;
                return $this->getPartials('newfrontend.user.__action', $data);
            })
            ->editColumn('created_at', function ($order) {
                return $order->proper_created_at;
            })
            ->editColumn('amount', function ($order) {
                return $order->amount_text;
            })
            ->editColumn('discount', function ($order) {
                return $order->discount_text;
            })
            ->editColumn('total', function ($order) {
                return config('constant.default_currency_symbol') . @$order->total_amount;
            })
            ->addColumn('payment_method', function ($item) {
                $html = 'Payment Via <span class="clrbl dblck">' . @$item->order->payment->method_text . '</span>';
                return $html;
            })
            ->rawColumns(['created_at', 'amount', 'discount', 'total', 'payment_method','action'])
            ->make(true);
    }
    /** 
     * -------------------------------------------------------
     * | Get Paper Invoice Data                              |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function getPaperInvoiceData(Request $request)
    {
        $fromDate = null;
        $toDate = null;
        if ($request->from_date != null) {
            $fromDate = date('Y-m-d', strtotime($request->from_date));
            if ($request->to_date == null) {
                $date = new DateTime();
                $toDate = $date->modify("+1 day");
            }
        }
        if ($request->to_date != null) {
            $toDate = date('Y-m-d', strtotime($request->to_date . ' +1 day'));
            if ($request->from_date == null) {
                $fromDate = date('Y-m-d');
            }
        }
        $parent = Auth::guard('parent')->user();
        $payments = ParentPayment::whereParentId($parent->id)
            ->where(function ($q) use ($fromDate, $toDate) {
                if ($fromDate != null && $toDate != null) {
                    $q->whereBetween('created_at', [$fromDate, $toDate]);
                }
            })
            ->get();
            return Datatables::of($payments)
                ->editColumn('description', function ($payment) {
                    return $this->getPartials('newfrontend.user._add_message',['payment' => @$payment]);
                })
                ->editColumn('method', function ($payment) {
                    return $payment->method_text;
                })
                ->editColumn('created_at', function ($payment) {
                    return $payment->proper_payment_at;
                })
                ->editColumn('status', function ($payment) {
                    return @$payment->proper_status;
                })
                ->addColumn('action', function ($payment) {
                    $data['invoiceRoute'] = route('view.payment.invoice',['uuid' => @$payment->id]);
                    $data['downloadRoute'] = route('download.payment.invoice',['uuid' => @$payment->id]);
                    $data['data'] = @$payment;
                    return $this->getPartials('newfrontend.user.__action', $data);
                })
                ->rawColumns(['action','method', 'action', 'status', 'description'])
                ->make(true);
    }

    /**
     * -------------------------------------------------------
     * | Save Complete Mock Detail                           |
     * |                                                     |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function completeMock(Request $request)
    {
        $this->dbStart();
        try {
            if(Session::has('question_answer_id')){
                Session::forget('question_answer_id');
            }
            if(Session::has('questionNo')){
                Session::forget('questionNo');
            }
            $studentId = Auth::guard('student')->id();
            
            $test = StudentTest::where(['id' => @$request->student_test_id])->first();
            
            $timeTaken = @$test->duration??0 + $request->time_taken;
            // Store student tests details
            $studentTest = StudentTest::updateOrCreate(
                [
                    'id' => $request->student_test_id,
                ],
                [
                    'student_id' => $studentId,
                    'mock_test_id' => $request->mock_test_id,
                    'ip_address' => $request->ip_address,
                    'start_date' => date('Y-m-d', strtotime(now())),
                    'end_date' => date('Y-m-d', strtotime(now())),
                    // 'status' => 2,
                    'duration' => $timeTaken,
                    'project_type' => 1,
                ]);
            $mockTest = $studentTest->mockTest;
            $subjects = MockTestSubjectQuestion::where('mock_test_id', $request->mock_test_id)->orderBy('subject_id')->get();
            $questionIds = $subjects->pluck('question_id');
            $questionList = QuestionList::whereIn('question_id', $questionIds)->orderBy('question_id');
            $questionListIds = $questionList->pluck('id');
            $totalQuestions = $questionList->count();
            $studentTestResult = StudentTestResults::find($request->student_test_result_id);
            // Store Student Test Results
            $query = StudentTestQuestionAnswer::whereStudentTestResultId($studentTestResult->id)->whereStudentId($studentId)->whereMockTestId($request->mock_test_id);
            $questions = $totalQuestions;
            $attemptedCount = $query->whereIsAttempted(1)->count();
            $correctlyAnswered = $query->whereIsCorrect(1)->count();
            $unanswered = StudentTestQuestionAnswer::whereStudentTestResultId($studentTestResult->id)
                            ->whereStudentId($studentId)
                            ->whereMockTestId($request->mock_test_id)
                            ->whereIsAttempted(0)->count();
            $questionAnswerIds = StudentTestQuestionAnswer::whereStudentTestResultId($studentTestResult->id)->whereStudentId($studentId)->whereMockTestId($request->mock_test_id)->pluck('answer_id');
            if ($attemptedCount == 0) {
                $unanswered = $totalQuestions;
            }
            $totalMarks = $questionList->sum('marks');
            if ($attemptedCount > 0 && $totalMarks > 0) {
                $answerData = Answer::whereIn('id', $questionAnswerIds)->whereIsCorrect(1)->pluck('question_list_id');
                $obtainedMark = QuestionList::whereIn('id', $answerData)->sum('marks');
                $overAllResult = ($obtainedMark * 100) / $totalMarks;
            } else {
                $overAllResult = 0;
                $obtainedMark = 0;
            }
            $studentTestResults =   StudentTestResults::where([
                                        'id' => $request->student_test_result_id,
                                        'is_reset' => 0,
                                    ])->first();
            $rank = 0;
            $query = StudentTestResults::where(['mock_test_id' => $request->mock_test_id, 'is_reset' => 0]);
            $testResults = $query->orderBy('overall_result', 'desc')->get();
            // Update the purchased mocks status
            $purchasedMock = PurchasedMockTest::whereMockTestId($request->mock_test_id)->whereStudentId($studentId)->first();
            $status = 2;
            if($mockTest->stage_id == 2){
                $status = 3;
                $studentTest->update(['status' => 3]);
            }
            if ($purchasedMock != null) {
                $purchasedMock->update(['status' => $status]);
            }
            session()->put('isExam','yes');
            $this->dbCommit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            $this->dbRollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
     /** 
     * -------------------------------------------------------
     * | Get Obtainer Marks                                  |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function getObtainedMarks($mockTestId, $studentTestResultId)
    {
        // get obtained Marks
        $query = StudentTestQuestionAnswer::where(
            [
                'student_id' => Auth::guard('student')->id(),
                'mock_test_id' => $mockTestId,
                'student_test_result_id' => $studentTestResultId,
            ]);
        $questionAnswers = $query->pluck('answer_id');
        $questionIds = $query->pluck('question_id');
        $totalMarks = QuestionList::whereIn('question_id', $questionIds)->sum('marks');
        $mockTest = MockTest::find($mockTestId);
        $answerData = Answer::whereIn('id', $questionAnswers)->whereIsCorrect(1)->pluck('question_list_id');
        $obtainedMark = QuestionList::whereIn('id', $answerData)->sum('marks');
        $overAllResult = 0;
        if ($obtainedMark > 0 && $totalMarks > 0) {
            $overAllResult = ($obtainedMark * 100) / $totalMarks;
        }
        return [$obtainedMark, $totalMarks, $overAllResult];
    }


    /**
     * -------------------------------------------------------
     * | print answer sheet                          |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */

    public function printpreviewans($id)
    {
        $allquestionlist = [];
        $mockTest = MockTest::where('uuid',$id)->first();
        return view('newfrontend.user.answer_sheet', ['allquestionlist' => @$allquestionlist,'mockTest'=>@$mockTest]);
    }


    /**
     * -------------------------------------------------------
     * | mcq evaluation                                      |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */

    public function mevaluation()
    {
        return view('newfrontend.user.mevaluation');
    }

    /**
     * -------------------------------------------------------
     * | standard evaluation                                 |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */

    public function sevaluation($mockTestId,$studentId)
    {
        $query = StudentTestResults::where(['student_id'=>$studentId,'mock_test_id'=>$mockTestId,'is_reset'=>0])->orderBy('student_test_paper_id','asc');
        $studentTestResultIds = $query->pluck('id');
        $mockTest = $query->first()->mockTest;
        $query =    StudentTestQuestionAnswer::where([
                        'student_id' => $studentId,
                        'mock_test_id' => $mockTestId
                        ])
                    ->whereIn('student_test_result_id', $studentTestResultIds)
                    ->orderBy('id','asc');
        $studentTestQuestionAnswers = $query->get();
        $firstQuestion = $query->first();
        $questionNo = 1;
        $nextQuestionNo = 2;
        $answers = Answer::where(['question_list_id'=>$firstQuestion->question_list_id,'is_correct'=>1])->get();
        $totalQuestions = $query->count();
        // get previous user id
        $prevQuestionId = StudentTestQuestionAnswer::whereIn('student_test_result_id',$studentTestResultIds)->where('id', '<', $firstQuestion->id)->max('id');
        // get next user id
        $nextQuestionId = StudentTestQuestionAnswer::whereIn('student_test_result_id',$studentTestResultIds)->where('id', '>', $firstQuestion->id)->min('id');
        return view('newfrontend.user.sevaluation', ['student_id' => $studentId,'questionNo'=>@$questionNo,'mockTest' => @$mockTest, 'subject_id' => @$firstQuestion->subject_id , 'firstQuestion' => @$firstQuestion,'answers' => @$answers, 'prevQuestionId' => @$prevQuestionId, 'nextQuestionId' => @$nextQuestionId, 'totalQuestions' => @$totalQuestions,'nextQuestionNo'=> @$nextQuestionNo]);
    }

    /**
     * -------------------------------------------------------
     * | seval Mark Question Answer                          |
     * |                                                     |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function sevalMarkQuestionAnswer(Request $request)
    {
        $parent = Auth::guard('parent')->user();
        $questionAnswer = StudentTestQuestionAnswer::find($request->current_question_id);
        $question = $questionAnswer->questionData;
        $studentId = @$questionAnswer->student_id;
        if($request->answer == 0){ // for incorrect
            $status = 2;
            $marks_obtained = 0;
            $array = ['is_correct'=>$status,'is_attempted'=>1];
        }elseif($request->answer == 1){ // for fairy correct
            $status = 3;
            $marks_obtained = (25 * $question->marks) / 100;
            $array = ['is_correct'=>$status,'is_attempted'=>1];
        }elseif($request->answer == 2){ // for half correct
            $status = 4;
            $marks_obtained = 3 * $question->marks / 2;
            $array = ['is_correct'=>$status,'is_attempted'=>1];
        }elseif($request->answer == 3){ // for mostly correct
            $status = 5;
            $marks_obtained = (75 * $question->marks) / 100;
            $array = ['is_correct'=>$status,'is_attempted'=>1];
        }else{ // for full correct
            $status = 1;
            $marks_obtained = $question->marks;
            // $answer = $question->correctAnswer;
            $array = ['is_correct'=>$status,'is_attempted'=>1];
        }
        $questionAnswer->update($array);
        $studentTestResult = StudentTestResults::find($questionAnswer->student_test_result_id);
        $questionList=Question::whereIn('id',$studentTestResult->studentTestQuestionAnswers->pluck('question_id'));
        $totalMarks = $questionList->sum('marks');
        $attempted = $studentTestResult->attemptTestQuestionAnswers->count();
        $unanswered = $studentTestResult->unanswerdQuestionAnswers->count();
        $correctAns = $studentTestResult->correctAnswers->count();
        $marks = 0;
        foreach($studentTestResult->studentTestQuestionAnswers as $questionAns){
            $marks = $marks + $questionAns->mark_text;
        }
        $overAllResult = ($marks * 100)/$totalMarks;
        $studentTestResult->update(['overall_result'=>$overAllResult,'total_marks'=>$totalMarks,'attempted'=>$attempted,'obtained_marks'=>$marks,'unanswered'=>$unanswered,'correctly_answered'=>$correctAns]);
        $studentTest = $studentTestResult->studentTestPaper;
        
        $studentTestResults = $studentTest->studentResult;
        $questions = $studentTestResults->questions;
        $attempted = $studentTestResults->attempted;
        $correctlyAnswered = $studentTestResults->correctly_answered;
        $unanswered = $studentTestResults->unanswered;
        $totalMarks = $studentTestResults->total_marks;
        $obtainedMarks = $studentTestResults->obtained_marks;
        $overAllResult = 0;
        if ($attempted > 0 && $totalMarks > 0) {
            $overAllResult = ($obtainedMarks * 100) / $totalMarks;
            $overAllResult = number_format($overAllResult,2);
        }

        $studentTest->update([
            'questions' => $questions,
            'attempted' => $attempted,
            'correctly_answered' => $correctlyAnswered,
            'unanswered' => $unanswered,
            'overall_result' => $overAllResult,
            'total_marks' => $totalMarks,
            'obtained_marks' =>$obtainedMarks,
        ]);
        return response()->json(['selectedAns'=>$questionAnswer->is_correct,'marks_obtained' => $obtainedMarks, 'totalMarks' => $totalMarks]);
    }

    /**
     * -------------------------------------------------------
     * | seval complete Mock Marking                         |
     * |                                                     |
     * | @return response                                    |
     * -------------------------------------------------------
     */

    public function sevalCompleteMockMarking(Request $request)
    {
        $parent = Auth::guard('parent')->user();
        $studentId = $request->student_id;
        $studentTestResults = StudentTestResults::find($request->student_test_result_id);
        $studentTest = StudentTest::find($studentTestResults->student_test_id);
        $mockTest = $studentTestResults->mockTest;
        $studentTestPaper = $studentTestResults->studentTestPaper;
        $studentTestPaper->update(['status'=>1]);
        $flag = false;
        if($studentTest){
            $paperIds = $studentTest->studentTestPapers->pluck('mock_test_paper_id')->toArray();
            $mockPaperIds = $mockTest->papers2->pluck('id')->toArray();
            if($paperIds == $mockPaperIds){
                $flag = true;
            }
            if($flag == true){
                $studentTest->update(['status'=>2]);
                PurchasedMockTest::whereMockTestId($studentTestResults->mock_test_id)->whereStudentId($studentTestResults->student_id)->update(['status'=> 2]);
            }
        }
        Session::forget('studentEvaluateTestPaper');
        $id = $request->student_test_result_id;
        $route = route('view-paper-result',['mock_test_id'=>$studentTestPaper->uuid,'student_id'=>$studentId]);
        return response()->json(['redirectUrl' => $route]);
    }


    /**
     * -------------------------------------------------------
     * | seval Result Page                                   |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function sevalResult($id)
    {
        $listids = explode('-', $id);
        $mock_test_id = $listids[0];
        $subject_id = $listids[1];
        $student_id = $listids[2];

        $mockTest = MockTest::find($mock_test_id);

        $querystandardExam = StandardExamTest::where('mock_test_id', $mock_test_id)
            ->where('subject_id', $subject_id)
            ->where('student_id', $student_id)->get();

        $mocktest = MockTestSubjectQuestion::where('mock_test_id', $mock_test_id)->whereSubjectId($subject_id);
        $question = $mocktest->orderBy('question_id', 'asc')->get();

        $totalMarks = 0;
        for ($i = 0; $i < count($question); $i++) {
            // echo $question[$i]['question_id'].';;';
            $q = Question::find($question[$i]['question_id']);
            $marks = QuestionList::where('question_id', $q->id)->sum('marks');
            $totalMarks += $marks;

        }

        $totalQuestionAttempted = $querystandardExam->count();
        $totalQuestions = $mocktest->count();
        $correctlyAnswered = $querystandardExam->where('answer', '=', 4)->count();
        $totalMarksObtained = $querystandardExam->sum('marks_obtained');

        return view('newfrontend.user.sevaluation_result', ['totalQuestionAttempted' => $totalQuestionAttempted, 'totalQuestions' => $totalQuestions, 'correctlyAnswered' => $correctlyAnswered, 'totalMarksObtained' => $totalMarksObtained, 'totalMarks' => $totalMarks, 'mock_test_id' => $mock_test_id]);
    }


    /**
     * -------------------------------------------------------
     * | purchased Mock Review/Rate                          |
     * |                                                     |
     * | @return response                                    |
     * -------------------------------------------------------
     */

    public function pReviewRate(Request $request)
    {
        $parent = Auth::guard('parent')->id();
        $query = PurchasedMockTestRating::create(['mock_test_id' => $request->mock_test_id, 'parent_id' => $parent, 'rating' => $request->score, 'msg' => $request->msg]);

        //update feedback status

        $feedbackStatus = DB::table('purchased_mock_tests')
            ->where('mock_test_id', $request->mock_test_id)
            ->where('parent_id', $parent)
            ->update(['feedback_status' => 1]);

        //get parent user details
        $parentUser = ParentUser::where('id', $parent)->get();
        //  print_r($parentUser);

        //get Mock test info

        $mockTest = MockTest::where('id', $request->mock_test_id)->first();

        // details

        $details = ['subject' => 'User Review', 'rating' => $request->score, 'msg' => $request->msg];

        if ($query && $feedbackStatus) {
            $this->mockTestHelper->sendMailToAdmin($details, $parentUser, $mockTest);
        }

        return redirect()->route('purchased-mock');
    }

    /*
    * -------------------------------------------------------
    * | check exam is inprogress                            |
    * |                                                     |
    * | @return response                                    |
    * -------------------------------------------------------
    */
    public function checkExam(Request $request){
        // check if exam is in progress
        $count = StudentTest::whereStudentId($request->student_id)
                    ->whereProjectType(1)
                    ->whereStatus(1)
                    ->count();
        // check if exam is in progress
        $isMockCompleted = StudentTest::whereStudentId($request->student_id)
                    ->where('mock_test_id',$request->mockTestId)
                    ->whereProjectType(1)
                    ->whereStatus(2)
                    ->count();
        if($isMockCompleted > 0){
            $msg = __('formname.exam_completed');
            return response()->json(['msg'=>$msg,'status'=>'error']);
        }elseif($count > 0){
            $msg = __('formname.exam_inprogress');
            return response()->json(['msg'=>$msg,'status'=>'error']);
        }else{
            return response()->json(['status'=>'success']);
        }
    }

    /**
     * -------------------------------------------------------
     * | view exam questions incorrect                       |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function viewIncorrectQuestions($uuid)
    {
        $student = Student::whereId(Auth::guard('student')->id())->first();
        $mockTest = MockTest::whereUuid($uuid)->firstOrFail();
        $questionIds = $mockTest->mockTestSubjectQuestion->pluck('question_id');
        $studentTest = StudentTest::where(['mock_test_id' => $mockTest->id, 'student_id' => $student->id])->first();

        $studentTestResults = StudentTestResults::where(['student_test_id' => $studentTest->id, 'is_reset' => 0])->orderBy('id', 'desc')->get();
        $studentTestResultIds = $studentTestResults->pluck('id')->toArray();
        $subjectIds = StudentTestQuestionAnswer::whereIn('student_test_result_id', $studentTestResultIds)->pluck('subject_id');
        $studentTestQuestionAnswers = StudentTestQuestionAnswer::whereIn('student_test_result_id', $studentTestResultIds)->orderBy('question_list_id', 'asc')->paginate(5);

        // $studentTestResults = StudentTestResults::where(['student_test_id' => $studentTest->id, 'is_reset' => 0])->orderBy('id', 'desc')->first();
        // $subjectIds = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResults->id])->pluck('subject_id');
        // $studentTestQuestionAnswers = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResults->id])->where('is_correct','!=',1)->orderBy('question_list_id', 'asc')->paginate(5);

        if (count($studentTestQuestionAnswers) == 0) {
            $questionList = QuestionList::whereIn('question_id', $questionIds)->orderBy('question_id', 'asc')->paginate(5);
            $subjectIds = $mockTest->subjects->pluck('subject_id');
        }
        $subjects = Subject::whereIn('id', $subjectIds)->get();
        $resetAttempt = StudentTestResults::where(['student_test_id' => @$studentTest->id])->count();
        /** Get student rank */
        $studentRanks = $this->mockTestHelper->getMockTestStudentRank($mockTest, $student);
        $query = StudentTestResults::where(['mock_test_id' => @$studentTest->mock_test_id, 'is_reset' => 0]);
        $testResults = $query->orderBy('overall_result', 'desc')->get();
        $totalStudentAttemptTest = count(@$testResults);
        $title = __('formname.view_incorrect_question');
        return view('newfrontend.child.view_questions', ['title'=>@$title,'questionList' => @$questionList, 'mockTest' => @$mockTest,
            'student' => $student, 'studentTest' => $studentTest, 'resetAttempt' => $resetAttempt,
            'studentTestResults' => $studentTestResults, 'subjects' => $subjects, 'studentTestQuestionAnswers' => $studentTestQuestionAnswers, 'studentRanks' => $studentRanks]);
    }

    /**
     * -------------------------------------------------------
     * | seval Prev/Next Questions                           |
     * |                                                     |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function sevalPrevNextQuestions(Request $request)
    {
        $isReview = 0;
        $firstQuestion = StudentTestQuestionAnswer::find($request->next_sub_question_id);
        if($request->has('answer') && $request->answer != null){
            $this->storeAnswer($request->current_question_id,$request->answer);
            $isReview = 1;
            $this->previewQuestionList2($request->current_question_id,$isReview);
        }else{
            $isReview = 0;
            $this->previewQuestionList2($request->current_question_id,$isReview);
        }
        if($request->type == 'prev-sub-question'){
            $firstQuestion = StudentTestQuestionAnswer::find($request->prev_sub_question_id);
        }
        $paper = @$firstQuestion->testResult->studentTestPaper;
        $mockTest = @$paper->paper->mockTest;
        $mockTestPaper = @$paper->paper;
        $studentTestResultId = $firstQuestion->testResult->id;
        $answers = Answer::where(['question_id'=>$firstQuestion->question_id,'is_correct'=>1])->get();
        $allAnswers = Answer::where(['question_id'=>$firstQuestion->question_id])->get();
        // get previous user id
        $prevQuestionId = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResultId)->where('id', '<', $firstQuestion->id)->max('id');
        $prevQuestion = StudentTestQuestionAnswer::find($prevQuestionId);
        // get next user id
        $nextQuestionId = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResultId)->where('id', '>', $firstQuestion->id)->min('id');
        $nextQuestion = StudentTestQuestionAnswer::find($prevQuestionId);
        $nextButton = view('newfrontend.user.seval_next_question', ['nextQuestionId' => $nextQuestionId,'prevQuestionId' => $prevQuestionId,'nextQuestion' => @$nextQuestion,'firstQuestion' => @$firstQuestion])->render();
        $prevButton = view('newfrontend.user.seval_prev_question', ['nextQuestionId' => $nextQuestionId,'prevQuestionId' => $prevQuestionId,'prevQuestion' => @$prevQuestion,'firstQuestion' => @$firstQuestion])->render();
        // complete_mock_button
        $cmpltButton = view('newfrontend.user.scomplete_mock_button', ['subject_id' => $firstQuestion->subject_id,'mock_test_id' => @$mockTest->id,'nextQuestionId'=>@$nextQuestionId])->render();
        $passage = view('newfrontend.user.__passage', ['section' => $firstQuestion->section])->render();
        $questionTitle = view('newfrontend.user.squestion_title',['question'=>$firstQuestion,'answers'=>@$allAnswers,'nextQuestionId' => $nextQuestionId])->render();
        $query = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResultId])->orderBy('id', 'asc');
        $questionList = $query->get();
        Session::put('sectionQuestion',$questionList);
        $previewQuestionList = Session::get('previewQuestionList');
        $previewList = view('newfrontend.user.__question_preview_list',['previewQuestionList' => @$previewQuestionList,'firstQuestion'=>@$firstQuestion,'nextQuestionId'=>@$nextQuestionId])->render();
        $detailArr = [
                        'subject_id' => @$request->subject_id, 
                        'mock_test_id' => @$request->mock_test_id, 
                        'btn_type' => @$request->type, 
                        'current_question_id' => @$firstQuestion->id , 
                        'prev_sub_question_id' => @$prevQuestionId, 
                        'btn_class' => 'btn nxt_btn nxt_qus', 
                        'next_sub_question_id' => @$nextQuestionId, 
                        'prev_question_id' => @$prevQuestionId, 
                        'next_question_id' => @$nextQuestionId, 
                        'current_sub_question_id' => @$firstQuestion->id, 
                        'mockTest' => @$firstQuestion->mockTest, 
                        'current_question_number' => @$request->next_question_number, 
                        'prev_question_number' => @$request->current_question_number, 
                        'disabled' => '',
                        'nextQuestionTitle' => @$questionTitle,
                        'subQuestion' => @$firstQuestion->questionData->question,
                        'subQuestionAnswer' => @$answers[0]->answer, 
                        'currentSubQuestionId' => @$firstQuestion->id, 
                        'mockInfo' => @$firstQuestion->mockTest, 
                        'prevSubQuestionId' => @$prevQuestionId, 
                        'nextSubQuestionId' => @$nextQuestionId, 
                        'prevQuestionId' => @$prevQuestionId, 
                        'nextQuestionId' => @$nextQuestionId,
                        'nextButton' => @$nextButton, 
                        'question_marks' => @$firstQuestion->questionData->marks,
                        'passage' => @$passage,
                        'section' => @$firstQuestion->section,
                    ];
        if (isset($cmpltButton)) {
            return response()->json(['section' => @$firstQuestion->section,'passage' => @$passage,'previewList' => @$previewList,'labelId'=>@$firstQuestion->is_correct, 'marks_obtained' => @$firstQuestion->testResult->studentTestPaper->obtained_marks?? 00 ,'selectedAns'=>(string)@$firstQuestion->standard_selected_answer,'nextQuestionTitle' => @$questionTitle,'subject_id' => @$firstQuestion->subject_id, 'mockInfo' => @$mockTest, 'subQuestion' => @$firstQuestion->questionList->question, 'subQuestionAnswer' => @$answers[0]->answer, 'prevSubQuestionId' => @$prevQuestionId, 'nextSubQuestionId' => @$nextQuestionId, 'currentquestionId' => @$request->current_question_id, 'prevQuestionId' => @$prevQuestionId, 'nextQuestionId' => @$nextQuestionId, 'nextButton' => @$nextButton, 'detailArr' => @$detailArr, 'completeMockBtn' => @$cmpltButton, 'question_marks' => @$firstQuestion->questionList->marks, 'prevButton' => @$prevButton]);
        } else {
        return response()->json(['section' => @$firstQuestion->section,'passage' => @$passage,'labelId'=>@$firstQuestion->is_correct, 'marks_obtained' => @$firstQuestion->testResult->studentTestPaper->obtained_marks?? 00 ,'selectedAns'=>(string)@$firstQuestion->standard_selected_answer,'nextQuestionTitle' => $questionTitle,'subject_id' => @$firstQuestion->subject_id, 'mockInfo' => @$mockTest, 'subQuestion' => @$firstQuestion->questionList->question, 'subQuestionAnswer' => $answers[0]->answer, 'prevSubQuestionId' => $prevQuestionId, 'nextSubQuestionId' => $nextQuestionId, 'currentquestionId' => $request->current_question_id, 'prevQuestionId' => $prevQuestionId, 'nextQuestionId' => $nextQuestionId, 'nextButton' => @$nextButton, 'detailArr' => @$detailArr, 'completeMockBtn' => '', 'question_marks' => @$firstQuestion->questionList->marks, 'prevButton' => @$prevButton]);
        }
    }

     /**
     * -------------------------------------------------------
     * | Get student result                                  |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function evaluateMockResult($id)
    {
        $studentTestResults = StudentTestResults::find($id);
        $student = Student::whereId($studentTestResults->student_id)->first();
        $mockTest = $studentTestResults->mockTest;
        $studentTest = StudentTest::find($studentTestResults->student_test_id)->first();
        $subjectIds = $mockTest->subjects->pluck('subject_id');
        if ($studentTestResults) {
            $subjectIds = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResults->id, 'mock_test_id' => $mockTest->id, 'student_id' => $student->id])->pluck('subject_id');
        }
        $subjects = Subject::whereIn('id', $subjectIds)->get();
        $resetAttempt = StudentTestResults::where(['student_test_id' => @$studentTest->id])->count();
        $rank = 0;
        $query = StudentTestResults::where(['mock_test_id' => @$studentTest->mock_test_id, 'is_reset' => 0]);
        $testResults = $query->orderBy('overall_result', 'desc')->get();
        if ($studentTestResults->overall_result > 0) {
            foreach ($testResults as $result) {
                if ($result->student_id == $studentTestResults->student_id) {
                    $rank++;
                }
            }
        }
        $studentTestResults->update(['rank'=>$rank]);
        $totalStudentAttemptTest = count(@$testResults);
        return view('newfrontend.child.mock_result', ['mockTest' => @$mockTest,
            'resetAttempt' => @$resetAttempt,
            'student' => $student, 'rank' => @$rank, 'totalStudentAttemptTest' => @$totalStudentAttemptTest,
            'studentTest' => $studentTest, 'studentTestResults' => $studentTestResults, 'subjects' => $subjects]);
    }

    /**
     * -------------------------------------------------------
     * | Get parent exams                                    |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function mockExam2($uuid,$subjectId)
    {
        $this->dbStart();
        try{
            $student = Auth::guard('student')->user();
            $mockTest = MockTest::whereUuid($uuid)->firstOrFail();
            $paper = MockTestPaper::where(['id'=> $subjectId])->orderBy('id','asc')->first();
            $subjects = $paper->mockTestSubjectQuestion()->orderBy('subject_id','asc')->get();
            $questionIds = $subjects->pluck('question_id');
            $questionList = QuestionList::whereIn('question_id', $questionIds)->orderBy('question_id', 'asc');
            $questionListIds = $questionList->pluck('id');
            $totalQuestions = $questionList->count();
            $totalMarks = $questionList->sum('marks');
            $subjectDetail = $paper->mockTestSubjectDetail;
            $examTotalTime = $paper->mockTestSubjectDetail()->sum('time');
            $time = 0;
            $examTotalSeconds = $examTotalTime * 60;
            $studentTest = StudentTest::where(['student_id' => $student->id,'mock_test_id' => $mockTest->id,'status'=>1])->first();
            $currentSubjectId = session()->get('paper_id');
            $testPaper = StudentTestPaper::where([
                'student_id' => $student->id,
                'mock_test_paper_id' => $paper->id,
                'is_reset' => 0,
                'student_test_id' => $studentTest->id,
            ])->first();
            if($currentSubjectId != null && ($currentSubjectId == $testPaper->mock_test_paper_id)){
                if($testPaper){
                    $studentTestResultsData = StudentTestResults::where([
                        'student_id' => $student->id,
                        'student_test_id' => $studentTest->id,
                        'mock_test_id' => $mockTest->id,
                        'student_test_paper_id' => $testPaper->id,
                        'is_reset' => 0,
                    ])->first();
                    $query = StudentTestQuestionAnswer::whereStudentTestResultId($studentTestResultsData->id)->whereStudentId($student->id)->whereMockTestId($mockTest->id);
                    $unanswered = $query->whereIsAttempted(0)->count();
                    $studentTestResultsData->update([
                        'unanswered' => $unanswered,
                    ]);
                }
                $studentTestResultsData = StudentTestResults::where([
                    'student_id' => $student->id,
                    'student_test_id' => $studentTest->id,
                    'mock_test_id' => $mockTest->id,
                    'is_reset' => 0,
                ])->first();
                $query = StudentTestQuestionAnswer::whereStudentTestResultId($studentTestResultsData->id)->whereStudentId($student->id)->whereMockTestId($mockTest->id);
                $unanswered = $query->whereIsAttempted(0)->count();
                $purchasedMock = PurchasedMockTest::whereMockTestId($mockTest->id)->whereStudentId($student->id)->where('status', '<>', 2)->first();
                if ($purchasedMock) {
                    $purchasedMock->update(['status' => 2]);
                }
                $studentTest->update(['status' => 2]);
                if($totalQuestions == 0){
                    return redirect()->route('student-mocks')->withErrors(['msg','No questions found in this mock']);
                }
                return redirect()->route('student-mocks')->withErrors(['msg','This mock exam ended']);
            }
            // allAudios
            $firstAudio = '';
            $secondAudio = '';
            $thirdAudio = '';
            $forthAudio = '';
            $secondAudioPlayTime = 0;
            $thirdAudioPlayTime = 0;
            $forthAudioPlayTime = 0;
            if (count($mockTest->mockAudio) > 0) {
                $firstAudio = $mockTest->mockAudio->where('seq', 1)->first();
                $secondAudio = $mockTest->mockAudio->where('seq', 3)->first();
                $thirdAudio = $mockTest->mockAudio->where('seq', 4)->first();
                $forthAudio = $mockTest->mockAudio->where('seq', 2)->first();

                $secondAudioPlayTime = ($examTotalSeconds / 2) * 1000;
                $thirdAudioPlayTime = ($examTotalSeconds - 60) * 1000;
                $forthAudioPlayTime = ($examTotalSeconds - 1) * 1000;
            }
            $studentTest = StudentTest::where([
                'student_id' => $student->id,
                'mock_test_id' => $mockTest->id,
            ])->first();

            $questions = $paper->mockTestSubjectDetail()->sum('questions');
            $totalMarks = $paper->mockTestSubjectQuestion->sum('total_marks');

            $testPaper = StudentTestPaper::updateOrCreate([
                'student_id' => $student->id,
                'mock_test_paper_id' => $paper->id,
                'student_test_id' => $studentTest->id,
                'is_reset' => '0'
            ],[
                'student_id' => $student->id,
                'mock_test_id' => $mockTest->id,
                'mock_test_paper_id' => $paper->id,
                'questions' => $questions,
                'total_marks' => $totalMarks,
                'is_completed' => 0,
            ]);
            $studentTestResult = StudentTestResults::where([
                'student_id' => $student->id,
                'student_test_id' => $studentTest->id,
                'mock_test_id' => $mockTest->id,
                'is_reset' => 0,
                'student_test_paper_id' => $testPaper->id,
            ])->first();
            $questionList = StudentTestQuestionAnswer::where([
                            'student_test_result_id' => $studentTestResult->id,
                            ])->orderBy('id','asc');

            $currentQuestion = $questionList->first();
            $attempted = $questionList->where('is_attempted',1)->count();
            $answers = Answer::whereQuestionListId(@$currentQuestion->question_list_id)->get();
            // get previous user id
            $prevQuestionId = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResult->id)->where('id', '<', $currentQuestion->id)->max('id');
            // get next user id
            $nextQuestionId = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResult->id)->where('id', '>', $currentQuestion->id)->min('id');
            session()->put('isExam','yes');
            $subjectDetail = MockTestPaper::where(['mock_test_id'=> $mockTest->id])->where('id', '>', $subjectId)->orderBy('id','asc')->first();
            if($subjectDetail != null){
                $nextSubjectId = @$subjectDetail->id;
                $nextSubjectTime = @$subjectDetail->mockTestSubjectDetail->sum('time');
                $nextSubject = MockTestPaper::where('id',$nextSubjectId)->first();
            }else{
                $nextSubjectId = null;
                $nextSubjectTime= null;
                $nextSubject = null;
            }
            $currentSubject = MockTestPaper::where('id',$subjectId)->first();

            session()->put('paper_id',$testPaper->id);
            $this->dbCommit();
            // return view('newfrontend.child.mock_exam',['subject_id' => $question->subject_id,'mockTest'=>@$mockTest,'student' => $student,'ip' => \Request::ip(),'firstQuestion' => $firstQuestion,'answers' => $answers,'time_left' => hoursAndMins($examTotalTime),'examTotalTimeSeconds' => $examTotalTime * 60,'nextQuestionId' => $nextQuestionId,'prevQuestionId' => $prevQuestionId,'total_subjects' => count($subjects),'totalQuestions' => $totalQuestions,'studentTest'=>@$studentTest,'studentTestResult'=>@$studentTestResult]);
            return view('newfrontend.child.mock_exam', ['questionListIds' => $questionListIds, 'subject_id' => $currentQuestion->subject_id,
                'mockTest' => @$mockTest, 'student' => $student, 'ip' => \Request::ip(), 'firstQuestion' => $currentQuestion,'currentSubject'=>$currentSubject,
                'answers' => $answers, 'time_left' => hoursAndMins($examTotalTime), 'examTotalTimeSeconds' => $examTotalSeconds,
                'nextQuestionId' => $nextQuestionId, 'prevQuestionId' => $prevQuestionId, 'total_subjects' => count($subjects),'nextSubjectTime' => $nextSubjectTime,
                'totalQuestions' => $totalQuestions, 'studentTest' => @$studentTest, 'studentTestResult' => @$studentTestResult,'nextSubject'=>$nextSubject,
                'firstAudio' => @$firstAudio, 'secondAudio' => @$secondAudio, 'thirdAudio' => @$thirdAudio, 'forthAudio' => @$forthAudio,
                'secondAudioPlayTime' => @$secondAudioPlayTime, 'thirdAudioPlayTime' => @$thirdAudioPlayTime,'nextSubjectId' =>@$nextSubjectId,
                'forthAudioPlayTime' => @$forthAudioPlayTime,'qno'=>@$qno,'attempted'=>@$attempted,'timeArray'=>@$timeArray,'inBetweenTime'=>@$inBetweenTime]);
        }catch(Exception $e){
            $this->dbRollBack();
            return redirect()->back();
        }
    }
     /** 
     * -------------------------------------------------------
     * | Update Test status                                  |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */

    public function updateTestStatus(Request $request){
        $mockTest = MockTest::where('id',$request->mock_test_id)->first();
        $status = 2;
        if($mockTest != null && $mockTest->stage_id == 2){
            $status = 3;
        }
        StudentTest::where('id',$request->test_id)->update(['status'=>$status]);
        $student = Auth::guard('student')->user();
        PurchasedMockTest::whereMockTestId($request->mock_test_id)->whereStudentId($student->id)->update(['status'=> 2]);        
        return response()->json(['status'=>'success']);
    }

    /** 
     * -------------------------------------------------------
     * | store Answer                                        |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */

    public function storeAnswer($questionId,$answer){
        $questionAnswer = StudentTestQuestionAnswer::find($questionId);
        $question = $questionAnswer->questionData;
        $studentId = @$questionAnswer->student_id;
        if($answer == 0){ // for incorrect
            $status = 2;
            $marks_obtained = 0;
            $array = ['is_correct'=>$status,'is_attempted'=>1];
        }elseif($answer == 1){ // for fairy correct
            $status = 3;
            $marks_obtained = (25 * $question->marks) / 100;
            $array = ['is_correct'=>$status,'is_attempted'=>1];
        }elseif($answer == 2){ // for half correct
            $status = 4;
            $marks_obtained = 3 * $question->marks / 2;
            $array = ['is_correct'=>$status,'is_attempted'=>1];
        }elseif($answer == 3){ // for mostly correct
            $status = 5;
            $marks_obtained = (75 * $question->marks) / 100;
            $array = ['is_correct'=>$status,'is_attempted'=>1];
        }else{ // for full correct
            $status = 1;
            $marks_obtained = $question->marks;
            // $answer = $question->correctAnswer;
            $array = ['is_correct'=>$status,'is_attempted'=>1];
        }
        $questionAnswer->update($array);
        $studentTestResult = StudentTestResults::find($questionAnswer->student_test_result_id);
        $questionList=Question::whereIn('id',$studentTestResult->studentTestQuestionAnswers->pluck('question_id'));
        $totalMarks = $questionList->sum('marks');
        $attempted = $studentTestResult->attemptTestQuestionAnswers->count();
        $unanswered = $studentTestResult->unanswerdQuestionAnswers->count();
        $correctAns = $studentTestResult->correctAnswers->count();
        $marks = 0;
        foreach($studentTestResult->studentTestQuestionAnswers as $questionAns){
            $marks = $marks + $questionAns->mark_text;
        }
        $overAllResult = ($marks * 100)/$totalMarks;
        $studentTestResult->update(['overall_result'=>$overAllResult,'total_marks'=>$totalMarks,'attempted'=>$attempted,'obtained_marks'=>$marks,'unanswered'=>$unanswered,'correctly_answered'=>$correctAns]);
        $studentTest = $studentTestResult->studentTestPaper;

        $studentTestResults = $studentTest->studentResult;
        $questions = $studentTestResults->questions;
        $attempted = $studentTestResults->attempted;
        $correctlyAnswered = $studentTestResults->correctly_answered;
        $unanswered = $studentTestResults->unanswered;
        $totalMarks = $studentTestResults->total_marks;
        $obtainedMarks = $studentTestResults->obtained_marks;
        $overAllResult = 0;
        if ($attempted > 0 && $totalMarks > 0) {
            $overAllResult = ($obtainedMarks * 100) / $totalMarks;
            $overAllResult = number_format($overAllResult,2);
        }

        $studentTest->update([
            'questions' => $questions,
            'attempted' => $attempted,
            'correctly_answered' => $correctlyAnswered,
            'unanswered' => $unanswered,
            'overall_result' => $overAllResult,
            'total_marks' => $totalMarks,
            'obtained_marks' =>$obtainedMarks,
        ]);
    }
     /** 
     * -------------------------------------------------------
     * | Evaluate Go to question                             |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function evaluateGoToQuestion(Request $request){
        $isReview = 0;
        $currentQuestion = StudentTestQuestionAnswer::find($request->current_question_id);
        $questions = Session::get('sectionQuestion');
        $currentQuestionId = $request->question_id;
        $question = @$questions[$currentQuestionId];
        if($request->has('answer') && $request->answer != null){
            $this->storeAnswer($request->current_question_id,$request->answer);
            $isReview = 1;
            $this->previewQuestionList2($request->current_question_id,$isReview);
        }
        $previewQuestionList = Session::get('previewQuestionList');
        $nextQuestionId = $request->question_id + 1 ;
        $prevQuestionId = $request->question_id - 1 ;
        $currentQuestionId = $request->current_question_id;
        if($nextQuestionId == count($questions)){
            $nextQuestionId = null;
        }
        if($prevQuestionId < 0){
            $prevQuestionId = null;
        }
        $firstQuestion = StudentTestQuestionAnswer::find($question->id);
        $mockTest = $firstQuestion->mockTest;
        $currentQuestion = StudentTestQuestionAnswer::find($request->current_question_id);
        $allAnswers = $firstQuestion->questionData->answers;
        // get previous user id
        $prevQuestionId = StudentTestQuestionAnswer::where('student_test_result_id',$firstQuestion->student_test_result_id)->where('id', '<', $firstQuestion->id)->max('id');
        $prevQuestion = StudentTestQuestionAnswer::find($prevQuestionId);
        // get next user id
        $nextQuestionId = StudentTestQuestionAnswer::where('student_test_result_id',$firstQuestion->student_test_result_id)->where('id', '>', $firstQuestion->id)->min('id');
        $nextQuestion = StudentTestQuestionAnswer::find($prevQuestionId);
        $data['nextButton'] = view('newfrontend.user.seval_next_question', ['nextQuestionId' => $nextQuestionId,'prevQuestionId' => $prevQuestionId,'nextQuestion' => @$nextQuestion,'firstQuestion' => @$firstQuestion])->render();
        $data['prevButton'] = view('newfrontend.user.seval_prev_question', ['nextQuestionId' => $nextQuestionId,'prevQuestionId' => $prevQuestionId,'prevQuestion' => @$prevQuestion,'firstQuestion' => @$firstQuestion])->render();
        $data['passage'] = view('newfrontend.user.__passage', ['section' => $firstQuestion->section])->render();
        $data['section'] = @$firstQuestion->section;
        // complete_mock_button
        $data['completeMockBtn'] = view('newfrontend.user.scomplete_mock_button', ['subject_id' => $firstQuestion->subject_id,'mock_test_id' => @$mockTest->id,'nextQuestionId'=>@$nextQuestionId])->render();
        $data['nextQuestionTitle'] = view('newfrontend.user.squestion_title',['question'=>$firstQuestion,'answers'=>@$allAnswers,'nextQuestionId' => $nextQuestionId])->render();
        $data['passage'] = view('newfrontend.user._passage',['question'=>$firstQuestion,'answers'=>@$allAnswers,'nextQuestionId' => $nextQuestionId])->render();
        $data['previewList'] = view('newfrontend.user.__question_preview_list',['previewQuestionList' => @$previewQuestionList,'firstQuestion'=>@$firstQuestion,'nextQuestionId'=>@$nextQuestionId])->render();
        $data['status'] = 'success';
        $data['marks_obtained'] = $firstQuestion->testResult->studentTestPaper->obtained_marks;
        $data['selectedAns'] = (string)$firstQuestion->standard_selected_answer;
        $data['answerList'] = $allAnswers;
        $data['testDetail'] = $mockTest;
        $data['question_marks'] = $firstQuestion->questionData->marks;
        $data['nextQuestionId'] = $nextQuestionId;
        if (isset($cmpltButton)) {
            return response()->json($data);
        } else {
            return response()->json($data);
        }
        return response()->json($data);
    }
     /** 
     * -------------------------------------------------------
     * | Preview question List                               |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function previewQuestionList2($questionId,$isReview=null){
        $previewQuestionList = Session::get('previewQuestionList');
        foreach($previewQuestionList as $nKey => $questionData){
            foreach($questionData['data'] as $key => $question){
                if($questionId == @$question['question_id']){
                    $previewQuestionList[$nKey]['data'][$key]['mark_as_review'] = @$isReview;
                }
            }
        }
        Session::put('previewQuestionList',$previewQuestionList);
        return $previewQuestionList;
    }
}
