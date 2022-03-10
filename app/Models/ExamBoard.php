<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamBoard extends BaseModel
{
    use Sluggable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','slug','status','content'
    ];


    /**
     * get that own test subjects
     *
     * @return void
     */
    public function mockTests()
    {
        $today = Carbon::now();
        return $this->hasMany('App\Models\MockTest','exam_board_id','id')
                    ->where('end_date','!=',null)
                    ->whereDate('end_date','>=',$today)
                    ->orderBy('created_at','desc')
                    ->active();
    }

    /**
     * get that own test subjects
     *
     * @return void
     */
    public function relatedMockTests()
    {
        $today = Carbon::now();
        return $this->hasMany('App\Models\MockTest','exam_board_id','id')
                    ->where('end_date','!=',null)
                    ->whereDate('end_date','>=',$today)
                    ->orderBy('created_at','desc')
                    ->active()
                    ->limit(5);
    }

    /**
     * -------------------------------------------------------------
     * | Get that exam related mock test                           |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
    */
    public function relatedMockTestsLogin()
    {
        $today = Carbon::now();
        return $this->hasMany('App\Models\MockTest','exam_board_id','id')
            ->where('end_date','!=',null)
            ->whereDate('end_date','>=',$today)
            ->where('show_mock','=',2)
            ->orderBy('created_at','desc')
            ->active()
            ->limit(5);
    }

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

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string) \Str::uuid();
            }
            $query->content = trimContent($query->content);
        });
        self::updating(function ($query) {
            $query->content = trimContent($query->content);
        });
    }
}
