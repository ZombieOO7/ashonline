<?php

namespace App\Models;

class ResourceCategory extends BaseModel
{
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'uuid', 'name', 'content', 'status', 'slug',
    ];

    // Get name attribute
    public function getNameAttribute($name)
    {
        return ucwords($name);
    }
}
