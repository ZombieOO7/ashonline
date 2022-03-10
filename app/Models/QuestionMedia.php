<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;


class QuestionMedia extends BaseModel
{
    protected $table = 'question_medias';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'question_id', 'name', 'path', 'media_type'
    ];

    protected $appends = ['question_image', 'question_pdf'];

    /**
     * Get that question image
     */
    public function getQuestionImageAttribute()
    {
        $path = 'question' . $this->question_id . '/' . $this->name;
        $avatarPath = file_exists(Storage::path($path)) ? url('storage/app/'.$path) : asset('images/mock_img_tbl.png');
        return $avatarPath;
    }

    /**
     * Get that question pdf
     */
    public function getQuestionPdfAttribute()
    {
        $path = 'question' . $this->question_id . '/' . $this->name;
        $avatarPath = file_exists(Storage::path($path)) ? url('storage/app/'.$path) : null;
        return $avatarPath;
    }

    /**
     * Get that question pdf
     */
    public function getImageNameAttribute()
    {
        return $this->name;
    }
}
