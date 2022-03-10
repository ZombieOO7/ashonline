<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;

class Payment extends BaseModel
{

    protected $table = 'payments';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'uuid', 'order_id', 'currency', 'amount', 'payment_date', 'status', 'created_at', 'updated_at', 'deleted_at', 'method', 'transaction_id',
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
     * | Get the order that owns the payment data.                 |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
    /**
     * -------------------------------------------------------------
     * | Get payment status active                                 |
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
     * | Get payment status active                                 |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActiveSearch($query, $status)
    {
        return $query->where('status', ($status == 'paid') ? 1 : 0);
    }
    /**
     * -------------------------------------------------------------
     * | Get amount attribute.                                     |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getAmountAttribute()
    {
        return config('constant.default_currency_symbol') . $this->attributes['amount'];
    }
    /**
     * -------------------------------------------------------------
     * | Get created at attribute                                  |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    public function getPaymentDateAttribute($date)
    {
        if ($date != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format(config('constant.date_display_format'));
        }

    }

    /**
     * -------------------------------------------------------------
     * | Get Payment Method attribute                              |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    public function getMethodTextAttribute()
    {
        if ($this->attributes['method'] != null) {
            return ($this->attributes['method'] == 1) ? 'PayPal' : 'Credit Card';
        }

    }

    /**
     * This function is used for getting created date in d/m/y
     *
     * @return void
     */
    public function getProperPaymentAtAttribute()
    {
        $value = $this->attributes['payment_date'];
        return '<span class="hid_spn">' . date('Ymd', strtotime($value)) . '</span>' . date('d-m-Y', strtotime($value));
    }
}
