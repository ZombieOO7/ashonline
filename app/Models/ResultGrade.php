<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ResultGrade extends BaseModel
{
    use SoftDeletes;
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'excellent_min','excellent_max','very_good_min','very_good_max','good_min','good_max','fair_min','fair_max',
        'improve_min','improve_max','mock_test_paper_id'
    ];

    /*
     * Auto-sets values on creation
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string) \Str::uuid();
            }
        });
    }

}
