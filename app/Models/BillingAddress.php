<?php

namespace App\Models;

use App\Models\BaseModel;

class BillingAddress extends BaseModel
{
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = ['uuid', 'order_id', 'uuid', 'email', 'first_name', 'last_name', 'phone', 'address1', 'address2', 'city', 'postal_code', 'state', 'country', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['full_name', 'short_city'];

    // Get user full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    
    /**
     * -------------------------------------------------------------
     * | Get the order of that own billingAddress.                 |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    // Get short city name
    public function getShortCityAttribute()
    {
        return (strlen($this->city) > 10) ? substr($this->city, 0, 10) . '...' : $this->city;
    }
}
