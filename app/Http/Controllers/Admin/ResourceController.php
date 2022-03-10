<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Helpers\ResourceHelper;
use App\Http\Requests\Admin\ResourceRequest;
use App\Models\ResourceCategory;
use App\Models\ResourceGuidance;
use Exception;
use Yajra\DataTables\DataTables;
use File;
use Validator;

class ResourceController extends BaseController
{
    protected $resource, $helper, $resCategory;
    protected $viewConstant = 'admin.resources.';

    public function __construct(Resource $resource, ResourceHelper $helper, ResourceCategory $resCategory)
    {
        $this->resource = $resource;
        $this->helper = $helper;
        $this->resCategory = $resCategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        try {
            $title = @config('constant.resource_type.'.$type);
            $category = $this->resCategory->whereSlug($type)->first();
            if (in_array($type, config('constant.blog_type')))
                return view($this->viewConstant . 'index_guidance', ['title'=>@$title,'type' => @$type, 'category' => @$category]);
            else
                return view($this->viewConstant . 'index', ['title'=>@$title,'type' => @$type, 'category' => @$category]);
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param Uuid $uuid
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $gradeList = $this->gradeList();
        $type2 = ucwords(str_replace('-',' ',$type));
        if (in_array($type, config('constant.blog_type')))
            return view($this->viewConstant . 'create_guidance', ['type' => @$type, 'gradeList' => @$gradeList]);
        return view($this->viewConstant . 'create', ['type' => @$type,'type2'=>$type2]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResourceRequest $request)
    {
        /** Get resource category title */
        $resCat = ResourceCategory::whereSlug($request->type)->first();
        if (($request->type == config('constant.blog_type')[0] || $request->type == config('constant.blog_type')[1] || $request->type == config('constant.blog_type')[2]) && $request->id != null) {
            $this->helper->storeGuidance($request);
        } else {
            if (($request->type == config('constant.blog_type')[0] || $request->type == config('constant.blog_type')[1] || $request->type == config('constant.blog_type')[2]) && $request->id == null) {
                $this->helper->storeGuidance($request);
            } else {
                $this->helper->store($request);
            }
        }
        return redirect()->route('resources.index', @$request->type);
    }

    /**
     * Display all data.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getDatatable(Request $request)
    {

        $lists = $this->helper->listing($request);
        return DataTables::of($lists)
            ->addColumn('question', function ($list) {
                return '<a href="' . route('resource.download.pdf', [@$list->uuid, 'question']) . '" >' . @$list->question_original_name . '</a>';
            })
            ->addColumn('answer', function ($list) {
                if ($list->answer_original_name)
                    return '<a href="' . route('resource.download.pdf', [@$list->uuid, 'answer']) . '" >' . @$list->answer_original_name . '</a>';
                else
                    return "-";
            })
            ->addColumn('checkbox', function ($list) use ($request) {
                return $this->getPartials($this->viewConstant . 'action', ['item' => @$list, 'type' => config('constant.col_checkbox'), 'resType' => @$request->slug]);
            })
            ->editColumn('created_at', function ($list) {
                return @$list->proper_created_at;
            })
            ->addColumn('action', function ($list) use ($request) {
                return $this->getPartials($this->viewConstant . 'action', ['item' => @$list, 'type' => config('constant.col_action'), 'resType' => @$request->slug]);
            })
            ->rawColumns(['checkbox', 'action', 'question', 'answer', 'created_at'])
            ->make(true);
    }

    /**
     * Display all data.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getGuidanceDatatable(Request $request)
    {
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        $itemQuery = $this->helper->guidanceListing($request);
        $count_total = $itemQuery->count();
        $itemQuery = $itemQuery->skip($start)->take($limit);
        $lists = $itemQuery->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return DataTables::of($lists)
            ->addColumn('featured_img', function ($list) {
                if ($list->featured_stored_name) {
                    return '<img src="' . url('storage/app/public/uploads/' . @$list->featured_stored_name) . '" alt="' . @$list->featured_original_name . '" width="100" height="100" >';
                } else {
                    return '<img src="' . @$list->featured_img . '" alt="' . @$list->featured_original_name . '" width="100" height="100" >';
                }
            })
            ->editColumn('category_id', function ($list) {
                if ($list->grade_id != null) {
                    return $list->grade->title;
                }
                return @$list->guidanceCategory->title;
            })
            ->editColumn('status', function ($list) {
                return @$list->status_tag;
            })
            ->addColumn('checkbox', function ($list) use ($request) {
                return $this->getPartials($this->viewConstant . 'action', ['item' => @$list, 'type' => config('constant.col_checkbox'), 'resType' => @$request->slug]);
            })
            ->editColumn('created_at', function ($list) {
                return @$list->proper_created_at;
            })
            ->addColumn('action', function ($list) use ($request) {
                return $this->getPartials($this->viewConstant . 'action', ['item' => @$list, 'type' => config('constant.col_action'), 'resType' => @$request->slug]);
            })
            ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
            ->rawColumns(['checkbox', 'action', 'featured_img', 'created_at', 'status'])
            ->skipPaging()
            ->make(true);
    }

    /**
     * For edit category
     */
    public function edit($type, $uuid)
    {
        try {
            $gradeList = $this->gradeList();
            // find if type is in blog type array
            if (in_array($type, config('constant.blog_type'))) {
                $record = $this->helper->guidanceRecordByUuid($uuid);
                return view('admin.resources.create_guidance', ['resource' => @$record, 'type' => $type, 'gradeList' => @$gradeList]);
            }
            $record = $this->helper->recordByUuid($uuid);
            return view('admin.resources.create', ['resource' => @$record, 'type' => @$type]);
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * For update category
     */
    public function update($uuid, ResourceRequest $request)
    {
        // find if type is in blog type array
        if (in_array($request->type, config('constant.blog_type')))
            $this->helper->storeGuidance($request);
        else
            $this->helper->store($request);
        return redirect()->route('resources.index', @$request->type)->with('message', __('admin_messages.edit_msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($resType, $uuid)
    {
        $this->helper->delete($uuid, $resType);
        $type = ($resType == config('constant.blog_type')[1]) ? __('admin_messages.blog2') : __('admin_messages.resource');
        /** Get resource category title */
        $resCat = ResourceCategory::whereSlug($resType)->first();
        return response()->json(['msg' => __('admin_messages.delete_msg', ['type' => @$resCat->name]), 'icon' => __('admin_messages.icon_success')]);
    }

    /**
     * update the status like active and inactive.
     *
     * @param Request $request
     * @return void
     */
    public function changeStatus($resType, Request $request)
    {
        $result = $this->helper->statusUpdate($request->id);
        $resType = ($resType == config('constant.blog_type')[1]) ? __('admin_messages.blog2') : __('admin_messages.resource');
        return response()->json(['msg' => __('admin_messages.status_msg', ['resType' => @$resType, 'type' => @$result->status_text]), 'icon' => __('admin_messages.icon_success')]);
    }

    /**
     * Perform multiple action like active, inactive and delete.
     *
     * @param Request $request
     * @return void
     */
    public function bulkAction(Request $request)
    {
        try {
            $record = $this->helper->bulkAction($request);
            // check if records found
            if ($record) {
                /** Get resource category title */
                $res = Resource::where('id', $request->ids[0])->first();
                $resCat = ResourceCategory::where('id', $res->resource_category_id)->first();
                return response()->json(['msg' => __('admin_messages.delete_msg', ['type' => @$resCat->name]), 'icon' => __('admin_messages.icon_success')]);
            }
        } catch (Exception $e) {
            return response()->json(['msg' => __('admin_messages.icon_error'), 'icon' => __('admin_messages.icon_error')]);
        }
    }

    /**
     * Perform multiple action like active, inactive and delete.
     *
     * @param Request $request
     * @return void
     */
    public function guidanceBulkAction($restype, Request $request)
    {
        try {
            $res = ResourceGuidance::where('id', $request->ids[0])->first();
            $resCat = ResourceCategory::where('id', $res->resource_category_id)->first();
            $record = $this->helper->guidanceBulkAction($request);
            $restype = ($restype == config('constant.blog_type')[1]) ? __('admin_messages.blog2') : __('admin_messages.resource');
            /** Get resource category title */
            if ($record) {
                return response()->json(['msg' => __('admin_messages.status_msg', ['resType' => @$resCat->name, 'type' => @$resCat->name]), 'icon' => __('admin_messages.icon_success')]);
            }
            return response()->json(['msg' => __('admin_messages.delete_msg', ['type' => @$resCat->name]), 'icon' => __('admin_messages.icon_success')]);
        } catch (Exception $e) {
            return response()->json(['msg' => __('admin_messages.icon_error'), 'icon' => __('admin_messages.icon_error')]);
        }
    }

    // For download file
    public function downloadMedia($uuid, $filetype)
    {
        return $this->helper->downlaodFile(@$uuid, @$filetype);
    }

    // For update resource category
    public function updateCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'content' => 'required',
            ]);
            // check if validator fail
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $category = $this->resCategory->whereUuid($request->uuid)->first();
            $category->fill($request->all())->save();
            return redirect()->route('resources.index', @$category->slug)->with('message', __('admin_messages.res_category_msg', ['type' => @$request->name]));
        } catch (Exception $e) {
            abort(404);
        }
    }

    // For store editor upload file
    public function storeCKEditorFile(Request $request)
    {
        $folderName = config('constant.editor_img_store_folder');
        if (!File::isDirectory($folderName)) {
            File::makeDirectory($folderName, 0755, true, true);
        }
        if (file_exists(storage_path() . $folderName . $_FILES["upload"]["name"])) {
            echo $_FILES["upload"]["name"] . __('admin_messages.already_exists');
        } else {
            $originalName = $request->file('upload')->getClientOriginalName();
            $request->file('upload')->storeAs($folderName, $originalName);
            // echo "Stored in: " . $folderName . $originalName;

            $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
            $image_path = str_replace("/public", "", url('/'));
            $newPath = $image_path . '/' . config('constant.editor_img_directory_path') . $originalName;
            $url = asset($newPath);
            $msg = $originalName . ' successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }

    /**
     * -------------------------------------------------
     * | Sort Order Sequence                           |
     * |                                               |
     * | @param Request $request                       |
     * |------------------------------------------------
     */
    public function sorting(Request $request)
    {
        $request->sorting = $request->sorting + 1;
        $subject = ResourceGuidance::whereId($request->id)->first();
        $subject->update(['order_seq' => @$request->sorting]);
    }

    /**
     * -------------------------------------------------
     * | Get Resource images                           |
     * |                                               |
     * | @param Request $request                       |
     * |------------------------------------------------
     */
    public function imageGet(Request $request)
    {
        $data = $request->all();
        $imageGet = commonImageId($data['image_id']);
        $id = $imageGet->id;
        $imageShow = $imageGet->path;
        return view('admin.mock-test._image_show', ['imageShow' => @$imageShow, 'id' => @$id]);

    }

    /**
     * -------------------------------------------------
     * | Get images List                               |
     * |                                               |
     * | @param Request $request                       |
     * |------------------------------------------------
     */
    public function getImage(Request $request)
    {

        try {
            $stages = $this->commonImageIdCheck();
            $imageId = $request->image_id;
            $stageList = $stages->where(function ($query) use ($request) {
                // check if request has status

            })->get();
            return Datatables::of($stageList)
                ->addColumn('path', function ($list) {
                    return '<img src="' . url('storage/app/public/uploads/' . @$list->path) . '" alt="' . @$list->path . '" width="70" height="70" >';
                })->addColumn('checkbox', function ($resource) use ($imageId) {
                    return $this->getPartials($this->viewConstant . '_add_image_action_checkbox', ['resource' => @$resource, 'image_id' => @$imageId]);
                })
                ->rawColumns(['checkbox', 'path'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

}
