<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CMS extends BaseModel
{
    use SoftDeletes;
    use Sluggable;
    protected $table = 'cms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'page_slug', 'api_page_slug', 'content', 'meta_title', 'meta_keyword', 'meta_description', 
        'meta_robots', 'created_by', 'updated_by', 'status','type', 'school_id','short_description', 'image',
        'image_path','logo','exam_style','logo_image_id','image_id'
    ];

    /**
     * This function is used for getting image path
     *
     * @return void
     */
    public function getImagePathAttribute()
    {
        // $path = ($this->image !=null && file_exists(storage_path('app/cms/'.$this->image))) ? 
        // url('storage/app/cms/'.$this->image) : asset('images/mock_img_tbl.png');
        // return $path;
        $path = ($this->image != null && file_exists(storage_path(config('constant.image.storage_path') . $this->image))) ?
        url(config('constant.image.url_path') . $this->image) : asset('images/mock_img_tbl.png');
        return $path;
    }

    /**
     * -------------------------------------------------------------
     * | Return the sluggable configuration array for this model.  |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function sluggable()
    {
        return [
            'page_slug' => [
                'source' => 'title',
                'onUpdate' => false,
            ],
        ];
    }

    /**
     * -------------------------------------------------------------
     * | Get cms mock pages                                        |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
    */
    public function mockCms(){
        return $this->belongsToMany('App\Models\CmsMock','cms_mocks','cms_id','mock_test_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get cms mock paper pages                                  |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
    */
    public function mockPapers(){
        return $this->belongsToMany('App\Models\CmsPaper','cms_papers','cms_id','paper_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get cms mock pages                                        |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
    */
    public function mocks(){
        return $this->hasMany('App\Models\CmsMock','cms_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get cms mock paper pages                                  |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
    */
    public function papers(){
        return $this->hasMany('App\Models\CmsPaper','cms_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get school cms pages                                      |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
    */
    public function school(){
        return $this->belongsTo('App\Models\Schools','school_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get cms images                                            |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
    */
    public function imageData(){
        return $this->belongsTo('App\Models\Image','image_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get cms images                                            |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
    */
    public function logoData(){
        return $this->belongsTo('App\Models\Image','logo_image_id');
    }
    /**
     * This function is used for getting logo path
     *
     * @return void
     */
    public function getLogoPathAttribute()
    {
        $path = ($this->logo != null && file_exists(storage_path(config('constant.image.storage_path') . $this->logo))) ?
        url(config('constant.image.url_path') . $this->logo) : asset('images/mock_img_tbl.png');
        return $path;
    }

    /*
     * Auto-sets values on creation
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
            $query->short_description = trimContent($query->short_description);
        });
        self::updating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
            $query->short_description = trimContent($query->short_description);
        });
    }
    /**
     * This function is used for getting logo path
     *
     * @return void
     */
    public function getProperLogoPathAttribute()
    {
        $path = ($this->logo != null && file_exists(storage_path().'/'.'app/public/uploads/'.$this->logo)) ? url('storage/app/public/uploads/'. $this->logo) : asset('images/mock_img_tbl.png');
        // $path = storage_path().'/'.'app/public/uploads/'.$this->logo;
        return $path;
    }

    /**
     * This function is used for getting logo path
     *
     * @return void
     */
    public function getProperImagePathAttribute()
    {
        $path = ($this->image != null && file_exists(storage_path().'/'.'app/public/uploads/'.$this->image)) ? url('storage/app/public/uploads/'. $this->image) : asset('images/mock_img_tbl.png');
        // $path = storage_path().'/'.'app/public/uploads/'.$this->image;
        return $path;
    }
}
