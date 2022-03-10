<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\MockTest;
use App\Models\MockTestPaper;
use App\Models\MockTestSubjectDetail;
use App\Models\PurchasedMockTest;
use App\Models\Question;
use App\Models\QuestionList;
use App\Models\StudentTest;
use App\Models\StudentTestPaper;
use App\Models\StudentTestQuestionAnswer;
use App\Models\StudentTestResults;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Session;

class MockTestPaperController extends BaseController
{
    public function __construct(MockTest $mockTest,MockTestPaper $mockTestPaper)
    {
        $this->mockTestPaper = $mockTestPaper;
        $this->mockTest = $mockTest;
    }

    /**
     * -------------------------------------------------------
     * | Get Mock Exam Mock Paper Info                       |
     * |                                                     |
     * | @param uuid                                         |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function examInfo($uuid=null){
        try{
            $mockTest = $this->mockTest::whereUuid($uuid)->firstOrFail();
            $inprgExam = StudentTestPaper::whereStudentId(Auth::guard('student')->id())
                                ->whereHas('paper',function($query){
                                    $query->whereNull('deleted_at');
                                    $query->whereHas('mockTest');
                                })
                                ->whereIsCompleted('0')
                                ->where('is_reset','0')
                                ->whereHas('studentTest')
                                ->count();
            // if(Session::get('studentTest') != null){
            //     $inprgExam = 1;
            // }
            return view('newfrontend.paper.exam_info',['mockTest'=>@$mockTest,'inprgExam'=>@$inprgExam]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get student mock paper info                         |
     * |                                                     |
     * | @param uuid                                         |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function mockPaperInfo($uuid=null){
        try{
            $mockTestPaper = MockTestPaper::where('uuid',$uuid)->first();
            $mockTest = $mockTestPaper->mockTest;
            $inprgExam = StudentTestPaper::whereStudentId(Auth::guard('student')->id())
                                ->whereHas('paper',function($query){
                                    $query->whereNull('deleted_at');
                                    $query->whereHas('mockTest');
                                })
                                ->whereIsCompleted('0')
                                ->where('is_reset','0')
                                ->whereHas('studentTest')
                                ->count();
            if($inprgExam > 0){
                return redirect()->route('mock-info',['uuid'=>@$mockTest->uuid])->with(['message'=>__('formname.exam_inprogress')]);
            }
            session()->forget('sectionIds');
            return view('newfrontend.paper.paper_info',['mockTestPaper'=>@$mockTestPaper]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get ,ock test paper section data                    |
     * |                                                     |
     * | @param request                                      |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function mockPaperSection(Request $request)
    {
        try{
            Session::forget('studentTest');
            Session::forget('studentTestPaper');
            $mockTestPaper = $this->mockTestPaper::where('uuid',$request->uuid)->first();
            $mockTest = @$mockTestPaper->mockTest;
            Session::forget('mockTest');
            Session::forget('paper');
            Session::put('mockTest',$mockTest);
            Session::put('paper',$mockTestPaper);

            $section = @$mockTestPaper->mockTestSubjectDetail[0];
            Session::forget('sections');
            Session::forget('questions');
            session()->forget('sectionIds');
            Session::put('sections', @$mockTestPaper->mockTestSubjectDetail);
            Session::put('questions', @$mockTestPaper->mockTestSubjectDetail);
            // check that section has description and redirect to section detail route
            if($section->description != null || $section->image != null){
                return redirect()->route('section.detail', ['paper'=>@$mockTestPaper->uuid]);
            }
            return redirect()->route('start.exam',['uuid'=>@$mockTestPaper->uuid,'sectionId'=>$section->id]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get section detail page                             |
     * |                                                     |
     * | @param uuid                                         |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function sectionDetail($uuid=null,$sectionId=null)
    {
        try{
            // set condition to go to next section
            $mockTestPaper = Session::get('paper');
            $sections = Session::get('sections');
            Session::put('refresh_flag',false);
            // start first section exam
            if($sectionId==null){
                $sectionId = 0;
                $section = $sections[$sectionId];
                $routeUrl = route('start.exam',['uuid'=>@$uuid,'sectionId'=>@$section->id]);
            }else{
                // start that section exam
                $section = $sections[$sectionId];
                $routeUrl = route('go-to-section',['uuid'=>@$uuid,'sectionId'=>@$sectionId]);
            }
            $sectionIds = session()->get('sectionIds');
            // if mock test paper time is mandatory then student can jump to other section
            if($mockTestPaper->is_time_mandatory == 0){
                if($sectionIds == null){
                    $sectionIds[] = $section->id;
                    session()->put('sectionIds',$sectionIds);
                }else{
                    if(in_array($section->id,$sectionIds)){
                        return redirect()->route('go-to-section',['uuid'=>@$uuid,'sectionId'=>@$sectionId]);
                    }else{
                        $sectionIds[] = $section->id;
                        session()->put('sectionIds',$sectionIds);
                    }
                }
            }
            $time = explode(':', $section->instruction_read_time);
            $hour = ($time[0] == null || $time[0]=='')?'00':$time[0] * 3600;
            $minutes = ($time[1] == null || $time[1]=='')?'00':$time[1] * 60;
            $seconds = ($time[2] == null || $time[2]=='')?'00':$time[2];
            $examTotalTimeSeconds = $hour + $minutes + $seconds;
            return view('newfrontend.paper.section_detail',['section'=>@$section,'examTotalTimeSeconds'=>@$examTotalTimeSeconds,'uuid'=>$uuid,'routeUrl'=>@$routeUrl]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Start Paper Exam                                    |
     * |                                                     |
     * | @param uuid,sectionId                               |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function startExam(Request $request,$uuid=null,$sectionId=null){
        $this->dbStart();
        try{
            session()->forget('sectionTime');
            $sections = Session::get('sections');
            $section = $sections[0];
            $paper = Session::get('paper');
            $mockTest = $paper->mockTest;
            // if page refesh than redirect to result page
            $oldTest = Session::get('studentTest');
            $oldTestPaper = Session::get('studentTestPaper');
            session()->put('isExam',true);
            if($oldTest != null && $oldTestPaper != null){
                $oldTestPaper->update(['is_completed'=>1]);
                return redirect()->route('paper-result',['paperId'=>$oldTestPaper->uuid]);
            }
            // check paper is time or untimed
            if($paper->is_time_mandatory==0){
                $time = explode(':', $paper->time);
                $examTotalSeconds = ($time[0] * 3600) + ($time[1] * 60) + $time[2];
            }else{
                $time = explode(':', $section->time);
                $examTotalSeconds = ($time[0] * 3600) + ($time[1] * 60) + $time[2];
            }
            // $examTotalSeconds = 1800;
            // allAudios
            $audioData = $this->mockExamAudio($mockTest,$examTotalSeconds);

            // store test data
            $studentTest = $this->studentTest($mockTest);

            // store test paper data
            $studentTestPaper = $this->studentTestPaper($mockTest,$studentTest,$paper);

            // store test paper result data
            $studentTestResult = $this->studentTestResult($mockTest,$studentTestPaper);

            // store test paper question list
            $this->questionList($mockTest,$studentTestPaper,$studentTestResult,$section,$paper);
            $questionList = Session::get('sectionQuestion');
            // preview question list
            $this->previewQuestionList();
            $previewQuestionList = Session::get('previewQuestionList');

            $firstQuestion = $questionList[0];
            $nextQuestionId = 1;
            $prevQuestionId = null;
            $student = Auth::guard('student')->user();
            if(count($sections)>1){
                $nextSectionId = 1;
                $nextSection = @$sections[1];
            }else{
                $nextSection = null;
                $nextSectionId = null;
            }
            $prevSectionId = null;
            $array = [
                'section'=>@$section,'mockTest'=>@$mockTest,'studentTest' => @$studentTest,'studentTestPaper'=>@$studentTestPaper,
                'firstQuestion'=>@$firstQuestion, 'studentTestResult' => $studentTestResult,'section' => @$section,'sections' => $sections,
                'student' => $student,'ip' => \Request::ip(),'nextQuestionId'=>$nextQuestionId,'prevQuestionId'=>@$prevQuestionId,
                'nextSectionId' => @$nextSectionId, 'prevSectionId' => @$prevSectionId,'examTotalTimeSeconds'=>$examTotalSeconds,
                'subjectId' => @$section->subject_id,'sectionId'=>0, 'nextSection'=> @$nextSection,'paper'=>@$paper,'previewQuestionList'=>@$previewQuestionList
            ];
            $examArray = array_merge($array,$audioData);
            $this->dbCommit();
            return view('newfrontend.paper.exam',$examArray);
        }catch(Exception $e){
            $this->dbRollBack();
            abort('404');
        //     dd($e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Mock Exam audios                                    |
     * |                                                     |
     * | @param mockTest,seconds                             |
     * | @return AudioDataArray                              |
     * -------------------------------------------------------
     */
    public function mockExamAudio($mockTest,$examTotalSeconds){
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
        return ['firstAudio' => @$firstAudio, 'secondAudio' => @$secondAudio, 'thirdAudio' => @$thirdAudio,
        'forthAudio' => @$forthAudio, 'secondAudioPlayTime' => @$secondAudioPlayTime,
        'thirdAudioPlayTime' => @$thirdAudioPlayTime, 'forthAudioPlayTime' => @$forthAudioPlayTime];
    }

    /**
     * -------------------------------------------------------
     * | Student Test Data                                   |
     * |                                                     |
     * | @param mockTest                                     |
     * | @return StudentTest                                 |
     * -------------------------------------------------------
     */
    public function studentTest($mockTest){
        $questionIds = $mockTest->mockTestSubjectQuestion->pluck('question_id');
        $query = Question::whereIn('id',$questionIds);
        $questions = $query->count();
        $totalMarks = $query->sum('marks');
        $student = Auth::guard('student')->user();
        $studentTest = StudentTest::updateOrCreate(
            [
                'student_id' => $student->id,
                'mock_test_id' => $mockTest->id,
            ],[
                'student_id' => $student->id,
                'mock_test_id' => $mockTest->id,
                'start_date' => date('Y-m-d', strtotime(now())),
                'end_date' => date('Y-m-d', strtotime(now())),
                'status' => 1,
                'project_type' => 1,
                'questions' => $questions,
                'attempted' => 0,
                'correctly_answered' => 0,
                'unanswered' => $questions,
                'overall_result' => 0,
                'total_marks' => $totalMarks,
                'obtained_marks' =>0,
            ]
        );
        Session::put('studentTest',$studentTest);
        return $studentTest;
    }

    /**
     * -------------------------------------------------------
     * | Student Test Paper Data                             |
     * |                                                     |
     * | @param mockTest,studentTest,paper                   |
     * | @return StudentTestPaper                            |
     * -------------------------------------------------------
     */
    public function studentTestPaper($mockTest,$studentTest,$paper){
        $student = Auth::guard('student')->user();
        $questionIds = $paper->mockTestSubjectQuestion->pluck('question_id');
        $query = Question::whereIn('id',$questionIds);
        $questions = $query->count();
        $totalMarks = $query->sum('marks');
        $studentTestPaper = StudentTestPaper::updateOrCreate([
            'student_id' => $student->id,
            'mock_test_paper_id' => $paper->id,
            'student_test_id' => $studentTest->id,
        ],[
            'student_id' => $student->id,
            'mock_test_paper_id' => $paper->id,
            'student_test_id' => $studentTest->id,
            'questions' => $questions,
            'attempted' => 0,
            'unanswered' => $questions,
            'correctly_answered' => 0,
            'obtained_marks' => 0,
            'overall_result' => 0,
            'total_marks' => $totalMarks,
            'is_completed' => 0,
            'is_reset' => '0',
            'status' =>'2',
        ]);
        $attempt = $studentTestPaper->attempt + 1;
        $studentTestPaper->update(['attempt'=>$attempt]);
        Session::put('studentTestPaper',$studentTestPaper);

        return $studentTestPaper;
    }

    /**
     * -------------------------------------------------------
     * | Student Test resulr Data                             |
     * |                                                      |
     * | @param mockTest,studentTestPaper                     |
     * | @return StudentTestResult                            |
     * -------------------------------------------------------
     */
    public function studentTestResult($mockTest,$studentTestPaper){
        StudentTestResults::where(['student_test_paper_id' => @$studentTestPaper->id,'student_id'=>$studentTestPaper->student_id])->delete();
        $studentTestResult = StudentTestResults::create([
            'student_id' => $studentTestPaper->student_id,
            'student_test_id' => $studentTestPaper->student_test_id,
            'mock_test_id' => $mockTest->id,
            'questions' => $studentTestPaper->questions,
            'attempted'=> 0,
            'unanswerd'=> 0,
            'overall_result'=>0,
            'obtained_marks'=>0,
            'questions' => $studentTestPaper->questions,
            'correctly_answered' => 0,
            'unanswered' =>$studentTestPaper->questions,
            'total_marks' => $studentTestPaper->total_marks,
            'student_test_paper_id' => $studentTestPaper->id,
        ]);
        return $studentTestResult;
    }

    /**
     * -------------------------------------------------------
     * | Student Test Paper Data                             |
     * |                                                     |
     * | @param mockTest,studentTest,paper                   |
     * | @return questionList                                |
     * -------------------------------------------------------
     */
    public function questionList($mockTest,$studentTestPaper,$studentTestResult,$section,$paper){
        $sections = $paper->mockTestSubjectDetail;
        foreach($sections as $sectionKey => $sectionPack){
            $questionList = $sectionPack->questionList3()
                            ->orderBy(\DB::raw('CAST(questions.question_no AS INTEGER)'),'asc')
                            ->get();
            foreach($questionList as $key => $question){
                $sectionData[$sectionKey]['questionList'][$key] = StudentTestQuestionAnswer::create(
                    [
                        'student_id' => $studentTestResult->student_id,
                        'mock_test_id' => $mockTest->id,
                        'question_id' => $question->id,
                        'mark_as_review' =>0,
                        'subject_id' => $sectionPack->subject_id,
                        'is_correct' =>0,
                        'is_attempted' =>0,
                        'time_taken' =>0,
                        'answer_id'=>null,
                        'student_test_result_id' => $studentTestResult->id,
                        // 'question_list_id'=>$question->id,
                        'section_id'=>$sectionPack->id,
                    ]);
            }
        }
        Session::forget('questionList');
        Session::forget('sectionQuestion');
        $questionList = $sectionData[0]['questionList'];
        Session::put('sectionQuestion',$questionList);
        return $questionList;
    }

    /**
     * -------------------------------------------------------
     * | Go to next and previous question                    |
     * |                                                     |
     * | @param request                                      |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function prevNextQuestion(Request $request){
        $mockTest = MockTest::find($request->mock_test_id);
        $questions = Session::get('sectionQuestion');
        $paper = Session::get('paper');
        if ($request->type == 'next') { // Clicked next question button
            $sessionQuestion = $questions[$request->next_question_id];
            $question = StudentTestQuestionAnswer::where('id',$sessionQuestion->id)->first();
            $nextQuestionId = $request->next_question_id + 1 ;
            $prevQuestionId = $request->current_question_id;
            $currentQuestionId = $request->next_question_id;
        } else { // Clicked previous question button
            $sessionQuestion = $questions[$request->prev_question_id];
            $question = StudentTestQuestionAnswer::where('id',$sessionQuestion->id)->first();
            $nextQuestionId = $request->current_question_id;
            $prevQuestionId = $request->prev_question_id - 1;
            $currentQuestionId = $request->prev_question_id;
        }
        if($nextQuestionId == count($questions)){
            $nextQuestionId = null;
        }
        if($currentQuestionId == 0){
            $prevQuestionId = null;
        }
        $currentQuestion = @$questions[$request->current_question_id];
        $questionNo = @$question->questionData->question_no;
        $answers = $question->questionData->answers;
        $data = $question;
        $arr = [
            'question' => $question,
            'answers' => $answers,
            'mockTest' => $mockTest,
            'prev_selected_ans' => @$data->answer_id,
            'review' => true,
            'questionNo' => $questionNo,
        ];
        $studentId = Auth::guard('student')->id();

        $studentTest = StudentTest::where(['id' => @$request->student_test_id])->first();

        // recalculate taken time
        $timeTaken = isset($request->time_taken) ? $request->time_taken : 0;
        if (isset($data) && !empty(json_decode($data->answer_ids)) != null && !empty(json_decode($request->answer)) != null && !empty(json_decode($data->answer_ids)) != !empty(json_decode($request->answer))) {
            $timeTaken = $data->time_taken + $request->time_taken;
        }
        $sections = Session::get('sections');
        $nextSectionId = $request->section_id+1;
        if(isset($sections[$nextSectionId])){
            $nextSection = $sections[$nextSectionId];
        }else{
            $nextSection = null;
            $nextSectionId = null;
        }
        $prevSectionId = $request->section_id - 1;
        $prevSection = @$sections[$prevSectionId];
        $section= $sections[$request->section_id];
        if($prevSectionId < 0){
            $prevSectionId = null;
        }
        
        // Save UnAttempted Questions
        $studentAnswerIds = json_decode($request->answer);
        if ($request->type == 'next' || $request->type == 'prev') {
            $isCorrect = 0;
            if($request->answer != null && !empty($request->answer)){
                // get student answer id for compare 
                sort($studentAnswerIds);
                // get question correct answer ids
                $correctAnswerIds = @$currentQuestion->questionData->multipleCorrectAnswers->pluck('id')->toArray()??null;
                // dd($correctAnswerIds==$studentAnswerIds);
                // compare student answers and correct answer ids and set is correct
                if($correctAnswerIds == $studentAnswerIds){
                    $isCorrect = 1;
                }
            }
            StudentTestQuestionAnswer::updateOrCreate(
                [
                    'id' => @$currentQuestion->id,
                ],
                [
                    'answer_ids' => $request->answer,
                    // 'subject_id' => $currentQuestion->subject_id,
                    'is_attempted' => (!empty(json_decode($request->answer)))? 1 : 0,
                    'mark_as_review' => ($request->mark_as_review == 1)? 1 : 0,
                    'time_taken' => $timeTaken,
                    'is_correct' => @$isCorrect,
                ]
            );
        }
        $answer = StudentTestQuestionAnswer::where('id', @$currentQuestion->id)->first();
        $previewQuestionList = $this->updatePreviewQuestionList($request->current_question_id,$answer->mark_as_review,$answer->is_attempted);
        // $previewQuestionList = Session::get('previewQuestionList');
        $arr = [
            'question' => $question,
            'answers' => $answers,
            'mockTest' => $mockTest,
            'prev_selected_ans' => @$question->answer_id,
            'questionNo' => $questionNo,
            'review' => true,
            'time_taken' => $timeTaken,
            'nextQuestionId' => $nextQuestionId,
            'prevQuestionId' => (string)$prevQuestionId,
            'prev_question_id' => $prevQuestionId,
            'nextSectionId' => $nextSectionId,
            'current_question_id' => $currentQuestionId,
            'prevSectionId' =>$prevSectionId,
            'paper'=>@$paper,
            'previewQuestionList'=>@$previewQuestionList,
            'section' => @$section,
        ];
        $markAsReview = (isset($question) && $question->mark_as_review == 1) ? 1 :0;
        $testDetail = view('newfrontend.paper.exam_questions', $arr)->render();
        $detailArr = [
                        'nextQuestionId' => $nextQuestionId,
                        'prevQuestionId' => $prevQuestionId,
                        'nextSubjectId'=>$request->next_subject_id,
                        'subject_id' => $question->subject_id,
                        'question' => $question,
                        'current_question_id' => $question->id,
                        'prev_question_id' => $prevQuestionId, 'nextQuestionId' => $nextQuestionId,
                        'mockTest' => $mockTest];
        $subjectId = @$question->subject_id;
        $attemptedCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())
                            ->where(['student_test_result_id'=>$question->student_test_result_id,'subject_id'=>@$subjectId])
                            ->whereMockTestId($mockTest->id)
                            ->whereMockTestId($mockTest->id)
                            ->whereSectionId(@$answer->section_id)
                            ->whereIsAttempted(1)->count();
        $reviewCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())
                            ->where(['student_test_result_id'=>$question->student_test_result_id,'subject_id'=>@$subjectId])
                            ->whereMockTestId($mockTest->id)
                            ->whereSectionId(@$answer->section_id)
                            ->where('mark_as_review','1')->count();
        $subjectName = @$question->subject->title;
        $topicName = @$question->topic->title;
        $time =  0;
        $totalTime = hoursAndMins($time);
        return response()->json(['nextQuestionId' => @$nextQuestionId,'mark_as_review' => $markAsReview,'testDetail' => $testDetail,'attemptedCount' => $attemptedCount, 'student_test_id' => $studentTest->id,'subject_id'=>@$subjectId,'subjectName'=>@$subjectName,'topicName'=>@$topicName,'totalTime'=>@$totalTime,'review_count'=> @$reviewCount??0]);
    }

    /**
     * -------------------------------------------------------
     * | Store question answer                               |
     * |                                                     |
     * | @param request                                      |
     * | @return res                                |
     * -------------------------------------------------------
     */
    public function storeQuestion(Request $request){
        $mockTest = MockTest::find($request->mock_test_id);
        $questions = Session::get('sectionQuestion');
        $currentQuestion = @$questions[$request->current_question_id];
        // recalculate taken time
        $timeTaken = isset($request->time_taken) ? $request->time_taken : 0;
        if (isset($data) && $data->answer_id != null && $request->answer_id != null && $data->answer_id != $request->answer_id) {
            $timeTaken = $data->time_taken + $request->time_taken;
        }
        // $answer = Answer::find($request->answer_id);
        $studentAnswerIds = json_decode($request->answer_ids);
        $isCorrect = 0;
        if($request->answer_ids != null && !empty($request->answer_ids) && count($studentAnswerIds) > 0){
            // get student answer id for compare 
            sort($studentAnswerIds);
            // get question correct answer ids
            $correctAnswerIds = @$currentQuestion->questionData->multipleCorrectAnswers->pluck('id')->toArray()??null;
            // dd($correctAnswerIds==$studentAnswerIds);
            // compare student answers and correct answer ids and set is correct
            if($correctAnswerIds == $studentAnswerIds){
                $isCorrect = 1;
            }
        }
        // Save UnAttempted Questions
        if($currentQuestion){
            $currentQuestion->update([
                    'answer_ids' => $request->answer_ids,
                    'is_attempted' => (!empty(json_decode($request->answer_ids)))? 1 : 0,
                    'mark_as_review' => ($request->mark_as_review == 1)? 1 : 0,
                    'time_taken' => $timeTaken,
                    'is_correct' => @$isCorrect,
                ]
            );
        }
        $markAsReview = (isset($currentQuestion) && $currentQuestion->mark_as_review == 1) ? 1 :0;
        $attemptedCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())->where(['student_test_result_id'=>@$currentQuestion->student_test_result_id,'section_id'=>@$currentQuestion->section_id])->whereMockTestId($mockTest->id)->whereIsAttempted(1)->count();
        $reviewCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())->where(['student_test_result_id'=>@$currentQuestion->student_test_result_id,'section_id'=>@$currentQuestion->section_id])->whereMockTestId($mockTest->id)->where('mark_as_review','1')->count();
        return response()->json(['success' => true, 'attemptedCount' => $attemptedCount,'review_count'=>@$reviewCount??0]);
    }

    /**
     * -------------------------------------------------------
     * | Go to section                                       |
     * |                                                     |
     * | @param request,paperId,sectionId                    |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function goToSection(Request $request,$paperId=null,$sectionId=null){
        $this->dbStart();
        try{
            $refreshFlag = session()->get('refresh_flag');
            // if page refesh than redirect to result page
            if($refreshFlag == true){
                $oldTestPaper = Session::get('studentTestPaper');
                $oldTestPaper->update(['is_completed'=>1]);
                return redirect()->route('paper-result',['paperId'=>$oldTestPaper->uuid]);
            }
            $sections = Session::get('sections');
            $mockTest = Session::get('mockTest');
            $paper = Session::get('paper');
            $section = $sections[$sectionId];
            // store test paper
            $studentTestPaper = StudentTestPaper::where('uuid',$paperId)->first();
            if($paper->is_time_mandatory==0){
                // section exam time
                $time = explode(':', $paper->time);
                $paperTime = ($time[0] * 3600) + ($time[1] * 60) + $time[2];
                $sectionTime = session()->get('sectionTime');
                $timeTaken = array_sum($sectionTime);
                $examTotalSeconds = $paperTime - $timeTaken;
            }else{
                // section exam time
                $time = explode(':', $section->time);
                $examTotalSeconds = ($time[0] * 3600) + ($time[1] * 60) + $time[2];
            }
            // allAudios
            $audioData = $this->mockExamAudio($mockTest,$examTotalSeconds);

            // store test data
            $studentTest = $studentTestPaper->studentTest;

            // store test paper data
            $studentTestPaper = StudentTestPaper::where('uuid',$paperId)->first();

            // store test paper result data
            $studentTestResult = StudentTestResults::where([
                'student_id' => $studentTestPaper->student_id,
                'student_test_id' => $studentTestPaper->student_test_id,
                'mock_test_id' => $mockTest->id,
                'student_test_paper_id' => $studentTestPaper->id,
            ])->first();
            Session::forget('sectionQuestion');
            // store test paper question list
            $questionList = StudentTestQuestionAnswer::where([
                                'section_id'=>$section->id,
                                'student_test_result_id' => $studentTestResult->id,
                                'mock_test_id' => $mockTest->id,
                                'student_id' => $studentTestPaper->student_id,
                            ])->orderBy('id','asc')->get();

            Session::put('sectionQuestion',$questionList);

            // preview question list
            $this->previewQuestionList();
            $previewQuestionList = Session::get('previewQuestionList');

            $firstQuestion = $questionList[0];
            $nextQuestionId = 1;
            $prevQuestionId = null;
            $student = Auth::guard('student')->user();
            $nextSectionId = $sectionId + 1;
            if(isset($sections[$nextSectionId])){
                $nextSection = $sections[$nextSectionId];
            }else{
                $nextSection = null;
                $nextSectionId = null;
            }
            $prevSectionId = $sectionId - 1;
            $prevSection = @$sections[$prevSectionId];
            $section= $sections[$sectionId];
            if($prevSectionId < 0){
                $prevSectionId = null;
            }
            $attemptedCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())
                            ->where(['student_test_result_id'=>$studentTestResult->id,'subject_id'=>@$firstQuestion->subject_id])
                            ->whereMockTestId($mockTest->id)
                            ->whereSectionId(@$firstQuestion->section_id)
                            ->whereIsAttempted(1)->count();
            $array = [
                'section'=>@$section,'mockTest'=>@$mockTest,'studentTest' => @$studentTest,'studentTestPaper'=>@$studentTestPaper,
                'firstQuestion'=>@$firstQuestion, 'studentTestResult' => $studentTestResult,'section' => @$section,'sections' => $sections,
                'student' => $student,'ip' => \Request::ip(),'nextQuestionId'=>$nextQuestionId,'prevQuestionId'=>@$prevQuestionId,
                'nextSectionId' => @$nextSectionId, 'prevSectionId' => @$prevSectionId,'examTotalTimeSeconds'=>$examTotalSeconds,
                'subjectId' => @$section->subject_id,'sectionId'=>$sectionId, 'nextSection'=> @$nextSection,'paper'=>@$paper,
                'prevSection' => $prevSection,'attemptedCount'=>@$attemptedCount,'previewQuestionList'=>@$previewQuestionList,
            ];
            $examArray = array_merge($array,$audioData);
            $this->dbCommit();
            return view('newfrontend.paper.exam',$examArray);
        }catch(Exception $e){
            $this->dbRollBack();
            abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | result                                              |
     * |                                                     |
     * | @param paperId                                      |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function paperResult($paperId=null){
        $this->dbStart();
        try{
            // if(Session::get('isExam')==true){
                Session::forget('mockTest');
                Session::forget('paper');
                Session::forget('sections');
                Session::forget('questions');
                Session::forget('studentTest');
                Session::forget('studentTestPaper');
                Session::forget('sectionQuestion');
                Session::forget('sectionIds');
                Session::forget('sectionTime');
                Session::forget('refresh_flag');
                Session::forget('isExam');
                Session::forget('studentEvaluateTestPaper');
            // }

            $studentTestPaper = StudentTestPaper::where('uuid',$paperId)->first();
            if($studentTestPaper->is_greater_then_end_date == true){
                // manually update rank
                // $this->generateResult($studentTestPaper);
            }
            $studentTest = $studentTestPaper->studentTest;
            $studentTestResults = $studentTestPaper->studentResult;
            $student = $studentTestPaper->student;
            $mockTest = $studentTestResults->mockTest;
            $status = ($mockTest->stage_id == 2)?3:1;
            $studentTestPaper->update(['is_completed'=>'1','status'=>$status]);
            $purchasedMock = PurchasedMockTest::whereMockTestId($mockTest->id)->whereStudentId($student->id)->first();
            if($studentTest){
                $status =2;
                $paperIds = $studentTest->studentTestPapers->pluck('mock_test_paper_id')->toArray();
                $mockPaperIds = $mockTest->papers->pluck('id')->toArray();
                sort($paperIds);
                sort($mockPaperIds);
                $flag = false;
                if($paperIds == $mockPaperIds){
                    $flag = true;
                }
                // dd($paperIds,$mockPaperIds,$flag);
                if($flag == true){
                    if($mockTest->stage_id == 2){
                        $status = 3;
                        $studentTest->update(['status' => 3]);
                    }
                    if ($purchasedMock != null) {
                        $studentTest->update(['status' => $status]);
                        $purchasedMock->update(['status' => $status]);
                    }
                }
            }
            if(session()->has('isExam')){
                $isExam = 'yes';
            }else{
                $isExam = 'no';
            }
            $mockTestPaper = $studentTestPaper->paper;
            $this->dbCommit();
            return view('newfrontend.paper.paper_info',['mockTest' => @$mockTest,'studentTestPaper'=>@$studentTestPaper,'mockTestPaper'=>@$mockTestPaper]);
            // return view('newfrontend.child.mock_result', ['mockTest' => @$mockTest,'isExam' =>@$isExam,'attempt'=>0,
            // 'student' => $student,'totalStudentAttemptTest' => 1,'studentTest' => $studentTestPaper,
            // 'studentTestResults' => $studentTestResults, 'subjects' => @$subjects]);
        }catch(Exception $e){
            $this->dbRollBack();
            abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | complete mock paper and update status               |
     * |                                                     |
     * | @param request                                      |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function completeMock(Request $request){
        $this->dbStart();
        try {
            $studentId = Auth::guard('student')->id();
            $studentTest = StudentTest::where(['id' => @$request->student_test_id])->first();
            $timeTaken = session()->get('sectionTime');
            if($timeTaken == null){
                $timeTaken[] = $request->section_taken_time;
                session()->put('sectionTime',$timeTaken);
            }else{
                $timeTaken[] = $request->section_taken_time;
                session()->put('sectionTime',$timeTaken);
            }
            $sectionTime = session()->get('sectionTime');
            if($sectionTime != null){
                $timeTaken = array_sum($sectionTime);
            }
            $mockTest = $studentTest->mockTest;
            $studentTestPaper = StudentTestPaper::where('id',$request->paper_id)->first();
            $studentTestPaper->update([
                'is_completed'=>1,
                'time_taken'=>@$timeTaken
            ]);
            // Update the purchased mocks status
            $purchasedMock = PurchasedMockTest::whereMockTestId($request->mock_test_id)->whereStudentId($studentId)->first();
            $status = 2;
            $flag = false;
            if($studentTest){
                $paperIds = $studentTest->studentTestPapers->pluck('mock_test_paper_id')->toArray();
                $mockPaperIds = $mockTest->papers->pluck('id')->toArray();
                if($paperIds == $mockPaperIds){
                    $flag = true;
                }
                if($flag == true){
                    if($mockTest->stage_id == 2){
                        $status = 3;
                        $studentTest->update(['status' => 3]);
                    }
                    if ($purchasedMock != null) {
                        $purchasedMock->update(['status' => $status]);
                    }
                }
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
     * | update status mock test status                      |
     * |                                                     |
     * | @param request                                      |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function updateTestStatus(Request $request){
        $student = Auth::guard('student')->user();
        $mockTest = MockTest::where('id',$request->mock_test_id)->first();
        $status = 2;
        if($mockTest != null && $mockTest->stage_id == 2){
            $status = 3;
        }
        $testPaper = StudentTestPaper::where('id',$request->paper_id)->first();
        $timeTaken = $testPaper->time_taken + 1;
        StudentTestPaper::where('id',$request->paper_id)->update(['time_taken'=>$timeTaken,'is_completed'=>1]);
        $studentTest = StudentTest::where('id',$request->test_id)->first();
        $flag = false;
        if($studentTest){
            $paperIds = $studentTest->studentTestPapers->pluck('mock_test_paper_id')->toArray();
            $mockPaperIds = $mockTest->papers->pluck('id')->toArray();
            if($paperIds == $mockPaperIds){
                $flag = true;
            }
            if($flag == true){
                $studentTest->update(['status'=>$status]);
                PurchasedMockTest::whereMockTestId($request->mock_test_id)->whereStudentId($student->id)->update(['status'=> 2]);
            }
        }
        return response()->json(['status'=>'success']);
    }

    /**
     * -------------------------------------------------------
     * | save paper section attempt time                     |
     * |                                                     |
     * | @param request                                      |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function saveRemainingTime(Request $request){
        session()->put('refresh_flag',false);
        $timeTaken = session()->get('sectionTime');
        if($timeTaken == null){
            $timeTaken[] = $request->section_taken_time;
            session()->put('sectionTime',$timeTaken);
        }else{
            $timeTaken[] = $request->section_taken_time;
            session()->put('sectionTime',$timeTaken);
        }
        return response()->json(['status'=>'success','sectionTime'=>$timeTaken]);
    }

    /**
     * -------------------------------------------------------
     * | review mock paper                                   |
     * |                                                     |
     * | @param paperId                                      |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function paperReview($paperId=null){
        try{
            $testPaper = StudentTestPaper::where('uuid',$paperId)->first();
            $sectionTime = session()->get('sectionTime');
            if($sectionTime == null){
                return redirect()->route('paper-result',[@$testPaper->uuid]);
            }
            $attemptTime = array_sum($sectionTime);
            $mockTestPaper = $testPaper->paper;
            $mockTest = $mockTestPaper->mockTest;

            // section exam time
            $time = explode(':', $mockTestPaper->time);
            $paperTotalSeconds = ($time[0] * 3600) + ($time[1] * 60) + $time[2];
            $examTotalTimeSeconds = $paperTotalSeconds - $attemptTime;
            if($examTotalTimeSeconds <= 0){
                $testPaper->update(['is_completed'=>1]);
                return redirect()->route('paper-result',[@$testPaper->uuid]);
            }
            // $examTotalTimeSeconds = 3600;
            $studentTest = $testPaper->studentTest;
            if($studentTest != NULL){
                if($studentTest->status== 2 || $studentTest->status== 3){
                    return redirect()->route('student-mocks');
                }
            }
            $studentTestResult = StudentTestResults::where(['student_test_paper_id' => $testPaper->id,'is_reset' => 0])->orderBy('id', 'desc')->first();
            $student = Auth::guard('student')->user();
            $query = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResult->id, 'mark_as_review' => 1])->orderBy('id', 'asc');
            $studentTestQuestionAnswer = $query->count();
            $questionList = $query->get();
            if($studentTestQuestionAnswer==0){
                $testPaper->update(['is_completed'=>1]);
                return redirect()->route('paper-result',[@$testPaper->uuid]);
            }
            $firstStudentTestQuestionAnswer = $query->orderBy('id', 'asc')->first();
            Session::forget('sectionQuestion');
            Session::put('sectionQuestion',$questionList);

            // preview question list
            $this->previewQuestionList();
            $previewQuestionList = Session::get('previewQuestionList');

            if ($firstStudentTestQuestionAnswer) {
                $firstQuestion = $questionList[0];
                $nextQuestionId =1;
                if(!isset($questionList[$nextQuestionId])){
                    $nextQuestionId = null;
                }
                $prevQuestionId = null;
                $answers = Answer::whereQuestionListId(@$firstQuestion->question_list_id)->get();
            }
            $sections = Session::get('sections');
            $section = $firstStudentTestQuestionAnswer->section;
            session()->put('isExam','yes');
            return view('newfrontend.paper.exam_review', ['studentTestResult' => @$studentTestResult,'studentTest' => @$studentTest,
            'mockTest' => @$mockTest, 'student' => @$student, 'ip' => \Request::ip(), 'studentTestQuestionAnswer' => @$studentTestQuestionAnswer,
            'firstQuestion' => @$firstQuestion, 'answers' => @$answers, 'firstStudentTestQuestionAnswer' => @$firstStudentTestQuestionAnswer,
            'prevQuestionId' => @$prevQuestionId, 'nextQuestionId' => @$nextQuestionId,'examTotalTimeSeconds'=>$examTotalTimeSeconds,
            'sections' => @$sections, 'section' =>@$section, 'studentTestPaper'=>$testPaper,'previewQuestionList'=>@$previewQuestionList
            ]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Go to next and previous question                    |
     * |                                                     |
     * | @param request                                      |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function reviewPrevNextQuestion(Request $request){
        $mockTest = MockTest::find($request->mock_test_id);
        $questions = Session::get('sectionQuestion');
        if ($request->type == 'next') { // Clicked next question button
            $sessionQuestion = $questions[$request->next_question_id];
            $question = StudentTestQuestionAnswer::where('id',$sessionQuestion->id)->first();
            $nextQuestionId = $request->next_question_id + 1 ;
            $prevQuestionId = $request->current_question_id;
            $currentQuestionId = $request->next_question_id;
        } else { // Clicked previous question button
            $sessionQuestion = $questions[$request->prev_question_id];
            $question = StudentTestQuestionAnswer::where('id',$sessionQuestion->id)->first();
            $nextQuestionId = $request->current_question_id;
            $prevQuestionId = $request->prev_question_id - 1;
            $currentQuestionId = $request->prev_question_id;
        }
        if(!isset($questions[$nextQuestionId]) && $nextQuestionId == count($questions)){
            $nextQuestionId = null;
        }
        if($currentQuestionId == 0){
            $prevQuestionId = null;
        }
        $currentQuestion = @$questions[$request->current_question_id];
        $questionNo = @$question->questionList->question_no;
        $answers = $question->questionList->answers;
        $data = $question;
        $arr = [
            'question' => $question,
            'answers' => $answers,
            'mockTest' => $mockTest,
            'prev_selected_ans' => @$data->answer_id,
            'review' => true,
            'questionNo' => $questionNo,
        ];
        $studentId = Auth::guard('student')->id();

        $studentTest = StudentTest::where(['id' => @$request->student_test_id])->first();

        // recalculate taken time
        $timeTaken = isset($request->time_taken) ? $request->time_taken : 0;
        if (isset($data) && !empty(json_decode($data->answer_ids)) != null && !empty(json_decode($request->answer_ids)) != null && !empty(json_decode($data->answer_ids)) != !empty(json_decode($request->answer_ids))) {
            $timeTaken = $data->time_taken + $request->time_taken;
        }
        $sections = Session::get('sections');
        $nextSection = null;
        $nextSectionId = null;
        $studentTestPaper = $currentQuestion->testResult->studentTestPaper;
        
        // Save UnAttempted Questions
        $studentAnswerIds = json_decode($request->answer_ids);
        if ($request->type == 'next' || $request->type == 'prev') {
            $isCorrect = 0;
            if($request->answer_ids != null && !empty($request->answer_ids)){
                // get student answer id for compare 
                sort($studentAnswerIds);
                // get question correct answer ids
                $correctAnswerIds = @$currentQuestion->questionList->multipleCorrectAnswers->pluck('id')->toArray()??null;
                // dd($correctAnswerIds==$studentAnswerIds);
                // compare student answers and correct answer ids and set is correct
                if($correctAnswerIds == $studentAnswerIds){
                    $isCorrect = 1;
                }
            }
            StudentTestQuestionAnswer::updateOrCreate(
                [
                    'id' => @$currentQuestion->id,
                ],
                [
                    'answer_ids' => $request->answer_ids,
                    'is_attempted' => (!empty(json_decode($request->answer_ids)))? 1 : 0,
                    'mark_as_review' =>  1,
                    'time_taken' => $timeTaken,
                    'is_correct' => @$isCorrect,
                ]
            );
        }
        $answer = StudentTestQuestionAnswer::where('id' ,@$currentQuestion->id)->first();
        // dd($answer);
        $markAsReview = (isset($question) && $question->mark_as_review == 1) ? 1 :0;
        $this->updatePreviewQuestionList($request->current_question_id,$answer->mark_as_review,$answer->is_attempted);
        $previewQuestionList = Session::get('previewQuestionList');

        $arr = [
            'question' => $question,
            'answers' => $answers,
            'mockTest' => $mockTest,
            'prev_selected_ans' => @$question->answer_id,
            'questionNo' => $questionNo,
            'review' => true,
            'time_taken' => $timeTaken,
            'nextQuestionId' => $nextQuestionId,
            'prevQuestionId' => (string)$prevQuestionId,
            'prev_question_id' => $prevQuestionId,
            'nextSectionId' => $nextSectionId,
            'current_question_id' => $currentQuestionId,
            'studentTestPaper' =>$studentTestPaper,
            'previewQuestionList' => @$previewQuestionList??[],
        ];
        $testDetail = view('newfrontend.paper.review_exam_questions', $arr)->render();
        $detailArr = [
                        'nextQuestionId' => $nextQuestionId,
                        'prevQuestionId' => $prevQuestionId,
                        'nextSubjectId'=>$request->next_subject_id,
                        'subject_id' => $question->subject_id,
                        'question' => $question,
                        'current_question_id' => $question->id,
                        'prev_question_id' => $prevQuestionId, 'nextQuestionId' => $nextQuestionId,
                        'mockTest' => $mockTest];
        $subjectId = @$question->subject_id;
        $attemptedCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())->where(['student_test_result_id'=>$question->student_test_result_id,'subject_id'=>@$subjectId])->whereMockTestId($mockTest->id)->whereIsAttempted(1)->count();
        $subjectName = @$question->subject->title;
        $topicName = @$question->topic->title;
        $time =  0;
        $totalTime = hoursAndMins($time);
        $sectionName = @$question->section->name;
        return response()->json(['nextQuestionId' => @$nextQuestionId,'mark_as_review' => $markAsReview,'testDetail' => $testDetail,'attemptedCount' => $attemptedCount, 'student_test_id' => $studentTest->id,'subject_id'=>@$subjectId,'subjectName'=>@$subjectName,'topicName'=>@$topicName,'totalTime'=>@$totalTime,'sectionName'=>@$sectionName]);
    }

    /**
     * -------------------------------------------------------
     * | show paper result                                   |
     * |                                                     |
     * | @param paperUuid                                    |
     * | @return view                                        |
     * -------------------------------------------------------
     */
    public function viewPaperResult($uuid){
        try{
            if(Session::get('isExam')==true){
                Session::forget('mockTest');
                Session::forget('paper');
                Session::forget('sections');
                Session::forget('questions');
                Session::forget('studentTest');
                Session::forget('studentTestPaper');
                Session::forget('sectionQuestion');
                Session::forget('sectionIds');
                Session::forget('sectionTime');
                Session::forget('refresh_flag');
                Session::forget('isExam');
                Session::forget('studentEvaluateTestPaper');
            }
            $studentTestPaper = StudentTestPaper::where('uuid',$uuid)->first();
            $startDate = date('Y-m-01',strtotime($studentTestPaper->created_at)).' 00:00:00';
            $endDate = date('Y-m-t',strtotime($studentTestPaper->created_at)).' 23:59:59';
            $totalStudentAttemptTest = StudentTestPaper::where(['mock_test_paper_id'=>$studentTestPaper->mock_test_paper_id,'is_completed'=>1])
                                        ->select('id','mock_test_paper_id','is_completed')
                                        ->whereHas('studentResult',function($query) use($startDate,$endDate){
                                            $query->whereBetween('created_at',[$startDate,$endDate]);
                                        })
                                        ->count();
            // manually update rank
            // $this->generateResult($studentTestPaper);
            $student = $studentTestPaper->student;
            $studentTestResults = $studentTestPaper->studentResult;
            $mockTest = $studentTestResults->mockTest;
            if(session()->has('isExam')){
                $isExam = 'yes';
            }else{
                $isExam = 'no';
            }
            $studentTestPaper = StudentTestPaper::where('uuid',$uuid)->first();
            $mockTestPaper = $studentTestPaper->paper;
            // display report for n no of day
            $examAttemptDate = new DateTime($studentTestResults->created_at);
            $todayDate = new DateTime();
            $interval = $examAttemptDate->diff($todayDate);
            $days = $interval->format('%a');
            $showResult = false;
            if($mockTest->no_of_days >= $days){
                $showResult = true;
            }
            $questions = $studentTestResults->currentStudentTestQuestionAnswers()->paginate(5);
            return view('newfrontend.paper.paper_result', ['mockTest' => @$mockTest,'attempt'=>1,
            'student' => @$student,'totalStudentAttemptTest' => @$totalStudentAttemptTest,'studentTest' => @$studentTestPaper,
            'studentTestResults' => $studentTestResults,'mockTestPaper'=>@$mockTestPaper,'showResult'=>@$showResult,'questions'=>@$questions]);
        }catch(Exception $e){
            return redirect()->route('student-mocks');
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
    public function viewQuestion($uuid=null,$sectionId=null){
        try{
            $studentTestResults = StudentTestResults::where(['uuid'=>$uuid])->first();
            $startDate = date('Y-m-01',strtotime($studentTestResults->created_at)).' 00:00:00';
            $endDate = date('Y-m-t',strtotime($studentTestResults->created_at)).' 23:59:59';
            $studentTestPaper = $studentTestResults->studentTestPaper;
            $totalStudentAttemptTest = StudentTestPaper::where(['mock_test_paper_id'=>$studentTestPaper->mock_test_paper_id,'is_completed'=>1])
                                        ->select('id','mock_test_paper_id','is_completed')
                                        ->whereHas('studentResult',function($query) use($startDate,$endDate){
                                            $query->whereBetween('created_at',[$startDate,$endDate]);
                                        })
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
                            ->limit($limit)
                            ->get();
            $routeName = Route::currentRouteName();
            if($routeName=='view-incorrect-questions'){
                $studentTestQuestionAnswerIds = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResults->id)
                                                ->where(['section_id'=>$sectionId])
                                                ->where('is_correct','!=','1')
                                                ->orderBy('id', 'asc')
                                                ->limit($limit)
                                                ->pluck('id');
                                                // ->paginate(5);
                                                // ->get();
            }else{
                $studentTestQuestionAnswerIds = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResults->id)
                                                ->where(['section_id'=>$sectionId])
                                                ->orderBy('id', 'asc')
                                                ->limit($limit)
                                                ->pluck('id');
                                                // ->get();
                                                // ->paginate(5);
            }
            $studentTestQuestionAnswers = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResults->id)
                                            ->whereIn('id',$studentTestQuestionAnswerIds)
                                            ->orderBy('id','asc')
                                            ->paginate(5);

            $title = ($routeName=='view-incorrect-questions')?__('formname.view_incorrect_question'):__('formname.view_all_question');
            return view('newfrontend.child.view_questions', ['title'=>@$title,'questionList' => @$questionList, 'mockTest' => @$mockTest,
            'student' => $student, 'studentTest' => $studentTestPaper,'questionData' => @$questionData,'section' =>@$sectionData,
            'studentTestResults' => $studentTestResults,'totalStudentAttemptTest'=>@$totalStudentAttemptTest,'studentTestQuestionAnswers' => @$studentTestQuestionAnswers]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | show paper result                                   |
     * |                                                     |
     * | @param studentTestId                                |
     * | @return view                                        |
     * -------------------------------------------------------
     */
    public function examResult($uuid=null){
        try{
            $studentTest = StudentTest::whereUuid($uuid)->firstOrFail();
            return view('newfrontend.paper.exam_result',['studentTest'=>@$studentTest]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | evaluate mock paper                                 |
     * |                                                     |
     * | @param paperId                                      |
     * | @return view                                        |
     * -------------------------------------------------------
     */
    public function evaluation($uuid=null){
        try{
            $paper = StudentTestPaper::where(['uuid'=>$uuid])->first();
            $oldTestPaper = Session::get('studentEvaluateTestPaper');
            $mockTest = $paper->paper->mockTest;
            $flag = false;
            session()->put('isExam',true);
            if($oldTestPaper != null){
                $studentTest = StudentTest::find($paper->student_test_id);
                if($studentTest){
                    $paperIds = $studentTest->studentTestPapers->pluck('mock_test_paper_id')->toArray();
                    $mockPaperIds = $mockTest->papers2->pluck('id')->toArray();
                    if($paperIds == $mockPaperIds){
                        $flag = true;
                    }
                    if($flag == true){
                        $studentTest->update(['status'=>2]);
                        PurchasedMockTest::whereMockTestId($paper->mock_test_id)->whereStudentId($paper->student_id)->update(['status'=> 2]);
                    }
                }
                return redirect()->route('view-paper-result',['mock_test_id'=>$paper->uuid,'student_id'=>$paper->student_id]);
            }else{
                Session::put('studentEvaluateTestPaper',$paper);
                $count = $paper->evaluate_count + 1;
                $paper->update(['evaluate_count'=> $count]);
            }
            $mockTestPaper = $paper->paper;
            $student = $paper->student;
            $studentTestResultId = $paper->studentResult->id;
            $query =    StudentTestQuestionAnswer::where([
                            'student_test_result_id' => $studentTestResultId,
                            'mock_test_id' => $mockTest->id,
                            ])->orderBy('id','asc');
            $studentTestQuestionAnswers = $query->get();
            $firstQuestion = $query->first();
            $answers = Answer::where(['question_id'=>$firstQuestion->question_id,'is_correct'=>1])->get();
            $totalQuestions = $query->count();
            $studentId = $paper->student->id;
            // get previous user id
            $prevQuestionId = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResultId)->where('id', '<', $firstQuestion->id)->max('id');
            // get next user id
            $nextQuestionId = StudentTestQuestionAnswer::where('student_test_result_id',$studentTestResultId)->where('id', '>', $firstQuestion->id)->min('id');

            $query = StudentTestQuestionAnswer::where(['student_test_result_id' => $studentTestResultId])->orderBy('id', 'asc');
            $studentTestQuestionAnswer = $query->count();
            $questionList = $query->get();
            Session::forget('sectionQuestion');
            Session::put('sectionQuestion',$questionList);
            $this->previewQuestionList2();
            $previewQuestionList = Session::get('previewQuestionList');
            // dd($previewQuestionList);
            return view('newfrontend.user.sevaluation', ['student_id' => $studentId,'student' => @$student,
            'mockTest' => @$mockTest, 'subject_id' => @$firstQuestion->subject_id , 'firstQuestion' => @$firstQuestion,
            'answers' => @$answers, 'prevQuestionId' => @$prevQuestionId, 'nextQuestionId' => @$nextQuestionId,
            'totalQuestions' => @$totalQuestions,'mockTestPaper'=>$mockTestPaper, 'previewQuestionList' => @$previewQuestionList]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
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
     * | Preview question list                               |
     * |                                                     |
     * | @param questionId                                   |
     * | @return response                                    |
     * -------------------------------------------------------
     */

    public function previewQuestionList(){
        $questionList = Session::get('sectionQuestion');
        $previewQuestionList = [];
        foreach($questionList as $key => $question){
            $previewQuestionList[$key]['id'] = $key;
            $previewQuestionList[$key]['question_id'] = $question->id;
            $previewQuestionList[$key]['q_no'] = $question->question->question_no;
            $previewQuestionList[$key]['question'] = $question->question->question;
            $previewQuestionList[$key]['mark_as_review'] = $question->mark_as_review;
            $previewQuestionList[$key]['is_attempted'] = $question->is_attempted;
        }
        Session::put('previewQuestionList',$previewQuestionList);
        return $previewQuestionList;
    }
    /**
     * -------------------------------------------------------
     * | Go to question list                                 |
     * |                                                     |
     * | @param questionId                                   |
     * | @return response                                    |
     * -------------------------------------------------------
     */


    public function goToQuestion(Request $request){
        $questions = Session::get('sectionQuestion');
        $paper = Session::get('paper');
        $sessionQuestion = $questions[$request->question_id];
        $question = StudentTestQuestionAnswer::where('id',$sessionQuestion->id)->first();
        $mockTest = MockTest::find($question->mock_test_id);
        $nextQuestionId = $request->question_id + 1 ;
        $prevQuestionId = $request->question_id - 1 ;
        $currentQuestionId = $request->current_question_id;
        if($nextQuestionId == count($questions)){
            $nextQuestionId = null;
        }
        if($prevQuestionId < 0){
            $prevQuestionId = null;
        }
        $currentQuestion = @$questions[$currentQuestionId];
        $questionNo = @$question->questionData->question_no;
        $answers = $question->questionData->answers;
        $data = $question;
        $arr = [
            'question' => $question,
            'answers' => $answers,
            'mockTest' => $mockTest,
            'prev_selected_ans' => @$data->answer_id,
            'review' => true,
            'questionNo' => $questionNo,
        ];
        $studentId = Auth::guard('student')->id();

        $studentTest = Session::get('studentTest');

        // recalculate taken time
        $timeTaken = isset($request->time_taken) ? $request->time_taken : 0;
        if (isset($data) && $data->answer_id != null && $request->answer_id != null && $data->answer_id != $request->answer_id) {
            $timeTaken = $data->time_taken + $request->time_taken;
        }
        $sections = Session::get('sections');
        $nextSectionId = $request->section_id+1;
        if(isset($sections[$nextSectionId])){
            $nextSection = $sections[$nextSectionId];
        }else{
            $nextSection = null;
            $nextSectionId = null;
        }
        $prevSectionId = $request->section_id - 1;
        $prevSection = @$sections[$prevSectionId];
        $section= $sections[$request->section_id];
        if($prevSectionId < 0){
            $prevSectionId = null;
        }
        // Save UnAttempted Questions
        $studentAnswerIds = json_decode($request->answer);
        $isCorrect = 0;
        if($request->answer != null && !empty($request->answer)){
            // get student answer id for compare 
            sort($studentAnswerIds);
            // get question correct answer ids
            $correctAnswerIds = @$currentQuestion->questionData->multipleCorrectAnswers->pluck('id')->toArray()??null;
            // compare student answers and correct answer ids and set is correct
            if($correctAnswerIds == $studentAnswerIds){
                $isCorrect = 1;
            }
        }
        $answer = StudentTestQuestionAnswer::updateOrCreate(['id' => @$currentQuestion->id],[
            'answer_ids' => $request->answer,
            'is_attempted' => (!empty(json_decode($request->answer)))? 1 : 0,
            'mark_as_review' => ($request->mark_as_review == 1)? 1 : 0,
            'time_taken' => $timeTaken,
            'is_correct' => @$isCorrect,
        ]);
        $this->updatePreviewQuestionList($currentQuestionId,$answer->mark_as_review,$answer->is_attempted);
        $previewQuestionList = Session::get('previewQuestionList');
        $arr = [
            'question' => $question,
            'answers' => $answers,
            'mockTest' => $mockTest,
            'prev_selected_ans' => @$question->answer_id,
            'review' => true,
            'time_taken' => $timeTaken,
            'nextQuestionId' => $nextQuestionId,
            'prevQuestionId' => (string)$prevQuestionId,
            'prev_question_id' => $prevQuestionId,
            'nextSectionId' => $nextSectionId,
            'current_question_id' => $request->question_id,
            'prevSectionId' =>$prevSectionId,
            'paper'=>@$paper,
            'previewQuestionList'=>@$previewQuestionList,
            'section' => @$section,
        ];
        $markAsReview = (isset($question) && $question->mark_as_review == 1) ? 1 :0;
        $testDetail = view('newfrontend.paper.exam_questions', $arr)->render();
        $subjectId = @$question->subject_id;
        $attemptedCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())
                            ->where(['student_test_result_id'=>$question->student_test_result_id,'subject_id'=>@$subjectId])
                            ->whereMockTestId($mockTest->id)
                            ->whereQuestionId(@$currentQuestion->question_id)
                            ->whereIsAttempted(1)->count();

        $reviewCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())
                            ->where(['student_test_result_id'=>$question->student_test_result_id,'subject_id'=>@$subjectId])
                            ->whereMockTestId($mockTest->id)
                            ->whereQuestionId(@$currentQuestion->question_id)
                            ->where('mark_as_review','1')->count();
        $subjectName = @$question->subject->title;
        $topicName = @$question->topic->title;
        $time =  0;
        $totalTime = hoursAndMins($time);
        return response()->json(['nextQuestionId' => @$nextQuestionId,'mark_as_review' => $markAsReview,'testDetail' => $testDetail,'attemptedCount' => $attemptedCount, 'student_test_id' => $studentTest->id,'subject_id'=>@$subjectId,'subjectName'=>@$subjectName,'topicName'=>@$topicName,'totalTime'=>@$totalTime,'status'=>'success','review_count'=>@$reviewCount]);
    }
     /**
     * -------------------------------------------------------
     * | update preview question list                        |
     * |                                                     |
     * | @param questionId                                   |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function updatePreviewQuestionList($key,$review=null,$isAttempted=null){
        $markForReview = ($review == 1)? 1 : 0;
        $questionList = Session::get('previewQuestionList');
        $questionList[$key]['mark_as_review'] = $markForReview;
        $questionList[$key]['is_attempted'] = $isAttempted;
        Session::put('previewQuestionList',$questionList);
        $questionList = Session::get('previewQuestionList');
        return $questionList;
    }
    /**
     * -------------------------------------------------------
     * | Review go to question list                          |
     * |                                                     |
     * | @param questionId                                   |
     * | @return response                                    |
     * -------------------------------------------------------
     */

    public function reviewGoToQuestion(Request $request){
        $questions = Session::get('sectionQuestion');
        $paper = Session::get('paper');
        $sessionQuestion = $questions[$request->question_id];
        $question = StudentTestQuestionAnswer::where('id',$sessionQuestion->id)->first();
        $mockTest = MockTest::find($question->mock_test_id);
        $nextQuestionId = $request->question_id + 1 ;
        $prevQuestionId = $request->question_id - 1 ;
        $currentQuestionId = $request->current_question_id;
        if($nextQuestionId == count($questions)){
            $nextQuestionId = null;
        }
        if($prevQuestionId < 0){
            $prevQuestionId = null;
        }
        $currentQuestion = @$questions[$currentQuestionId];
        $questionNo = @$question->questionList->question_no;
        $answers = $question->questionList->answers;
        $data = $question;
        $arr = [
            'question' => $question,
            'answers' => $answers,
            'mockTest' => $mockTest,
            'prev_selected_ans' => @$data->answer_id,
            'review' => true,
            'questionNo' => $questionNo,
        ];
        $studentId = Auth::guard('student')->id();

        $studentTest = Session::get('studentTest');

        // recalculate taken time
        $timeTaken = isset($request->time_taken) ? $request->time_taken : 0;
        if (isset($data) && $data->answer != null && $request->answer != null && $data->answer != $request->answer) {
            $timeTaken = $data->time_taken + $request->time_taken;
        }
        $sections = Session::get('sections');
        $nextSection = null;
        $nextSectionId = null;
        // dd($currentQuestion);
        $studentTestPaper = $currentQuestion->testResult->studentTestPaper;

        // $answer = Answer::find($request->answer_id);
        // Save UnAttempted Questions
        $studentAnswerIds = json_decode($request->answer);
        $isCorrect = 0;
        if($request->answer != null && !empty($request->answer)){
            // get student answer id for compare 
            sort($studentAnswerIds);
            // get question correct answer ids
            $correctAnswerIds = @$currentQuestion->questionList->multipleCorrectAnswers->pluck('id')->toArray()??null;
            // dd($correctAnswerIds==$studentAnswerIds);
            // compare student answers and correct answer ids and set is correct
            if($correctAnswerIds == $studentAnswerIds){
                $isCorrect = 1;
            }
        }
        $answer = StudentTestQuestionAnswer::updateOrCreate(
            [
                'id' => @$currentQuestion->id,
            ],
            [
                'answer_ids' => $request->answer,
                'is_attempted' => (!empty(json_decode($request->answer)))? 1 : 0,
                'mark_as_review' =>  1,
                'time_taken' => $timeTaken,
                'is_correct' => @$isCorrect,
            ]
        );
        $markAsReview = (isset($question) && $question->mark_as_review == 1) ? 1 :0;
        $this->updatePreviewQuestionList($currentQuestionId,$answer->mark_as_review,$answer->is_attempted);
        $previewQuestionList = Session::get('previewQuestionList');
        // dd($previewQuestionList,$currentQuestionId);
        $arr = [
            'question' => $question,
            'answers' => $answers,
            'mockTest' => $mockTest,
            'prev_selected_ans' => @$question->answer_id,
            'questionNo' => $questionNo,
            'review' => true,
            'time_taken' => $timeTaken,
            'nextQuestionId' => $nextQuestionId,
            'prevQuestionId' => (string)$prevQuestionId,
            'prev_question_id' => $prevQuestionId,
            'nextSectionId' => $nextSectionId,
            'current_question_id' => $request->question_id,
            'studentTestPaper' =>$studentTestPaper,
            'previewQuestionList' => @$previewQuestionList,
        ];
        $testDetail = view('newfrontend.paper.review_exam_questions', $arr)->render();
        $detailArr = [
                        'nextQuestionId' => $nextQuestionId,
                        'prevQuestionId' => $prevQuestionId,
                        'nextSubjectId'=>$request->next_subject_id,
                        'subject_id' => $question->subject_id,
                        'question' => $question,
                        'current_question_id' => $question->id,
                        'prev_question_id' => $prevQuestionId, 'nextQuestionId' => $nextQuestionId,
                        'mockTest' => $mockTest];
        $subjectId = @$question->subject_id;
        $attemptedCount = StudentTestQuestionAnswer::whereStudentId(Auth::guard('student')->id())->where(['student_test_result_id'=>$question->student_test_result_id,'subject_id'=>@$subjectId])->whereMockTestId($mockTest->id)->whereIsAttempted(1)->count();
        $subjectName = @$question->subject->title;
        $topicName = @$question->topic->title;
        $time =  0;
        $totalTime = hoursAndMins($time);
        $sectionName = @$question->section->name;
        return response()->json(['status'=>'success','nextQuestionId' => @$nextQuestionId,'mark_as_review' => $markAsReview,'testDetail' => $testDetail,'attemptedCount' => $attemptedCount, 'student_test_id' => $studentTest->id,'subject_id'=>@$subjectId,'subjectName'=>@$subjectName,'topicName'=>@$topicName,'totalTime'=>@$totalTime,'sectionName'=>@$sectionName]);
    }

    /**
     * -------------------------------------------------------
     * | Preview question list                               |
     * |                                                     |
     * | @param questionId                                   |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function previewQuestionList2(){
        $questionList = Session::get('sectionQuestion');
        $previewQuestionList = [];
        foreach($questionList as $key => $question){
            $nKey = $question->section_id;
            $previewQuestionList[$nKey]['section'] = @$question->section->name;
            $previewQuestionList[$nKey]['data'][$key]['id'] = $nKey;
            $previewQuestionList[$nKey]['data'][$key]['question_id'] = @$question->id;
            $previewQuestionList[$nKey]['data'][$key]['q_no'] = @$question->question->question_no;
            $previewQuestionList[$nKey]['data'][$key]['question'] = @$question->question->question;
            $previewQuestionList[$nKey]['data'][$key]['mark_as_review'] = 0;
            $previewQuestionList[$nKey]['data'][$key]['is_attempted'] = @$question->is_attempted;
        }
        Session::put('previewQuestionList',$previewQuestionList);
        return $previewQuestionList;
    }
}
