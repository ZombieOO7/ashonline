<?php

namespace App\Models;

class StandardExamStatus extends BaseModel
{
    protected $table= 'standard_exam_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =[
       'student_id', 'mock_test_id', 'subject_id','evaluation_status'
    ];

    /**
     * get that own test student
     *
     * @return void
     */
    public function question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id');
    }

   /**
     * get that own mock test subject
     *
     */
    public function subject(){
        return $this->belongsTo('App\Models\Subject','subject_id');
    }


}
