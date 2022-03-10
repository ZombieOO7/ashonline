<?php

namespace App\Models;

class StudentTestQuestionAnswer extends BaseModel
{
    protected $table= 'student_test_question_answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =[
        'uuid', 'student_id', 'mock_test_id', 'question_id','answer_id','mark_as_review','subject_id','section_id',
        'is_correct','is_attempted','time_taken','student_test_result_id', 'question_list_id','test_assessment_id',
        'answer_ids','assessment_section_id'
    ];

    /**
     * get that own test student
     *
     * @return void
     */
    public function question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id')->withTrashed();
    }

    /**
     * get that own test student
     *
     * @return void
     */
    public function questionList()
    {
        return $this->belongsTo('App\Models\QuestionList', 'question_list_id')->withTrashed();
    }

    /**
     * get that own test student
     *
     * @return void
     */
    public function answer()
    {
        return $this->belongsTo('App\Models\Answer', 'answer_id');
    }

    /**
     * get that own test student
     *
     * @return void
     */
    public function questionData()
    {
        return $this->belongsTo('App\Models\Question', 'question_id')->withTrashed();
    }

    /**
     * get that own test student
     *
     * @return void
     */
    public function mockTest()
    {
        return $this->belongsTo('App\Models\MockTest', 'mock_test_id')->withTrashed();
    }

    /**
     * get that own test student
     *
     * @return result
     */
    public function testResult()
    {
        return $this->belongsTo('App\Models\StudentTestResults', 'student_test_result_id');
    }

    /**
     * get that question marks for standard exam
     *
     * @return marks
     */
    public function getMarkTextAttribute()
    {
        $marks = 0;
        if($this->is_correct == 1){
            $marks = $this->questionData->marks;
        }elseif($this->is_correct == 0){
            $marks = 0;
        }
        switch($this->is_correct){
            case 1:  // full correct
                $marks = $this->questionData->marks;
            break;
            case 2:  // incorrect
                $marks = 0;
            break;
            case 3:  // for fair correct
                $marks = (25 * $this->questionData->marks) / 100;
            break;
            case 4:  // for half correct
                $marks = $this->questionData->marks / 2;
            break;
            case 5:  // for mostly correct
                $marks = (75 * $this->questionData->marks) / 100;
            break;
            default:
                $marks = 0;
        }
        $marks = is_float($marks)?number_format($marks,2):$marks;
        return $marks;
    }

    /**
     * get that question section
     *
     * @return void
     */
    public function section(){
        return $this->belongsTo('App\Models\MockTestSubjectDetail','section_id');
    }

    /**
     * get that question marks for standard exam
     *
     * @return marks
     */
    public function getSelectedAnswersAttribute()
    {
        $answerIds = [];
        if($this->answer_ids != null && !empty($this->answer_ids))
            $answerIds = json_decode($this->answer_ids);
        return $answerIds;
    }

    /**
     * get that student question answers
     *
     * @return marks
     */
    public function getSelectedAnswerTextAttribute()
    {
        $answers = Answer::whereIn('id',$this->selected_answers)
                    ->orderBy('id','asc')
                    ->pluck('answer')
                    ->toArray();
        if(!empty($answers)){
            $answers = implode(',',$answers);
            return $answers;
        }
        return null;
    }

    /**
     * get that student question answers
     *
     * @return marks
     */
    public function getCorrectAnswerTextAttribute()
    {
        $answers = Answer::where(['question_id'=>$this->question_id,'is_correct'=>'1'])
                    ->orderBy('id','asc')
                    ->pluck('answer')
                    ->toArray();
        if(!empty($answers)){
            $answers = implode(',',$answers);
            return $answers;
        }
        return '---';
    }

    /**
     * get that question section
     *
     * @return void
     */
    public function assessmentSection(){
        return $this->belongsTo('App\Models\TestAssessmentSubjectInfo','assessment_section_id');
    }

    /**
     * get that own test student
     *
     * @return void
     */
    public function getQuestionMarkAttribute()
    {
        return $this->questionData->marks;
    }

    /**
     * get that question marks for standard exam
     *
     * @return marks
     */
    public function getStandardSelectedAnswerAttribute()
    {
        $answer = $this->is_correct;
        if($answer == 2){ // for incorrect
            $status = 0;
        }elseif($answer == 3){ // for fairy correct
            $status = 1;
        }elseif($answer == 4){ // for half correct
            $status = 2;
        }elseif($answer == 5){ // for mostly correct
            $status = 3;
        }elseif($answer == 1){ // for full correct
            $status = 4;
        }else{
            $status = null;
        }
        return $status;
    }
}
