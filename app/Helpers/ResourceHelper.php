<?php

namespace App\Helpers;

use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\ResourceGuidance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ResourceHelper extends BaseHelper
{
    protected $resource, $guidance;
    public function __construct(Resource $resource, ResourceGuidance $guidance)
    {
        parent::__construct();
        $this->resource = $resource;
        $this->guidance = $guidance;
    }

    /**
     * ------------------------------------------------------
     * | Resource detail by id                                 |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function guidanceRecordById($id)
    {
        return $this->guidance::whereId($id)->firstOrFail();
    }

    /**
     * ------------------------------------------------------
     * | Resource detail by uuid                               |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function recordByUuid($uuid)
    {
        return $this->resource::whereUuid($uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Guidance detail by uuid                               |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function guidanceRecordByUuid($uuid)
    {
        return $this->guidance::whereUuid($uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Resource store                                        |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store($request)
    {
        $resCat = ResourceCategory::whereSlug($request->type)->value('id');
        array_set($request, 'resource_category_id', $resCat);
        $record = $this->resource->updateOrCreate(
            ['uuid' => $request->uuid],
            $request->all()
        );
        // check if request has file
        if ($request->file('question')) {
            $uploadFunction = commonUpload($request->file('question'), config('constant.resource_store_folder'), $record->id);
            array_set($request, 'question_stored_name', @$uploadFunction[0]);
            array_set($request, 'question_original_name', @$uploadFunction[1]);
        }
        // check if request has file
        if ($request->file('answer')) {
            $uploadFunction = commonUpload($request->file('answer'), config('constant.resource_store_folder'), $record->id);
            array_set($request, 'answer_stored_name', @$uploadFunction[0]);
            array_set($request, 'answer_original_name', @$uploadFunction[1]);
        }
        $record->fill($request->all())->save();
        return $record;
    }

    /**
     * ------------------------------------------------------
     * | Resource Guidance store                            |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function storeGuidance($request)
    {

        if ($request->image_path) {
            $request['featured_stored_name'] = $request->image_path;
            $request['image_id'] = $request->image_checkbox;
        }
        $resCat = ResourceCategory::whereSlug($request->type)->value('id');
        array_set($request, 'resource_category_id', $resCat);
        array_set($request, 'written_by', auth()->id());
        if($request->id == null && $request->type == 'blog'){
            $orderSeq = $this->getLastSeqNo($request->type);
            array_set($request, 'order_seq', $orderSeq);
        }
        $record = $this->guidance->updateOrCreate(
            ['uuid' => $request->uuid],
            $request->all()
        );
        // check if request has file
        if ($request->file('featured')) {
//            $this->removeDirectory($record->id, config('constant.guidance_directory_path'));
//            $uploadFunction = commonUpload($request->file('featured'), config('constant.guidance_store_folder'), $record->id, config('constant.featured_img_width'), config('constant.featured_img_height'));
//            array_set($request, 'featured_stored_name', @$uploadFunction[0]);
//            array_set($request, 'featured_original_name', @$uploadFunction[1]);
            $uploadFunction = commonImageUpload($request->file('featured'));
            array_set($request, 'featured_stored_name', @$uploadFunction->path);
            array_set($request, 'featured_original_name', @$uploadFunction->original_name);
            array_set($request,'image_id',@$uploadFunction->id);
        }
        if($request->type == config('constant.blog_type')[2]){
            array_set($request, 'project_type', 1);
        }
        $record->fill($request->all())->save();
        return $record;
    }

    /**
     * ------------------------------------------------------
     * | Update status                                      |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function statusUpdate($id)
    {
        $record = $this->guidanceRecordById($id);
        $status = $record->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $record->fill(['status' => $status])->save();
        return $record;
    }

    /**
     * ------------------------------------------------------
     * | Delete resource                                    |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid, $resType)
    {
        if(in_array($resType, config('constant.blog_type'))) {
            $record = $this->guidanceRecordByUuid($uuid);
            if ($record) {
                // $this->removeDirectory($record->id, config('constant.guidance_directory_path'));
                $record->delete();
            }
        } else {
            $record = $this->recordByUuid($uuid);
            if ($record) {
                // $this->removeDirectory($record->id, config('constant.resource_directory_path'));
                $record->delete();
            }
        }
    }

    /**
     * ------------------------------------------------------
     * | Remove folder                                      |
     * |                                                    |
     * | @param $folder                                     |
     * |-----------------------------------------------------
     */
    public function removeDirectory($id, $folder)
    {
        $publicPath = str_replace('public', '', public_path());
        $path = $publicPath . $folder . $id;
        // check if request has file
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple resources                                       |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function bulkAction(Request $request)
    {
        $records = $this->resource::whereIn('id', $request->ids);
        // check if request action is delete record
        if ($request->action == config('constant.delete')) {
            foreach ($request->ids as $item) {
                // $this->removeDirectory($item, config('constant.resource_directory_path'));
            }
            $records->delete();
            return true;
        }
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple guidance/blog                               |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function guidanceBulkAction(Request $request)
    {
        $records = $this->guidance::whereIn('id', $request->ids);
        if ($request->action == config('constant.delete')) {
            foreach ($request->ids as $item) {
                // $this->removeDirectory($item, config('constant.guidance_directory_path'));
            }
            $records->delete();
            return '';
        } else {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $records->update(['status' => $status]);
            return '1';
        }
    }

    /**
     * ---------------------------------------------------------------
     * | Listing                                                     |
     * |                                                             |
     * | @param Request $request                                     |
     * ---------------------------------------------------------------
     */
    public function listing($request)
    {
        $query = $this->resource->whereHas('category', function ($q) use ($request) {
            $q->whereSlug($request->slug);
        });
        return $query->get();
    }

    /**
     * ---------------------------------------------------------------
     * | Guidance Listing                                            |
     * |                                                             |
     * | @param Request $request                                     |
     * ---------------------------------------------------------------
     */
    public function guidanceListing($request)
    {
        $query = $this->guidance->whereHas('category', function ($q) use ($request) {
            $q->whereSlug($request->slug);
        })->orderBy('id', 'desc');
        if ($request->status != '') {
            $query = $query->StatusSearch($request->status);
        }
        return $query->get();
    }
    /**
     * ---------------------------------------------------------------
     * | Download File                                               |
     * |                                                             |
     * | @param uuid,type                                            |
     * ---------------------------------------------------------------
     */
    public function downlaodFile($uuid, $filetype)
    {
        $file = $this->recordByUuid($uuid);
        // check if file data found
        if ($file) {
            $fileType = ($filetype == 'question') ? $file->question_stored_name : $file->answer_stored_name;
            // check if fileType not null
            if ($fileType) {
                $newPath = storage_path() . '/' . config('constant.resource_download_path') . $file->id . '/' . $fileType;
                $fileExist = file_exists($newPath);
                if ($fileExist) {
                    return $this->forceToDownload($newPath);
                } else {
                    return back()->with(['info' => __('formname.file_not_found')]);
                }
            } else {
                return back()->with(['info' => __('formname.file_not_found')]);
            }
        }
    }
    public function getLastSeqNo($type){
        $resCat = ResourceCategory::whereSlug($type)->value('id');
        $orderSeq = ResourceGuidance::where('resource_category_id',$resCat)->count();
        $orderSeqNo = $orderSeq +1;
        return $orderSeqNo;
    }

}
