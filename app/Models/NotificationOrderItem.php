<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationOrderItem extends Model
{

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'order_id', 'paper_id', 'user_id',
    ];
    /**
     * -------------------------------------------------------------
     * | The storage format of the model's date columns.           |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    /**
     * -------------------------------------------------------------
     * | Get the order data that own tabel.                        |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
    /**
     * -------------------------------------------------------------
     * | Get the paper data that own tabel.                        |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    public function paper()
    {
        return $this->belongsTo('App\Models\Paper', 'paper_id');
    }
    /**
     * -------------------------------------------------------------
     * | Get the user or billing address data that own tabel.      |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    public function user()
    {
        return $this->belongsTo('App\Models\ParentUser', 'parent_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the user or billing address data that own tabel.      |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    public function billingAddress()
    {
        return $this->belongsTo('App\Models\BillingAddress', 'user_id');
    }
}
