<?php

namespace App\Models;


use Storage;
use App\Models\BaseModel;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Str;

class Paper extends BaseModel
{
    use Sluggable;
    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'papers';

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'title', 'slug', 'content', 'status', 'created_at', 'updated_at','category_id','subject_id','name',
        'path','thumb_path','extension','mime_type','deleted_at','price','edition','avg_rate','total_reviews','media_type','exam_type_id',
        'pdf_name','pdf_path','age_id','stage_id','product_no','original_name','image_id'
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string) \Str::uuid();
            }
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
        });
        self::updating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
        });
    }

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
                'source' => 'slug',
                'onUpdate' => true,
            ],
        ];
    }

    /**
     * -------------------------------------------------------------
     * | Get price text attribute.                                 |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getPriceTextAttribute()
    {
        return config('constant.default_currency_symbol').$this->attributes['price'];
    }

    /**
     * -------------------------------------------------------------
     * | Get the category that owns the paper.                     |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function category()
    {
        return $this->belongsTo('App\Models\PaperCategory','category_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the subject that owns the paper.                      |
     * |                                                           |
     * -------------------------------------------------------------
     */


    public function subject()
    {
        return $this->belongsTo('App\Models\Subject','subject_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the exam type that owns the paper.                    |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function examType()
    {
        return $this->belongsTo('App\Models\ExamType','exam_type_id');
    }


    /**
     * -------------------------------------------------------------
     * | Get path attribute                                        |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    public function getPathAttribute($path)
    {
        if (isset($path)) {
            $user_id = $this->id;
            $image_path = str_replace("/public", "", url($path));
            $newPath = config('constant.paper.folder_name') . $user_id .'/' . $this->name;
            if (Storage::exists($newPath)) {
                return $this->attributes['path'] = $image_path;
            } else {
                return $this->attributes['path'] = url(asset("frontend/images/english_pack.png"));
            }
        } else {
            return $this->attributes['path'] = url(asset("frontend/images/english_pack.png"));
        }
    }

    /**
     * -------------------------------------------------------------
     * | Get thumb path attribute                                  |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    public function getThumbPathAttribute($path)
    {
        if (isset($path)) {
            $user_id = $this->id;
            $image_path = str_replace("/public", "", url($path));
            $newPath = config('constant.paper.folder_name') . $user_id .'/thumb/' . $this->name;
            if (Storage::exists($newPath)) {
                return $this->attributes['path'] = $image_path;
            } else {
                return $this->attributes['path'] = url(asset("frontend/images/english_pack.png"));
            }
        } else {
            return $this->attributes['path'] = url(asset("frontend/images/english_pack.png"));
        }
    }

    /**
     * -------------------------------------------------------------
     * | Get detail path attribute                                 |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    public function getDetailPathAttribute()
    {
        $user_id = $this->id;
        $image_path = url('/storage/app/'.config('constant.paper.folder_name') . $user_id .'/detail/' . $this->name);
        $newPath = config('constant.paper.folder_name') . $user_id .'/detail/' . $this->name;
        if (Storage::exists($newPath)) {
            return $this->attributes['path'] = $image_path;
        } else {
            return $this->attributes['path'] = url(asset("frontend/images/english_pack_new.png"));
        }
    }


    /**
     * -------------------------------------------------------------
     * | Get the exam type that owns the paper.                    |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function stage()
    {
        return $this->belongsTo('App\Models\Stage','stage_id');
    }

    /**
     * -----------------------------------------------------------------
     * | Get the review that associated with the paper.                |
     * |                                                               |
     * -----------------------------------------------------------------
     */

    public function review()
    {
        return $this->hasOne('App\Models\Review','paper_id','id');
    }

    /**
     * -------------------------------------------------------------
     * | Get papers status active                                  |
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
     * | Get papers status active                                  |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActiveSearch($query,$status=null)
    {
        return $query->where('status', ($status == 'Active') ? 1 : 0);
    }

    /**
     * -------------------------------------------------------------
     * | Get papers not deleted                                    |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * -----------------------------------------------------------------
     * | Get paper title with limited texts attributes.                |
     * |                                                               |
     * -----------------------------------------------------------------
     */
    public function getTitleTextAttribute()
    {
        return Str::limit($this->attributes['title'],23,'...');
    }

    /**
     * -----------------------------------------------------------------
     * | Get paper title with limited texts for list attributes.       |
     * |                                                               |
     * -----------------------------------------------------------------
     */
    public function getTitleTextForListAttribute()
    {
        return Str::limit($this->attributes['title'],16,'...');
    }

    /**
     * -------------------------------------------------------------
     * | Get the order items that owns the paper.                  |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem','paper_id');
    }
    /**
     * -------------------------------------------------------------
     * | Get total sold papers amount                              |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getTotalSoldPaperAmountAttribute()
    {
        return $this->attributes['price']*$this->attributes['order_items_count'];
    }
    /**
     * -------------------------------------------------------------
     * | Get Last version of papers                                |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function version()
    {
        return $this->hasOne('App\Models\PaperVersion','paper_id','id')->latest();
    }

    /**
     * -------------------------------------------------------------
     * | Get price text attribute with number format.              |
     * |                                                           |
     * | @return attribute                                         |
     * -------------------------------------------------------------
     */
    public function getPriceFormatTextAttribute()
    {
        return number_format((float)@$this->attributes['price'], 2, '.', '');
    }

    /**
     * -------------------------------------------------------------
     * | Get that price keywords.                                  |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function keywords()
    {
        return $this->hasMany('App\Models\PaperKeyword','paper_id');
    }
     /**
     * -------------------------------------------------------------
     * | Get Total Seo                                             |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function getTitleSeoAttribute()
    {
        return str_replace('+',' Plus ('.$this->category->title.')',$this->attributes['title']);
    }
}
