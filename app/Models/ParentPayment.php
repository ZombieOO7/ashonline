<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ParentPayment extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'subscription_id', 'transaction_id', 'currency', 'amount', 'payment_date', 'method', 'status','description'
    ];

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

    /**
     * -------------------------------------------------------------
     * | Get that payment parent                                   |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    public function parent(){
        return $this->belongsTo('App\Models\ParentUser','parent_id');
    }

    public function getProperStatusAttribute(){
        return ($this->status == '1')? 'Paid' : 'Unpaid';
    }
}
