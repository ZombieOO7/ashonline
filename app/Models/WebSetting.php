<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'web_settings';
    public $timestamps = true;
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = ['logo', 'google_url', 'facebook_url', 'favicon', 'twitter_url', 'youtube_url', 'meta_keywords',
        'meta_description', 'amount_1', 'amount_2', 'discount_1', 'discount_2', 'code', 'rating_mail', 'code_status', 'notification_content'];
}
