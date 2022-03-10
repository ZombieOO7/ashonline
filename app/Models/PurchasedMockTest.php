<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasedMockTest extends BaseModel
{
    protected $table = 'purchased_mock_tests';

    /* Exatra details 
    * status 0=Pending, 1 =  In Progress, 2 = completed 
    /*

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'mock_test_id', 'status', 'uuid', 'parent_id', 'student_id','project_type'
    ];

    /**
     * -------------------------------------------------------------
     * | Get the mock test that owns the order items.              |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function mockTest()
    {
        return $this->belongsTo('App\Models\MockTest', 'mock_test_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the mock test that owns the order items.              |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function child()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the mock test that owns the order items.              |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function studentTest()
    {
        return $this->hasOne('App\Models\StudentTest', 'mock_test_id','mock_test_id')
                ->where('student_id',@$this->student_id)
                ->where('status','!=','0')
                ->orderBy('id','desc');
    }
}
