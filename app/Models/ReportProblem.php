<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportProblem extends BaseModel
{
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'uuid','mock_test_id','question_list_id','student_id','test_assessment_id','description',
        'project_type','status','question_answer_id','practice_test_question_answer_id',
        'practice_question_id'
    ];

        /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string)\Str::uuid();
                $query->status = 0;
            }
        });
    }

    /**
     * get that own test student
     *
     * @return void
     */
    public function child()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    /**
     * get that own test student
     *
     * @return void
     */
    public function questionList()
    {
        return $this->belongsTo('App\Models\PracticeQuestion', 'practice_question_id')->withTrashed();
    }

    /**
     * get proper project type
     *
     * @return void
     */
    public function getProperProjectTypeAttribute()
    {
        return @config('constant.module_type')[$this->project_type];
    }
}
