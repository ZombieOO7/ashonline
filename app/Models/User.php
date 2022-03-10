<?php

namespace App\Models;

use Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard_name = 'web';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'status',
    ];

    protected $appends = ['status_text', 'full_name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Dates to be treated as Carbon instances.
     *
     * @var array
     */

    /**
     * This is use to hash password.
     *
     * @param hash $pass
     */
    // public function setPasswordAttribute($pass)
    // {
    //     $this->attributes['password'] = Hash::make($pass);
    // }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Auto-sets values on password creation.
    */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * get that own user full name.
     *
     */
    public function getFullNameAttribute()
    {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }

    /**
     * get that own user first name.
     */
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * get that own user last name.
     */
    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * get that own user status.
     */
    public function getStatusTextAttribute()
    {
        $status = $this->status;
        return $status == 1 ? 'Active' : 'Inactive';
    }

}
