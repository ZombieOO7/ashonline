<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PurchasedMockTest;
use App\Models\Question;
use App\Models\QuestionList;
use App\Models\StudentTestPaper;
use Exception;
use Illuminate\Support\Facades\DB;
use View;
class BaseController extends Controller
{
    //
    /**
     * Show status dropdown
     * @return Array
     */
    public function statusList()
    {
        return $this->combineValues([
            config('constant.active') => config('constant.active'),
            config('constant.inactive') => config('constant.inactive'),
        ]);

    }
    /**
     * Show review dropdown
     * @return Array
     */
    public function reviewstatusList()
    {
        return $this->combineValues([
            config('constant.review_active') => config('constant.review_active'),
            config('constant.review_inactive') => config('constant.review_inactive'),
        ]);

    }
    /**
     * Show payment dropdown
     * @return Array
     */
    public function paymentStatusList()
    {
        return $this->combineValues([
            config('constant.payment_paid'),
            config('constant.payment_unpaid'),
        ]);

    }
    /**
     * Show order dropdown
     * @return Array
     */
    public function orderStatusList()
    {
        return $this->combineValues([
            config('constant.order_pending'),
            config('constant.order_completed'),
        ]);

    }

    /**
     * Show order dropdown
     * @return Array
     */
    public function contactUsSubjectList()
    {
        return $this->combineValues([
            __('formname.general'),
            __('formname.payments'),
            __('formname.technical'),
        ]);
    }
    /**
     * combile key and value
     * @return Array
     */
    public function combineValues($a)
    {
        return ['' => config('constant.select')] + array_combine($a, $a);
    }

    /**
     * partial view
     * @return View
     */
    public function getPartials($blade,$review){
        return View::make($blade, $review)->render();
    }

    /**
     * -------------------------------------------------------
     * | Merge Select option list.                           |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function mergeSelectOption($a,$type)
    {
        return  ['' => __('formname.select_type',['type'=>@$type])]+$a;
    }

    /*
     * -------------------------------------------------------
     * | Begine Transaction.                                 |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function dbStart()
    {
        return DB::beginTransaction();
    }

    /*
     * -------------------------------------------------------
     * | Commit Transaction.                                 |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function dbCommit()
    {
        return DB::commit();
    }

    /**
     * -------------------------------------------------------
     * | RollBack Transaction.                               |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function dbEnd()
    {
        return DB::rollback();
    }

    /**
     * -------------------------------------------------------
     * | RollBack Transaction.                               |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function dbRollBack()
    {
        return DB::rollback();
    }

    /**
     * -------------------------------------------------------
     * | Status List.                                        |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function properStatusList()
    {
        return $this->mergeSelectOption([
            0 => config('constant.inactive'),
            1 => config('constant.active'),
        ],'status');
    }

     /**
     * -------------------------------------------------------
     * | Genrate Result                                      |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function generateResult($studentTestPaper){
        try{
            $studentTestResults = $studentTestPaper->studentResult;
            $startDate = date('Y-m-01',strtotime($studentTestResults->created_at)).' 00:00:00';
            $endDate = date('Y-m-t',strtotime($studentTestResults->created_at)).' 23:59:59';
            $totalStudentAttemptTest = StudentTestPaper::where(['mock_test_paper_id'=>$studentTestPaper->mock_test_paper_id,'is_completed'=>1])
                                        ->select('id','mock_test_paper_id','is_completed')
                                        ->whereHas('studentResult',function($query) use($startDate,$endDate){
                                            $query->whereBetween('created_at',[$startDate,$endDate]);
                                        })
                                        ->count();
            $student = $studentTestPaper->student;
            $mockTest = $studentTestResults->mockTest;
            $studentTest = $studentTestPaper->studentTest;
            $attemptedCount = $studentTestResults->currentStudentTestQuestionAnswers()
                                ->where('is_attempted','1')
                                ->count();
            $correctlyAnswered = $studentTestResults->currentStudentTestQuestionAnswers()
                                ->where('is_attempted','1')
                                ->where('is_correct','1')
                                ->count();
            $unAnswered = $studentTestResults->currentStudentTestQuestionAnswers()
                        ->where('is_attempted','!=','1')
                        ->count();
            if($mockTest->stage_id == 1){
                $questionIds = $studentTestResults->currentStudentTestQuestionAnswers()->where('is_correct','1')->pluck('question_id');
                $obtainedMark = Question::whereIn('id', $questionIds)->sum('marks');
            }else{
                $obtainedMark = $studentTestResults->obtained_marks;
            }
            $overAllResult = 0;
            if ($attemptedCount > 0 && $studentTestResults->total_marks > 0 && $obtainedMark >0) {
                $overAllResult = ($obtainedMark * 100) / $studentTestResults->total_marks;
                $overAllResult = number_format($overAllResult,2);
            }
            $questions = ($studentTestResults->studentTestQuestionAnswers != null && !empty($studentTestResults->studentTestQuestionAnswers->toArray())) ? $studentTestResults->studentTestQuestionAnswers->count() : 0;
            $studentTestResults->update([
                'attempted' => $attemptedCount,
                'correctly_answered' => $correctlyAnswered,
                'unanswered' => $unAnswered,
                'obtained_marks' => $obtainedMark,
                'overall_result' => $overAllResult,
                'questions' => $questions,
            ]);
            $questions = $studentTestResults->questions;
            $attempted = $studentTestResults->attempted;
            $correctlyAnswered = $studentTestResults->correctly_answered;
            $unanswered = $studentTestResults->unanswered;
            $totalMarks = $studentTestResults->total_marks;
            $obtainedMarks = $studentTestResults->obtained_marks;
            $overAllResult = 0;
            if ($attempted > 0 && $totalMarks > 0) {
                $overAllResult = ($obtainedMarks * 100) / $totalMarks;
                $overAllResult = number_format($overAllResult,2);
            }
            $studentTestPaper->update([
                'questions' => $questions,
                'attempted' => $attempted,
                'correctly_answered' => $correctlyAnswered,
                'unanswered' => $unanswered,
                'overall_result' => $overAllResult,
                'total_marks' => $totalMarks,
                'obtained_marks' =>$obtainedMarks,
                'is_completed'=>1,
            ]);
            $rank = 1;
            $query = StudentTestPaper::where(['mock_test_paper_id' => @$studentTestPaper->mock_test_paper_id])
                        ->whereHas('studentResult',function($query) use($startDate,$endDate){
                            $query->whereBetween('created_at',[$startDate,$endDate]);
                        });
            $testPaperResults = $query->orderBy('overall_result', 'desc')->get();
            $studentTestPaper->update(['rank'=>0]);
            if ($testPaperResults) {
                foreach ($testPaperResults as $rkey =>  $result) {
                    if($result->overall_result > 0 ){
                        if($result->overall_result != $studentTestPaper->overall_result){
                            $rank++;
                        }
                        if($result->mock_test_paper_id == $studentTestPaper->mock_test_paper_id && $studentTestPaper->student_test_id == $result->student_test_id && $studentTestPaper->student_id == $result->student_id){
                            $studentTestPaper->update(['rank'=>$rank]);
                        }
                    }
                }
            }
            $purchasedMock = PurchasedMockTest::whereMockTestId($mockTest->id)->whereStudentId($student->id)->first();
            $flag = false;
            $status = 2;
            if($studentTest){
                $paperIds = $studentTest->studentTestPapers->pluck('mock_test_paper_id')->toArray();
                $mockPaperIds = $mockTest->papers->pluck('id')->toArray();
                sort($paperIds);
                sort($mockPaperIds);
                if($paperIds == $mockPaperIds){
                    $flag = true;
                }
                // dd($paperIds,$mockPaperIds,$flag);
                if($flag == true){
                    if($mockTest->stage_id == 2){
                        $status = 3;
                        $studentTest->update(['status' => 3]);
                    }
                    if ($purchasedMock != null) {
                        $studentTest->update(['status' => $status]);
                        $purchasedMock->update(['status' => $status]);
                    }
                }
            }
            return [$totalStudentAttemptTest,$studentTestResults];
        }catch(Exception $e){
            // dd($e->getMessage());
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

}
