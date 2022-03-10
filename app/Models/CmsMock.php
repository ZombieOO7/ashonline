<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsMock extends Model
{
    protected $table = 'cms_mocks';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cms_id','mock_test_id'
    ];
}
