<?php

namespace App\Http\Controllers\Practice;

use App\Helpers\PracticeHelper;
use App\Helpers\TestAssessmentHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\PracticeQuestion;
use App\Models\PracticeQuestionList;
use App\Models\PracticeTestQuestionAnswer;
use App\Models\Question;
use App\Models\Student;
use App\Models\TestAssessmentSubjectInfo;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class TestAssessmentController extends BaseController
{
    private $helper,$practiceHelper,$student;
    public $viewConstant = 'newfrontend.practice.';

    public function __construct(PracticeHelper $practiceHelper,TestAssessmentHelper $helper,Student $student)
    {
        $this->helper = $helper;
        $this->practiceHelper = $practiceHelper;
        $this->student = $student;
    }

    /**
     * -------------------------------------------------
     * | Attempt Assessment                            |
     * |                                               |
     * | @param $uuid                                  |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function attemptTest($uuid=null,$sectionId=null)
    {
        $this->helper->dbStart();
        try {
            $ip = \Request::ip();
            $sessionFlag = Session::get('refresh_flag');
            if($sessionFlag != null && $sessionFlag == false){
                return redirect()->route('submit-paper',['resultId'=>session()->get('result_id')]);
            }else{
                $sessionFlag = Session::put('refresh_flag',true);
            }
            $testAssessment = $this->practiceHelper->testAssessmentDetail($uuid);
            $section = $this->practiceHelper->getSectionDetail($sectionId);
            $nextSection = null;
            if($testAssessment->no_of_section > 1){
                $nextSection = $this->practiceHelper->getNextSection($section);
            }
            $examTotalTime = $section->section_time;
            $timeLeft = $section->time;
            $examTotalSeconds = $section->section_time;
            // for untimed test assessment
            if($testAssessment->is_time_mandatory == '0'){
                $examTotalSeconds = $testAssessment->section_total_time;
            }
            $timeTaken = [];
            $timeTaken[] = $examTotalSeconds;
            Session::forget('sectionTime');
            $student = Auth::guard('student')->user();
            $this->practiceHelper->startExam($student,$testAssessment);
            $studentTest = $this->practiceHelper->getStudentTestData($student,$testAssessment);
            $studentTestResult = @$studentTest->studentPracticeTestResult;
            session()->put('result_id',$studentTestResult->uuid);
            forgotTestSession();
            $isQuestionExist = $this->practiceHelper->addTestQuestionAnswer($student,$testAssessment,$studentTestResult);
            if($isQuestionExist == false){
                return redirect()->route('assessments-detail',['testAssessmentId'=>$testAssessment->uuid])->with('error', 'Question not found in this exam.');
            }
            @$studentTestResult->studentTestAssessmentQuestionAnswers;
            $questionData = $this->practiceHelper->getCurrentQuestion($studentTestResult,null,false,$section->id);
            $question = $questionData[0];
            $testQuestionAnswer = $questionData[1];
            $nextQuestionId = $this->practiceHelper->getNextQuestionId($studentTestResult,$testQuestionAnswer,false,$section->id);
            $previousQuestionId = $this->practiceHelper->getPreviousQuestionId($studentTestResult,$testQuestionAnswer,false,$section->id);
            $audioData = $this->helper->assessmentAudio(@$testAssessment);
            $questionList = PracticeTestQuestionAnswer::where('practice_test_result_id',$studentTestResult->id)
                            ->where('assessment_section_id',$section->id)
                            ->orderBy('id','asc')
                            ->get();
            $this->previewQuestionList($questionList);
            $previewQuestionList = Session::get('previewQuestionList');
            $this->helper->dbEnd();
            return view($this->viewConstant . 'exam',['testQuestionAnswer'=>@$testQuestionAnswer,'question'=>$question,
            'nextQuestionId'=>@$nextQuestionId,'studentTest'=>@$studentTest,'studentTestResult'=>@$studentTestResult,
            'testAssessment'=>@$testAssessment,'student'=>@$student,'nextQuestionId'=>$nextQuestionId,'firstAudio' => @$audioData[0],
            'secondAudio' => @$audioData[1], 'thirdAudio' => @$audioData[2], 'forthAudio' => @$audioData[3],
            'secondAudioPlayTime' => @$audioData[4], 'thirdAudioPlayTime' => @$audioData[5],'forthAudioPlayTime' => @$audioData[6],
            'timeLeft' => @$timeLeft,'examTotalTimeSeconds' => $examTotalSeconds,'section'=>@$section,'nextSection'=>@$nextSection,
            'previewQuestionList' => @$previewQuestionList,'ip'=>$ip,
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
            $studentTestResultData = $this->practiceHelper->storeAnswer($request);
            $studentTestResult = $studentTestResultData[0];
            $isReview = 0;
            if($studentTestResult->markAsReviewCount->count() >0){
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
            $studentTestResultData = $this->practiceHelper->storeAnswer($request);
            $studentTestResult = $studentTestResultData[0];
            $studentTestQuestion = $studentTestResultData[1];
            $markAsReview = ($request->is_review_question==1)?true:false;
            $questionData = $this->practiceHelper->getCurrentQuestion($studentTestResult,$request->next_question_id,$markAsReview,$request->section_id);
            $section = $this->practiceHelper->getSection($request->section_id);
            $question = $questionData[0];
            $testQuestionAnswer = $questionData[1];
            // dd($studentTestQuestion);
            $this->updatePreviewQuestionList($studentTestQuestion->id,$studentTestQuestion->mark_as_review,$studentTestQuestion->is_attempted);
            $previewQuestionList = Session::get('previewQuestionList');
            $nextQuestionId = $this->practiceHelper->getNextQuestionId($studentTestResult,$testQuestionAnswer,$markAsReview,$request->section_id);
            $previousQuestionId = $this->practiceHelper->getPreviousQuestionId($studentTestResult,$testQuestionAnswer,$markAsReview,$request->section_id);
            $nextSection = $this->practiceHelper->getNextSection($studentTestQuestion->assessmentSection);
            $data = ['previousQuestionId'=>@$previousQuestionId,'nextQuestionId'=>@$nextQuestionId,'question'=>@$question,
                     'testQuestionAnswer'=>@$testQuestionAnswer,'markAsReview'=>@$markAsReview,'previewQuestionList'=>@$previewQuestionList,
                     'nextSection' => $nextSection,'section'=>@$section,
                    ];
            $questionHtml = view($this->viewConstant.'question_view', $data)->render();
            $isReview = 0;
            if($studentTestResult->markAsReviewCount->count() >0){
                $isReview = 1;
            }
            $attempted = $studentTestResult->attempted;
            return response()->json(['attempted'=>@$attempted,'html'=>$questionHtml,'questionNo'=>@$question->question_no,'status' => __('admin_messages.icon_success'),'isReview'=>@$isReview]);
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
        try{
            Session::put('refresh_flag',false);
            $result = $this->practiceHelper->testResult($resultId);
            $sectionTime = Session::get('sectionTime');
            $studentTest = $result->studentTest;
            if($sectionTime != null){
                $duration = array_sum($sectionTime);
                $studentTest->update(['duration'=>$duration]);
            }
            $student = $this->student::find($result->student_id);
            $routeName = Route::currentRouteName();
            $totalAttemptCount = $result->studentTest->studentTotalTestAssessmentAttempt->count();
            $overallResult = 0;
            $totalMarks = 0;
            if($result->total_mark_text > 0 && $result->obtained_marks > 0){
                $totalMarks = $result->total_mark_text;
                $overallResult = ($result->obtained_marks * 100) / $totalMarks;
                $overallResult = round($overallResult,2);
            }
            $testAssessment = @$result->testAssessment;
            if($routeName == 'submit-paper' ){
                session()->put('result_id',$resultId);
                $result->update([
                    'overall_result' => $overallResult,
                    'total_marks' => @$testAssessment->proper_total_marks,
                ]);
                forgotTestSession();
            }
            $result = $this->practiceHelper->testResult($resultId);
            $question = $testAssessment->testAssessmentSubjectInfo[0]->question;
            $sectionId = $testAssessment->testAssessmentSubjectInfo[0]->section_id;
            $totalTest = $this->practiceHelper->totalStudentTest($testAssessment->id);
            $testQuestionAnswers = $result->studentTestAssessmentQuestionAnswers()
                                    ->paginate(5);
            return view($this->viewConstant .'result',['testQuestionAnswers'=>@$testQuestionAnswers,'question'=>@$question,'totalAttemptCount'=>@$totalAttemptCount,'totalTest'=>@$totalTest,'result'=>@$result,'testAssessment'=>@$testAssessment,'student'=>@$student,'studentTest' => @$studentTest]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------
     * | review paper                                  |
     * |                                               |
     * | @param $resultId                              |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function reviewTestPaper($resultId){
        try{
            $result = $this->practiceHelper->testResult($resultId);
            session()->put('result_id',$resultId);
            forgotTestSession();
            $studentTest = $result->studentTest;
            $data = $result->studentTestAssessmentQuestionAnswers->where('mark_as_review',1);
            $questionData = $this->practiceHelper->getCurrentQuestion($result,null,true);
            $question = $questionData[0];
            $testQuestionAnswer = $questionData[1];
            $nextQuestionId = $this->practiceHelper->getNextQuestionId($result,$testQuestionAnswer,true);
            $previousQuestionId = $this->practiceHelper->getPreviousQuestionId($result,$testQuestionAnswer,true);
            $student = Auth::guard('student')->user();
            $testAssessment = @$result->testAssessment;
            $totalAttemptCount = $result->studentTest->studentTotalTestAssessmentAttempt->count();
            return view($this->viewConstant . 'review_exam',['testQuestionAnswer'=>@$testQuestionAnswer,'question'=>@$question,
            'nextQuestionId'=>@$nextQuestionId,'studentTest'=>@$studentTest,'studentTestResult'=>@$result,'data' =>@$data,
            'testAssessment'=>@$testAssessment,'student'=>@$student,'previousQuestionId'=>@$previousQuestionId,'totalTest'=>@$totalTest,
            'totalAttemptCount'=>@$totalAttemptCount]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------
     * | view assessments questions                    |
     * |                                               |
     * | @param $resultId                              |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function viewTestAssessmentQuestion($resultId=null,$sectionId=null,$questionId=null){
        try{
            $result = $this->practiceHelper->testResult($resultId);
            $question = Question::where('uuid',$questionId)->first();
            $testQuestionAnswers = $result->studentTestAssessmentQuestionAnswers()
                                    ->where('question_id',$question->id)
                                    ->where('assessment_section_id',$sectionId)
                                    ->get();
            $section = TestAssessmentSubjectInfo::where('id',$sectionId)->first();
            $testAssessment = @$result->testAssessment;
            $totalTest = $this->practiceHelper->totalStudentTest($testAssessment->id);
            $student = Auth::guard('student')->user();
            $totalAttemptCount = $result->studentTest->studentTotalTestAssessmentAttempt->count();
            return view($this->viewConstant .'view_questions',['testQuestionAnswers'=>@$testQuestionAnswers,'totalTest'=>@$totalTest,
            'result'=>@$result,'testAssessment'=>@$testAssessment,'student'=>@$student,'section'=>@$section,'totalAttemptCount'=>@$totalAttemptCount]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------
     * | report problem                                |
     * |                                               |
     * | @param $resultId                              |
     * | @return response                              |
     * |------------------------------------------------
     */
    public function reportProblem(Request $request){
        $problem = $this->practiceHelper->storeProblem($request);
        return response()->json(['status'=>'success','msg'=>__('formname.problem_reported_success')]);
    }

    /**
     * -------------------------------------------------
     * | get report problem                            |
     * |                                               |
     * | @param $resultId                              |
     * | @return response                              |
     * |------------------------------------------------
     */
    public function getReportProblem(Request $request){
        $problem = $this->practiceHelper->getReportProblem($request);
        if($problem != null){
            return response()->json(['status'=>'success','data'=>@$problem]);
        }else{
            return response()->json(['status'=>'failed']);
        }
    }

    /**
     * -------------------------------------------------
     * | get section detail                            |
     * |                                               |
     * | @param $sectionId                             |
     * | @return response                              |
     * |------------------------------------------------
     */
    public function sectionDetail($uuid,$sectionId){
        $testAssessment = $this->practiceHelper->testAssessmentDetail($uuid);
        Session::put('refresh_flag',false);
        if($testAssessment != null){
            $section = $testAssessment->testAssessmentSubjectDetail[0];
            // if(@$section->description != null || @$section->image != null){
                // $routeUrl = route('attempt-test-assessment',['uuid'=>@$uuid,'sectionId'=>@$section->uuid]);
                // return view($this->viewConstant .'_section_detail',['section'=>@$section,'uuid'=>@$testAssessment->uuid,'testAssessment'=>@$testAssessment,'routeUrl'=>$routeUrl]);
            // }
            return redirect()->route('attempt-test-assessment',['uuid'=>@$uuid,'sectionId'=>@$section->uuid]);
        }else{
            abort('404');
        }
    }
    /**
     * -------------------------------------------------
     * | Go to section                                 |
     * |                                               |
     * | @param $sectionId                             |
     * | @return response                              |
     * |------------------------------------------------
     */

    public function goToSection($uuid,$sectionId){
        $testAssessment = $this->practiceHelper->testAssessmentDetail($uuid);
        if($testAssessment != null){
            $section = $this->practiceHelper->getSectionDetail($sectionId);
            if(@$section->description != null || @$section->image != null){
                $routeUrl = route('next.section',['uuid'=>@$uuid,'sectionId'=>@$section->uuid]);
                return view($this->viewConstant .'_section_detail',['section'=>@$section,'uuid'=>@$testAssessment->uuid,'testAssessment'=>@$testAssessment,'routeUrl'=>$routeUrl]);
            }
            return redirect()->route('next.section',['uuid'=>@$uuid,'sectionId'=>@$section->uuid]);
        }else{
            abort('404');
        }
    }
     /**
     * -------------------------------------------------
     * | Next section                                  |
     * |                                               |
     * | @param $sectionId                             |
     * | @return response                              |
     * |------------------------------------------------
     */


    public function nextSection($uuid,$sectionId){
        $this->helper->dbStart();
        try {
            $sessionFlag = Session::get('refresh_flag');
            if($sessionFlag != null && $sessionFlag == true){
                return redirect()->route('submit-paper',['resultId'=>session()->get('result_id')]);
            }else{
                $sessionFlag = Session::put('refresh_flag',false);
            }
            $testAssessment = $this->practiceHelper->testAssessmentDetail($uuid);
            $section = $this->practiceHelper->getSectionDetail($sectionId);
            $nextSection = null;
            if($testAssessment->no_of_section > 1){
                $nextSection = $this->practiceHelper->getNextSection($section);
            }
            $examTotalTime = $section->section_time;
            $timeLeft = $section->time;
            $examTotalSeconds = $section->section_time;
            // for untimed test assessment
            // if($testAssessment->is_time_mandatory == '0'){
            //     // section exam time
            //     $time = $testAssessment->section_total_time;
            //     $sectionTime = session()->get('sectionTime');
            //     $timeTaken = array_sum($sectionTime);
            //     $examTotalSeconds = $time - $timeTaken;
            // }
            $student = Auth::guard('student')->user();
            $studentTest = $this->practiceHelper->getStudentTestData($student,$testAssessment);
            $studentTestResult = @$studentTest->studentTestResult;
            // dd($studentTestResult);
            session()->put('result_id',$studentTestResult->uuid);
            forgotTestSession();
            $questionData = $this->practiceHelper->getCurrentQuestion($studentTestResult,null,false,$section->id);
            $question = $questionData[0];
            $testQuestionAnswer = $questionData[1];
            $nextQuestionId = $this->practiceHelper->getNextQuestionId($studentTestResult,$testQuestionAnswer,false,$section->id);
            $previousQuestionId = $this->practiceHelper->getPreviousQuestionId($studentTestResult,$testQuestionAnswer,false,$section->id);
            $audioData = $this->helper->assessmentAudio(@$testAssessment);
            $questionList = PracticeTestQuestionAnswer::where('student_test_result_id',$studentTestResult->id)
                            ->where('assessment_section_id',$section->id)
                            ->get();
            $this->previewQuestionList($questionList);
            $previewQuestionList = Session::get('previewQuestionList');
            $this->helper->dbEnd();
            return view($this->viewConstant . 'exam',['testQuestionAnswer'=>@$testQuestionAnswer,'question'=>$question,
            'nextQuestionId'=>@$nextQuestionId,'studentTest'=>@$studentTest,'studentTestResult'=>@$studentTestResult,
            'testAssessment'=>@$testAssessment,'student'=>@$student,'nextQuestionId'=>$nextQuestionId,'firstAudio' => @$audioData[0],
            'secondAudio' => @$audioData[1], 'thirdAudio' => @$audioData[2], 'forthAudio' => @$audioData[3],
            'secondAudioPlayTime' => @$audioData[4], 'thirdAudioPlayTime' => @$audioData[5],'forthAudioPlayTime' => @$audioData[6],
            'timeLeft' => @$timeLeft,'examTotalTimeSeconds' => $examTotalSeconds,'section'=>@$section,'nextSection'=>@$nextSection,
            'previewQuestionList'=> @$previewQuestionList,
            ]);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return redirect()->back()->with('error', $e->getMessage());
            abort('404');
        }
    }
     /**
     * -------------------------------------------------
     * | Preview question list section                 |
     * |                                               |
     * | @param $sectionId                             |
     * | @return response                              |
     * |------------------------------------------------
     */

    public function previewQuestionList($questionList){
        $previewQuestionList = [];
        foreach($questionList as $key => $question){
            $previewQuestionList[$question->id]['id'] = $question->id;
            $previewQuestionList[$question->id]['question_id'] = $question->question_id;
            $previewQuestionList[$question->id]['q_no'] = $question->questionData->question_no;
            $previewQuestionList[$question->id]['question'] = $question->questionData->question;
            $previewQuestionList[$question->id]['mark_as_review'] = 0;
            $previewQuestionList[$question->id]['is_attempted'] = 0;
        }
        Session::put('previewQuestionList',$previewQuestionList);
        return $previewQuestionList;
    }

    public function updatePreviewQuestionList($key,$review=null,$isAttempted=null){
        $questionList = Session::get('previewQuestionList');
        $markForReview = ($review == 1)? 1 : 0;
        $questionList = Session::get('previewQuestionList');
        $questionList[$key]['mark_as_review'] = $markForReview;
        $questionList[$key]['is_attempted'] = $isAttempted;
        Session::put('previewQuestionList',$questionList);
        $questionList = Session::get('previewQuestionList');
        return;
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
            $question = PracticeQuestion::where('uuid',$request->uuid)->firstOrFail();
            $studentTestQuestionAnswer = PracticeTestQuestionAnswer::where('uuid',$request->id)->first();
            $mockTest = $studentTestQuestionAnswer->assessmentSection->assessment;
            $html = $this->getPartials('newfrontend.paper._question_detail', ['mockTest'=>@$mockTest,'question' => @$question,'studentTestQuestionAnswer'=>@$studentTestQuestionAnswer]);
            return response()->json(['html'=>$html,'status'=>'success']);
        }catch(Exception $e){
            return response()->json(['status'=>'info']);
        }
    }
}
