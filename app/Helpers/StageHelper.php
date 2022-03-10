<?php

namespace App\Helpers;

use App\Models\Stage;
use App\Models\SubjectPaperCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StageHelper extends BaseHelper
{

    protected $stage;
    public function __construct(Stage $stage)
    {
        $this->stage = $stage;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Stage List                                     |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function stageList()
    {
        return $this->stage::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | Exam type detail by id                             |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->stage::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | ExamType store                                     |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        // check if request has id or not null
        if ($request->has('id') && $request->id != '') {
            $stage = $this->stage::findOrFail($request->id);
        } else {
            $stage = new Stage();
        }
        $stage->fill($request->all())->save();
        return $stage;
    }

    /**
     * ------------------------------------------------------
     * | Update status                                      |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function statusUpdate($uuid)
    {
        $stage = $this->detail($uuid);
        $status = $stage->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->stage::where('id', $stage->id)->update(['status' => $status]);
    }

    /**
     * ------------------------------------------------------
     * | ExamType detail by uuid                             |
     * |                                                    |
     * | @param $uuid                                         |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->stage::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Delete ExamType                                     |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $stage = $this->detail($uuid);
        $this->removeDirectory($stage->id);
        $stage->delete();
    }

    /**
     * ------------------------------------------------------
     * | Remove folder                                      |
     * |                                                    |
     * | @param $folder                                     |
     * |-----------------------------------------------------
     */
    public function removeDirectory($folder)
    {
        $publicPath = str_replace('public', '', public_path());
        $path = $publicPath . config('constant.examtypes.directory_path') . $folder;
        // check if directory exist in path 
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple Examtype                                    |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $stage = $this->stage::whereIn('id', $request->ids);
        // if request has action to delete records
        if ($request->action == config('constant.delete')) {
            $stage->delete();
        } else {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $stage->update(['status' => $status]);
        }
    }

    /**
     * ------------------------------------------------------
     * | Get Subject wise Paper Category list               |
     * | @param id                                          |
     * |-----------------------------------------------------
     */
    public function categoryDetailById($id)
    {
        return $paperCategories = SubjectPaperCategory::where('subject_id', $id)->pluck('paper_category_id');
    }
}
