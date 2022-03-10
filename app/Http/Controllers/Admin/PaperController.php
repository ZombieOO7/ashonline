<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PaperHelper;
use App\Helpers\PdfHelper;
use App\Http\Requests\Admin\PaperBlockFormRequest;
use App\Http\Requests\Admin\TestPaperFormRequest;
use App\Models\Block;
use App\Models\Image;
use App\Models\PaperCategory;
use App\Models\PaperVersion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use Yajra\Datatables\Datatables;

class PaperController extends BaseController
{
    private $helper, $paperCategory, $block;
    public $viewConstant = 'admin.papers.';

    public function __construct(PaperHelper $helper, PaperCategory $paperCategory, Block $block, PaperVersion $paperVersion)
    {
        $this->helper = $helper;
        $this->paperCategory = $paperCategory;
        $this->helper->mode = config('constant.admin');
        $this->block = $block;
        $this->paperVersion = $paperVersion;
    }

    /**
     * -------------------------------------------------
     * | Display papers list                           |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $statusList = $this->statusList();
        $block = $this->block::where('slug', 'papers')->first();
        return view($this->viewConstant . 'index', ['block' => @$block, 'statusList' => @$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Get Paper datatable date                      |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $draw = intval($request->draw) + 1 ;
            $limit = @$request->length?? 10;
            $start = @$request->start ?? 0;
            $papers = $this->helper->paperList2();
            $itemQuery = $papers->where(function ($query) use ($request) {
                // check if request has status or not null
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $paperList = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return Datatables::of($paperList)
                ->addColumn('action', function ($paper) {
                    return $this->getPartials($this->viewConstant . '_add_action', ['paper' => @$paper]);
                })
                ->editColumn('price', function ($paper) {
                    return @$paper->price_text;
                })
                ->editColumn('stage', function ($paper) {
                    return ($paper->stage) ? $paper->stage->title : '--';
                })
                ->editColumn('category_id', function ($paper) {
                    return ($paper->category) ? $paper->category->title : '--';
                })
                ->editColumn('exam_type_id', function ($paper) {
                    return ($paper->examType) ? $paper->examType->title : '--';
                })
                ->editColumn('subject_id', function ($paper) {
                    return ($paper->subject) ? $paper->subject->title : '--';
                })
                ->editColumn('status', function ($paper) {
                    return $this->getPartials($this->viewConstant . '_add_status', ['paper' => @$paper]);
                })
                ->addColumn('checkbox', function ($paper) {
                    return $this->getPartials($this->viewConstant . '_add_checkbox', ['paper' => @$paper]);
                })
                ->editColumn('created_at', function ($paper) {
                    return $paper->proper_created_at;
                })
                ->addColumn('avg_rate', function ($paper) {
                    return $this->getPartials($this->viewConstant . '__rate', ['paper' => @$paper]);
                })
                ->with(["draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total, "recordsFiltered" => $count_filter])
                ->rawColumns(['review', 'created_at', 'checkbox', 'action', 'status', 'price', 'category_id', 'subject_id', 'exam_type_id', 'stage', 'avg_rate'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Paper page                             |
     * |                                               |
     * | @param $id |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($id = null)
    {
        $keywords = "";
        // check id is not null
        if (isset($id)) {
            $paper = $this->helper->detailById($id);
            $keywords = $paper->keywords()->pluck("title")->toArray();
        }
        $paperCategories = $this->helper->paperCategories();
        $subjects = $this->helper->subjects();
        $examTypes = $this->helper->examTypes();
        $ages = $this->helper->ages();
        $title = isset($id) ? trans('formname.test_papers.update') : trans('formname.test_papers.create');
        $image = Image::all();
//        dd($paper);
        return view($this->viewConstant . 'create_paper')->with(['title' => @$title, 'image' => @$image, 'paper' => @$paper, 'paperCategories' => @$paperCategories, 'subjects' => @$subjects, 'examTypes' => @$examTypes, 'ages' => @$ages, 'keywords' => @$keywords]);
    }

    /**
     * -------------------------------------------------
     * | Store Paper details                           |
     * |                                               |
     * | @param TestPaperFormRequest $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(TestPaperFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $pdfFile = $this->helper->store($request, $uuid);
            // check if reqeust has file
            if ($request->has('pdf_name')) {
                $checkPdf = $this->fileCompability($pdfFile);
                // check fpdf is supported or not to that file
                if ($checkPdf == false) {
                    return redirect()->back()->with('error', 'This pdf format not supported')->withInput(Input::all());
                }
            }
            $msg = __('admin_messages.action_msg', ['action' => isset($request->id) ? __('admin_messages.updated') : __('admin_messages.created'), 'type' => __('formname.review.paper')]);
            $this->helper->dbEnd();
            return Redirect::route('paper_index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Delete Paper details                          |
     * |                                               |
     * | @param Request $request |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroyPaper(Request $request)
    {
        // check if request has id
        if (isset($request->id)) {
            $this->helper->delete($request->id);
            return response()->json(['msg' => __('admin_messages.action_msg', ['action' => __('admin_messages.deleted'), 'type' => __('formname.review.paper')]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * -------------------------------------------------
     * | Delete multiple Paper details                 |
     * |                                               |
     * | @param Request $request |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multideletePaper(Request $request)
    {
        $this->helper->multiDelete($request);
        // check if request action is active, inactive or delete
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            return response()->json(['msg' => __('formname.action_msg', ['type' => __('formname.review.paper'), 'action' => ($request->action == config('constant.inactive') ? __('formname.inactivated') : __('formname.activated'))]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.email_template.delete'), 'icon' => __('admin_messages.icon_success')]);
    }

    /**
     * -------------------------------------------------
     * | Update paper status details                   |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        // check if request has id
        if (isset($request->id)) {
            $status = $this->helper->statusUpdate($request->id);
            return response()->json(['msg' => __('admin_messages.action_msg', ['action' => ($status == config('constant.status_active_value')) ? __('admin_messages.activated') : __('admin_messages.inactivated'), 'type' => __('formname.review.paper')]), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
    }

    /**
     * ------------------------------------------------------
     * | Download paper medias                              |
     * |                                                    |
     * | @param $uuid |
     * | @return Redirect                                   |
     * |-----------------------------------------------------
     */
    public function downloadMedia($uuid)
    {
        $paper = null;
        $paperVersion = $this->paperVersion::whereUuid($uuid)
            ->orderBy('version', 'desc')
            ->first();
        $newPath = storage_path() . '/app/' . config('constant.paper.folder_name') . @$paperVersion->paper_id . config('constant.paper.version_name') . @$paperVersion->version . '/' . @$paperVersion->pdf_name;
        // check if paper version is null
        if ($paperVersion == null) {
            $paper = $this->helper->detailByUuid($uuid);
            $newPath = storage_path() . '/app/' . config('constant.paper.folder_name') . @$paper->id . '/' . @$paper->pdf_name;
        }
        $fileExist = file_exists($newPath);
        // check if paper version file is not empty or version file is exist
        if ((!empty($paperVersion) || !empty($paper)) && $fileExist) {
            return $this->helper->forceToDownload($newPath);
        }
        return back()->with([__('admin_messages.icon_info') => __('formname.file_not_found')]);
    }

    /**
     * ------------------------------------------------------
     * | retutn html by paper category type                 |
     * | types are grade and SATS                           |
     * | @param $paper_id ,category_id                      |
     * | @return Response                                   |
     * |-----------------------------------------------------
     */
    public function getColumns(Request $request)
    {
        // check is request has paper id
        if (isset($request->paper_id)) {
            $paper = $this->helper->detailById($request->paper_id);
        }
        $paperCategory = $this->paperCategory::find($request->category_id);
        $subjects = $this->helper->subjects();
        $examTypes = $this->helper->examTypes();
        $ages = $this->helper->ages();
        $stages = $this->helper->stages();
        return view('admin.papers.__get_column', ['type' => @$paperCategory->type, 'paper' => @$paper, 'subjects' => @$subjects, 'examTypes' => @$examTypes, 'ages' => @$ages, 'stages' => @$stages]);
    }

    /**
     * -------------------------------------------------
     * | Store Paper Block                             |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function storeBlock(PaperBlockFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $block = ($request->id != null) ? $this->block::find($request->id) : new Block();
            $block->fill($request->all())->save();
            // check is request has id
            $msg = __('admin_messages.action_msg', ['action' => isset($request->id) ? __('admin_messages.updated') : __('admin_messages.created'), 'type' => __('formname.review.paper')]);
            $this->helper->dbEnd();
            return Redirect::route('paper_index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Get Paper all Versions                        |
     * |                                               |
     * | @param Request $request |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function versionDetail($uuid)
    {
        $paper = $this->helper->detailByUuid($uuid);
        $paperVersions = $this->paperVersion::wherePaperId($paper->id)
            ->orderBy('version', 'asc')
            ->get();
        return view($this->viewConstant . 'view_versions', ['paper' => @$paper, 'paperVersions' => @$paperVersions]);
    }

    /**
     * -------------------------------------------------
     * | Get Paper order info                          |
     * |                                               |
     * | @param Uuuid                                  |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function orderInfo($uuid)
    {
        $paperOrderItems = $this->helper->detailWithItems($uuid);
        return response()->json(['items' => @$paperOrderItems, 'status' => __('admin_messages.icon_success')]);
    }

    /**
     * -------------------------------------------------
     * | Check pdf is support fpdi or not              |
     * |                                               |
     * | @param File                                   |
     * | @return Boolean                               |
     * |------------------------------------------------
     */
    public function fileCompability($file)
    {
        try {
            $this->pdf2 = new PdfHelper();
            $this->pdf2->file($file, -20);
            $this->pdf2->AddPage();
            $this->pdf2->SetFont('Arial', '', 12);
            $this->pdf2->setSourceFile($file);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * -----------------------------------------------------
     * | Image Get                                         |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function imageGet(Request $request)
    {
        $data = $request->all();
        $imageGet = commonImageId($data['image_id']);
        $id = $imageGet->id;
        $imageShow = $imageGet->path;
        return view('admin.papers._image_show', ['imageShow' => @$imageShow, 'id' => @$id]);

    }
     /** 
     * -----------------------------------------------------
     * | Image Get In Datatable                            |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function getImage(Request $request)
    {
        try {
            $stages =  $this->commonImageIdCheck();
            $imageId = $request->image_id;
            $stageList = $stages->where(function ($query) use ($request) {
                // check if request has status


            })->get();
            return Datatables::of($stageList)
                ->addColumn('path', function ($list) {
                    return '<img src="' . url('storage/app/public/uploads/' . @$list->path) . '" alt="' . @$list->path . '" width="70" height="70" >';
                })->addColumn('checkbox', function ($list) use ($imageId) {

                    return $this->getPartials($this->viewConstant . '_add_image_action_checkbox', ['paper' => @$list, 'image_id' => @$imageId]);
                })
                ->rawColumns(['checkbox', 'path'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }
}
