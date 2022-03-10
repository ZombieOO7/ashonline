<?php

namespace App\Models;

use App\Models\BaseModel;

class PromoCode extends BaseModel
{

    protected $table = 'promo_codes';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'code', 'status', 'created_at', 'updated_at', 'uuid', 'deleted_at', 'amount_1', 'amount_2', 'discount_1', 'discount_2', 'start_date', 'end_date',
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
     * | Get active scope                                          |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * -------------------------------------------------------------
     * | Get not deleted scope                                     |
     * |                                                           |
     * | @param $query                                             |
     * -------------------------------------------------------------
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * -------------------------------------------------------------
     * | Get start date text attribute                             |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getStartDateTextAttribute()
    {
        $value = $this->attributes['start_date'];
        return '<span class="hid_spn">' . date('Ymd', strtotime($value)) . '</span>' . date('d-m-Y', strtotime($value));
    }

    /**
     * -------------------------------------------------------------
     * | Get end date text attribute                               |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getEndDateTextAttribute()
    {
        $value = $this->attributes['end_date'];
        return '<span class="hid_spn">' . date('Ymd', strtotime($value)) . '</span>' . date('d-m-Y', strtotime($value));
    }

    /**
     * -------------------------------------------------------------
     * | Get amount 1 text attribute                               |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getAmount1TextAttribute()
    {
        return config('constant.default_currency_symbol') . $this->attributes['amount_1'];
    }

    /**
     * -------------------------------------------------------------
     * | Get discount 1 text attribute                             |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getDiscount1TextAttribute()
    {
        return $this->attributes['discount_1'] . config('constant.percentage_symbol');
    }

    /**
     * -------------------------------------------------------------
     * | Get amount 2 text attribute                               |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getAmount2TextAttribute()
    {
        return config('constant.default_currency_symbol') . $this->attributes['amount_2'];
    }

    /**
     * -------------------------------------------------------------
     * | Get discount 2 text attribute                             |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getDiscount2TextAttribute()
    {
        return $this->attributes['discount_2'] . config('constant.percentage_symbol');
    }
}
