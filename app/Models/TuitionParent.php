<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TuitionParent extends Model
{
    use SoftDeletes;
    use SoftDeletes {
    SoftDeletes::restore as sfRestore;
    }
    
    protected $table= 'tution_parents';

    protected $fillable =[
        'uuid', 'first_name', 'last_name', 'middle_name', 'full_name', 'dob', 'gender', 'email', 
        'mobile', 'profile_pic', 'status'
    ];

    protected $appends = ['proper_created_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
        });
    }

     /**
     * -------------------------------------------------------------
     * | Get proper Created at attribute.                          |  
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function getProperCreatedAtAttribute()
    {
        $value = $this->attributes['created_at'];
        return '<span class="hid_spn">' . date('Ymd', strtotime($value)) . '</span>' . date('d-m-Y', strtotime($value));
    }
}
