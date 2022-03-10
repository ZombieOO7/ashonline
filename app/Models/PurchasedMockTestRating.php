<?php

namespace App\Models;

class PurchasedMockTestRating extends BaseModel
{
    protected $table= 'purchased_mock_tests_ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =[
        'mock_test_id', 'parent_id','rating','msg'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
      * Get that  unattempted answer count
    */
    public function user()
    {
        return $this->belongsTo('App\Models\ParentUser','parent_id');
    }

    /**
      * Get that created at attribute in human readable format
    */
    public function getCreatedAtHumanFormateAttribute(){
        return \Carbon\Carbon::parse($this->created_at)->diffForHumans();
    }

    /**
      * Get that created at attribute in human readable format
    */
    public function getReviewDateAttribute()
    {
        return date(strtotime('M d, Y'),$this->created_at);
    }
}