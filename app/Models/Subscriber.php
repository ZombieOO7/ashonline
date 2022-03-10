<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use SoftDeletes;
    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'newsletter_subscribers';

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'uuid', 'email', 'status', 'created_at', 'updated_at',
    ];

    // Append attributes
    protected $appneds = ['proper_created_at'];

    /**
     * -------------------------------------------------------------
     * | get proper_created_at attributes                          |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    public function getProperCreatedAtAttribute()
    {
        return date('d-m-Y', strtotime($this->created_at));
    }
}
