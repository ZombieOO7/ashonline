<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTestPaper extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','mock_test_paper_id','student_test_id','student_id','questions','attempted','unanswered',
        'correctly_answered','obtained_marks','overall_result','total_marks','is_completed','is_reset',
        'rank','attempt','time_taken','status','evaluate_count'
    ];

    /**
     * get that paper test
     *
     * @return void
     */
    public function studentTest()
    {
        return $this->belongsTo('App\Models\StudentTest', 'student_test_id');
    }

    /**
     * get that paper result
     *
     * @return void
     */
    public function studentResult()
    {
        return $this->hasOne('App\Models\StudentTestResults', 'student_test_paper_id')->where('is_reset','0')->orderBy('id','desc');
    }

    /**
     * get that paper result
     *
     * @return void
     */
    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id')->orderBy('id','desc');
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
     * get that paper result
     *
     * @return void
     */
    public function paper()
    {
        return $this->belongsTo('App\Models\MockTestPaper', 'mock_test_paper_id')->orderBy('id','desc');
    }

    public function getCompletedAttribute()
    {
        $ratio = 0;
        $attemptedCount = 0;
        if (isset($this->studentResult)) {
            $attemptedCount = $this->attempted;
            $totalQuestion = $this->questions;
            if ($attemptedCount > 0 && $totalQuestion > 0) {
                $ratio = ($attemptedCount * 100) / $totalQuestion;
            }
        }
        if(is_float($ratio)){
            $ratio = number_format($ratio,2,'.','');
        }
        return $ratio . '%';
    }

    /**
     * This function is used for getting created date in user readabale format
     *
     * @return void
     */
    public function getProperTimeTakenAttribute()
    {
        $timeTaken = date('H:i:s',$this->time_taken);
        return $timeTaken;
    }

    /**
     * This function is used for getting created date in user readabale format
     *
     * @return void
     */
    public function getProperRankAttribute()
    {
        $rank = $this->rank;
        if($rank > 0){
            $rank = $this->rank;
        }else{
            $rank = '---';
        }
        return $rank;
    }

    /**
     * get that paper result
     *
     * @return void
     */
    public function studentResults()
    {
        return $this->hasMany('App\Models\StudentTestResults', 'student_test_paper_id')->where('is_reset','0')->orderBy('id','desc');
    }

    public function getIncorrectAnswerAttribute(){
        return $this->studentResults->sum('incorrect_answer');
    }

    /**
     * get that paper result
     *
     * @return void
     */
    public function studentResultWithReset()
    {
        return $this->hasOne('App\Models\StudentTestResults', 'student_test_paper_id')->orderBy('id','desc')->withTrashed();
    }

    /**
     * get that paper result
     *
     * @return void
     */
    public function studentResultsWithReset()
    {
        return $this->hasMany('App\Models\StudentTestResults', 'student_test_paper_id')->where('is_reset','0')->orderBy('id','desc');
    }

    /**
     * check that paper attempt date is end date or not
     *
     * @return Boolean
     */
    public function getIsGreaterThenEndDateAttribute(){
        $endDate = date('Y-m-t',strtotime($this->created_at));
        $todayDate = date('Y-m-d');
        if($todayDate > $endDate){
            return true;
        }else{
            return false;
        }
    }
}
