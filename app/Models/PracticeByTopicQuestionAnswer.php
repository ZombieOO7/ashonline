<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeByTopicQuestionAnswer extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','answer_id','practice_exam_id','question_id','student_id','subject_id','topic_id',
        'mark_as_review','is_correct','is_attempted','time_taken','practice_by_topic_result_id',
        'answer_ids'
    ];

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
        if($this->answer_ids != null && !empty($this->answer_ids)){
            $answerIds = json_decode($this->answer_ids);
        }
        return $answerIds;
    }
}
