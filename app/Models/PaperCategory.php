<?php

namespace App\Models;

use App\Models\BaseModel;
use Cviebrock\EloquentSluggable\Sluggable;

class PaperCategory extends BaseModel
{
    use Sluggable;
    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'paper_categories';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'title', 'slug', 'content', 'status', 'created_at', 'updated_at', 'uuid', 'color_code', 'image', 'sequence',
        'image_path', 'thumb_path', 'extension', 'mime_type', 'deleted_at', 'position', 'product_content', 'type',
    ];
    /**
     * -------------------------------------------------------------
     * | The storage format of the model's date columns.           |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    public $dates = [
        'deleted_at',
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
            $query->product_content = trimContent($query->product_content);
        });
        static::updating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
            $query->product_content = trimContent($query->product_content);
        });
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
            'slug' => [
                'source' => 'slug',
                'onUpdate' => true,
            ],
        ];
    }
    /**
     * -------------------------------------------------------------
     * | Get Paper category own papers                             |
     * |                                                           |
     * | @return PaperCategory                                     |
     * -------------------------------------------------------------
     */
    public function papers()
    {
        return $this->hasMany('App\Models\Paper','category_id','id')->orderBy('title','asc')->where('status',1);
    }

    /**
     * -------------------------------------------------------------
     * | Get Paper category status active                          |
     * |                                                           |
     * | @return PaperCategory                                     |
     * -------------------------------------------------------------
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    /**
     * -------------------------------------------------------------
     * | Get Paper category not deleted                            |
     * |                                                           |
     * | @return PaperCategory                                     |
     * -------------------------------------------------------------
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }
    /**
     * -------------------------------------------------------------
     * | Get Paper category own benefits                           |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function keyBenefits()
    {
        return $this->hasMany('App\Models\ProductKeyBenefit', 'product_category_id', 'id')->where('type', 0);
    }
    /**
     * -------------------------------------------------------------
     * | Get Paper category own products                           |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function keyProducts()
    {
        return $this->hasMany('App\Models\ProductKeyBenefit', 'product_category_id', 'id')->where('type', 1);
    }
    /**
     * -------------------------------------------------------------
     * | Get Payment Method attribute                              |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    public function getTypeTextAttribute()
    {
        if ($this->attributes['type'] != null) {
            return ($this->attributes['type'] == 1) ? 'Grade' : 'SATs';
        }

    }
    /**
     * -----------------------------------------------------------------
     * | Get title with text "Papers" attributes.                      |     
     * |                                                               | 
     * | @return String
     * -----------------------------------------------------------------
     */
    public function getTitleWithTextPapersAttribute()
    {
        return $this->attributes['slug'] == 'sats' ? $this->attributes['title'] : $this->attributes['title'] . ' Papers';
    }

    // Get category blogGuidance
    public function blogGuidance()
    {
        return $this->hasMany('App\Models\ResourceGuidance', 'category_id');
    }

    /**
     * get that category seo attributes
     *
     */
    public function getTitleSeoAttribute() 
    {
        return str_replace('+',' Plus ('.$this->attributes['title'].')',$this->attributes['title']);
         
    }
}
