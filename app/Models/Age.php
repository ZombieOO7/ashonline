<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Age extends Model
{
    use SoftDeletes;
    protected $table = 'ages';
    
    /**
     * -------------------------------------------------------------
     * | Get Age status active                                     |
     * |                                                           |
     * | @return PaperCategory                                     |
     * -------------------------------------------------------------
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
