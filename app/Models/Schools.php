<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

   
class Schools extends Model
{

    use SoftDeletes;
    use SoftDeletes {
    SoftDeletes::restore as sfRestore;
    }
    
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable =[
        'uuid', 'school_name', 'exam_board', 'categories','created_at', 'active','is_multiple'
    ];

    protected $appends = ['active_tag','active_text','proper_created_at'];

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
            $query->school_name = trimContent($query->school_name);
        });
        static::updating(function ($query) {
            $query->school_name = trimContent($query->school_name);
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
        return $query->where('active', ($status == config('constant.active')) ? 1 : 0);
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
        $value = $this->active;
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
        $value = $this->attributes['active'];
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
     * get that own school exam board
     *
     * @return void
     */
    public function examBoard()
    {
        return $this->belongsTo('App\Models\ExamBoard','categories');
    }
}
