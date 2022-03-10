<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StudentTestAssessmentHelper;
use App\Models\PracticeQuestion;
use Illuminate\Http\Request;
use App\Models\PracticeQuestionList;
use App\Models\PracticeTestQuestionAnswer;
use Exception;
use Yajra\DataTables\DataTables;

class StudentAssessmentController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.test-assessment-report.';
    public $route = 'student-assessment-report.';

    public function __construct(StudentTestAssessmentHelper $helper)
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
                $route = route('student-assessment-report.show', ['uuid'=>@$student->uuid,'fromDate'=>$fromDate,'toDate'=>@$toDate]);
                return $this->getPartials($this->viewConstant.'action', ['route' => @$route, 'studentTest' => $student, 'type' => config('constant.col_action')]);
            })
            ->editColumn('parent_name', function ($student) {
                return @$student->parents->full_name;
            })->editColumn('student_no', function ($student) {
                return @$student->ChildIdText;
            })
            ->editColumn('no_of_test', function ($student) use($request) {
                return @$student->testAssessmentCount($request);
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
    public function studentAssessment($uuid=null,$fromDate=null,$toDate=null){
        $student = $this->helper->findStudent($uuid);
        $count = $student->testAssessmentCount2($fromDate,$toDate);
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
        $studentTests = $student->testAssessmentData($request);
        return Datatables::of($studentTests)
            ->addColumn('action', function ($studentTest) {
                $route = route('test-assessment-detail', [@$studentTest->uuid]);
                return $this->getPartials($this->viewConstant.'test_action', ['route' => $route, 'studentTest' => $studentTest, 'type' => config('constant.col_action')]);
            })
            ->addColumn('student_no', function ($studentTest) {
                return @$studentTest->student->student_no;
            })
            ->addColumn('mock_test_title', function ($studentTest) {
                return @$studentTest->testAssessment->title;
            })
            ->editColumn('start_date', function ($studentTest) {
                return @$studentTest->start_date_text;
            })
            ->editColumn('end_date', function ($studentTest) {
                return @$studentTest->end_date_text;
            })
            ->editColumn('no_of_attempt', function ($studentTest) {
                return @$studentTest->studentTotalTestAssessmentAttempt->count();
            })
            ->editColumn('mock_completion', function ($studentTest) {
                $ratio = 0;
                $attemptedCount = 0;
                if (isset($studentTest->lastTestAssessmentResult->attemptTestQuestionAnswers2)) {
                    $attemptedCount = @$studentTest->lastTestAssessmentResult->attempted;
                    $totalQuestion = @$studentTest->lastTestAssessmentResult->questions;
                    if ($attemptedCount > 0 && $totalQuestion > 0) {
                        $ratio = ($attemptedCount * 100) / $totalQuestion;
                    }
                }
                return number_format($ratio,2) . '%';
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
        // studentTestResultRank();
        $studentTest = $this->helper->studentTest($uuid);
        $totalTests = $this->helper->totalTest($studentTest);
        return view($this->viewConstant.'detail', ['studentTest' => @$studentTest,'totalTests'=>@$totalTests]);
    }


    /**
     * -------------------------------------------------
     * | Get Test Assessment detail                    |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function resetAttempt($uuid = null)
    {
        try{
            $studentTestResults = $this->helper->studentTestResult($uuid);
            $studentTestResults->update([
                'correctly_answered' => 0,
                'attempted' => 0,
                'unanswered' => 0,
                'obtained_marks' => 0,
                'overall_result' => 0,
                'is_reset' => 1
            ]);
            $this->dbCommit();
            return response()->json(['msg' => 'Test Reset successfully', 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            $this->dbRollBack();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------------
     * | question detail                                     |
     * |                                                     |
     * | @param questionId                                   |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function questionDetail(Request $request){
        try{
            $question = PracticeQuestion::where('uuid',$request->uuid)->firstOrFail();
            $studentTestQuestionAnswer = PracticeTestQuestionAnswer::where('uuid',$request->id)->first();
            $html = $this->getPartials('newfrontend.paper._question_detail', ['question' => @$question,'studentTestQuestionAnswer'=>@$studentTestQuestionAnswer]);
            return response()->json(['html'=>$html,'status'=>'success']);
        }catch(Exception $e){
            return response()->json(['status'=>'info']);
        }
    }
}
