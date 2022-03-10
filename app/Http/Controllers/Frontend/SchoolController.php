<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CMS;
use App\Models\ExamBoard;
use App\Models\MockTest;
use App\Models\Subject;
use Carbon\Carbon;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class SchoolController extends BaseController
{
    protected $viewConstant = 'newfrontend.school.';
    public function __construct(ExamBoard $examBoard,MockTest $mockTests)
    {
        $this->examBoard = $examBoard;
        $this->mockTests = $mockTests;
    }

    public function schoolPage($slug=null){
        try{
            $school = CMS::wherePageSlug($slug)->first();
            if($school != null && $school->mocks != null){
                $mockIds = $school->mocks->pluck('mock_test_id');
                $mocks = $this->mockTests::whereIn('id',$mockIds)->whereSchoolId($school->school_id)->get();
                $examBoardIds = $mocks->pluck('exam_board_id');
                $examBoards = $this->examBoard->whereIn('id',$examBoardIds)->get();
                foreach($examBoards as $key=> $board){
                    $examBoards[$key]['mocks'] = $this->mockTests::whereIn('id',$mockIds)->whereExamBoardId($board->id)->get();
                }
            }
            return view('newfrontend.school.details',['superSelectiveMock'=>@$mocks,'school'=>@$school,'examBoards'=>@$examBoards]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    /**
     * -------------------------------------------------------
     * | Get Exam board data                                 |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function getSchoolMock(Request $request){
        $today = Carbon::now();
        $examBoard = $this->examBoard->whereSlug($request->exam_board)->first();
        $query=  MockTest::active()
                            ->where('end_date','!=',null)
                            ->where('end_date','>',$today)
                            ->whereExamBoardId($examBoard->id)
                            ->whereSchoolId($request->school_id);
        $mockTestList=  $query->whereHas('mockTestSubjectList',function($q) use($request){
                            $q->whereSubjectId($request->subject_id);
                        })->get();
        return DataTables::of($mockTestList)
            ->addColumn('action', function ($mockTest) {
                return $this->getPartials($this->viewConstant . '_add_action', ['mockTest' => @$mockTest]);
            })
            ->editColumn('price', function ($mockTest) {
                return config('constant.default_currency_symbol').@$mockTest->price;
            })
            ->addColumn('date', function ($mockTest) {
                return @$mockTest->proper_start_date_and_end_date;
            })
            ->addColumn('time', function ($mockTest) {
                return @$mockTest->mockTestSubjectTime->proper_time;
            })
            ->editColumn('image', function ($mockTest) {
                return $this->getPartials($this->viewConstant .'_add_image',['mockTest'=>@$mockTest]);
            })
            ->editColumn('exam_name', function ($mockTest) {
                return $this->getPartials($this->viewConstant .'_add_exam',['mockTest'=>@$mockTest]);
            })
            ->rawColumns(['image','exam_name','date','time','action'])
            ->make(true);
    }

    public function schoolList(){
        try{
            return view('newfrontend.school.index');
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function getData(){
        $schoolList = CMS::whereType(3)->whereStatus('1')->get();
        return DataTables::of($schoolList)
            ->addColumn('action', function ($school) {
                return $this->getPartials($this->viewConstant . '_add_action', ['school' => @$school]);
            })
            ->addColumn('school_name', function ($school) {
                return @$school->title;
            })
            ->addColumn('exam_style', function ($school) {
                return @$school->school->examBoard->title;
            })
            ->editColumn('image', function ($school) {
                return $this->getPartials($this->viewConstant .'_add_image',['school'=>@$school]);
            })
            ->editColumn('short_description', function ($school) {
                return $this->getPartials($this->viewConstant .'_message',['school'=>@$school]);
            })
            ->rawColumns(['image','school_name','short_description','action'])
            ->make(true);
    }
}
