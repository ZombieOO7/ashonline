<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticeExamTopic extends Model
{
    protected $primary_key = null;
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'practice_exam_id','topic_id','no_of_questions'
    ];

    /**
     * get that own exam questions
     *
     * @return Object
     */
    public function practiceExam()
    {
        return $this->belongsTo('App\Models\PracticeExam', 'practice_exam_id');
    }

    /**
     * get that own exam questions
     *
     * @return Object
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic', 'topic_id');
    }
}
