<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeByTopicResult extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id','practice_exam_id','questions','attempted','correctly_answered','unanswered',
        'overall_result','total_marks','obtained_marks','practice_by_topic_test_id','rank'
    ];

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function correctAnswers()
    {
        return $this->hasMany('App\Models\PracticeByTopicQuestionAnswer','practice_by_topic_result_id')->whereIsCorrect(1)->orderBy('id','asc')->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function attemptTestQuestionAnswers()
    {
        return $this->hasMany('App\Models\PracticeByTopicQuestionAnswer','practice_by_topic_result_id')->whereIsAttempted(1)->orderBy('id','asc')->withTrashed();
    }

    /**
     * get that own test question answers
     *
     * @return Object
     */
    public function unansweredTestQuestionAnswers()
    {
        return $this->hasMany('App\Models\PracticeByTopicQuestionAnswer','practice_by_topic_result_id')->whereIsAttempted(0)->orderBy('id','asc');
    }

    /**
     * get that own test question answers
     *
     * @return Object
     */
    public function markAsReviewCount()
    {
        return $this->hasMany('App\Models\PracticeByTopicQuestionAnswer','practice_by_topic_result_id')
                    ->where('mark_as_review',1)
                    ->orderBy('id','asc');
    }

    /**
     * get that own test student
     *
     * @return Object
     */
    public function student(){
        return $this->belongsTo('App\Models\Student','student_id')->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function testQuestionAnswers()
    {
        return $this->hasMany('App\Models\PracticeByTopicQuestionAnswer','practice_by_topic_result_id')
                ->orderBy('id','ASC')
                ->withTrashed();
    }

    /**
     * get that own test student
     *
     * @return Object
     */
    public function practiceExam(){
        return $this->belongsTo('App\Models\PracticeExam','practice_exam_id')->withTrashed();
    }
}
