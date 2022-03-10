<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    use Notifiable;
    use SoftDeletes {
        SoftDeletes::restore as sfRestore;
    }

    protected $appends = ['status_text', 'proper_created_at', 'status_tag'];

    /**
     * This function is used for getting table name
     *
     * @return void
     */
    public function getTableName()
    {
        return $this->getTable();
    }

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
     * This function is used for getting created date in d-m-y
     *
     * @return void
     */
    public function getCreatedAtAttribute($value)
    {
        // $value = $this->attributes['created_at'];
        return date('d-m-Y', strtotime($value));
    }

     /**
     * -------------------------------------------------------------
     * | Set Active Text                                           |
     * |                                                           |
     * | @return void                                              |
     * -------------------------------------------------------------
     */
  
    public function getStatusTextAttribute()
    {
        $value = $this->status;
        $status = __('admin/table.inactive');
        if ($value) {
            $status = __('admin/table.active');
        }
        return $status;
    }

      /**
     * -------------------------------------------------------------
     * | Set Active in Li                                          |
     * |                                                           |
     * | @return void                                              |
     * -------------------------------------------------------------
     */
    
    public function getStatusTagAttribute()
    {
        $value = $this->status;
        $status = "<span class='m-badge  m-badge--danger m-badge--wide'>" . __('admin/table.inactive') . "</span>";
        if ($value) {
            $status = "<span class='m-badge  m-badge--success m-badge--wide'>" . __('admin/table.active') . "</span>";
        }
        return $status;
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
        return $query->where('status', ($status == 'Active') ? config('constant.status_active_value'):config('constant.status_inactive_value'));
    }

    /**
     * -------------------------------------------------------------
     * | Get records with status active                            |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeProperActive($query, $status)
    {
        return $query->where('active', ($status == 'Active') ? config('constant.status_active_value'):config('constant.status_inactive_value'));
    }

    /**
     * -------------------------------------------------------------
     * | Get records with status active                            |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActiveSearchStatus($query, $status)
    {
        return $query->where('status', ($status == 1) ? config('constant.status_active_value'):config('constant.status_inactive_value'));
    }

    /**
     * This function is used for getting created date in d/m/y
     *
     * @return void
     */
    public function getProperPaymentDateAttribute()
    {
        $value = $this->attributes['created_at'];
        return date('d-m-Y', strtotime($value));
    }

    /**
     * -------------------------------------------------------------
     * | Get stages status active                                  |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeStatusSearch($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Set Active in List  // By->Yugank
     *
     * @return void
     */
    public function getActiveTagAttribute()
    {
        $value = $this->active;
        $status = "<span class='m-badge  m-badge--danger m-badge--wide'>" . __('general.inactive') . "</span>";
        if ($value) {
            $status = "<span class='m-badge  m-badge--success m-badge--wide'>" . __('general.active') . "</span>";
        }
        return $status;
    }

    /**
     * This function is used for getting start date in d-m-y
     *
     * @return void
     */
    public function getProperUpdatedAtAttribute()
    {
        $value = $this->attributes['updated_at'];
        return date('d-m-Y', strtotime($value));
    }

    /**
     * -------------------------------------------------------------
     * | Get records with status active                            |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}
