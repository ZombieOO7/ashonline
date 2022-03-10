<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockTestOrderHistory extends Model
{
    protected $primaryKey = 'mock_test_id';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mock_test_id','parent_id','order_id','status'
    ];
}
