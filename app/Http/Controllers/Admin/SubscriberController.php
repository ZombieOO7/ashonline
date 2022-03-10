<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class SubscriberController extends BaseController
{
    protected $subscribe;
    public function __construct(Subscriber $subscribe)
    {
        $this->subscribe = $subscribe;
    }
    /**
     * -----------------------------------------------------
     * | Role list                                         |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function index(Request $request)
    {
        $data = $this->statusList();
        return view('admin.subscriber.index', ['statusList' => @$data]);
    }

    /**
     * -----------------------------------------------------
     * | Role datatables data                              |  
     * |                                                   |   
     * | @param Request $request                           |
     * | @return Response                                  |                 
     * -----------------------------------------------------
     */
    public function getDatatable(Request $request)
    {
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        $itemQuery = $this->subscribe->select('*');
        $count_total = $itemQuery->count();
        $itemQuery = $itemQuery->skip($start)->take($limit);
        $dataList = $itemQuery->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return Datatables::of($dataList)
            ->editColumn('created_at', function($item) {
                return '<span style="display: none;">'.date('Ymd', strtotime($item->proper_created_at)).'</span>'.$item->proper_created_at;
            })
            ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
            ->rawColumns(['checkbox', 'created_at'])
            ->skipPaging()
            ->make(true);
    }

    /**
     * -----------------------------------------------------
     * | Multiple Delete record                            |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function bulkAction(Request $request)
    {
        $this->subscribe::whereIn('id', $request->ids)->delete();
        return response()->json(['msg' => __('admin_messages.subscriber_deleted_msg'), 'icon' => __('admin_messages.icon_success')]);
    }
}