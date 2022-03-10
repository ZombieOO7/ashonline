<?php

namespace App\Models;

use App\Notifications\ParentResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class ParentUser extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use SoftDeletes {
        SoftDeletes::restore as sfRestore;
    }

    protected $table = 'parents';
    protected $guard = 'parent'; //For guard
    protected $broker = 'parents';

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'uuid', 'first_name', 'last_name', 'middle_name', 'full_name', 'dob', 'gender', 'email', 'region', 'council', 'country_id',
        'password', 'address', 'address2', 'city', 'zip_code', 'mobile', 'profile_pic', 'status', 'email_verified_at', 'remember_token', 'state', 'country', 'is_tuition_parent', 'is_verify'
        , 'last_sign_in_at', 'current_sign_in_at', 'session_id', 'subscription_status', 'subscription_cancel_date', 'subscription_start_date', 'subscription_end_date',
        'card_number','name_on_card','expiry_date','cvv','subscription_id'
    ];

    protected $appends = ['active_tag', 'active_text', 'proper_created_at'];

    public function expiredStatusUpdated($id)
    {
        $StatusUpdate = self::find($id);
        $StatusUpdate->update(['status' => 2]);
    }

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
     * | set the email in lowercase.                               |
     * |                                                           |
     * | @return $password                                         |
     * -------------------------------------------------------------
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    /**
     * -------------------------------------------------------------
     * | Set parent Dob                                            |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function setDobAttribute($dob)
    {
        $this->attributes['dob'] = date('Y-m-d', strtotime($dob));
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->uuid = (string)Str::uuid();
            // $query->full_name = $query->first_name.' '.$query->middle_name.' '.$query->last_name;
        });
        static::updating(function ($parent) {
            // $parent->full_name = $parent->first_name.' '.$parent->middle_name.' '.$parent->last_name;
            $parent->childs()->update(['active' => $parent->status]);
        });
        static::deleting(function ($parent) {
            $parent->childs()->delete();
        });
    }

    /**
     * -------------------------------------------------------------
     * | Get records with status active                            |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActiveSearch($query, $status)
    {
        if($status == config('constant.active')){
            $status = 1;
        }else if($status == config('constant.inactive')){
            $status = 0;
        }else{
            $status = 2;
        }
        return $query->where('status', $status);
    }

    /**
     * -------------------------------------------------------------
     * | Get records with status active                            |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function getActiveTextAttribute()
    {
        $value = $this->status;
        $status = __('general.inactive');
        if ($value) {
            $status = __('general.active');
        }
        return $status;
    }

    /**
     * -------------------------------------------------------------
     * | Get records with status active tag                        |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function getActiveTagAttribute()
    {
        $value = $this->attributes['status'];
        if ($value == config('constant.active_0')) {
            $status = '<span class="m-badge  m-badge--danger m-badge--wide">' . __('general.inactive') . '</span>';
        } else {
            $status = '<span class="m-badge  m-badge--success m-badge--wide">' . __('general.active') . '</span>';
        }
        return $status;
    }

    /**
     * This function is used for getting created date in d/m/y
     *
     * @return void
     */
    public function getProperCreatedAtAttribute()
    {
        $value = $this->attributes['created_at'];
        return '<span class="hid_spn">' . date('Ymd', strtotime($value)) . '</span>' . date('d-m-Y', strtotime($value));
    }

    /**
     * This function is used for getting birth of date in d/m/y
     *
     * @return void
     */
    public function getDobTextAttribute()
    {
        return date('m/d/Y', strtotime($this->dob));
    }

    /**
     * get that own parent child or student
     *
     * @return void
     */
    public function childs()
    {
        return $this->hasMany('App\Models\Student', 'parent_id')->orderBy('id','asc');
    }

    /**
     * -------------------------------------------------------------
     * | Get active scope                                          |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * -------------------------------------------------------------
     * | Get not deleted scope                                     |
     * |                                                           |
     * | @param $query |
     * -------------------------------------------------------------
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * -------------------------------------------------------------
     * | Get Auth user password                                    |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getImageThumbAttribute()
    {
        $file = config('constant.app_path') . config('constant.user_profile_folder') . $this->id . '/' . $this->profile_pic;
        $avatarPath = !empty($this->profile_pic) && file_exists($file) ? url($file) : asset('newfrontend/images/profile_image.png');
        return asset($avatarPath);
    }

    //Send password reset notification
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ParentResetPasswordNotification($token));
    }

    /**
     * get that own parent first name with email
     *
     * @return void
     */
    public function getFullNameWithEmailAttribute()
    {
        return $this->full_name . ' (' . $this->email . ') ';
    }

    /**
     * get that own parent child or student
     *
     * @return void
     */
    public function child()
    {
        return $this->hasOne('App\Models\Student', 'parent_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\ParentAddress', 'parent_id')->orderBy('id');
    }

    public function paperReviews()
    {
        return $this->hasMany('App\Models\Review', 'parent_id', 'id')->where('paper_id', '!=', null)->orderBy('id');
    }

    public function mockRatings()
    {
        return $this->hasMany('App\Models\PurchasedMockTest', 'parent_id', 'id')->where('feedback_status', '!=', 0)->orderBy('id');
    }

    /**
     * Get subject data
     */
    public function getCountry()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    /**
     * get that own parent child or student
     *
     * @return void
     */
    public function getChildCountAttribute()
    {
        return @$this->childs->count()??0;
    }

     /**
     * get subscription
     *
     * @return void
     */

    public function subscription()
    {
        return $this->belongsTo('App\Models\Subscription','subscription_id');
    }

    /**
     * get user subscription trial end date.
     */
    public function getTrialEndDateAttribute()
    {
        $date = $this->created_at;
        $date->addDays(7);
        return $date->format('d-m-Y');
    }

    /**
     * get user last login date time.
     */
    public function getLastLoginAttribute()
    {
        return date('d-m-Y H:i:s',strtotime($this->last_sign_in_at));
    }

    /**
     * get user last login date time.
     */
    public function lastSubscription()
    {
        return $this->hasOne('App\Models\ParentSubscriptionInfo','parent_id')->orderBy('id','desc');
    }

    /**
     * get user subscription end date.
     */
    public function getProperSubscriptionEndDateAttribute()
    {
        return date('d-m-Y',strtotime($this->subscription_end_date));
    }

    /**
     * get child school years.
     */
    public function getChildSchoolYearsAttribute()
    {
        return $this->childs->pluck('school_year')->toArray();
    }
}
