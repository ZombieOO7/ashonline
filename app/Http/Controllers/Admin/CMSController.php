<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Lang;
use Redirect;
use App\Models\CMS;
use App\Models\Paper;
use App\Models\MockTest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\CMSFormRequest;
use App\Models\Image;
use Exception;

class CMSController extends BaseController
{
    protected $viewConstant = 'admin.cms.';

    /**
     * -----------------------------------------------------
     * | CMS list                                          |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function index()
    {
        try{
            $routeName = Route::currentRouteName();
            // check if route name is subject-cms.index to display subject cms page
            if ($routeName == 'subject-cms.index') {
                $type = 2;
                $title = __('formname.cms.subject_page');
                $route = 'subject-cms.create';
            }
            // check if route name is school-cms.index to display school cms page
            if ($routeName == 'school-cms.index') {
                $type = 3;
                $title = __('formname.cms.school_page');
                $route = 'school-cms.create';
            }
            $statusList = $this->statusList();
            return view($this->viewConstant . 'index', ['statusList' => @$statusList, 'type' => @$type, 'title' => @$title, 'route' => @$route]);
        }catch (Exception $e)  {
            abort('404');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * -----------------------------------------------------
     * | CMS datatables data                               |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function getdata(Request $request)
    {
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        $itemQuery = CMS::whereType($request->type)
                    ->where(function ($query) use ($request) {
                        // check if request has id or not
                        if ($request->status != null) {
                            $query->activeSearch($request->status);
                        }
                    });
        $count_total = $itemQuery->count();
        $itemQuery = $itemQuery->skip($start)->take($limit);
        $cms = $itemQuery->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return Datatables::of($cms)
            ->addColumn('action', function ($cms) {
                return $this->getPartials($this->viewConstant . '_add_action', ['cms' => @$cms]);
            })
            ->editColumn('status', function ($cms) {
                return $this->getPartials($this->viewConstant . '_add_status', ['cms' => @$cms]);
            })
            ->addColumn('checkbox', function ($cms) {
                return $this->getPartials($this->viewConstant . '_add_checkbox', ['cms' => @$cms]);
            })
            ->editColumn('created_at', function ($cms) {
                return $cms->proper_created_at;
            })
            ->with(["draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total, "recordsFiltered" => $count_filter])
            ->rawColumns(['checkbox', 'action', 'status', 'created_at'])
            ->skipPaging()
            ->make(true);
    }

    /**
     * -----------------------------------------------------
     * | Create/Update CMS form                            |
     * |                                                   |
     * | @param $id                                        |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function create($id = null)
    {
        try{
            $mockTests = [];
            // check if request has id
            if (isset($id)) {
                $cms = CMS::find($id);
                // check if cms mock is not null
                if ($cms->mocks) {
                    $mockTestIds = $cms->mocks->pluck('mock_test_id');
                    $paperIds = $cms->papers->pluck('paper_id');
                    $mockTests = MockTest::where('school_id', $cms->school_id)->pluck('title', 'id');
                }
            }
            $routeName = Route::currentRouteName();
            // check route name to crete subject cms page
            if ($routeName == 'subject-cms.create' || $routeName == 'subject-cms.edit') {
                $type = 2;
                $title = ($routeName == 'subject-cms.create') ? __('formname.cms.create_subject_page') : __('formname.cms.update_subject_page');
                $route = 'subject-cms.index';
            }
            // check route name to crete school cms page
            if ($routeName == 'school-cms.create' || $routeName == 'school-cms.edit') {
                $type = 3;
                $title = ($routeName == 'school-cms.create') ? __('formname.cms.create_school_page') : __('formname.cms.update_school_page');
                $route = 'school-cms.index';
            }
            $list = $this->schoolList()->pluck('school_name', 'id');
            $schoolList = ['' => 'Select School'] + $list->toArray();
            $papers = Paper::active()->pluck('title', 'id');
            return view($this->viewConstant . 'create_cms', ['cms' => @$cms, 'type' => @$type, 'title' => @$title,
                'schoolList' => @$schoolList, 'route' => @$route, 'mockTests' => @$mockTests, 'mockTestIds' => @$mockTestIds,
                'papers' => @$papers, 'paperIds' => @$paperIds]);
        }catch (Exception $e)  {
            return redirect()->back()->with('error', $e->getMessage());
            abort('404');
        }
    }

    /**
     * -----------------------------------------------------
     * | Store/Edit CMS form                               |
     * |                                                   |
     * | @param CMSFormRequest $request                    |
     * | @return Redirect                                  |
     * -----------------------------------------------------
     */
    public function store(CMSFormRequest $request)
    {
        $this->dbStart();
        try{
            if ($request->image_path) {
                $request['image'] = $request->image_path;
                $request['image_id'] = $request->image_checkbox;
            }
            $action = !empty($request->id) ? __('formname.updated') : __('formname.created');
            $msg = __('formname.action_msg', ['type' => __('formname.page'), 'action' => @$action]);
            $request['created_by'] = Auth::guard('admin')->user()->id;
            $cms = CMS::updateOrCreate(['id' => $request->id], $request->all());
            // check if request mock_test_id is null or not
            if ($request->mock_test_id != null) {
                $cms->mockCms()->sync($request->mock_test_id);
            }
            if ($request->paper_id != null) {
                $cms->mockPapers()->sync($request->paper_id);
            }
            // check if request has media file
            if ($request->hasFile('name')): $this->storeImage($request, $cms);
            endif;
            // check if request has media file
            if ($request->hasFile('logo_file')): $this->storeLogo($request, $cms);
            endif;
            $this->dbCommit();
            // check if cms type is general
            if ($cms->type == 1) {
                return Redirect::route('cms_pages', ['slug' => @$cms->page_slug])->with('message', $msg);
            } else {
                $msg = __('formname.action_msg', ['type' => ($cms->type == 2) ? __('formname.cms.subject_page_msg') : __('formname.cms.school_page_msg'), 'action' => @$action]);
                $type = config('constant.cms_type')[$cms->type];
                return Redirect::route($type . '-cms.index', ['type' => @$type])->with('message', $msg);
            }
        }catch (Exception $e)  {
            $this->dbEnd();
            return redirect()->back()->with('error', $e->getMessage());
            abort('404');
        }
    }

    /**
     * -----------------------------------------------------
     * | Delete CMS record                                 |
     * |                                                   |
     * | @param Request $request |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function destroyCms(Request $request)
    {
        $this->dbStart();
        try{
            // check is request has id
            if (isset($request->id)) {
                $cms = CMS::find($request->id);
                $cms->delete();
                $this->dbCommit();
                if ($cms->type == 1) {
                    return response()->json(['msg' => __('formname.action_msg', ['type' => __('formname.page'), 'action' => __('formname.deleted')]), 'icon' => __('admin_messages.icon_success')]);
                } else {
                    $msg = __('formname.action_msg', ['type' => ($cms->type == 2) ? __('formname.cms.subject_page_msg') : __('formname.cms.school_page_msg'), 'action' => __('formname.deleted')]);
                    return response()->json(['msg' => @$msg, 'icon' => __('admin_messages.icon_success')]);
                }
                // return response()->json(['msg' => __('formname.action_msg',['type'=>__('formname.page'),'action'=>__('formname.deleted')]), 'icon' => __('admin_messages.icon_success')]);
            }
            return response()->json(['msg' => Lang::get('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }catch (Exception $e)  {
            return response()->json(['msg' =>$e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -----------------------------------------------------
     * | Multiple Delete CMS record                        |
     * |                                                   |
     * | @param Request $request                           |
     * | @return Response                                  |
     * -----------------------------------------------------
     */
    public function multideleteCMS(Request $request)
    {
        $this->dbStart();
        try{
            $cms = CMS::whereIn('id', $request->ids)->first();
            $cmsArr = CMS::whereIn('id', $request->ids)->delete();
            $this->dbCommit();
            if ($cms->type == 1) {
                return response()->json(['msg' => __('formname.action_msg', ['type' => __('formname.page'), 'action' => __('formname.deleted')]), 'icon' => __('admin_messages.icon_success')]);
            } else {
                $msg = __('formname.action_msg', ['type' => ($cms->type == 2) ? __('formname.cms.subject_page_msg') : __('formname.cms.school_page_msg'), 'action' => __('formname.deleted')]);
                return response()->json(['msg' => @$msg, 'icon' => __('admin_messages.icon_success')]);
            }
        }catch(Exception $e){
            $this->dbEnd();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * -----------------------------------------------------
     * | Get page detail by slug                           |
     * |                                                   |
     * | @param Slug                                       |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function detail($slug = null)
    {
        $cms = CMS::wherePageSlug($slug)->firstOrFail();
        $title = $cms->title;
        return view('admin.cms.detail', ['cms' => @$cms, 'title' => @$title]);
    }

    /**
     * ------------------------------------------------------
     * | Store image                                        |
     * |                                                    |
     * | @param $request ,$user                             |
     * |-----------------------------------------------------
     */
    public function storeImage($request, $cms)
    {
        $folderName = config('constant.image.storage_path');
        $imageName = $request->file('name')->getClientOriginalExtension();
        $destinationPath = storage_path().'/'. $folderName;
        $filename = Str::random(25) . '.' . $imageName;
        $request->file('name')->move($destinationPath, $filename);
        $cms = CMS::updateOrCreate([
            'id' => $cms->id,
        ], [
            'image' => $filename,
            'image_path' => $filename,
        ]);
        $mimeType = $request->file('name')->getClientMimeType();
        $ImageSave = Image::create(['path' => $filename, 'extension' => $imageName, 'mime_type' => $mimeType,
        'original_name' => $imageName]);
        $cms = CMS::updateOrCreate([
            'id' => $cms->id,
        ], [
            'image' => @$ImageSave->path,
            'image_id' => @$ImageSave->id
        ]);
        return $request;
    }

    /**
     * -------------------------------------------------------
     * | Upload image                                        |
     * |                                                     |
     * | @param $requestImage ,$folderName,$width,$height     |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function uploadImage($requestImage, $folderName, $width, $height)
    {
        // check if width is 64 or not
        $folderName = config('constant.image.storage_path');
        // if ($width != config('constant.avatar_img_width')) {
        //     $folder_name = config('constant.banner');
        // }
        $originalName = $requestImage->getClientOriginalName();
        $path = $requestImage->store($folderName);
        $fileName = pathinfo($path, PATHINFO_FILENAME) . '.' . pathinfo($path, PATHINFO_EXTENSION);
        $resizeDirectory = Storage::path($folderName);
        // check if file directory is exist or not
        if (!File::isDirectory($resizeDirectory)) {
            File::makeDirectory($resizeDirectory, 0777, true, true);
        }
        return [$fileName, $originalName];
    }

    /**
     * ------------------------------------------------------
     * | Get Subject Mocks                                  |
     * | Get Subject Mocks                                  |
     * |                                                    |
     * | @return Response                                   |
     * |-----------------------------------------------------
     */
    public function getMock(Request $request)
    {
        $mockTests = MockTest::whereSchoolId($request->school_id)->pluck('title', 'id');
        return response()->json(['mockTests' => @$mockTests]);
    }

    /**
     * ------------------------------------------------------
     * | Store logo                                         |
     * |                                                    |
     * | @param $request ,$user                             |
     * |-----------------------------------------------------
     */
    public function storeLogo($request, $cms)
    {
        $folderName = config('constant.image.storage_path');
        $imageName = $request->file('logo_file')->getClientOriginalExtension();
        $destinationPath = storage_path().'/'. $folderName;
        $filename = Str::random(25) . '.' . $imageName;
        $request->file('logo_file')->move($destinationPath, $filename);
        $cms = CMS::updateOrCreate([
            'id' => $cms->id,
        ], [
            'logo' => $filename,
        ]);
        return $request;
    }

    /**
     * ------------------------------------------------------
     * | Get Image                                          |
     * |                                                    |
     * | @param View                                        |
     * |-----------------------------------------------------
     */
    public function imageGet(Request $request)
    {
        $data = $request->all();
        $imageGet = commonImageId($data['image_id']);
        $id = $imageGet->id;
        $imageShow = $imageGet->path;
        return view('admin.cms._image_show', ['imageShow' => @$imageShow, 'id' => @$id]);

    }

     /**
     * ------------------------------------------------------
     * | Get Image Datatable                                |
     * |                                                    |
     * | @param View                                        |
     * |-----------------------------------------------------
     */

    public function getImage(Request $request)
    {
        try {
            $stages = $this->commonImageIdCheck();
            $imageId = $request->image_id;
            $logo_image_id = $request->logo_image_id;
            $stageList = $stages->where(function ($query) use ($request) {
                // check if request has status

            })->get();
            return Datatables::of($stageList)
                ->addColumn('path', function ($list) {
                    return '<img src="' . url('storage/app/public/uploads/' . @$list->path) . '" alt="' . @$list->path . '" width="70" height="70" >';
                })->addColumn('checkbox', function ($cms) use ($imageId, $logo_image_id) {
                    return $this->getPartials($this->viewConstant . '_add_image_action_checkbox', ['cms' => @$cms, 'image_id' => @$imageId, 'logo_image_id' => @$logo_image_id]);
                })
                ->rawColumns(['checkbox', 'path'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }
}

