<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class PaperKeyword extends Model
{
    
    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'paper_keywords';

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'title', 'paper_id','created_at','updated_at','uuid'
    ];

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            $query->uuid = (string) \Str::uuid();
        });
    }
    /**
     * get that papers keywords
     *
     */
    public function paper() 
    {
        return $this->belongsTo('App\Models\Paper','paper_id');
    }
}
