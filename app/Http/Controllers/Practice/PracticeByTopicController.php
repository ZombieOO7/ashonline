<?php

namespace App\Http\Controllers\Practice;

use App\Helpers\PracticeByTopicHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\PracticeByTopicQuestionAnswer;
use App\Models\PracticeByTopicTest;
use App\Models\Student;
use App\Models\Topic;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class PracticeByTopicController extends BaseController
{
    protected $viewConstant = 'newfrontend.practice.topic.';
    protected $helper;
    public $isParent = false,$parent=[];
    public function __construct(PracticeByTopicHelper $helper){
        $this->helper = $helper;
    }

    
    /**
     * -------------------------------------------------
     * | Practice Test paper results                   |
     * |                                               |
     * | @param subject,studentId                      |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index($slug=null,$studentId=null){
        try {
            $student = $this->helper->findChild($studentId);
            $studentId = @$student[0];
            $uuid = @$student[1];
            $subjectData = $this->helper->subject($slug);
            $student = Student::find($studentId);
            $topicList = $this->helper->topicList($subjectData,$student);
            $topicList = ($topicList != null)?$topicList:[];
            return view($this->viewConstant . 'list',['subjectData'=>@$subjectData,'uuid' => $uuid,'studentId'=>@$studentId,'topicList'=>@$topicList,'subject'=>@$subjectData]);
        }catch(Exception $e){
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Practice Test paper results                   |
     * |                                               |
     * | @param subject,slug                           |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function detail($uuid=null)
    {
        try {
            $data['practiceExam'] = $this->helper->detail($uuid);
            $questionData = $this->helper->questionData($data['practiceExam']);
            $data['totalQuestions'] = $questionData['totalQuestions'];
            $data['totalMarks'] = $questionData['totalMarks'];
            $data['subjectData'] = $data['practiceExam']->subject;
            return view($this->viewConstant .'detail',$data);
        }catch(Exception $e){
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Attempt Practice Test paper                   |
     * |                                               |
     * | @param topi slug                              |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function attemptTest($uuid=null)
    {
        $this->helper->dbStart();
        try {
            if(session()->has('result_id')){
                return redirect()->route('topic.submit-paper',['resultId'=>session()->get('result_id')]);
            }
            $practiceExam = $this->helper->detail($uuid);
            $student = Auth::guard('student')->user();
            $studentTestResult = $this->helper->startExam($practiceExam);
            session()->put('result_id',$studentTestResult->uuid);
            forgotTestSession();
            Session::forget('questionList');
            Session::forget('testAnswers');
            $testQuestionAnswers = $this->helper->addTestQuestionAnswer($practiceExam,$student,$studentTestResult->id);
            if($testQuestionAnswers == null){
                return Redirect::back()->with('error', 'Question not found in this exam.');
            }
            $testQuestionAnswer = $testQuestionAnswers[0];
            $questionList = Session::get('questionList');
            $previewQuestionList = Session::get('previewQuestionList');
            $question = $questionList['questionList'][0];
            $nextQuestionId = @$questionList['questionList'][1] != null ? @$questionList['questionList'][1]['id'] : null;
            $prevQuestionId = null;
            $this->helper->dbEnd();
            return view($this->viewConstant .'exam',['question'=>$question,'previewQuestionList'=>@$previewQuestionList,
            'nextQuestionId'=>@$nextQuestionId,'studentTestResult'=>@$studentTestResult, 'practiceExam' => $practiceExam,
            'student'=>@$student,'nextQuestionId'=>$nextQuestionId,'prevQuestionId'=>@$prevQuestionId,
            'testQuestionAnswer' => @$testQuestionAnswer,
            ]);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return Redirect::back()->with('error', $e->getMessage());
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Store test question answer                    |
     * |                                               |
     * | @param Request                                |
     * | @return Respomse                              |
     * |------------------------------------------------
     */
    public function storeAnswers(Request $request){
        try{
            $studentTestResult =$this->helper->storeAnswer($request);
            $isReview = 0;
            if(isset($studentTestResult->markAsReviewCount) && $studentTestResult->markAsReviewCount->count() >0){
                $isReview = 1;
            }
            session()->put('isExam','yes');
            return response()->json(['isReview'=>$isReview,'status' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            return response()->json(['msg' => $e->getMessage(), 'status' => __('admin_messages.icon_info')]);
        }
    }

        /**
     * -------------------------------------------------
     * | Get Next question                             |
     * |                                               |
     * | @param Request                                |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getQuestion(Request $request){
        try{
            $this->helper->storeAnswer($request);
            $markAsReview = ($request->is_review_question==1)?true:false;
            $questionData = Session::get('questionList');
            $questionList = $questionData['questionList'];
            $testQuestionAnswers = Session::get('testAnswers');
            $question = @$questionList[$request->index];
            $testQuestionAnswerId = @$testQuestionAnswers[$request->index]['id'];
            $testQuestionAnswer = PracticeByTopicQuestionAnswer::where('id',$testQuestionAnswerId)->first();
            $nextIndex = isset($questionList[$request->index + 1])?$request->index + 1 : null;
            $prevIndex = isset($questionList[$request->index - 1])?$request->index - 1 : null;
            $nextQuestionId = isset($questionList[($request->index+1)])?$questionList[($request->index+1)]['id']:null;
            $previousQuestionId = isset($questionList[($request->index-1)])?$questionList[($request->index-1)]['id']:null;
            $data = ['questionNo'=>@$question->question_no,'previousQuestionId'=>@$previousQuestionId,
            'nextQuestionId'=>@$nextQuestionId,'question'=>@$question,'testQuestionAnswer'=>@$testQuestionAnswer,
            'markAsReview'=>@$markAsReview, 'nextIndex' => @$nextIndex,'prevIndex'=>@$prevIndex];
            $questionHtml = view($this->viewConstant.'question_view', $data)->render();
            $previewQuestionList = Session::get('previewQuestionList');
            $previewHtml = view($this->viewConstant.'_preview_list',['question'=>@$testQuestionAnswer,'previewQuestionList'=>@$previewQuestionList] )->render();
            $isReview = 0;
            return response()->json(['html'=>$questionHtml,'previewHtml'=>@$previewHtml,'status' => __('admin_messages.icon_success'),'isReview'=>@$isReview]);
        }catch(Exception $e){
            return response()->json(['msg' => $e->getMessage(), 'status' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | submit paper                                  |
     * |                                               |
     * | @param $resultId                              |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function testAssessmentResult($resultId=null){
        // studentTestResultRank();
        try{
            $result = $this->helper->testResult($resultId);
            $student = $result->student;
            $routeName = Route::currentRouteName();
            if($routeName == 'topic.submit-paper' ){
                session()->put('result_id',$resultId);
                forgotTestSession();
            }
            $practiceExam = @$result->practiceExam;
            $subject = $practiceExam->subject;
            $questionData = $this->helper->getCurrentQuestion($result,null,false);
            $question = $questionData[0];
            $testQuestionAnswer = $questionData[1];
            $nextQuestionId = $this->helper->getNextQuestionId($result,$testQuestionAnswer,false);
            $previousQuestionId = $this->helper->getPreviousQuestionId($result,$testQuestionAnswer,false);
            $totalTest = $this->helper->totalTestAttempt($result);
            $routeName = Route::currentRouteName();
            if($routeName == 'topic.view-result'){
                return view($this->viewConstant .'result_2',['practiceExam'=>@$practiceExam,'totalTest'=>@$totalTest,'result'=>@$result,'topic'=>@$topic,
                'subject'=>@$subject,'student'=>@$student,'question'=>@$question,'testQuestionAnswer'=>@$testQuestionAnswer,
                'nextQuestionId'=>@$nextQuestionId,'previousQuestionId'=>@$previousQuestionId]);
            }
            return view($this->viewConstant .'result',['practiceExam'=>@$practiceExam,'totalTest'=>@$totalTest,'result'=>@$result,'topic'=>@$topic,
            'subject'=>@$subject,'student'=>@$student,'question'=>@$question,'testQuestionAnswer'=>@$testQuestionAnswer,
            'nextQuestionId'=>@$nextQuestionId,'previousQuestionId'=>@$previousQuestionId]);
        }catch(Exception $e){
            abort('404');
        }
    }


    /**
     * -------------------------------------------------
     * | submit paper                                  |
     * |                                               |
     * | @param $resultId                              |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function viewTestAssessmentQuestion($resultId=null){
        try{
            $result = $this->helper->testResult($resultId);
            $testQuestionAnswers = $result->studentTestQuestionAnswers;
            $testAssessment = @$result->testAssessment;
            $totalTest = $this->helper->totalStudentTest($testAssessment->id);
            $student = Auth::guard('student')->user();
            return view($this->viewConstant .'view_questions',['testQuestionAnswers'=>@$testQuestionAnswers,'totalTest'=>@$totalTest,'result'=>@$result,'testAssessment'=>@$testAssessment,'student'=>@$student]);
        }catch(Exception $e){
            abort('404');
        }
    }
    
    public function goToQuestion(Request $request){
        $studentTestResult =$this->helper->storeAnswer($request);
        $questionData = Session::get('questionList');
        $questionList = $questionData['questionList'];
        $testQuestionAnswers = Session::get('testAnswers');
        $question = @$questionList[$request->index];
        $testQuestionAnswerId = @$testQuestionAnswers[$request->index]['id'];
        $testQuestionAnswer = PracticeByTopicQuestionAnswer::where('id',$testQuestionAnswerId)->first();
        $nextIndex = isset($questionList[$request->index + 1])?$request->index + 1 : null;
        $prevIndex = isset($questionList[$request->index - 1])?$request->index - 1 : null;
        $nextQuestionId = isset($questionList[($request->index+1)])?$questionList[($request->index+1)]['id']:null;
        $previousQuestionId = isset($questionList[($request->index-1)])?$questionList[($request->index-1)]['id']:null;
        $data = ['questionNo'=>@$question->question_no,'previousQuestionId'=>@$previousQuestionId,
        'nextQuestionId'=>@$nextQuestionId,'question'=>@$question,'testQuestionAnswer'=>@$testQuestionAnswer,
        'nextIndex' => @$nextIndex,'prevIndex'=>@$prevIndex];
        $questionHtml = view($this->viewConstant.'question_view', $data)->render();
        $previewQuestionList = Session::get('previewQuestionList');
        $previewHtml = view($this->viewConstant.'_preview_list',['question'=>@$testQuestionAnswer,'previewQuestionList'=>@$previewQuestionList] )->render();
        $isReview = 0;
        return response()->json(['html'=>$questionHtml,'previewHtml'=>@$previewHtml,'status' => __('admin_messages.icon_success'),'isReview'=>@$isReview]);
    }
}
