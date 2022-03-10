<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentPaymentDetail extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','parent_id','parent_id','card_number','name_on_card','expire_date','cvv'
    ];

}
