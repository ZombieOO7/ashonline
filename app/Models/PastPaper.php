<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastPaper extends BaseModel
{
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'uuid','name','year','total_duration','instruction','file','school_id','exam_board_id',
        'grade_id','subject_id','status','paper_show_to','month','school_year'
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
     * | Get the questions of that owns the paper.                 |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function pastPaperQuestion()
    {
        return $this->hasMany('App\Models\PastPaperQuestion', 'past_paper_id')->with('topicData');
    }

    /**
     * -------------------------------------------------------------
     * | Get the subject of that owns the paper.                   |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the exam board of that owns the paper.                |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function examBoard()
    {
        return $this->belongsTo('App\Models\ExamBoard', 'exam_board_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the grade of that owns the paper.                     |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id');
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getFilePathAttribute()
    {
        $path = ($this->file != null && file_exists(storage_path(config('constant.past-paper.storage_path') . $this->file))) ?
            url(config('constant.past-paper.url_path') . $this->file) : null;
        return $path;
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getFilePathTextAttribute()
    {
        $path = ($this->file != null && file_exists(storage_path(config('constant.past-paper.storage_path') . $this->file))) ?
                storage_path(config('constant.past-paper.storage_path') . $this->file) : null;
        return $path;
    }

    /**
     * -------------------------------------------------------------
     * | Get the questions of that owns the paper.                 |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function topicList()
    {
        return $this->belongsToMany('App\Models\PastPaperTopic', 'past_paper_questions', 'past_paper_id', 'id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the questions of that owns the paper.                 |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getTopicIdsAttribute()
    {
        $topicIds = array_unique($this->topicList->pluck('topic_id')->toArray());
        return @$topicIds;
    }

    /**
     * -------------------------------------------------------------
     * | Get the subject of that owns the paper.                   |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function school()
    {
        return $this->belongsTo('App\Models\Schools', 'school_id');
    }

    public function getNoOfQuestionAttribute(){
        return $this->pastPaperQuestion->count();
    }
    /**
     * -------------------------------------------------------------
     * | Get the questions of that owns the paper.                 |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function topicList2()
    {
        return $this->belongsToMany('App\Models\Topic', 'past_paper_questions', 'past_paper_id', 'topic_id');
    }
}
