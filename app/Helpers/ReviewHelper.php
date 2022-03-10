<?php

namespace App\Helpers;

use App\Models\Paper;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewHelper extends BaseHelper
{
    protected $review;
    public function __construct(Review $review)
    {
        $this->review = $review;
        parent::__construct();
    }

    /**
     * ------------------------------------------------------
     * | Get review List                                    |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function reviewList()
    {
        return $this->review::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | review detail by id                                |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->review::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | review detail by uuid                              |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->review::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Update status                                      |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function statusUpdate($id, $status)
    {
        $review = $this->detailById($id);
        $status = $status == config('constant.review_active') ? config('constant.review_active_value') : config('constant.review_inactive_value');
        $this->review::where('id', $review->id)->update(['status' => $status]);
        $this->updatePaperAverageRate($review->paper_id);
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple Review                                      |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $review = $this->review::whereIn('id', $request->ids);
        $paperIds = $review->pluck('paper_id');
        $this->updateMultiPaperAverageRate($paperIds);
        // check if request action to delete record
        if ($request->action == config('constant.delete')) {
            $review->delete();
        } else {
            $status = $request->action == config('constant.review_active') ? config('constant.review_active_value') : config('constant.review_inactive_value');
            $review->update(['status' => $status]);
        }
    }
    /**
     * ------------------------------------------------------
     * | Delete Review                                      |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $review = $this->detail($uuid);
        $paperId = $review->paper_id;
        $review->delete();
        $this->updatePaperAverageRate($paperId);
    }

    /**
     * -------------------------------------------------------
     * | Update average of paper                             |   
     * |                                                     |
     * | @param $paperId                                     |
     * -------------------------------------------------------
     */
    public function updatePaperAverageRate($paperId) 
    {
        $query = Review::wherePaperId($paperId)->where('status',1);
        $paperReviews = $query->sum('rate');
        $totalPaperReviews = $query->count();
        $rate = 0.00;
        if($totalPaperReviews > 0 ) {
            $rate = $paperReviews / $totalPaperReviews;
        }
        Paper::whereId($paperId)->update(['avg_rate' => $rate]);
    }

    /**
     * -------------------------------------------------------
     * | Update average of paper                             |   
     * |                                                     |
     * | @param $paperId                                     |
     * -------------------------------------------------------
     */
    public function updateMultiPaperAverageRate($paperIds) 
    {
        foreach($paperIds as $key => $paperId){
            $query = Review::wherePaperId($paperId)->where('status',1);
            $paperReviews = $query->sum('rate');
            $totalPaperReviews = $query->count();
            $rate = 0.00;
            if($totalPaperReviews > 0 ) {
                $rate = $paperReviews / $totalPaperReviews;
            }
            Paper::whereId($paperId)->update(['avg_rate' => $rate]);
        }
    }

}
