<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'title', 'description', 'currency', 'price', 'status', 'type', 'payment_date', 'daily_charge'
    ];

}
