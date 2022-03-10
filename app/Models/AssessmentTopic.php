<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentTopic extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'topic_id';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'topic_id', 'test_assessment_id',
    ];
}
