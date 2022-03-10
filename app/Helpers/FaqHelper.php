<?php

namespace App\Helpers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqHelper extends BaseHelper
{
    protected $faq, $faqCategory;
    public function __construct(Faq $faq, FaqCategory $faqCategory)
    {
        $this->faq = $faq;
        $this->faqCategory = $faqCategory;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Faq List                                       |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function faqList()
    {
        return $this->faq::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | FAQ detail by id                                   |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->faq::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | FAQ store                                          |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        $faq = Faq::updateOrCreate(['id'=>@$request->id],$request->all());
        return $faq;
    }

    /**
     * ------------------------------------------------------
     * | Update status                                      |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function statusUpdate($uuid)
    {
        $faq = $this->detail($uuid);
        $status = $faq->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->faq::where('id', $faq->id)->update(['status' => $status]);
        return $status;
    }

    /**
     * ------------------------------------------------------
     * | FAQ detail by uuid                                 |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->faq::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Delete ExamType                                    |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $faq = $this->detail($uuid);
        $faq->delete();
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple FAQ                                         |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $faq = $this->faq::whereIn('id', $request->ids);
        // check if request action is delete
        if ($request->action == config('constant.delete')) {
            $faq->delete();
            return;
        }
        $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $faq->update(['status' => $status]);
    }

    /**
     * ---------------------------------------------------------------
     * | Get FAQ List                                                |
     * |                                                             |
     * ---------------------------------------------------------------
     */
    public function faqCategoryList()
    {
        return $this->faqCategory::pluck('title', 'id');
    }

    /**
     * ---------------------------------------------------------------
     * | Get All FAQs                                                |
     * |                                                             |
     * ---------------------------------------------------------------
     */
    public function getAllFaqs()
    {
        return $this->faqCategory::whereHas('frontendFaqs')
            ->whereStatus(1)
            ->whereNull('deleted_at')
            ->get();
    }

    /**
     * ---------------------------------------------------------------
     * | Get FAQ details using slug                                  |
     * |                                                             |
     * ---------------------------------------------------------------
     */
    public function getFaqBySlug($slug) 
    {
        return $this->faq::whereSlug($slug)
            ->whereStatus(1)
            ->whereNull('deleted_at')
            ->first();
    }
}
