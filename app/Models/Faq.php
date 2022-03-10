<?php

namespace App\Models;

use App\Models\BaseModel;
use Cviebrock\EloquentSluggable\Sluggable;

class Faq extends BaseModel
{
    use Sluggable;

    protected $table = 'faqs';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'content', 'faq_category_id', 'title', 'status', 'created_at', 'updated_at', 'uuid', 'deleted_at', 'slug',
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
                'source' => 'title',
                'onUpdate' => true,
            ],
        ];
    }

    /**
     * -------------------------------------------------------------
     * | Get scope active                                          |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * -------------------------------------------------------------
     * | Get scope not deleted                                     |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * -------------------------------------------------------------
     * | FaqCategory ownes faq                                     |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function category()
    {
        return $this->belongsTo('App\Models\FaqCategory', 'faq_category_id');
    }

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
        });
        self::updating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
        });
    }
}
