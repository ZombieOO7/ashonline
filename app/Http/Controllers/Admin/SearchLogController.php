<?php

namespace App\Http\Controllers\Admin;

use App\Models\SearchLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Yajra\Datatables\Datatables;

class SearchLogController extends BaseController
{
    public $viewConstant = 'admin.search_logs.';
    
    /**
     * -------------------------------------------------
     * | Display Stages list                           |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        return view($this->viewConstant . 'index');
    }

    /**
     * -------------------------------------------------
     * | Get Stage datatable date                      |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $draw = intval($request->draw) + 1 ;
            $limit = @$request->length?? 10;
            $start = @$request->start ?? 0;
            $itemQuery = SearchLog::query();
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $logs = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return Datatables::of($logs)
                ->addColumn('action', function ($logs) {
                    return $this->getPartials($this->viewConstant .'_add_action',['logs' => $logs]);
                })
                ->addColumn('checkbox', function ($logs) {
                    return $this->getPartials($this->viewConstant .'_add_checkbox',['logs'=>@$logs]);
                })
                ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
                ->rawColumns(['created_at', 'checkbox', 'action'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Delete Log details                            |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        // check if request has id
        if (isset($request->id)) {
            SearchLog::whereUuid($request->id)->delete();
            return response()->json(['msg' => __('admin_messages.paper_search_logs_deleted_msg'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => Lang::get('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }

     /**
     * -------------------------------------------------
     * | Delete multiple Logs                          |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multidelete(Request $request)
    {
        $faq = SearchLog::whereIn('id', $request->ids);
        $faq->delete();
        return response()->json(['msg' => __('admin_messages.paper_search_logs_deleted_msg'), 'icon' => __('admin_messages.icon_success')]);
    }
}
