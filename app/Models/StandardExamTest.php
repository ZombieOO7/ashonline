<?php

namespace App\Models;

class StandardExamTest extends BaseModel
{
    protected $table= 'standard_exam_test';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =[
        'student_id', 'mock_test_id', 'question_id','answer','marks_obtained','subject_id','mark_as_checked',
        'evaluation_status'
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
