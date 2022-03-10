<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class PracticeByTopicQuestion extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','uuid','subject_id','no_of_questions','question_no','question','instruction','type',
        'marks','resize_full_image','resize_question_image','resize_answer_image','answer_type',
        'image','question_image','answer_image','explanation','status','topic_id'
    ];

    /*
     * Auto-sets values on creation
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string) \Str::uuid();
            }
            $query->question = trimContent($query->question);
        });
        static::updating(function ($question) {
            $question->question = trimContent($question->question);
        });
        static::deleting(function ($question) {
        });
    }

    /**
     * Get that question subject
     */
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }

    /**
     * Get that question own topic
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic', 'topic_id')->withTrashed();
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
        $html .='<div class="progress-bar m--bg-success" role="progressbar" style="width: '.$per.'%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>';
        $html .='</div>';
        $html .='<span class="m-widget24__number">'.$per.'%</span>';
        return $html;
    }

    /**
     * Get that question average time
     */
    public function getAverageTimeAttribute(){
        $query =  $this->hasMany('App\Models\PracticeByTopicQuestionAnswer', 'question_id');
        $totalTime =  $query->sum('time_taken');
        $timeAnswer = $query->count();
        $averageTime = 0;
        $timeTaken = '00:00:00';
        if($totalTime > 0 && $timeAnswer > 0){
            $averageTime = $totalTime/$timeAnswer;
            $timeTaken = sprintf('%02d:%02d:%02d', ($averageTime/3600),($averageTime/60%60), $averageTime%60);
        }
        return $timeTaken;
    }

    /**
     * Get that question average correct answers
     */
    public function getAverageCorrectAnswerAttribute(){
        return $this->hasMany('App\Models\PracticeByTopicQuestionAnswer','question_id')
                    ->where('is_attempted','1')
                    ->whereNull('deleted_at')
                    ->where('is_correct','1')
                    ->count();
    }

    /**
     * Get that question average incorrect answers
     */
    public function getAverageIncorrectAnswerAttribute(){
        return $this->hasMany('App\Models\PracticeByTopicQuestionAnswer','question_id')
                    ->where('is_attempted','1')
                    ->whereNull('deleted_at')
                    ->where('is_correct','!=','1')
                    ->count();
    }

    /**
     * Get that question average responses answers
     */
    public function getAverageResponsesAttribute(){
        return $this->hasMany('App\Models\PracticeByTopicQuestionAnswer','question_id')
                    ->where('is_attempted','1')
                    ->whereNull('deleted_at')
                    ->count();
    }

    /**
     * Get that question average unattempted question
     */
    public function getAverageUnattemptedAttribute(){
        return $this->hasMany('App\Models\PracticeByTopicQuestionAnswer','question_id')
                    ->where('is_attempted','0')
                    ->count();
    }

    public function answers(){
        return $this->hasMany('App\Models\PracticeByTopicAnswer','question_id');
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
     * Get that question own answers
    */
    public function correctAnswer()
    {
        return $this->hasOne('App\Models\PracticeByTopicAnswer', 'question_id')->whereIsCorrect('1');
    }

    /**
     * Get that question own answers
    */
    public function multipleCorrectAnswers()
    {
        return $this->hasMany('App\Models\PracticeByTopicAnswer', 'question_id')->whereIsCorrect('1')->orderBy('id','asc');
    }

    /**
     * Get that question own answers
     */
    public function getSingleAnswer()
    {
        return $this->hasOne('App\Models\PracticeByTopicAnswer', 'question_id')->orderBy('id','desc');
    }

    /**
     * Get that question own answers
     */
    public function questionAnswers()
    {
        return $this->hasMany('App\Models\PracticeByTopicQuestionAnswer', 'question_id');
    }

    public function getQuestionTypeAttribute(){
        return 1;
    }
}
