<?php

namespace App\Models;


class Review extends BaseModel
{
    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'reviews';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'paper_id', 'order_id', 'content', 'rate', 'status', 'created_at', 'updated_at', 'uuid','parent_id'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
    /**
     * -------------------------------------------------------------
     * | Get review of order billing address                       |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function billingDetail()
    {
        return $this->belongsTo('App\Models\BillingAddress', 'order_id');
    }
    /**
     * -------------------------------------------------------------
     * | Get review of order paper detail                          |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function paper()
    {
        return $this->belongsTo('App\Models\Paper', 'paper_id');
    }
    /**
     * -------------------------------------------------------------
     * | Get review status active                                  |
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
     * | Get review status active                                  |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActiveSearch($query, $status)
    {
        return $query->where('status', ($status == 'publish') ? 1 : 2);
    }

    /**
     * -------------------------------------------------------------
     * | Get review of order paper detail                          |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function mock()
    {
        return $this->belongsTo('App\Models\MockTest', 'mock_test_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get review of order paper detail                          |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\ParentUser', 'parent_id');
    }
}
