<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class PracticeAnswer extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_list_id','answer','is_correct', 'question_id'
    ];

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->answer = trimContent($query->answer);
        });
        static::updating(function ($query) {
            $query->answer = trimContent($query->answer);
        });
    }

    /**
     * -------------------------------------------------------------
     * | Get student selected correct answer                       |
     * |                                                           |
     * | @return Count                                             |
     * -------------------------------------------------------------
     */
    public function getSelectedCorrectAnswerAttribute(){
        $per = PracticeTestQuestionAnswer::where('answer_ids','like','%'.$this->id.'%')
                    ->count();
        return $per;
    }

    /**
     * -------------------------------------------------------------
     * | Get student selected answer                               |
     * |                                                           |
     * | @return Count                                             |
     * -------------------------------------------------------------
     */
    public function getSelectedAnswerAttribute(){
        $per = PracticeTestQuestionAnswer::where('answer_ids','like','%'.$this->id.'%')
                ->count();
        return $per;
    }
}
