<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TopicHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TopicFormRequest;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class TopicController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.topic.';
    public function __construct(TopicHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * -------------------------------------------------
     * | Display Topic list                            |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $statusList = $this->statusList();
        return view($this->viewConstant . 'index', ['statusList' => @$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Get Topic datatable data                      |
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
            $faqs = $this->helper->list();
            $itemQuery = $faqs->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeStatus($request->status);
                }
            });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $topicList = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return DataTables::of($topicList)
                ->addColumn('action', function ($topic) {
                    return $this->getPartials($this->viewConstant .'_add_action',['topic'=>@$topic]);
                })
                ->editColumn('status', function ($topic) {
                    return $this->getPartials($this->viewConstant .'_add_status',['topic'=>@$topic]);
                })
                ->editColumn('created_at', function ($topic) {
                    return $topic->proper_created_at;
                })
                ->addColumn('checkbox', function ($topic) {
                    return $this->getPartials($this->viewConstant .'_add_checkbox',['topic'=>@$topic]);
                })
                ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
                ->rawColumns(['created_at', 'checkbox', 'action', 'status'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Topic page                             |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($uuid = null)
    {
        // check if request has uuid or not
        if (isset($uuid)) {
            $topic = $this->helper->detail($uuid);
        }
        $title = isset($uuid) ? trans('formname.topic.update') : trans('formname.topic.create');
        return view($this->viewConstant . 'create', ['topic' => @$topic, 'title' => @$title]);
    }

    /**
     * -------------------------------------------------
     * | Store Topic details                           |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(TopicFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            $msg = isset($request->id)?__('formname.topic.updated'):__('formname.topic.created');
            $this->helper->dbEnd();
            return Redirect::route('topic.index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            abort('404');
        }
    }
    /**
     * -------------------------------------------------
     * | Delete Topic details                          |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        // check if request has id or not
        if (isset($request->id)) {
            $this->helper->delete($request->id);
            return response()->json(['msg' => __('formname.topic.deleted'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }
    /**
     * -------------------------------------------------
     * | Delete multiple Stage                         |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multidelete(Request $request)
    {
        $this->helper->multiDelete($request);
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            return response()->json(['msg' => __('formname.topic.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.topic.deleted'), 'icon' => __('admin_messages.icon_success')]);
    }
    /**
     * -------------------------------------------------
     * | Update Stage status details                   |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        // check if request has id or not
        if (isset($request->id)) {
            $status = $this->helper->statusUpdate($request->id);
            return response()->json(['msg' => __('formname.topic.status'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }
}
