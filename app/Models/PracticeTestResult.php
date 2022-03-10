<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeTestResult extends BaseModel
{
    use SoftDeletes;
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =[
        'uuid','student_id','subject_id','topic_id','questions','attempted','correctly_answered','unanswered',
        'overall_result','total_marks','obtained_marks','is_reset','rank','created_at','updated_at','student_test_id',
        'test_assessment_id'
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
     * get that own test mock
     *
     * @return Object
     */
    public function testQuestionAnswers()
    {
        return $this->hasMany('App\Models\PracticeTestQuestionAnswer','practice_test_result_id')->orderBy('id','asc')->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function correctAnswers()
    {
        return $this->hasMany('App\Models\PracticeTestQuestionAnswer','practice_test_result_id')->whereIsCorrect(1)->orderBy('id','asc')->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function attemptTestQuestionAnswers()
    {
        return $this->hasMany('App\Models\PracticeTestQuestionAnswer','practice_test_result_id')->whereIsAttempted(1)->orderBy('id','asc')->withTrashed();
    }

    /**
     * get that own test question answers
     *
     * @return Object
     */
    public function unansweredTestQuestionAnswers()
    {
        return $this->hasMany('App\Models\PracticeTestQuestionAnswer','practice_test_result_id')->whereIsAttempted(0)->orderBy('id','asc');
    }

    /**
     * get that own test question answers
     *
     * @return Object
     */
    public function getOverallResultPerAttribute()
    {
        $per = 0;
        if($this->obtained_marks > 0 && $this->total_marks > 0){
            $per = ($this->obtained_marks * 100) / $this->total_marks;
            $per = round($per,2);
        }
        return $per;
    }

    /**
     * get that own test question answers
     *
     * @return Object
     */
    public function markAsReviewCount()
    {
        return $this->hasMany('App\Models\PracticeTestQuestionAnswer','practice_test_result_id')->where('mark_as_review',1)->orderBy('id','asc');
    }

    /**
     * get that own test topic
     *
     * @return Object
     */
    public function topic(){
        return $this->belongsTo('App\Models\Topic','topic_id')->withTrashed();
    }

    /**
     * get that own test subject
     *
     * @return Object
     */
    public function subject(){
        return $this->belongsTo('App\Models\Subject','subject_id')->withTrashed();
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
     * get that own test student
     *
     * @return Object
     */
    public function studentTest(){
        return $this->belongsTo('App\Models\StudentTest','student_test_id')->withTrashed();
    }

    /**
     * get that own test assessment
     *
     * @return Object
     */
    public function testAssessment()
    {
        return $this->belongsTo('App\Models\TestAssessment', 'test_assessment_id')->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function studentTestAssessmentQuestionAnswers()
    {
        return $this->hasMany('App\Models\PracticeTestQuestionAnswer','practice_test_result_id')
                    // ->where('mock_test_id','=',NULL)
                    ->orderBy('id','asc')
                    ->withTrashed();
    }

    public function getTotalMarkTextAttribute(){
        return $this->studentTestAssessmentQuestionAnswers->sum('question_mark');
    }

    /**
     * get that test assessment result date
     *
     * @return Object
     */
    public function getProperDateAttribute(){
        return date('jS F Y',strtotime($this->created_at));
    }

    /**
     * get that own test mock
     *
     * @return attribute
     */
    public function getOverallResultTextAttribute()
    {
        return number_format($this->overall_result,2);
    }

    /**
     * This function is used for getting created date in user readabale format
     *
     * @return void
     */
    public function getCreatedAtUserReadableAttribute()
    {
        $value = $this->attributes['created_at'];
        return date('dS F Y', strtotime($value));
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function attemptTestQuestionAnswers2()
    {
        return $this->hasMany('App\Models\PracticeTestQuestionAnswer','practice_test_result_id')
                    ->whereIsAttempted(1)
                    ->orderBy('id','asc')
                    ->withTrashed();
    }

    /**
     * get that test assessment result date
     *
     * @return Object
     */
    public function getProperMonthDateAttribute(){
        return date('jS F',strtotime($this->created_at));
    }
}
