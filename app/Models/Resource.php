<?php

namespace App\Models;

use App\Models\BaseModel;

class Resource extends BaseModel
{

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'title', 'resource_category_id', 'question_original_name', 'answer_original_name', 'status', 'question_stored_name', 'answer_stored_name',
    ];

    protected $appends = [];

    /**
     * -------------------------------------------------------------
     * | Get the category that owns the paper.                     |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function category()
    {
        return $this->belongsTo('App\Models\ResourceCategory', 'resource_category_id');
    }

    // Get title attribute
    public function getTitleAttribute($title)
    {
        return ucwords($title);
    }

}
