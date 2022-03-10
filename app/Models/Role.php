<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{

    protected $table = 'roles';
    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'created_at', 'updated_at', 'guard_name',
    ];

    /**
     * set that strlower role name
     *
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower(str_replace('_', ' ', $name));
    }
}