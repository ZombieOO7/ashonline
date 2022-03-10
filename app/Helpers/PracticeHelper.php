<?php

namespace App\Helpers;

use App\Models\PracticeQuestion;
use App\Models\PracticeQuestionList;
use App\Models\PracticeTestQuestionAnswer;
use App\Models\PracticeTestResult;
use App\Models\ReportProblem;
use App\Models\Student;
use App\Models\StudentTest;
use App\Models\StudentTestResults;
use App\Models\Subject;
use App\Models\TestAssessment;
use App\Models\TestAssessmentSubjectInfo;
use Illuminate\Support\Facades\Auth;

class PracticeHelper extends BaseHelper
{
    protected $subject,$testAssessment,$student,$studentTest,$studentTestQuestionAnswer,$reportProblem,$sectionDetail;
    public function __construct(PracticeQuestionList $questionList,PracticeTestQuestionAnswer $studentTestQuestionAnswer,StudentTest $studentTest,
     Subject $subject, TestAssessment $testAssessment, Student $student,PracticeTestResult $studentTestResults, 
     ReportProblem $reportProblem, TestAssessmentSubjectInfo $sectionDetail,PracticeQuestion $question){
        $this->student = $student;
        $this->subject = $subject;
        $this->question = $question;
        $this->testAssessment = $testAssessment;
        $this->studentTest = $studentTest;
        $this->studentTestResults = $studentTestResults;
        $this->studentTestQuestionAnswer = $studentTestQuestionAnswer;
        $this->questionList = $questionList;
        $this->reportProblem = $reportProblem;
        $this->sectionDetail = $sectionDetail;
    }

    /**
     * -------------------------------------------------------------
     * | Get Subject List                                          |
     * |                                                           |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function subjectList()
    {
        $subjects = [];
        $subjects = $this->subject->active()
                    ->select('id','title','slug','order_seq','created_at')
                    ->orderBy('order_seq','asc')
                    ->get();
        return @$subjects;
    }

    /**
     * -------------------------------------------------------------
     * | Get Test Assessment List                                  |
     * |                                                           |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function assessmentList(){
        $assessmentList = [];
        $assessmentList = $this->testAssessment::active()
                            ->select('id','title','created_at','status')
                            ->get();
        return @$assessmentList;
    }

    /**
     * -------------------------------------------------------------
     * | Get Test Assessment Detail                                |
     * |                                                           |
     * | @param uuid                                               |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function testAssessmentDetail($uuid){
        $assessment = $this->testAssessment::whereUuid($uuid)->first();
        return @$assessment;
    }

    /**
     * -------------------------------------------------------------
     * | Start Practice Exam                                       |
     * |                                                           |
     * | @param $student,$testAssessment                           |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function startExam($student,$testAssessment){
        $studentTest = $this->studentTest::updateOrCreate(
            [
                'student_id' => $student->id,
                'test_assessment_id' => $testAssessment->id,
            ], [
                'student_id' => $student->id,
                'test_assessment_id' => $testAssessment->id,
                'start_date' => date('Y-m-d', strtotime(now())),
                'end_date' => date('Y-m-d', strtotime(now())),
                'status' => 1,
                'duration' => 1,
                'project_type' => 2,
                'questions' => @$testAssessment->total_question_count,
                'correctly_answered' => 0,
                'unanswered' =>@$testAssessment->total_question_count,
                'total_marks' => @$testAssessment->proper_total_marks,
                'obtained_marks'=>0,
            ]);
        $result = $this->studentTestResults::create([
            'student_id' => $student->id,
            'student_test_id' => $studentTest->id,
            'test_assessment_id' => $testAssessment->id,
            'questions' => @$testAssessment->total_question_count,
            'attempted'=>0,
            'unanswerd'=>0,
            'overall_result'=>0,
            'obtained_marks'=>0,
            'correctly_answered' => 0,
            'unanswered' =>@$testAssessment->total_question_count,
            'total_marks' => @$testAssessment->proper_total_marks,
        ]);
        return [$studentTest,$result];
    }

    /**
     * -------------------------------------------------------------
     * | Add test question answers                                 |
     * |                                                           |
     * | @param $student,$testAssessment,$studentTestResult        |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function addTestQuestionAnswer($student,$testAssessment,$studentTestResult){
        $sections = @$testAssessment->testAssessmentSubjectInfo;
        foreach($sections as $section){
            $questionList = $section->questionList3()
                            ->select('id',\DB::raw('CAST(question_no AS INTEGER)'))
                            ->orderBy('question_no','asc')
                            ->get();
            if($questionList == null || $section->questionList3()->count() == '0'){
                return false;
            }
            foreach($questionList as $key => $question){
                $data[] = $this->studentTestQuestionAnswer::create([
                        'student_id' => $student->id,
                        'test_assessment_id' => $testAssessment->id,
                        'question_id' => $question->id,
                        'mark_as_review' =>0,
                        'subject_id' =>@$section->subject_id,
                        'is_correct' =>0,
                        'is_attempted' =>0,
                        'time_taken' =>0,
                        'answer_id'=>null,
                        'practice_test_result_id' => $studentTestResult->id,
                        // 'question_list_id'=>$question->id,
                        'assessment_section_id' => $section->id,
                        'is_reset' =>0,
                ]);
            }
        }
        return true;
    }

    /**
     * -------------------------------------------------------------
     * | get student test data                                     |
     * |                                                           |
     * | @param $student,$testAssessment                           |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function getStudentTestData($student,$testAssessment){
        $studentTest = $this->studentTest::where([
                            'test_assessment_id'=>$testAssessment->id,
                            'student_id' => $student->id,
                        ])
                        ->orderBy('id','desc')
                        ->first();
        return $studentTest;
    }

    /**
     * -------------------------------------------------------------
     * | get previous question id                                  |
     * |                                                           |
     * | @param $studentTestResult,$currentQuestion                |
     * | @return $nextQuestionId                                   |
     * -------------------------------------------------------------
     */
    public function getPreviousQuestionId($studentTestResult,$currentQuestion,$markAsReview,$sectionId=null){
        $previousQuestionId = $this->studentTestQuestionAnswer::where('practice_test_result_id',$studentTestResult->id)
                            ->where(function($q) use($markAsReview){
                                if($markAsReview == true){
                                    $q->where('mark_as_review',1);
                                }
                            })
                            ->where('assessment_section_id',$sectionId)
                            ->where('id', '<', $currentQuestion->id)
                            ->max('id');
        return @$previousQuestionId;
    }

    /**
     * -------------------------------------------------------------
     * | get next question id                                      |
     * |                                                           |
     * | @param $studentTestResult,$currentQuestion                |
     * | @return $nextQuestionId                                   |
     * -------------------------------------------------------------
     */
    public function getNextQuestionId($studentTestResult,$currentQuestion,$markAsReview,$sectionId=null){
        $nextQuestionId = $this->studentTestQuestionAnswer::where('practice_test_result_id',$studentTestResult->id)
                            ->where(function($q) use($markAsReview){
                                if($markAsReview == true){
                                    $q->where('mark_as_review',1);
                                }
                            })
                            ->where('assessment_section_id',$sectionId)
                            ->where('id', '>', $currentQuestion->id)
                            ->min('id');
        return @$nextQuestionId;
    }

    /**
     * -------------------------------------------------------------
     * | get current question                                      |
     * |                                                           |
     * | @param $studentTestResult,$currentQuestion                |
     * | @return $nextQuestionId                                   |
     * -------------------------------------------------------------
     */
    public function getCurrentQuestion($studentTestResult,$questionId,$markAsReview,$sectionId=null){
        if($questionId == null){
            $questionData = $this->studentTestQuestionAnswer::where('practice_test_result_id',$studentTestResult->id)
                                ->where(function($q) use($markAsReview){
                                    if($markAsReview == true){
                                        $q->where('mark_as_review',1);
                                    }
                                })
                                ->where('assessment_section_id',$sectionId)
                                ->orderBy('id','asc')
                                ->first();
            $currentQuestion = $questionData->questionData;
        }else{
            $questionData = $this->studentTestQuestionAnswer::where('id',$questionId)
                            ->where(function($q) use($markAsReview){
                                if($markAsReview == true){
                                    $q->where('mark_as_review',1);
                                }
                            })
                            ->where('assessment_section_id',$sectionId)
                            ->first();
            $currentQuestion = $questionData->questionData;
        }
        return [@$currentQuestion,@$questionData];
    }

    /**
     * -------------------------------------------------------------
     * | store test question answer                                |
     * |                                                           |
     * | @param Request                                            |
     * | @return $nextQuestionId                                   |
     * -------------------------------------------------------------
     */
    public function storeAnswer($request){
        $obtainedMarks = 0;
        $testQuestionAnswer = $this->studentTestQuestionAnswer::find($request->id);
        $isAttempted = 0;
        $studentAnswerIds = json_decode($request->answer_ids);
        $isCorrect = 0;
        if($studentAnswerIds != null && !empty($studentAnswerIds)){
            $isAttempted = 1;
            // get student answer id for compare 
            sort($studentAnswerIds);
            // get question correct answer ids
            $correctAnswerIds = @$testQuestionAnswer->questionData->multipleCorrectAnswers->pluck('id')->toArray()??null;
            // dd($correctAnswerIds==$studentAnswerIds);
            // compare student answers and correct answer ids and set is correct
            if($correctAnswerIds == $studentAnswerIds){
                $isCorrect = 1;
            }
        }
        // dd($isAttempted);
        $testQuestionAnswer->update([
            'answer_ids' => $request->answer_ids,
            'mark_as_review' => $request->mark_as_review,
            'is_correct' => $isCorrect,
            'is_attempted' => $isAttempted,
        ]);
        $result = $this->studentTestResults::find($testQuestionAnswer->practice_test_result_id);
        $questionListIds = $result->correctAnswers->pluck('question_id')->toArray();
        if(count($questionListIds)>0){
            $obtainedMarks = $this->question::whereIn('id',$questionListIds)->sum('marks');
        }
        $result->update([
            'correctly_answered' => $result->correctAnswers->count(),
            'attempted' => $result->attemptTestQuestionAnswers->count(),
            'unanswered' => $result->unansweredTestQuestionAnswers->count(),
            'obtained_marks' => $obtainedMarks,
        ]);
        $result->update([
            'overall_result' => $result->overall_result_per,
        ]);
        $result->studentTest()->update([
            'correctly_answered' => $result->correctAnswers->count(),
            'attempted' => $result->attemptTestQuestionAnswers->count(),
            'unanswered' => $result->unansweredTestQuestionAnswers->count(),
            'obtained_marks' => $obtainedMarks,
            'overall_result' => $result->overall_result_per,
        ]);
        return [$result,$testQuestionAnswer];
    }

    /**
     * -------------------------------------------------------------
     * | get student test result                                   |
     * |                                                           |
     * | @param Request                                            |
     * | @return $nextQuestionId                                   |
     * -------------------------------------------------------------
     */
    public function testResult($id){
        $result = $this->studentTestResults::whereUuid($id)->first();
        return $result;
    }

    /**
     * -------------------------------------------------------------
     * | get student total test                                    |
     * |                                                           |
     * | @param id                                                 |
     * | @return count                                             |
     * -------------------------------------------------------------
     */
    public function totalStudentTest($id){
        return $this->studentTest::where('test_assessment_id',$id)->count();
    }

    /**
     * -------------------------------------------------------------
     * | get student test                                          |
     * |                                                           |
     * | @param Request                                            |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function studentTest($id){
        return $this->studentTest::where('uuid',$id)->first();
    }

    /**
     * -------------------------------------------------------------
     * | get student test                                          |
     * |                                                           |
     * | @param Request                                            |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function subject($slug){
        return $this->subject::where('slug',$slug)->first();
    }

    /**
     * -------------------------------------------------------------
     * | Store Problem Data                                        |
     * |                                                           |
     * | @param Request                                            |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function storeProblem($request){
        if($request->has('practice_test_question_answer_id')){
            $problem = $this->reportProblem::updateOrCreate(['practice_question_id'=> $request->question_id,
                                                  'student_id'=> Auth::guard('student')->id(),
                                                  'test_assessment_id' => $request->test_assessment_id,
                                                  'practice_test_question_answer_id' => $request->question_answer_id,
                                                ],
                                                $request->all());
        }else{
            $problem = $this->reportProblem::updateOrCreate(['practice_question_id'=> $request->question_id,
                                                  'student_id'=> Auth::guard('student')->id(),
                                                  'test_assessment_id' => $request->test_assessment_id,
                                                  'practice_test_question_answer_id' => $request->question_answer_id,
                                                ],
                                                $request->all());
        }
        return $problem;
    }

    /**
     * -------------------------------------------------------------
     * | get Problem data                                          |
     * |                                                           |
     * | @param Request                                            |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function getReportProblem($request){
        if($request->has('practice_test_question_answer_id')){
            $problem = $this->reportProblem::where(['practice_question_id'=> $request->question_id,
                                                    'student_id'=> Auth::guard('student')->id(),
                                                    'test_assessment_id' => $request->test_assessment_id,
                                                    'practice_test_question_answer_id' => $request->practice_test_question_answer_id,
                                                    ])->first();
        }else{
            $problem = $this->reportProblem::where(['practice_question_id'=> $request->question_id,
                            'student_id'=> Auth::guard('student')->id(),
                            'test_assessment_id' => $request->test_assessment_id,
                            'practice_test_question_answer_id' => $request->practice_test_question_answer_id,
                        ])->first();
        }
        return $problem;
    }

    /**
     * -------------------------------------------------------------
     * | get sectiond detail                                       |
     * |                                                           |
     * | @param Request                                            |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function getSectionDetail($uuid){
        return $this->sectionDetail::where('uuid',$uuid)->first();
    }

    /**
     * -------------------------------------------------------------
     * | get sectiond detail                                       |
     * |                                                           |
     * | @param Request                                            |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function getSection($uuid){
        return $this->sectionDetail::where('id',$uuid)->first();
    }

    public function getNextSection($section){
        $nextSection = $this->sectionDetail::where('test_assessment_id',$section->test_assessment_id)
            ->where('id', '>', $section->id)
            ->orderBy('id','asc')
            ->first();
        // dd($nextSection);
        return $nextSection;
    }

    /**
     * -------------------------------------------------------------
     * | get Problem data                                          |
     * |                                                           |
     * | @param Request                                            |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function getPracticeByTopicReportProblem($request){
        if($request->has('practice_test_question_answer_id')){
            $problem = $this->reportProblem::where(['question_list_id'=> $request->question_list_id,
                                                    'student_id'=> Auth::guard('student')->id(),
                                                    'test_assessment_id' => $request->test_assessment_id,
                                                    'practice_test_question_answer_id' => $request->practice_test_question_answer_id,
                                                    'practice_test_question_answer_id' => $request->practice_test_question_answer_id,
                                                    ])->first();
        }else{
            $problem = $this->reportProblem::where(['question_list_id'=> $request->question_list_id,
                            'student_id'=> Auth::guard('student')->id(),
                            'test_assessment_id' => $request->test_assessment_id,
                            'question_answer_id' => $request->question_answer_id,
                        ])->first();
        }
        return $problem;
    }
}