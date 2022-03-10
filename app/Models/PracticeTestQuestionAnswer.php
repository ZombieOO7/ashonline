<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeTestQuestionAnswer extends BaseModel
{
    use SoftDeletes;
    protected $fillable = [
        'uuid','answer_id','practice_test_result_id','question_id','question_list_id','student_id','subject_id','topic_id','mark_as_review','is_correct','is_attempted','time_taken',
        'created_at','updated_at','assessment_section_id','answer_ids'
    ];

    /*
     * Auto-sets values on creation
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string) \Str::uuid();
            }
        });
    }

    /**
     * get that own test student
     *
     * @return void
     */
    public function questionList()
    {
        return $this->belongsTo('App\Models\PracticeQuestionList', 'question_list_id')->withTrashed();
    }

    /**
      * Get that question list own question
      */
    public function questionData()
    {
        return $this->belongsTo('App\Models\PracticeByTopicQuestion', 'question_id');
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
     * get that question section
     *
     * @return void
     */
    public function assessmentSection(){
        return $this->belongsTo('App\Models\TestAssessmentSubjectInfo','assessment_section_id');
    }

    /**
     * get that student question answers
     *
     * @return marks
     */
    public function getSelectedAnswerTextAttribute()
    {
        $answers = PracticeAnswer::whereIn('id',$this->selected_answers)
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
        $answers = PracticeByTopicAnswer::where(['question_id'=>$this->question_id,'is_correct'=>'1'])
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
     * get that own test student
     *
     * @return void
     */
    public function getQuestionMarkAttribute()
    {
        return $this->questionData->marks;
    }
}
