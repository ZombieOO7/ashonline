<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductKeyBenefit extends Model
{
    use SoftDeletes;
    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'product_key_benefit_and_products';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = ['product_category_id', 'type', 'description', 'title'];

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            $query->title = trimContent($query->title);
            $query->description = trimContent($query->description);
        });
        static::updating(function ($query) {
            $query->title = trimContent($query->title);
            $query->description = trimContent($query->description);
        });
    }
}
