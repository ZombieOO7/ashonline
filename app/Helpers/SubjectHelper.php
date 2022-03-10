<?php

namespace App\Helpers;

use App\Models\PaperCategory;
use App\Models\Subject;
use App\Models\SubjectPaperCategory;
use Illuminate\Http\Request;

class SubjectHelper extends BaseHelper
{

    protected $subject, $paperCategory, $subjectPaperCategory;
    public function __construct(Subject $subject, PaperCategory $paperCategory, SubjectPaperCategory $subjectPaperCategory)
    {
        $this->subject = $subject;
        $this->paperCategory = $paperCategory;
        $this->subjectPaperCategory = $subjectPaperCategory;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Subject List                                   |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function subjectList()
    {
        return $this->subject::orderBy('order_seq','ASC');
    }

    /**
     * ------------------------------------------------------
     * | Get paper Categories                               |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function productCategories()
    {
        return $paperCategories = $this->paperCategory::active()->notDeleted()->pluck('title', 'id');
    }

    /**
     * ------------------------------------------------------
     * | Subject detail by id                               |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->subject::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | Subject store                                      |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        // check if request has id or not null
        if ($request->has('id') && $request->id != '') {
            $subject = $this->subject::findOrFail($request->id);
        } else {
            $subject = new Subject();
            $request['order_seq'] = $this->getLastOrderSeq();
        }
        $subject->fill($request->all())->save();
        $subject->subjectCategories()->sync($request->paper_category_id);
        return $subject;
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
        $subject = $this->detail($uuid);
        $status = $subject->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->subject::where('id', $subject->id)->update(['status' => $status]);
    }

    /**
     * ------------------------------------------------------
     * | Subject detail by uuid                             |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->subject::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Delete Subject                                     |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $subject = $this->detail($uuid);
        $subject->delete();
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple subject                                     |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $subject = $this->subject::whereIn('id', $request->ids);
        // check if request action to delete records
        if ($request->action == config('constant.delete')) {
            $subject->delete();
        } else {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $subject->update(['status' => $status]);
        }
    }

    /**
     * ------------------------------------------------------
     * | Get Paper Category list                            |
     * | @param id                                          |
     * |-----------------------------------------------------
     */
    public function categoryDetailById($id)
    {
        return $paperCategories = $this->subjectPaperCategory::where('subject_id', $id)->pluck('paper_category_id');
    }

    /**
     * ------------------------------------------------------
     * | Get subject last sequence no                       |
     * | @param id                                          |
     * |-----------------------------------------------------
     */
    public function getLastOrderSeq(){
        $totalSubject = Subject::whereNotNull('order_seq')->orderBy('order_seq','desc')->count();
        $sequence = $totalSubject +1;
        return  $sequence;
    }
}
