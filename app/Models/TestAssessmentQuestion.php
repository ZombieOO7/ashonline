<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAssessmentQuestion extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'test_assessment_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_assessment_id', 'subject_id', 'question_id','test_assessment_subject_id'
    ];

    /**
     * get that own assessment subject questions
     *
     */
    public function questions(){
        return $this->hasMany('App\Models\PracticeQuestion','id','question_id');
    }

    /**
     * get that own assessment subject questions
     *
     */
    public function questionList(){
        return $this->hasMany('App\Models\QuestionList','question_id','question_id');
    }

    /**
     * get that own assessment questions marks
     *
     */
    public function getTotalMarksAttribute(){
        return $this->questions->sum('marks');
    }

    /**
     * get that own assessment subject questions
     *
     */
    public function question(){
        return $this->hasOne('App\Models\PracticeQuestion','id','question_id');
    }
}
