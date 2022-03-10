<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PaperCategoryHelper;
use App\Http\Requests\Admin\PaperCategoryFormRequest;
use Exception;
use Illuminate\Http\Request;
use Lang;
use Redirect;
use View;
use Yajra\Datatables\Datatables;

class PaperCategoryController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.paper-category.';
    public function __construct(PaperCategoryHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * -------------------------------------------------
     * | Display Paper Categories list                 |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $data = $this->statusList();
        return view($this->viewConstant . 'index', ['statusList' => $data]);
    }

    /**
     * -------------------------------------------------
     * | Get Paper Category datatable date             |
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
            $paperCategories = $this->helper->PaperCategoryList();
            $itemQuery = $paperCategories->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $paperCategoriesList = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return Datatables::of($paperCategoriesList)
                ->editColumn('color_code', function ($paperCategory) {
                    return $this->getPartials($this->viewConstant .'_add_color_code',['paperCategory' => @$paperCategory]);
                })
                ->addColumn('action', function ($paperCategory) {
                    return $this->getPartials($this->viewConstant .'_add_action',['paperCategory' => @$paperCategory]);
                })
                ->editColumn('status', function ($paperCategory) {
                    return $this->getPartials($this->viewConstant .'_add_status',['paperCategory' => @$paperCategory]);
                })
                ->editColumn('created_at', function ($paperCategory) {
                    return $paperCategory->proper_created_at;
                })
                ->editColumn('type', function ($paperCategory) {
                    return $paperCategory->type_text;
                })
                ->addColumn('checkbox', function ($paperCategory) {
                    return View::make($this->viewConstant . '_add_checkbox', ['paperCategory' => @$paperCategory])->render();
                })
                ->with(["draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total, "recordsFiltered" => $count_filter])
                ->rawColumns(['type', 'checkbox', 'action', 'status', 'color_code', 'created_at'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Paper Category page                    |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($id = null)
    {
        // check if request has is or not
        if (isset($id)) {
            $paperCategory = $this->helper->detailById($id);
        }
        $title = isset($id) ? trans('formname.paper_category.update') : trans('formname.paper_category.create');
        $types = $this->helper->typeList();
        return view($this->viewConstant . 'create_paper_category', ['title' => @$title, 'paperCategory' => @$paperCategory, 'types' => @$types]);
    }

    /**
     * -------------------------------------------------
     * | Store Paper Category details                  |
     * |                                               |
     * | @param PaperCategoryFormRequest $request      |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(PaperCategoryFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            $msg = __('admin_messages.action_msg', ['action' => isset($request->id)?__('admin_messages.updated'):__('admin_messages.created'), 'type' => __('formname.paper_category.paper_category')]);
            $this->helper->dbEnd();
            return Redirect::route('paper_category_index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return Redirect::route('paper_category_index')->with('error', $e->getMessage());
        }
    }

    /**
     * -------------------------------------------------
     * | Delete Paper Category details                 |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroyPaperCategory(Request $request)
    {
        // check if request has is or not
        if (isset($request->id)) {
            $this->helper->delete($request->id);
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('admin_messages.deleted'),'type' => __('formname.paper_category.paper_category')]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => Lang::get('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * -------------------------------------------------
     * | Delete multiple Paper category details        |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multiDeletePaperCategory(Request $request)
    {
        $this->helper->multiDelete($request);
        // check if request action is active, inactive or delete
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            return response()->json(['msg' => __('formname.action_msg',['type'=>__('formname.paper_category.paper_category'),'action'=>($request->action == config('constant.inactive')?__('formname.inactivated'):__('formname.activated'))]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.email_template.delete'), 'icon' => __('admin_messages.icon_success')]);
    }

    /**
     * -------------------------------------------------
     * | Update paper category status details          |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        // check if request has id
        if (isset($request->id)) {
            $status = $this->helper->statusUpdate($request->id);
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>($status == config('constant.status_active_value'))?__('admin_messages.activated'):__('admin_messages.inactivated'),'type' => __('formname.paper_category.paper_category')]), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => Lang::get('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Show paper category details                   |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function show($uuid = null)
    {
        $paperCategory = $this->helper->detail($uuid);
        return view($this->viewConstant . 'detail_paper_category', ['paperCategory' => @$paperCategory]);
    }

}
