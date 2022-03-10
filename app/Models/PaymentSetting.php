<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $table = 'payment_settings';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'id', 'uuid', 'payment_type', 'stripe_key', 'stripe_secret', 'stripe_currency', 'stripe_mode', 'paypal_client_id',
        'paypal_sandbox_api_username', 'paypal_sandbox_api_password', 'paypal_sandbox_api_secret', 'paypal_currency', 
        'paypal_sandbox_api_certificate', 'paypal_mode', 'status',
    ];

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string) \Str::uuid();
            }
        });
    }
}
