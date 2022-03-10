<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsPaper extends Model
{
    protected $table = 'cms_papers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cms_id','paper_id'
    ];

    /**
     * -------------------------------------------------------------
     * | Get that paper cms content                                |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
    */
    public function paper(){
        return $this->belongsTo('App\Models\Paper','paper_id');
    }
}
