<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentAddress extends BaseModel
{
    protected $table= 'parent_addresses';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = ['uuid', 'parent_id', 'address', 'address2', 'city', 'postal_code', 'state', 'country', 'default', 'created_at', 'updated_at', 'deleted_at'];



    /**
     * -------------------------------------------------------------
     * | Get the order of that own billingAddress.                 |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\ParentUser', 'parent_id');
    }


}
