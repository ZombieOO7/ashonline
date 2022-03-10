<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $primaryKey = null;
    public $incrementing = false;

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'order_id', 'paper_id','price','version_id','mock_test_id',
    ];

    public $timestamps = false;

    /**
     * -------------------------------------------------------------
     * | Get the order that owns the order items.                  |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the paper that owns the order items.                  |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function paper()
    {
        return $this->belongsTo('App\Models\Paper', 'paper_id');
    }

    /**
     * -----------------------------------------------------------------
     * | Get the billing address that associated with the order items. |
     * |                                                               |
     * -----------------------------------------------------------------
     */
    public function biilingAddress()
    {
        return $this->hasOne('App\Models\BillingAddress', 'order_id', 'order_id');
    }

    /**
     * -------------------------------------------------------------
     * | get Order that associated with the order items.           |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function orders()
    {
        return $this->belongsTo('App\Models\Order', 'order_id')->with('papers');
    }

    /**
     * -------------------------------------------------------------
     * | Get the paper that owns the order items.                  |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function paperVersion()
    {
        return $this->hasMany('App\Models\PaperVersion', 'paper_id','paper_id')->orderBy('id','asc');
    }
    /**
     * -------------------------------------------------------------
     * | Get item price text attribute with number format.         |
     * |                                                           |
     * | @return attribute                                         |
     * -------------------------------------------------------------
     */
    public function getItemPriceTextAttribute()
    {
        return config('constant.default_currency_symbol'). number_format((float)@$this->attributes['price'], 2, '.', '');
    }

    /**
     * -------------------------------------------------------------
     * | Get the mock test that owns the order items.              |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function mockTest()
    {
        return $this->belongsTo('App\Models\MockTest', 'mock_test_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the mock test that owns the order items.              |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function activatedMock()
    {
        return $this->belongsTo('App\Models\PurchasedMockTest', 'mock_test_id','mock_test_id');
    }

    /**
     * get that own parent child or student
     *
     * @return void
     */
    public function review()
    {
        return $this->hasOne('App\Models\Review','paper_id','paper_id')->where('order_id',$this->order_id);
    }

    /**
     * -------------------------------------------------------------
     * | Get price text attribute.                                 |
     * |                                                           |
     * | @return attribute                                         |
     * -------------------------------------------------------------
     */
    public function getPriceTextAttribute()
    {
        return config('constant.default_currency_symbol') . $this->attributes['price'];
    }
}
