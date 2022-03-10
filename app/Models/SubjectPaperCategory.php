<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectPaperCategory extends Model
{
    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'subject_paper_categories';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'paper_category_id', 'subject_id',
    ];

    /**
     * -------------------------------------------------------------
     * | Get the paper category that owns subject.                 |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function paperCategory()
    {
        return $this->belongsTo('App\Models\PaperCategory','paper_category_id');
    }
    /**
     * -------------------------------------------------------------
     * | Get the paper that owns the order items.                  |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject','subject_id');
    }
}
