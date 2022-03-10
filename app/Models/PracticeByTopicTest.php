<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeByTopicTest extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id','practice_exam_id','duration','status','ip_address','questions','attempted',
        'correctly_answered','attempt_count','unanswered','overall_result','total_marks',
        'obtained_marks','rank'
    ];
}
