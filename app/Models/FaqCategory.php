<?php

namespace App\Models;

use App\Models\BaseModel;

class FaqCategory extends BaseModel
{
    protected $table = 'faq_categories';

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [

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
     * | Get the faqs for the faq category.                        |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function faqs()
    {
        return $this->hasMany('App\Models\Faq', 'faq_category_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get the faqs for the faq category.                        |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function frontendFaqs()
    {
        return $this->hasMany('App\Models\Faq', 'faq_category_id')
            ->where('status', 1)
            ->where('deleted_at', null);
    }
}
