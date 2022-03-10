<?php

namespace App\Models;

use App\Models\BaseModel;

class ExamType extends BaseModel
{
    public $timestamps = true;

    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */

    protected $table = 'exam_types';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'title', 'slug', 'status', 'created_at', 'updated_at', 'uuid', 'paper_category_id', 'deleted_at',
    ];

    /**
     * -------------------------------------------------------------
     * | The storage format of the model's date columns.           |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    public $dates = [
        'deleted_at',
    ];
    
    /**
     * -------------------------------------------------------------
     * | Get active examtypes                                      |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * -------------------------------------------------------------
     * | Get examtypes not deleted                                 |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * -------------------------------------------------------------
     * | Get the category that owns the paper.                     |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function category()
    {
        return $this->belongsTo('App\Models\PaperCategory', 'paper_category_id');
    }
}
