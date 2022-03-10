<?php

namespace App\Helpers;

use App\Models\Order;
use App\Models\Paper;
use App\Models\OrderItem;
use App\Models\PaperCategory;
use App\Models\Subject;
use Carbon\Carbon;

class ReportHelper extends BaseHelper
{
    protected $order,$items, $paper;
    public function __construct(Paper $paper,Order $order,OrderItem $items,PaperCategory $paperCategory, Subject $subject)
    {
        $this->order = $order;
        $this->paper = $paper;
        $this->items = $items;
        $this->paperCategory = $paperCategory;
        $this->subject = $subject;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Sold Paper Order Report List                   |
     * | @param Request $request                            |
     * | months, year, categoryIds and subjectIds           |
     * | @return Array                                      |
     * |-----------------------------------------------------
     */
    public function orderList($request=null)
    {
        $categoryIds = $request->categoryIds;
        $subjectIds = $request->subjectIds;
        $months = $request->months;
        $year = $request->year;
        $papers = $this->paper::where(function($q) use($categoryIds,$subjectIds){
                    // check if request has category ids
                    if(@$categoryIds)
                        $q->whereIn('category_id',$categoryIds);
                    if(@$subjectIds)
                        $q->whereIn('subject_id',$subjectIds);
                    })
                    ->whereHas('orderItems',function($query) use($year,$months){
                        $query->whereHas('order',function($q) use($year,$months){
                            $q->whereYear('created_at',$year);
                            foreach($months as $key => $month)
                                if($key == 0)
                                    $q->whereMonth('created_at',$month);
                                else
                                    $q->orWhereMonth('created_at',$month);
                        });
                    })
                    ->withCount(['orderItems as order_items_count'=>function ($query) use($year,$months){
                        $query->whereHas('order',function($q) use($year,$months){
                            $q->whereYear('created_at',$year);
                            foreach($months as $key => $month)
                                if($key == 0)
                                    $q->whereMonth('created_at',$month);
                                else
                                    $q->orWhereMonth('created_at',$month);
                        });
                    }
                    ])
                    ->active()
                    ->notDeleted()
                    ->orderBy('category_id', 'asc')
                    ->orderBy('title', 'asc')
                    ->get();
        return @$papers;
    }

    /**
     * -------------------------------------------------------------
     * | Get Paper Category List                                   |
     * |                                                           |
     * | @return Response                                          |
     * -------------------------------------------------------------
     */
    public function paperCategories(){
        $paperCategories = $this->paperCategory->active()
            ->notDeleted()
            ->orderByRaw('LENGTH(title) ASC')
            ->orderBy('title', 'ASC')
            ->pluck('title', 'id');
        return @$paperCategories;
    }

    /**
     * -------------------------------------------------------------
     * | Get Subject List                                          |
     * |                                                           |
     * | @return Response                                          |
     * -------------------------------------------------------------
     */
    public function subjects()
    {
        return Subject::active()
            ->notDeleted()
            ->orderBy('order_seq','ASC')
            ->pluck('title', 'id');
    }

    /**
     * -------------------------------------------------------------
     * | Get Subject List                                          |
     * |                                                           |
     * | @return Response                                          |
     * -------------------------------------------------------------
     */
    public function reportSubjects()
    {
        return Subject::active()
            ->notDeleted()
            ->orderBy('title','ASC')
            ->pluck('title', 'id');
    }
}
