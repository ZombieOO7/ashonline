<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    protected $table = 'images';
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path', 'created_by', 'updated_by', 'status','deleted_at','extension','mime_type','original_name'
    ];

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getImagePathAttribute()
    {
        $path = ($this->path != null && file_exists(storage_path(config('constant.image.storage_path') . $this->path))) ?
            url(config('constant.image.url_path') . $this->path) : asset('images/default.png');
        return $path;
    }
}
