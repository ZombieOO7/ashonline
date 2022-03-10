<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;


class QuestionImage extends BaseModel
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','question_id','name','path', 'media_type'
    ];

    protected $appends = ['question_image', 'question_pdf'];

    /**
     * get that question image
     *
     */
    public function getQuestionImageAttribute()
    {
        $path = 'media/question'.$this->question_id.'/'.$this->path;
        $avatarPath = !empty($this->path) &&
            file_exists(Storage::path($path)) ? asset(Storage::url($path)) : asset('images/licence_default.png');
        return $avatarPath;
    }

    /**
     * get that question pdf
     *
     */
    public function getQuestionPdfAttribute()
    {
        $path = 'pdf/question'.$this->question_id.'/'.$this->path;
        $avatarPath = !empty($this->path) &&
            file_exists(Storage::path($path)) ? asset(Storage::url($path)) : asset('images/licence_default.png');
        return $avatarPath;
    }
}
