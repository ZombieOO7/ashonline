<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PastPaperQuestion extends BaseModel
{
    use SoftDeletes;
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'question_image','answer_image','solved_question_time','past_paper_id','question_no','topic_id','subject_id','resize_question_image','resize_answer_image'
    ];

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string) \Str::uuid();
            }
        });
    }

    /**
     * -------------------------------------------------------------
     * | Get the paper of that owns question.                      |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function pastPaper()
    {
        return $this->belongsTo('App\Models\PastPaper', 'past_paper_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the paper of that owns question.                      |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function topics()
    {
        return $this->hasMany('App\Models\PastPaperTopic', 'past_paper_question_id');
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getQuestionImagePathAttribute()
    {
        $path = ($this->question_image != null && file_exists(storage_path(config('constant.past-paper.storage_path') . $this->question_image))) ?
            url(config('constant.past-paper.url_path') . $this->question_image) : asset('images/mock_img_tbl.png');
        return $path;
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getAnswerImagePathAttribute()
    {
        $path = ($this->answer_image != null && file_exists(storage_path(config('constant.past-paper.storage_path') . $this->answer_image))) ?
            url(config('constant.past-paper.url_path') . $this->answer_image) : asset('images/mock_img_tbl.png');
        return $path;
    }

    /**
     * -------------------------------------------------------------
     * | Get the paper of that owns question.                      |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function topicList()
    {
        $list = $this->topics->pluck('topic_id')->toArray();
        return $list;
    }

    /**
     * -------------------------------------------------------------
     * | Get the paper of that owns question.                      |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function topicData()
    {
        return $this->belongsToMany('App\Models\Topic', 'past_paper_topics', 'past_paper_question_id', 'topic_id')->select('topics.id','topics.title',
        'topics.slug','topics.created_at');
    }

    /**
     * -------------------------------------------------------------
     * | Get the paper of that owns question.                      |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic', 'topic_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the paper of that owns question.                      |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getSolvedQuestionTimeTextAttribute()
    {
        $time = $this->solved_question_time;
        return $time;
    }

    /**
     * -------------------------------------------------------------
     * | Get the paper of that owns question.                      |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getTopicIdsAttribute()
    {
        return $this->topics->pluck('topic_id')->toArray();
    }

    /**
     * -------------------------------------------------------------
     * | Get the paper of that owns question.                      |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getTopicNamesAttribute()
    {
        $topicNames = $this->topicData->pluck('title')->toArray();
        return implode(',',$topicNames);
    }
}
