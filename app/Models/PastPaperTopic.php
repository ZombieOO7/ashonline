<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastPaperTopic extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'past_paper_question_id';

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'past_paper_question_id','topic_id'
    ];

    /**
     * -------------------------------------------------------------
     * | Get the paper of that owns question.                      |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function questions()
    {
        return $this->belongsTo('App\Models\PastPaperQuestion', 'past_paper_question_id');
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

}
