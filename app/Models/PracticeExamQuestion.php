<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticeExamQuestion extends Model
{
    protected $primary_key = null;
    public $incrementing = false;
    public $timestamp = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'practice_exam_id', 'question_id'
    ];
}
