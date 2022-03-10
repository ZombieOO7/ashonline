<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class PracticeExam extends BaseModel
{
    use Sluggable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','title','slug','description','grade_id','topic_id','exam_board_id',
        'subject_id','questions','audio_1','audio_2','audio_3','audio_4','status',
        'school_year'
    ];

    /**
     * -------------------------------------------------------------
     * | Return the sluggable configuration array for this model.  |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ],
        ];
    }

    /**
     * get that own test exam board
     *
     * @return Object     *
     */
    public function examBoard()
    {
        return $this->belongsTo('App\Models\ExamBoard', 'exam_board_id');
    }

    /**
     * get that own test grade
     *
     * @return Object
     */
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id');
    }

    /**
     * get that own exam questions
     *
     * @return Object
     */
    public function practiceExamQuestions()
    {
        return $this->hasMany('App\Models\PracticeExamQuestion', 'practice_exam_id');
    }

    /**
     * get that own exam questions
     *
     * @return Object
     */
    public function practiceExamTopic()
    {
        return $this->hasMany('App\Models\PracticeExamTopic', 'practice_exam_id');
    }

    /**
     * get that own exam questions
     *
     * @return Object
     */
    public function getTopicIdsAttribute()
    {
        $ids = $this->practiceExamTopic->pluck('topic_id');
        return $ids;
    }

    /**
     * get that own test grade
     *
     * @return Object
     */
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }

    /**
     * get that own test grade
     *
     * @return Object
     */
    public function result()
    {
        return $this->hasOne('App\Models\PracticeByTopicResult', 'practice_exam_id')->orderBy('id','desc');
    }
}
