<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentMockTest extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'mock_test_id';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'parent_id','mock_test_id'
    ];
}
