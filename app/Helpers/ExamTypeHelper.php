<?php

namespace App\Helpers;

use App\Models\ExamType;
use App\Models\PaperCategory;
use App\Models\SubjectPaperCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExamTypeHelper extends BaseHelper
{

    protected $examType, $paperCategory, $subjectPaperCategory;
    public function __construct(ExamType $examType, PaperCategory $paperCategory, SubjectPaperCategory $subjectPaperCategory)
    {
        $this->examType = $examType;
        $this->paperCategory = $paperCategory;
        $this->subjectPaperCategory = $subjectPaperCategory;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Exam type List                                 |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function examTypeList()
    {
        return $this->examType::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | Get paper Categories                               |
     * |                                                    |
     * | @param                                             |
     * |-----------------------------------------------------
     */
    public function paperCategories()
    {
        return $paperCategories = $this->paperCategory::active()->notDeleted()->pluck('title', 'id');
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
        return $this->examType::whereId($id)->first();
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
        $examType = ExamType::updateOrCreate(['id'=>@$request->id],$request->all());
        return $examType;
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
        $examType = $this->detail($uuid);
        $status = $examType->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->examType::where('id', $examType->id)->update(['status' => $status]);
        return $status;
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
        return $this->examType::where('uuid', $uuid)->first();
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
        $examType = $this->detail($uuid);
        $this->removeDirectory($examType->id);
        $examType->delete();
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
        // check if directory exist or not
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
        $examType = $this->examType::whereIn('id', $request->ids);
        // check if request action is delete 
        if ($request->action == config('constant.delete')) {
            $examType->delete();
        } else {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $examType->update(['status' => $status]);
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
        return $paperCategories = $this->subjectPaperCategory::where('subject_id', $id)->pluck('paper_category_id');
    }
}
