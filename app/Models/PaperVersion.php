<?php

namespace App\Models;

use App\Models\BaseModel;

class PaperVersion extends BaseModel
{
    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'paper_versions';

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = ['uuid','version','paper_id','pdf_name','pdf_path','original_name'];

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
     * | Get paper data of version                                 |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function paper()
    {
        return $this->belongsTo('App\Models\Paper','paper_id');
    }
}
