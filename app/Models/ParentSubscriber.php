<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentSubscriber extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'subscriber_id'
    ];

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
