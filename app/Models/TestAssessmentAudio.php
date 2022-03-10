<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAssessmentAudio extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'test_assessment_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_assessment_id','seq','interval','audio'
    ];

    /**
     * get that own test grade
     *
     * @return void
     */
    public function mockTest()
    {
        return $this->belongsTo('App\Models\TestAssessment','id','test_assessment_id');
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getAudioPathAttribute()
    {
        $path = ($this->audio !=null && file_exists(storage_path(config('constant.test-assessment.storage_path').$this->audio))) ? 
        url(config('constant.test-assessment.url_path').$this->audio) : null;
        return $path;
    }
}
