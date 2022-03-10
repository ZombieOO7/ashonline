<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends BaseModel
{
    use SoftDeletes;
    use Sluggable;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','title','active','slug'
    ];

    /**
     * -------------------------------------------------------------
     * | Return the sluggable configuration array for this model.  |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => false,
            ],
        ];
    }
     /**
     * -------------------------------------------------------------
     * | Auto-sets values on creationl.                            |  
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string) \Str::uuid();
            }
            $query->title = trimContent($query->title);
        });
        static::updating(function ($query) {
            $query->title = trimContent($query->title);
        });
    }

    /**
     * get that own toic name.
     *
     */
    public function getTitleTextAttribute()
    {
        $name = ucwords($this->title);
        return $name;
    }

    /**
     * -------------------------------------------------------------
     * | Get records with status active                            |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActiveStatus($query, $status)
    {
        return $query->where('active', ($status == 'Active') ? config('constant.status_active_value'):config('constant.status_inactive_value'));
    }

    /**
     * -------------------------------------------------------------
     * | Get that topic result for student                         |
     * |                                                           |
     * | param $studentId                                          |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function studentTestResult($studentId=null)
    {
        return  $this->hasOne(PracticeTestResult::class,'topic_id')
                    ->where('student_id',$studentId)
                    ->orderBy('id','desc')
                    ->first();
    }

    /**
     * -------------------------------------------------------------
     * | Get question of topic                                     |
     * |                                                           |
     * | @return Object                                             |
     * -------------------------------------------------------------
     */
    public function questions()
    {
        return  $this->hasMany(Question::class,'topic_id')->whereQuestionType(1);
    }

    /**
     * -------------------------------------------------------------
     * | Get question of topic                                     |
     * |                                                           |
     * | @return Object                                             |
     * -------------------------------------------------------------
     */
    public function pastPaperQuestions()
    {
        return  $this->hasMany(PastPaperQuestion::class,'topic_id');
    }
}
