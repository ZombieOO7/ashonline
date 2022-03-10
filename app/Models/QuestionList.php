<?php

namespace App\Models;

use Faker\Provider\File;

class QuestionList extends BaseModel
{
    protected $table= 'question_lists';
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'uuid','question_id','question','marks','image','hint', 'question_no', 'question_image',
       'answer_image','explanation','topic_id','instruction','answer_type','resize_full_image',
       'resize_question_image','resize_answer_image'
    ];

    /**
     * Get that question own answers
     */
    public function answers()
    {
        return $this->hasMany('App\Models\Answer', 'question_list_id')->orderBy('id');
    }

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->question = trimContent($query->question);
        });
        static::updating(function ($question) {
            $question->question = trimContent($question->question);
            $question->answers()->delete();
        });
        static::deleting(function ($question) {
            $question->answers()->delete();
        });
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getImagePathAttribute()
    {
        $path = ($this->image !=null && file_exists(storage_path(config('constant.question-list.storage_path').'/'.$this->image))) ? 
        url(config('constant.question-list.url_path').'/'.$this->image) : asset('images/mock_img_tbl.png');
        return $path;
    }

    /**
     * Get that question own answers
     */
    public function correctAnswer()
    {
        return $this->hasOne('App\Models\Answer', 'question_list_id')->whereIsCorrect('1');
    }

    /**
     * Get that question list own question
     */
    public function questionData()
    {
        return $this->belongsTo('App\Models\Question', 'question_id');
    }

    public function getAverageCorrectAnswerAttribute(){
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','question_list_id')
                    ->whereHas('questionList',function($query){
                        $query->whereNull('deleted_at');
                    })
                    ->where('is_attempted',1)
                    ->whereNotNull('answer_id')
                    ->where('is_correct',1)
                    ->whereNull('deleted_at')
                    ->count();
    }

    public function getAverageIncorrectAnswerAttribute(){
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','question_list_id')
                    ->whereHas('questionList',function($query){
                        $query->whereNull('deleted_at');
                    })
                    ->where('is_attempted',1)
                    ->whereNotNull('answer_id')
                    ->where('is_correct',0)
                    ->whereNull('deleted_at')
                    ->count();
    }

    public function getAverageIncorrectAnswer2Attribute(){
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','question_list_id')
                    ->where('is_correct','!=',1)
                    ->where('is_attempted',1)
                    ->count();
    }

    public function getAverageResponsesAttribute(){
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','question_list_id')
                    ->whereHas('questionList',function($query){
                        $query->whereNull('deleted_at');
                    })
                    ->where('is_attempted',1)
                    ->whereNull('deleted_at')
                    ->count();
    }

    /**
     * Get that question own mcq question
     */
    public function getProgressBarAttribute(){
        if($this->average_responses > 0 && ($this->average_correct_answer > 0 || $this->average_incorrect_answer > 0)){
            $per = (100 * $this->average_correct_answer)/ $this->average_responses;
            if($per != 0){
                $per = number_format($per,2);
            }else{
                $per = 0;
            }
        }else{
            $per = 0;
        }
        $html = '<div class="progress m-progress--sm">';
        $html .='<div class="progress-bar m--bg-success" role="progressbar" style="width: '.$per.'%;" aria-valuenow="'.$per.'" aria-valuemin="0" aria-valuemax="100"></div>';
        $html .='</div>';
        $html .='<span class="m-widget24__number">'.$per.'%</span>';
        return $html;
    }
     /** 
     * Get total answer
     */
    public function totalAnswer(){
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','question_list_id');
    }

    public function getAverageUnattemptedAttribute(){
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','question_list_id')
                    ->where('is_attempted',0)
                    ->count();
    }

    /**
     * Get that question own answers
     */
    public function getSingleAnswer()
    {
        return $this->hasOne('App\Models\Answer', 'question_list_id')->orderBy('id','desc');
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getQuestionImagePathAttribute()
    {
        $path = ($this->question_image !=null && file_exists(storage_path(config('constant.question-list.storage_path').'/'.$this->question_image))) ? 
        url(config('constant.question-list.url_path').'/'.$this->question_image) : asset('images/mock_img_tbl.png');
        return $path;
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getAnswerImagePathAttribute()
    {
        $path = ($this->answer_image !=null && file_exists(storage_path(config('constant.question-list.storage_path').'/'.$this->answer_image))) ? 
        url(config('constant.question-list.url_path').'/'.$this->answer_image) : asset('images/mock_img_tbl.png');
        return $path;
    }

    /**
     * Get that question own topic
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic', 'topic_id')->withTrashed();
    }

    /**
     * Get that question own answers
     */
    public function multipleCorrectAnswers()
    {
        return $this->hasMany('App\Models\Answer', 'question_list_id')->whereIsCorrect('1')->orderBy('id','asc');
    }
}
