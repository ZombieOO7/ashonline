<?php

namespace App\Helpers;

use App\Models\PracticeByTopicQuestion;
use App\Models\PracticeExam;
use App\Models\Subject;
use App\Models\TestAssessment;
use App\Models\Topic;
use App\Models\PracticeByTopicQuestionAnswer;
use App\Models\PracticeByTopicResult;
use Illuminate\Support\Facades\Auth;
use PhpParser\ErrorHandler\Collecting;
use Session;

class PracticeByTopicHelper extends BaseHelper
{
    protected $subject,$topic,$practiceExam,$question,$practiceTestResult,$practiceTestQuestionAnswer,$questionList;
    public function __construct(Subject $subject, Topic $topic, TestAssessment $testAssessment,PracticeByTopicQuestion $question,PracticeByTopicResult $practiceTestResult, PracticeByTopicQuestionAnswer $practiceTestQuestionAnswer,PracticeExam $practiceExam){
        $this->subject = $subject;
        $this->topic = $topic;
        $this->testAssessment = $testAssessment;
        $this->question = $question;
        $this->practiceTestResult = $practiceTestResult;
        $this->practiceTestQuestionAnswer = $practiceTestQuestionAnswer;
        $this->practiceExam = $practiceExam;
    }

    /**
     * -------------------------------------------------------------
     * | Get topic List                                            |
     * |                                                           |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function topicList($subjectData,$student=null)
    {
        $topics = PracticeExam::where('subject_id',@$subjectData->id)
                    ->where(function($query) use($student){
                        if(@$student->school_year != null){
                            $query->where('school_year',$student->school_year);
                        }
                    })
                    ->get();
        return @$topics;
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
    public function startExam($practiceExam){
        $questionData = $this->questionData($practiceExam);
        $totalQuestions = $questionData['totalQuestions'];
        $totalMarks = $questionData['totalMarks'];
        $student = Auth::guard('student')->user();
        $result = $this->practiceTestResult::create([
            'student_id' => $student->id,
            'practice_exam_id' => @$practiceExam->id,
            'subject_id' => @$practiceExam->subject_id,
            'questions' => @$totalQuestions,
            'correctly_answered' => 0,
            'attempted'=>0,
            'unanswerd'=>0,
            'overall_result'=>0,
            'obtained_marks'=>0,
            'unanswered' =>@$totalQuestions,
            'total_marks' => @$totalMarks,
        ]);
        return $result;
    }

    /**
     * -------------------------------------------------------------
     * | Add test question answers                                 |
     * |                                                           |
     * | @param $student,$testAssessment,$studentTestResult        |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function addTestQuestionAnswer($practiceExam,$student,$studentTestResultId){
        $questionList = $this->questionData($practiceExam);
        if($questionList['totalQuestions'] == '0'){
            return null;
        }
        // $questionAnswers = [];
        foreach($questionList['questionList'] as $key => $question){
            $questionAnswer = $this->practiceTestQuestionAnswer::create([
                    'student_id' => $student->id,
                    'question_id' => $question->id,
                    'practice_by_topic_result_id' => $studentTestResultId,
                    'mark_as_review' =>0,
                    'subject_id' =>@$question->subject_id,
                    'is_correct' =>0,
                    'is_attempted' =>0,
                    'time_taken' =>0,
                    'practice_exam_id' => $practiceExam->id,
            ]);
            $previewQuestionList[$key]['id'] = $key;
            $previewQuestionList[$key]['question_id'] = $questionAnswer->id;
            $previewQuestionList[$key]['q_no'] = $question->question_no;
            $previewQuestionList[$key]['question'] = $question->question;
            $previewQuestionList[$key]['mark_as_review'] = 0;
            $previewQuestionList[$key]['is_attempted'] = 0;
        }
        $questionAnswers = $this->practiceTestQuestionAnswer::where(['practice_by_topic_result_id' => $studentTestResultId])
                            ->orderBy('id','asc')
                            ->get();
        Session::put('questionList',$questionList);
        Session::put('previewQuestionList',$previewQuestionList);
        Session::put('testAnswers',$questionAnswers);
        return $questionAnswers;
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
    public function getPreviousQuestionId($studentTestResult,$currentQuestion,$markAsReview){
        $previousQuestionId = $this->practiceTestQuestionAnswer::where('practice_by_topic_result_id',$studentTestResult->id)
                            ->where(function($q) use($markAsReview){
                                if($markAsReview == true){
                                    $q->where('mark_as_review',1);
                                }
                            })
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
    public function getNextQuestionId($studentTestResult,$currentQuestion,$markAsReview){
        $nextQuestionId = $this->practiceTestQuestionAnswer::where('practice_by_topic_result_id',$studentTestResult->id)
                            ->where(function($q) use($markAsReview){
                                if($markAsReview == true){
                                    $q->where('mark_as_review',1);
                                }
                            })
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
    public function getCurrentQuestion($studentTestResult,$questionId,$markAsReview){
        if($questionId == null){
            $questionData = $this->practiceTestQuestionAnswer::where('practice_by_topic_result_id',$studentTestResult->id)
                                ->where(function($q) use($markAsReview){
                                    if($markAsReview == true){
                                        $q->where('mark_as_review',1);
                                    }
                                })
                                ->orderBy('id','asc')
                                ->first();
            $currentQuestion = $questionData->questionData;
        }else{
            $questionData = $this->practiceTestQuestionAnswer::where('id',$questionId)
                            ->where(function($q) use($markAsReview){
                                if($markAsReview == true){
                                    $q->where('mark_as_review',1);
                                }
                            })
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
        $testQuestionAnswer = $this->practiceTestQuestionAnswer::find($request->id);
        $isAttempted = 0;
        $studentAnswerIds = json_decode($request->answer_ids);
        $isCorrect = 0;
        // dd(@$testQuestionAnswer);
        if($request->answer_ids != null && !empty($request->answer_ids) && count($studentAnswerIds) > 0){
            // get student answer id for compare
            sort($studentAnswerIds);
            // get question correct answer ids
            $correctAnswerIds = @$testQuestionAnswer->questionData->multipleCorrectAnswers->pluck('id')->toArray()??null;
            // compare student answers and correct answer ids and set is correct
            if($correctAnswerIds == $studentAnswerIds){
                $isCorrect = 1;
            }
            $isAttempted = 1;
            $this->updatePreviewList($testQuestionAnswer->id,$isAttempted);
            $testQuestionAnswer->update([
                'answer_ids' => $request->answer_ids,
                // 'mark_as_review' => @$request->mark_as_review,
                'is_correct' => $isCorrect,
                'is_attempted' => $isAttempted,
            ]);
        }
        // dd($testQuestionAnswer);
        $result = $this->practiceTestResult::find($testQuestionAnswer->practice_by_topic_result_id);
        $questionIds = @$result->correctAnswers->pluck('question_id')->toArray();
        if(count($questionIds)>0){
            $obtainedMarks = $this->question::whereIn('id',$questionIds)->sum('marks');
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
        return $result;
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
        $result = $this->practiceTestResult::whereUuid($id)->first();
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
    public function totalTestAttempt($result){
        return $this->practiceTestResult::where([
            'practice_exam_id' => $result->practice_exam_id,
            // 'subject_id' => $result->subject_id,
            'student_id' => $result->student_id,
        ])->count();
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
     * | get subject                                               |
     * |                                                           |
     * | @param slug                                               |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function subject($slug){
        return $this->subject::where('slug',$slug)->first();
    }

    /**
     * -------------------------------------------------------------
     * | get student test                                          |
     * |                                                           |
     * | @param Request                                            |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function topic($slug){
        return $this->topic::where('slug',$slug)->first();
    }

    /**
     * -------------------------------------------------------------
     * | get student test                                          |
     * |                                                           |
     * | @param Request                                            |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function questionData($practiceExam){
        $allQuestions = [];//new Collecting();
        $marks = 0;
        foreach($practiceExam->practiceExamTopic as $key => $examTopic){
            $questions =PracticeByTopicQuestion::where('subject_id',$practiceExam->subject_id)
                        ->where('topic_id',$examTopic->topic_id)
                        ->withCount('questionAnswers')
                        ->orderBy('question_answers_count','asc')
                        ->limit($examTopic->no_of_questions)
                        ->get();
            foreach($questions as $qKey => $question){
                $allQuestions[$qKey] = $question;
                $marks += $question->marks;
            }
        }
        $totalMarks = $marks;
        $totalQuestions = count($allQuestions);
        return ['totalQuestions'=>$totalQuestions,'totalMarks'=>$totalMarks,'questionList'=>@$allQuestions];
    }

    /**
     * -------------------------------------------------------------
     * | get past paper detail                                     |
     * |                                                           |
     * | @param Request                                            |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function detail($uuid){
        return $this->practiceExam::where('uuid',$uuid)->first();
    }

    public function updatePreviewList($id,$isAttempted){
        $previewQuestionList = Session::get('previewQuestionList');
        foreach($previewQuestionList as $key => $question){
            if($id == $question['question_id']){
                $previewQuestionList[$key]['is_attempted'] = $isAttempted;
            }
        }
        Session::put('previewQuestionList',$previewQuestionList);
        return $previewQuestionList;
    }
}