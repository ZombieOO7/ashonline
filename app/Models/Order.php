<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Payment;

class Order extends BaseModel
{

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'uuid', 'amount', 'discount', 'order_no', 'status', 'created_at', 'updated_at', 
        'deleted_at', 'invoice_no', 'is_remind', 'promo_code_id','parent_id',
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
     * | Get Order own billing address                             |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function items()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id', 'id')->with('paper')->with('paperVersion');
    }
    /**
     * -------------------------------------------------------------
     * | Get Order own billing address                             |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function biilingAddress()
    {
        return $this->hasOne('App\Models\BillingAddress', 'order_id', 'id');
    }
    /**
     * -------------------------------------------------------------
     * | Get Order own reviews                                     |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function review()
    {
        return $this->hasMany('App\Models\Review', 'order_id', 'id');
    }
    /**
     * -------------------------------------------------------------
     * | Get Order number with prefix                              |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function getOrderNoTextAttribute()
    {
        return '#' . $this->attributes['order_no'];
    }
    /**
     * -------------------------------------------------------------
     * | Get orders status active                                  |
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
     * | Get orders status active                                  |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActiveSearch($query, $status)
    {
        return $query->where('status', ($status == 'completed') ? 1 : 0);
    }

    /**
     * -------------------------------------------------------------
     * | Get orders not deleted                                    |
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
     * | Get amount text attribute.                                |
     * |                                                           |
     * | @return attribute                                         |
     * -------------------------------------------------------------
     */
    public function getAmountTextAttribute()
    {
        return config('constant.default_currency_symbol') . $this->attributes['amount'];
    }

    /**
     * -------------------------------------------------------------
     * | Get payment method.                                       |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    public function payment()
    {
        return $this->hasOne('App\Models\Payment', 'order_id', 'id');
    }

    /**
     * -------------------------------------------------------------
     * | Get totalItem method.                                     |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getTotalItemAttribute($items)
    {
        $items = $this->hasMany('App\Models\OrderItem', 'order_id', 'id');
        return $items->count();
    }
    /**
     * -------------------------------------------------------------
     * | Get Payment type attribute.                               |
     * |                                                           |
     * -------------------------------------------------------------
     */

    public function getPaymentTextAttribute()
    {
        $payment = Payment::where('order_id', $this->id)->first();
        if (@$payment->method == 1) {
            $method = 'PayPal';
        } else {
            $method = 'Credit Card';
        }
        return $method;
    }

    /**
     * -------------------------------------------------------------
     * | Get discount attribute.                                   |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getDiscountTextAttribute()
    {
        return config('constant.default_currency_symbol') . $this->attributes['discount'];
    }

    /**
     * -------------------------------------------------------------
     * | Promocode own by orders                                   |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function promoCode()
    {
        return $this->belongsTo('App\Models\PromoCode', 'promo_code_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get amount text attribute with number format.             |
     * |                                                           |
     * | @return attribute                                         |
     * -------------------------------------------------------------
     */
    public function getAmountFormatTextAttribute()
    {
        return config('constant.default_currency_symbol'). number_format((float)@$this->attributes['amount'], 2, '.', '');
    }

    /**
     * -------------------------------------------------------------
     * | Get Order own billing address                             |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function mockTests()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id', 'id')->where('mock_test_id','!=',null);
    }

    /**
     * -------------------------------------------------------------
     * | Get oder date of that own order.                          |
     * |                                                           |
     * | @return attribute                                         |
     * -------------------------------------------------------------
     */
    public function getProperOrderDateAttribute()
    {
        return date('jS F, Y', strtotime($this->created_at));
    }

    /**
     * -------------------------------------------------------------
     * | Get Order own billing address                             |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function papers()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id', 'id')->where('paper_id','!=',null);
    }

    /**
     * -------------------------------------------------------------
     * | Get Order own billing parent name                         |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\ParentUser', 'parent_id', 'id');
    }

    /**
     * -------------------------------------------------------------
     * | Get Order own billing address                             |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function biilingAddress2()
    {
        return $this->hasOne('App\Models\BillingAddress', 'order_id', 'id')->select('address1','address2','postal_code','city','state','country');
    }

    /**
     * -------------------------------------------------------------
     * | Get that order total amount                               |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function getTotalAmountAttribute()
    {
        if($this->discount > 0){
            $total = $this->amount - $this->discount;
        }else{
            $total = $this->amount;
        }
        return @$total;
    }
}