<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ReviewHelper;
use Exception;
use Illuminate\Http\Request;
use Lang;
use View;
use Yajra\Datatables\Datatables;

class ReviewController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.review.';
    public function __construct(ReviewHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * -------------------------------------------------
     * | Display Review list                           |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $reviewStatusList = $this->reviewstatusList();
        return view($this->viewConstant . 'index', ['reviewStatusList' => @$reviewStatusList]);
    }

    /**
     * -------------------------------------------------
     * | Get Review datatable data                     |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $draw = intval($request->draw) + 1 ;
            $limit = @$request->length?? 10;
            $start = @$request->start ?? 0;
            $reviews = $this->helper->reviewList();
            $itemQuery = $reviews->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $reviewList = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return Datatables::of($reviewList)
                ->addColumn('email', function ($review) {
                    return @$review->order->biilingAddress->email;
                })
                // ->editColumn('paper', function ($review) {
                //     return @$review->paper->title;
                // })
                ->addColumn('rate', function ($review) {
                    return $this->getPartials($this->viewConstant .'__rate',['review'=>$review]);
                })
                ->addColumn('review', function ($review) {
                    return $this->getPartials($this->viewConstant .'__review',['review'=>$review]);
                })
                ->addColumn('paper', function ($review) {
                    return $this->getPartials($this->viewConstant .'__paper',['review'=>$review]);
                })
                ->editColumn('mock_test_id', function ($review) {
                    return @$review->mock->title;
                })
                ->addColumn('action', function ($review) {
                    return $this->getPartials($this->viewConstant .'_add_action',['review'=>$review]);
                })
                ->editColumn('status', function ($review) {
                    return $this->getPartials($this->viewConstant .'_add_status',['review'=>$review]);
                })
                ->addColumn('checkbox', function ($review) {
                    return $this->getPartials($this->viewConstant .'_add_checkbox',['review'=>$review]);
                })
                ->editColumn('created_at', function ($review) {
                    return $review->proper_created_at;
                })
                ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
                ->rawColumns(['created_at', 'action', 'email', 'review', 'status', 'checkbox', 'paper', 'rate','mock_test_id'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Get review detail                             |
     * |                                               |
     * | @param Request $uuid                          |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function show($id = null)
    {
        $review = $this->helper->detailById($id);
        return view($this->viewConstant . 'view', ['review' => @$review]);
    }

    /**
     * -------------------------------------------------
     * | Update review status details                  |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        if (isset($request->id)) {
            $this->helper->statusUpdate($request->id, $request->status);
            return response()->json(['msg' => __('formname.review.status'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Delete multiple review details                |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multideleteReview(Request $request)
    {
        $this->helper->multiDelete($request);
        // check if request action is active, inactive or delete
        if ($request->action == config('constant.review_inactive') || $request->action == config('constant.review_active')) {
            return response()->json(['msg' => __('formname.review.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.review.delete'), 'icon' => __('admin_messages.icon_success')]);
    }

    /**
     * -------------------------------------------------
     * | Delete review details                         |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        // check if request has id
        if (isset($request->id)) {
            $this->helper->delete($request->id);
            return response()->json(['msg' => __('formname.review.delete'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

}
