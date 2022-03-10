<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use SoftDeletes;
    protected $table = 'blocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'type', 'sub_type', 'title', 'sub_title', 'content', 'note', 'subject_title_1', 'subject_title_1_content', 'subject_title_2', 'subject_title_2_content', 'subject_title_3', 'subject_title_3_content', 'subject_title_4', 'subject_title_4_content', 'exam_format_title_1', 'exam_format_title_1_content', 'exam_format_title_2', 'exam_format_title_2_content', 'slug',
        'deleted_at','slider_1_title','slider_1_sub_title','slider_1_description','slider_2_title','slider_2_sub_title','slider_2_description','slider_3_title','slider_3_sub_title','slider_3_description','title_1','content_1','title_2','content_2','title_3','content_3','title_4','content_4','title_5','content_5','title_6','content_6','image_1','image_2','image_3','image_4','image_5','image_6','video_url',
    ];
    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
            $query->sub_title = trimContent($query->sub_title);
            $query->subject_title_1 = trimContent($query->subject_title_1);
            $query->subject_title_1_content = trimContent($query->subject_title_1_content);
            $query->subject_title_2 = trimContent($query->subject_title_2);
            $query->subject_title_2_content = trimContent($query->subject_title_2_content);
            $query->subject_title_3 = trimContent($query->subject_title_3);
            $query->subject_title_3_content = trimContent($query->subject_title_3_content);
            $query->subject_title_4 = trimContent($query->subject_title_4);
            $query->subject_title_4_content = trimContent($query->subject_title_4_content);
            $query->exam_format_title_1 = trimContent($query->exam_format_title_1);
            $query->exam_format_title_1_content = trimContent($query->exam_format_title_1_content);
            $query->exam_format_title_2 = trimContent($query->exam_format_title_2);
            $query->exam_format_title_2_content = trimContent($query->exam_format_title_2_content);
            $query->slider_1_title = trimContent($query->slider_1_title);
            $query->slider_1_sub_title = trimContent($query->slider_1_sub_title);
            $query->slider_1_description = trimContent($query->slider_1_description);
            $query->slider_2_title = trimContent($query->slider_2_title);
            $query->slider_2_sub_title = trimContent($query->slider_2_sub_title);
            $query->slider_2_description = trimContent($query->slider_2_description);
            $query->slider_3_title = trimContent($query->slider_3_title);
            $query->slider_3_sub_title = trimContent($query->slider_3_sub_title);
            $query->slider_3_description = trimContent($query->slider_3_description);
            $query->title_1 = trimContent($query->title_1);
            $query->content_1 = trimContent($query->content_1);
            $query->title_2 = trimContent($query->title_2);
            $query->content_2 = trimContent($query->content_2);
            $query->title_3 = trimContent($query->title_3);
            $query->content_3 = trimContent($query->content_3);
            $query->title_4 = trimContent($query->title_4);
            $query->content_4 = trimContent($query->content_4);
            $query->title_5 = trimContent($query->title_5);
            $query->content_5 = trimContent($query->content_5);
            $query->title_6 = trimContent($query->title_6);
            $query->content_6 = trimContent($query->content_6);
        });
        static::updating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
            $query->sub_title = trimContent($query->sub_title);
            $query->subject_title_1 = trimContent($query->subject_title_1);
            $query->subject_title_1_content = trimContent($query->subject_title_1_content);
            $query->subject_title_2 = trimContent($query->subject_title_2);
            $query->subject_title_2_content = trimContent($query->subject_title_2_content);
            $query->subject_title_3 = trimContent($query->subject_title_3);
            $query->subject_title_3_content = trimContent($query->subject_title_3_content);
            $query->subject_title_4 = trimContent($query->subject_title_4);
            $query->subject_title_4_content = trimContent($query->subject_title_4_content);
            $query->exam_format_title_1 = trimContent($query->exam_format_title_1);
            $query->exam_format_title_1_content = trimContent($query->exam_format_title_1_content);
            $query->exam_format_title_2 = trimContent($query->exam_format_title_2);
            $query->exam_format_title_2_content = trimContent($query->exam_format_title_2_content);
            $query->slider_1_title = trimContent($query->slider_1_title);
            $query->slider_1_sub_title = trimContent($query->slider_1_sub_title);
            $query->slider_1_description = trimContent($query->slider_1_description);
            $query->slider_2_title = trimContent($query->slider_2_title);
            $query->slider_2_sub_title = trimContent($query->slider_2_sub_title);
            $query->slider_2_description = trimContent($query->slider_2_description);
            $query->slider_3_title = trimContent($query->slider_3_title);
            $query->slider_3_sub_title = trimContent($query->slider_3_sub_title);
            $query->slider_3_description = trimContent($query->slider_3_description);
            $query->title_1 = trimContent($query->title_1);
            $query->content_1 = trimContent($query->content_1);
            $query->title_2 = trimContent($query->title_2);
            $query->content_2 = trimContent($query->content_2);
            $query->title_3 = trimContent($query->title_3);
            $query->content_3 = trimContent($query->content_3);
            $query->title_4 = trimContent($query->title_4);
            $query->content_4 = trimContent($query->content_4);
            $query->title_5 = trimContent($query->title_5);
            $query->content_5 = trimContent($query->content_5);
            $query->title_6 = trimContent($query->title_6);
            $query->content_6 = trimContent($query->content_6);
        });
    }
}
