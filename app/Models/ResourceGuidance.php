<?php

namespace App\Models;

use App\Models\BaseModel;
use Cviebrock\EloquentSluggable\Sluggable;

class ResourceGuidance extends BaseModel
{
    use Sluggable;
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'title', 'resource_category_id', 'featured_original_name', 'featured_stored_name', 'status', 'content',
        'meta_title', 'meta_keyword', 'meta_description', 'slug', 'category_id', 'written_by','order_seq','link',
        'grade_id', 'project_type','image_id'
    ];

    protected $appends = ['featured_img', 'created_at_date', 'short_content', 'you_tube_link', 'paper_category_status', 'short_title'];

     /**
     * -------------------------------------------------------------
     * | The attributes For slug.                                  |
     * |                                                           |
     * |  @var array                                               |
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
     * -------------------------------------------------------------
     * | Get the resource category                                 |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function category()
    {
        return $this->belongsTo('App\Models\ResourceCategory', 'resource_category_id');
    }
     /**
     * -------------------------------------------------------------
     * | The attributes For Get title attribute.                   |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */

 
    public function getTitleAttribute($title)
    {
        return ucwords($title);
    }

    /**
     * -------------------------------------------------------------
     * | Get path attribute                                        |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    public function getFeaturedImgAttribute()
    {
        if (isset($this->featured_stored_name)) {
            $image_path = str_replace("/public", "", url('/'));

            $newPath = $image_path . '/' . config('constant.guidance_directory_path') . $this->id . "/resize/" . $this->featured_stored_name;
            $storagePath = storage_path() . '/' . config('constant.guidance_download_path') . $this->id . "/resize/" . $this->featured_stored_name;
            if (file_exists($storagePath)) {
                return asset($newPath);
            } else {
                return asset("frontend/images/english_pack.png");
            }
        } else {
            return asset("frontend/images/english_pack.png");
        }
    }

    /**
     * -------------------------------------------------------------
     * | Get the resource category                                  |
     * |                                                            |
     * -------------------------------------------------------------
     */
    public function guidanceCategory()
    {
        return $this->belongsTo('App\Models\PaperCategory', 'category_id');
    }

    // For date format
    public function getCreatedAtDateAttribute()
    {
        return date('F d, Y', strtotime($this->created_at));
    }
     /**
     * -------------------------------------------------------------
     * | The attributes For short description.                     |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    public function getShortContentAttribute()
    {
        $content = $this->content;
        $content = preg_replace("/<img[^>]+\>/i", "", $content);
        $content = strip_tags($content);
        return (strlen($content) > 300) ? substr($content, 0, 300) . '...' : $content;
    }
     /**
     * -------------------------------------------------------------
     * | The attributes For Get written by user detail.            |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */

    public function writtenBy()
    {
        return $this->belongsTo('App\Models\Admin', 'written_by');
    }
     /**
     * -------------------------------------------------------------
     * | The attributes For Get youtube link.                      |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    // 
    public function getYouTubeLinkAttribute()
    {
        preg_match_all(
            '@(https?://)?(?:www\.)?(youtu(?:\.be/([-\w]+)|be\.com/watch\?v=([-\w]+)))\S*@im',
            strip_tags($this->content),
            $matches
        );
        return @$matches[0];
    }
     /**
     * -------------------------------------------------------------
     * | The attributes for paper category status.                 |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    // 
    // 
    public function getPaperCategoryStatusAttribute()
    {
        return @$this->guidanceCategory->status;
    }
    /**
     * -------------------------------------------------------------
     * | The attributes Get short title.                           |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    // 
    public function getShortTitleAttribute()
    {
        return (strlen($this->title) > 80) ? substr($this->title, 0, 80) . '...' : $this->title;
    }

    // Get that blog own grade
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id');
    }
}
