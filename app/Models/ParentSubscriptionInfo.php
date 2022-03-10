<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class ParentSubscriptionInfo extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','parent_id','card_number','name_on_card','expiry_date','cvv','is_subscribed','subscribed_at','canceled_at', 
        'subscription_id', 'payment_date','extra_charges','subscription_end_date'
    ];

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            if (Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string)Str::uuid();
                $query->subscribed_at = date('Y-m-d H:i:s');
                $query->is_subscribed = 1;
                $query->extra_charges = 1;
    
            }
        });
    }

    /**
     * get that own subscription
     *
     * @return void
     */
    public function subscription()
    {
        return $this->belongsTo('App\Models\Subscription', 'subscription_id');
    }

    /**
     * get that own parents
     *
     * @return void
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\ParentUser', 'parent_id');
    }
}
