<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasRoles;
    protected $table = 'permissions';
    protected $guard_name = 'admin';

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'name', 'guard_name', 'created_at', 'updated_at',
    ];
}
