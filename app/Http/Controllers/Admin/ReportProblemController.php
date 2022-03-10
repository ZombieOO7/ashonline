<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ReportProblemHelper;
use App\Helpers\SubscriptionHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class ReportProblemController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.report-problem.';
    public function __construct(ReportProblemHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * -------------------------------------------------
     * | Display Topic list                            |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $statusList = $this->statusList();
        return view($this->viewConstant . 'index', ['statusList' => @$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Get Topic datatable data                      |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $draw = intval($request->draw) + 1 ;
            $limit = @$request->length?? 10;
            $start = @$request->start ?? 0;
            $problems = $this->helper->list();
            $itemQuery = $problems->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeStatus($request->status);
                }
            });
            $count_total = $itemQuery->count();
            $itemQuery = $itemQuery->skip($start)->take($limit);
            $problemList = $itemQuery->orderBy('created_at', 'desc')->get();
            $count_filter = 0;
            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return DataTables::of($problemList)
                ->editColumn('created_at', function ($problem) {
                    return @$problem->proper_created_at;
                })
                ->editColumn('project_type', function ($problem) {
                    return @$problem->proper_project_type;
                })
                ->editColumn('child_id', function ($problem) {
                    return 'Child'.@$problem->child->student_no;
                })
                ->editColumn('question', function ($problem) {
                    $question = $problem->questionList;
                    return $this->getPartials($this->viewConstant .'._content', ['question' => $question, 'title'=>__('formname.question.question_title')]);
                })
                ->editColumn('description', function ($problem) {
                    return $this->getPartials($this->viewConstant .'._description', ['problem' => @$problem, 'title'=>__('formname.description')]);
                })
                ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
                ->rawColumns(['child_id', 'question', 'description', 'project_type','created_at'])
                ->skipPaging()
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }
}
