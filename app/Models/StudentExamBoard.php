<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentExamBoard extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'student_id'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=[
        'exam_board_id','student_id'
    ];

    /**
     * get that own mock test subject
     *
     */
    public function student(){
        return $this->belongsTo('App\Models\Student','student_id');
    }

    /**
     * get that own mock test subject
     *
     */
    public function examBoard(){
        return $this->belongsTo('App\Models\ExamBoard','exam_board_id');
    }
}
