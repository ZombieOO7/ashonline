<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TopicHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResultGrade;
use Exception;

class ResultGradeController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.result-grade.';
    public function __construct()
    {
        // $this->helper->mode = config('constant.admin');
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
        $resultGrade = ResultGrade::first();
        return view($this->viewConstant . 'index', ['resultGrade'=>@$resultGrade]);
    }

    /**
     * -------------------------------------------------
     * | Store Topic                                   |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(Request $request){
        try{
            $resultGrade = ResultGrade::updateOrCreate(['mock_test_paper_id'=>$request->mock_test_paper_id],$request->all());
            return response()->json(['id'=>@$resultGrade->uuid,'status'=>'success','msg'=>__('formname.result-grade.saved'),'icon'=>'success']);
        }catch(Exception $e){
            return response()->json(['status'=>'info','msg'=>'Something went wrong !']);
        }
    }
}
