<?php

namespace App\Models;

use App\Models\BaseModel;

class Stage extends BaseModel
{
    protected $table = 'stages';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'title', 'status', 'created_at', 'updated_at', 'uuid', 'deleted_at',
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
     * | Get Active stages                                         |
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
     * | Get stages not deleted                                    |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

}
