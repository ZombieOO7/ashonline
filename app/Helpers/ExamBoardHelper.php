<?php

namespace App\Helpers;

use App\Models\ExamBoard;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class ExamBoardHelper extends BaseHelper
{
    protected $examBoard, $faqCategory;
    public function __construct(ExamBoard $examBoard, FaqCategory $faqCategory)
    {
        $this->examBoard = $examBoard;
        $this->faqCategory = $faqCategory;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Faq List                                       |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function list()
    {
        return $this->examBoard::orderBy('id', 'desc');
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
        return $this->examBoard::whereId($id)->first();
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
        $examBoard = ExamBoard::updateOrCreate(['id'=>@$request->id],$request->all());
        return $examBoard;
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
        $examBoard = $this->detail($uuid);
        $status = $examBoard->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->examBoard::where('id', $examBoard->id)->update(['status' => $status]);
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
        return $this->examBoard::where('uuid', $uuid)->first();
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
        $examBoard = $this->detail($uuid);
        $examBoard->delete();
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
        $examBoard = $this->examBoard::whereIn('id', $request->ids);
        // check if request action is delete
        if ($request->action == config('constant.delete')) {
            $examBoard->delete();
            return;
        }
        $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $examBoard->update(['status' => $status]);
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
        return $this->examBoard::whereSlug($slug)
            ->whereStatus(1)
            ->whereNull('deleted_at')
            ->first();
    }
}
