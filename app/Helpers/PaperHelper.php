<?php

namespace App\Helpers;

use App\Models\Paper;
use App\Models\PaperCategory;
use App\Models\PaperKeyword;
use App\Models\PaperVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PaperHelper extends BaseHelper
{
    protected $paper, $paperCategory, $paperVersion;

    public function __construct(Paper $paper, PaperCategory $paperCategory, PaperVersion $paperVersion)
    {
        $this->paper = $paper;
        $this->paperCategory = $paperCategory;
        $this->paperVersion = $paperVersion;
        parent::__construct();
    }

    /**
     * ------------------------------------------------------
     * | Get Paper List                                     |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function paperList()
    {
        return $this->paper::whereHas('category')
            ->whereHas('subject')
            ->whereHas('examType')
            ->orderBy('created_at');
    }

    /**
     * ------------------------------------------------------
     * | Paper detail by id                                 |
     * |                                                    |
     * | @param $id |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->paper::whereId($id)->firstOrFail();
    }

    /**
     * ------------------------------------------------------
     * | Paper detail by uuid                               |
     * |                                                    |
     * | @param $id |
     * |-----------------------------------------------------
     */
    public function detailByUuid($uuid)
    {
        return $this->paper::whereUuid($uuid)->firstOrFail();
    }

    /**
     * ------------------------------------------------------
     * | Paper detail by slug                               |
     * |                                                    |
     * | @param $slug |
     * |-----------------------------------------------------
     */
    public function detailByslug($slug)
    {
        return $this->paper::whereSlug($slug)->firstOrFail();
    }

    /**
     * ------------------------------------------------------
     * | Paper store                                        |
     * |                                                    |
     * | @param Request $request ,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        $imagePath = config('constant.paper.image_path');
        $data = [];
        if ($request->image_path) {
            $request['name'] = $request->image_path;
            $request['image_id'] = $request->image_checkbox;
            $request['path'] = $imagePath . '/' . $request->image_path;
            $request['thumb_path'] = $imagePath . '/thumb/' . $request->image_path;
            $imageTypeGet = $request['image_checkbox'];
            $ImageCheck =  commonImageId($imageTypeGet);
            $request['extension'] = $ImageCheck['extension'];
            $request['mime_type'] = $ImageCheck['mime_type'];
            $request['original_name'] = $ImageCheck['original_name'];
        }
        // check if request has id or not
        if ($request->has('id') && $request->id != '') {
            $paper = $this->paper::findOrFail($request->id);
        } else {
            $paper = new Paper();
            $version = 1;

            $request['sequence'] = $this->getLastSequence('sequence');
            $request['position'] = $this->getLastSequence('position');
        }
//
        // check if request has stage id
        if ($request->stage_id != null && $request->id != null) {
            $request['subject_id'] = null;
            $request['exam_type_id'] = null;
            $request['age_id'] = null;
        }
        if ($request->subject_id != null && $request->id != null) {
            $request['stage_id'] = null;
        }
        $request['slug'] = $this->createSlug($request->title);
        // check if uuid is null
        if ($uuid == null) {
            $request['product_no'] = $this->getNextProductNumber();
        }
        $paper->fill($request->all())->save();

        /** Store keywords */
        $dataKeywords = $request->get('hidden-keywords');
        $keywords = explode(",", $dataKeywords);
        // check if keywords is not empty
        if (!empty($keywords)) {
            $paper->keywords()->delete();
            foreach ($keywords as $val) {
                if ($val != "") {
                    $data = [
                        'paper_id' => $paper->id,
                        'title' => $val,
                    ];
                    $paperKeywords = new PaperKeyword();
                    $paperKeywords->fill($data)->save();
                }
            }
        }

        // check if request has image file
        if ($request->hasFile('name')): $this->storeImage($request, $paper);
        endif;
        // check if request has paper pdf file
        if ($request->hasFile('pdf_name')): $varsion = $this->storeFile($request, $paper);
        endif;
        return @$varsion;
    }

    /**
     * ------------------------------------------------------
     * | Store file                                         |
     * |                                                    |
     * | @param $request ,$paper                             |
     * |-----------------------------------------------------
     */
    public function storeFile($request, $paper)
    {
        $version = ($paper->version == null) ? 1 : ($paper->version->version + 1);
        $data['version'] = $version;
        $data['paper_id'] = $paper->id;
        $paperVersion = new PaperVersion();
        $paperVersion->fill($data)->save();
        $storagePath = config('constant.paper.folder_name') . $paperVersion->paper_id . config('constant.paper.version_name') . $paperVersion->version;
        $imageFunction = $this->uploadPdf($request->file('pdf_name'), $storagePath);
        $paperVersion = $this->paperVersion::updateOrCreate([
            'id' => $paperVersion->id,
        ], [
            'pdf_name' => @$imageFunction[1],
            'pdf_path' => config('constant.storage_path') . @$imageFunction[0],
            'original_name' => $request->file('pdf_name')->getClientOriginalName(),
        ]);
        return $paperVersion->pdf_path;
    }

    /**
     * ------------------------------------------------------
     * | Store image                                        |
     * |                                                    |
     * | @param $request ,$paper                             |
     * |-----------------------------------------------------
     */
    public function storeImage($request, $paper)

    {
        $folderName = config('constant.paper.folder_name') . $paper->id;
        // check if request id is not null
        if ($request->id != null):
            $this->deleteImage($paper->StoragePath, $folderName);
        endif;
        $avatarImage = $request->file('name');
        $ImageSave = commonImageUpload($avatarImage);
//        $imageFunction = $this->uploadPaperImage($avatarImage, $folderName, config('constant.thumb_test_paper_width'), config('constant.thumb_test_paper_height'));
        $paper = $this->paper::updateOrCreate([
            'id' => $paper->id,
        ], [
            'name' => $ImageSave->path,
            'image_id' => $ImageSave->id,
            'path' => config('constant.paper.image_path') . '/' . $ImageSave->path,
            'thumb_path' => config('constant.paper.image_path') . '/' . 'thumb/' . $ImageSave->path,
            'mime_type' => $avatarImage->getClientMimeType(),
            'extension' => $avatarImage->getClientOriginalExtension(),
            'original_name' => $avatarImage->getClientOriginalName(),
        ]);
        return $request;
    }

    /**
     * ------------------------------------------------------
     * | Update status                                      |
     * |                                                    |
     * | @param $uuid |
     * |-----------------------------------------------------
     */
    public function statusUpdate($uuid)
    {
        $paper = $this->detailByUuid($uuid);
        $status = $paper->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->paper::where('id', $paper->id)->update(['status' => $status]);
        return $status;
    }

    /**
     * ------------------------------------------------------
     * | Delete paper                                       |
     * |                                                    |
     * | @param $uuid |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $paper = $this->detailByUuid($uuid);
        $this->removeDirectory($paper->id);
        $paper->delete();
    }

    /**
     * ------------------------------------------------------
     * | Remove folder                                      |
     * |                                                    |
     * | @param $folder |
     * |-----------------------------------------------------
     */
    public function removeDirectory($folder)
    {
        $publicPath = str_replace('public', '', public_path());
        $path = $publicPath . config('constant.paper_directory_path') . $folder;
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple Paper                                       |
     * |                                                             |
     * | @param Request $request |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $paper = $this->paper::whereIn('id', $request->ids);
        // check if request action is delete
        if ($request->action == config('constant.delete')) {
            $paper->delete();
        } else {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $paper->update(['status' => $status]);
        }
    }

    /**
     * ---------------------------------------------------------------
     * | Search papers                                               |
     * |                                                             |
     * | @param Request $request |
     * ---------------------------------------------------------------
     */
    public function search(Request $request)
    {
        $query = $this->paper::where('status', 1)
            ->where('deleted_at', null)
            ->where('category_id', $request->category_id);
        // check if request has type
        if (@$request->type) {
            $query->where($request->type == 1 ? 'exam_type_id' : 'age_id', $request->exam_type_id);
        }
        // check if reqeust id is not null
        if ($request->subject_id != "") {
            $query->where('subject_id', $request->subject_id);
        }
        // check if request of stage id not null
        if (@$request->stage_id != "") {
            $query->where('stage_id', $request->stage_id);
        }
        return $query->get();
    }

    /**
     * -------------------------------------------------------
     * | Get Related Papers                                  |
     * |                                                     |
     * | @param $categoryId ,$paperId                         |
     * -------------------------------------------------------
     */
    public function getRelatedPapers($categoryId, $paperId)
    {
        return $this->paper->where('status', 1)
            ->where('deleted_at', null)
            ->where('category_id', $categoryId)
            ->where('id', '<>', $paperId)
            ->limit(4)
            ->get();
    }

    /**
     * -------------------------------------------------------
     * | Get Cart Related Papers                             |
     * |                                                     |
     * | @param $ids |
     * -------------------------------------------------------
     */
    public function getCartRelatedProducts($ids)
    {
        $papers = $this->paper->whereIn('id', $ids)
            ->select('category_id')
            ->groupBy('category_id')
            ->get();
        $categories = [];
        foreach ($papers as $key => $val) {
            $categories[$key]['title'] = $val->category->title;
            $categories[$key]['slug'] = $val->category->slug;
            $categories[$key]['papers'] = $this->paper->where('category_id', $val->category_id)->whereNotIn('id', $ids)->active()->limit(4)->get();
        }
        return $categories;
    }

    /**
     * -------------------------------------------------------
     * | Get Checkout Products                               |
     * |                                                     |
     * | @param $ids |
     * -------------------------------------------------------
     */
    public function getCheckoutProducts($ids)
    {
        return $this->paper->whereIn('id', $ids)->withTrashed()->get();
    }

    /**
     * ------------------------------------------------------
     * | Get Paper List                                    |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function paperList2()
    {
        return $this->paper::orderBy('created_at', 'DESC');
    }

    /**
     * -------------------------------------------------------
     * | Get Next product number                             |
     * |                                                     |
     * | @return Number                                      |
     * -------------------------------------------------------
     */
    public function getNextProductNumber()
    {
        $lastProduct = $this->paper::orderBy('created_at', 'desc')
            ->withTrashed()
            ->first();
        $lastProduct ? $number = substr($lastProduct->product_no, 7) : $number = 0;
        return 'PRD' . date('Y') . sprintf('%07d', intval($number) + 1);
    }

    /**
     * -------------------------------------------------------
     * | Get paper category last sequence or position        |
     * |                                                     |
     * | @return Number                                      |
     * -------------------------------------------------------
     */
    public function getLastSequence($type)
    {
        $paperCategory = $this->paperCategory::where('position', '!=', null)
            ->where('sequence', '!=', null)
            ->orderBy($type, 'desc')->first();
        $number = ($type == 'sequence') ? ($paperCategory->sequence) : ($paperCategory->position);
        return $number + 1;
    }

    /**
     * -------------------------------------------------------
     * | Get pdf paper version detail                        |
     * |                                                     |
     * | @return Number                                      |
     * -------------------------------------------------------
     */
    public function pdfVersion($filename)
    {
        $fp = @fopen($filename, 'rb');
        if (!$fp) {
            return 0;
        }
        /* Reset file pointer to the start */
        fseek($fp, 0);
        /* Read 20 bytes from the start of the PDF */
        preg_match('/\d\.\d/', fread($fp, 20), $match);
        fclose($fp);
        if (isset($match[0])) {
            return $match[0];
        } else {
            return 0;
        }
    }

    /**
     * -------------------------------------------------------
     * | Get numner oforder items                            |
     * |                                                     |
     * | @return Number                                      |
     * -------------------------------------------------------
     */
    public function detailWithItems($uuid)
    {
        $paper = $this->paper::whereUuid($uuid)
            ->withCount(['orderItems'])
            ->first();

        return @$paper->order_items_count;
    }
}
