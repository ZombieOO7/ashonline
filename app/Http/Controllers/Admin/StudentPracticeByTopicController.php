<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Helpers\StudentTopicTestHelper;
use App\Helpers\StudentTestAssessmentHelper;

class StudentPracticeByTopicController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.topic-test-report.';
    public $route = 'student-assessment-report.';

    public function __construct(StudentTopicTestHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentList = $this->studentList();
        return view($this->viewConstant.'index', ['studentList' => @$studentList]);
    }

    /**
     * -------------------------------------------------
     * | Get Test Assessment datatable                 |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getData(Request $request)
    {
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        $itemQuery = $this->helper->list($request);
        $fromDate = date('Y-m-d',strtotime($request->start_date));
        $toDate = date('Y-m-d',strtotime($request->end_date));
        $count_total = $itemQuery->count();
        $itemQuery = $itemQuery->skip($start)->take($limit);
        $students = $itemQuery->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return DataTables::of($students)
            ->addColumn('action', function ($student) use($fromDate,$toDate){
                $route = route('student-topic-report.show', ['uuid'=>@$student->uuid,'fromDate'=>$fromDate,'toDate'=>@$toDate]);
                return $this->getPartials($this->viewConstant.'action', ['route' => @$route, 'studentTest' => $student, 'type' => config('constant.col_action')]);
            })
            ->editColumn('parent_name', function ($student) {
                return @$student->parents->full_name;
            })->editColumn('student_no', function ($student) {
                return @$student->ChildIdText;
            })
            ->editColumn('no_of_test', function ($student) use($request){
                return @$student->practiceTestCount($request);
            })
            ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
            ->rawColumns(['no_of_test', 'parent_name', 'action'])
            ->skipPaging()
            ->make(true);
    }

    /**
     * -------------------------------------------------
     * | Get Test Assessment datatable                 |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function studentAssessment($uuid=null,$fromDate=null,$toDate=null)
    {
        $student = $this->helper->findStudent($uuid);
        $count = $student->practiceTestCount2($fromDate,$toDate);
        return view($this->viewConstant.'mock-detail', ['student' => @$student,'fromDate'=>@$fromDate,'toDate'=>@$toDate,'count'=>@$count]);
    }

    /**
     * -------------------------------------------------
     * | Get Test Assessment datatable                 |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getAssessmentData(Request $request){
        $student = $this->helper->findStudentById($request->student_id);
        $studentTests = $student->practiceTestData($request);
        return Datatables::of($studentTests)
            ->addColumn('action', function ($studentTest) {
                $route = route('test-topic-detail', [@$studentTest->uuid]);
                return $this->getPartials($this->viewConstant.'test_action', ['route' => $route, 'studentTest' => $studentTest, 'type' => config('constant.col_action')]);
            })
            ->addColumn('score', function ($studentTest) {
                return @$studentTest->overall_result;
            })
            ->addColumn('mock_test_title', function ($studentTest) {
                return @$studentTest->topic->title;
            })
            ->editColumn('start_date', function ($studentTest) {
                return @$studentTest->proper_created_at;
            })
            ->rawColumns(['student_no', 'mock_test_title', 'start_date', 'end_date', 'action', 'mock_completion'])
            ->make(true);
    }

    /**
     * -------------------------------------------------
     * | Get Test Assessment detail                    |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function testAssessmentDetail($uuid=null){
        $result = $this->helper->studentTest($uuid);
        return view($this->viewConstant.'detail', ['result' => @$result]);
    }
}
