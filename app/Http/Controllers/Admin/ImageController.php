<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelpers;
use Auth;
use App\Models\Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ImageController extends BaseController
{
    private $helper;

    protected $viewConstant = 'admin.images.';

    public function __construct(ImageHelpers $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * -----------------------------------------------------
     * | Images list                                       |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function index()
    {
        $image = Image::all();
        return view($this->viewConstant . 'index', ['image' => $image]);
    }

    /**
     * -----------------------------------------------------
     * | Store Image                                       |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function store(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::id();
        $images = $request->file('uploadFile');
        $uploadImageFunction = commonImageUpload($images);
        return view($this->viewConstant . 'index');
    }

    /**
     * -----------------------------------------------------
     * | Get Image Data                                    |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */

    public function getdata(Request $request)
    {
        try {
            $draw = intval($request->draw) + 1 ;
            $limit = @$request->length?? 10;
            $start = @$request->start ?? 0;
            $stages = $this->helper->ImageList();
            $itemQuery = $stages->where(function ($query) use ($request) {
                // check if request has status

            });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $stageList = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return Datatables::of($stageList)
                ->addColumn('path', function ($list) {
                    return '<img src="' . @$list->image_path . '" alt="' . @$list->path . '" width="180" height="130" >';
                })->addColumn('checkbox', function ($image) {
                })
                ->with(["draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total, "recordsFiltered" => $count_filter])
                ->rawColumns(['action', 'path', 'checkbox'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

     /**
     * -----------------------------------------------------
     * | Create Image Data                                 |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function create($id = null)
    {
        // check if request has uuid
        if (isset($id)) {
            $stage = $this->helper->detail($id);
        }
        $title = isset($id) ? trans('formname.image_name.update') : trans('formname.image_name.create');
        return view($this->viewConstant . 'create', ['stage' => @$stage, 'title' => @$title]);
    }
     /**
     * -----------------------------------------------------
     * | Delete Image                                      |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function destroy(Request $request)
    {
        // check if request has id
        if (isset($request->id)) {
            $this->helper->delete($request->id);
            return response()->json(['msg' => Lang::get('formname.image_name.delete'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => Lang::get('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }
     /**
     * -----------------------------------------------------
     * | Multiple Delete Image                             |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function multideleteImage(Request $request)
    {
        $image = Image::whereIn('id', $request->ids)->first();
        $images = Image::whereIn('id', $request->ids)->delete();
        return response()->json(['msg' => Lang::get('formname.image_name.delete'), 'icon' => __('admin_messages.icon_success')]);

    }


}
