<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Paper;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentTest;
use App\Exports\OrderExport;
use Illuminate\Http\Request;
use App\Helpers\ReportHelper;
use App\Exports\StudentTestExport;
use App\Models\StudentTestResults;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\ReportFormRequest;
use App\Http\Requests\Admin\MockReportFormRequest;
use DateTime;
use Illuminate\Support\Facades\Storage;

class ReportController extends BaseController
{
    protected $reportHelper,$subject;
    public $viewConstant = 'admin.reports.';
    public function __construct(ReportHelper $reportHelper,Subject $subject, Paper $paper, StudentTest $studentTest,Student $student, Order $order)
    {
        $this->subject = $subject;
        $this->student = $student;
        $this->paper = $paper;
        $this->reportHelper = $reportHelper;
        $this->studentTest = $studentTest;
        $this->order = $order;
        $this->reportHelper->mode = config('constant.admin');
    }
    /**
     * -------------------------------------------------
     * | Display Paper Order Report Form               |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $title = trans('formname.report.name');
        $paperCategories = $this->reportHelper->paperCategories();
        $subjects = $this->reportHelper->reportSubjects();
        return view($this->viewConstant.'index',['title'=>@$title,'paperCategories'=>@$paperCategories,'subjects'=>@$subjects]);
    }

    /**
     * -------------------------------------------------
     * | Export Sold Paper report file                 |
     * |                                               |
     * | @param Request $request                       |
     * | @return File                                  |
     * |------------------------------------------------
     */
    public function generate(ReportFormRequest $request)
    {
        $orders = $this->reportHelper->orderList($request);
        $exportType = ($request->export_to!=null)?$request->export_to:'.xls';
        $monthNames= [];
        
        foreach($request->months as $month) {
            $dateObj = DateTime::createFromFormat('!m', $month);
            $monthNames[] = $dateObj->format('M'); 
        }
        $months = implode("_",$monthNames);
        // check if order count is not zero
        if (count($orders)!=0) {
            $filename = @$request->year.'_'.@$months.'_Orders'.@$exportType;
            Excel::store(new OrderExport(@$orders),$filename,'public');
            // return Excel::download(new OrderExport(@$orders), @$request->year.'_'.@$months.'_Orders'.@$exportType);
            $filePath = Storage::path("public/{$filename}" );
            ob_end_clean();
            return response()->download($filePath, $filename)->deleteFileAfterSend(true);
        } else {
            return redirect()->back()->with(['error'=>__('admin_messages.no_reports_found')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Display Mock Report Form                      |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function mockReport()
    {
        $title = trans('formname.report.name');
        $statusList = $this->statusList();
        $studentList = $this->studentList()->pluck('full_name_with_email','id');
        $mockReportType = $this->mockReportType();
        return view($this->viewConstant.'mock-index',['mockReportType'=>@$mockReportType,'title'=>@$title,'statusList' => @$statusList,'studentList'=>@$studentList]);
    }

    /**
     * -------------------------------------------------
     * | generate mock report file                     |
     * |                                               |
     * | @param Request $request                       |
     * | @return File                                  |
     * |------------------------------------------------
     */
    public function generateMock(MockReportFormRequest $request){
        if($request->report_type == 1){ // get number of student attempt test report
            $query =$this->studentTest::where('status',2)->orderBy('id','asc');
        }else if($request->report_type == 2){ // get number of student joined report
            $query =$this->student::orderBy('student_no','asc');
        }else if($request->report_type == 3){ // get number of mock paper sold report
            $query =$this->order::whereHas('items',function($q){
                $q->whereNotNull('mock_test_id');
            })
            ->orderBy('id','asc');
        }else if($request->report_type == 4){ // get number of mock paper sold report
            $query =$this->order::whereHas('items',function($q){
                $q->whereNotNull('paper_id');
            })
            ->orderBy('id','asc');
        }
        // get data based on year
        $query->when(request('year') != null, function($q){
            return $q->whereYear('created_at',request('year'));
        });
        // get data based on month
        $query->when(request('month') != null, function($q){
            return $q->whereMonth('created_at',request('month'));
        });
        // get data based on date
        $query->when(request('date') != null, function($q){
            return $q->whereDay('created_at',request('date'));
        });
        $reportData = $query->get();
        return Excel::download(new StudentTestExport(@$reportData,$request->report_type), 'report.'.$request->export_to);
    }
}
