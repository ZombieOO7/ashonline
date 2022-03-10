<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends BaseModel
{
    protected $fillable = [
        'mock_test_id','paper_id','parent_id','price'
    ];

    /**
     * -------------------------------------------------------------
     * | Get Order own billing address                             |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function paper()
    {
        return $this->belongsTo('App\Models\Paper', 'paper_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get Order own billing address                             |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function mockTest()
    {
        return $this->belongsTo('App\Models\MockTest', 'mock_test_id');
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
}
