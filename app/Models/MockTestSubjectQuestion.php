<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockTestSubjectQuestion extends Model
{
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mock_test_id', 'subject_id', 'question_id','mock_test_paper_id','mock_test_subject_detail_id'
    ];

    /**
     * get that own mock test subject questions
     *
     */
    public function questions(){
        return $this->hasMany('App\Models\Question','id','question_id');
    }

    /**
     * get that own mock test subject detail
     *
     */
    public function subject(){
        return $this->belongsTo('App\Models\Subject','subject_id');
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function questionLists(){
        return $this->hasMany('App\Models\QuestionList','question_id','question_id');
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function question(){
        return $this->hasOne('App\Models\Question','id','question_id');
    }

    /**
     * get that own mock test subject questions
     *
     */
    public  function getTotalMarksAttribute()
    {
        return $this->question->marks_text;
    }
}
