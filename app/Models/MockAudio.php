<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockAudio extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'mock_test_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mock_test_id','seq','interval','audio'
    ];

    /**
     * get that own test grade
     *
     * @return void
     */
    public function mockTest()
    {
        return $this->belongsTo('App\Models\MockTest','id','mock_test_id');
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getAudioPathAttribute()
    {
        $path = ($this->audio !=null && file_exists(storage_path(config('constant.mock-test.storage_path').$this->audio))) ? 
        url(config('constant.mock-test.url_path').$this->audio) : null;
        return $path;
    }
}
