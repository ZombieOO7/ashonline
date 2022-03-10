<?php

namespace App\Models;

use App\Notifications\AdminResetPasswordNotification;
use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    protected $guard_name = 'admin';

    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'admins';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'email_verified_at', 'password', 'status', 'parent_id'];

    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['full_name'];

    /**
     * -------------------------------------------------------------
     * | set the enceypted password.                               |
     * |                                                           |
     * | @return $password                                         |
     * -------------------------------------------------------------
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * -------------------------------------------------------------
     * | set the enceypted password.                               |
     * |                                                           |
     * | @return $password                                         |
     * -------------------------------------------------------------
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);;
    }


    //Send password reset notification
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
    /**
     * -------------------------------------------------------------
     * | Get admin status active                                   |
     * |                                                           |
     * | @return PaperCategory                                     |
     * -------------------------------------------------------------
     */
    public function scopeActive($query, $status)
    {
        // dd($status);
        return $query->where('status', ($status == 'Active') ? 1 : 0);
    }
    /**
     * -------------------------------------------------------------
     * | Get admin not deleted                                     |
     * |                                                           |
     * | @return PaperCategory                                     |
     * -------------------------------------------------------------
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }
       /**
     * -------------------------------------------------------------
     * | Get full name                                             |
     * |                                                           |
     * | @return PaperCategory                                     |
     * -------------------------------------------------------------
     */

  
    public function getFullNameAttribute()
    {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }
}
