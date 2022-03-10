<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockTestSubject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mock_test_id', 'subject_id','mock_test_paper_id'
    ];
    
    /**
     * get that own mock test subject
     *
     */
    public function subject(){
        return $this->belongsTo('App\Models\Subject','subject_id');
    }
}
