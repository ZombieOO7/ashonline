<?php

namespace App\Helpers;

use App\Models\ReportProblem;
use App\Models\Topic;
use Illuminate\Http\Request;

class ReportProblemHelper extends BaseHelper
{
    protected $reportProblem;
    public function __construct(ReportProblem $reportProblem)
    {
        $this->reportProblem = $reportProblem;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Topic List                                     |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function list()
    {
        return $this->reportProblem::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | Topic detail by id                                 |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->reportProblem::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | Topic store                                        |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        $reportProblem = Topic::updateOrCreate(['id'=>@$request->id],$request->all());
        return $reportProblem;
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
        $reportProblem = $this->detail($uuid);
        $status = $reportProblem->active == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->reportProblem::where('id', $reportProblem->id)->update(['active' => $status]);
        return $status;
    }

    /**
     * ------------------------------------------------------
     * | Topic detail by uuid                               |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->reportProblem::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Delete Topic                                       |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $reportProblem = $this->detail($uuid);
        $reportProblem->delete();
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple Topic                                       |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $reportProblem = $this->reportProblem::whereIn('id', $request->ids);
        // check if request action is delete
        if ($request->action == config('constant.delete')) {
            $reportProblem->delete();
            return;
        }
        $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $reportProblem->update(['active' => $status]);
    }

}
