<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ContactUs extends BaseModel
{
    use SoftDeletes;
    protected $table = 'enquiry';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'phone', 'message', 'status', 'subject','created_at'
    ];

    /**
     * -------------------------------------------------------------
     * | Get created at attribute                                  |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    // public function getCreatedAtAttribute($date)
    // {
    //     return Date('d-m-Y', strtotime($date));
    // }

    /**
     * -------------------------------------------------------------
     * | Uppercase each character of a string                      |
     * |                                                           |
     * | @return String                                            |
     * -------------------------------------------------------------
     */
    public function getFullNameAttribute($value)
    {
        return ucwords($value);
    }
}
