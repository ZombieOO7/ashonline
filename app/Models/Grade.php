<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','title','slug','status'
    ];

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
        });
        self::updating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
        });
    }
}
