<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamBoard;
use App\Models\ExamType;
use App\Models\Grade;
use App\Models\Image;
use App\Models\ParentUser;
use App\Models\PurchasedMockTest;
use App\Models\Question;
use App\Models\QuestionList;
use App\Models\Schools;
use App\Models\Student;
use App\Models\StudentTestPaper;
use App\Models\Subject;
use App\Models\Topic;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
    public function getPartials($blade, $review)
    {
        return View::make($blade, $review)->render();
    }

    /**
     * -------------------------------------------------------
     * | Exam Board List.                                    |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function boardList()
    {
        $boardList = ExamBoard::pluck('title', 'id');
        return @$this->mergeSelectOption($boardList->toArray(), __('admin_messages.board'));
    }

    /**
     * -------------------------------------------------------
     * | Merge Select option list.                           |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function mergeSelectOption($a, $type)
    {
        return ['' => __('formname.select_type', ['type' => @$type])] + $a;
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
        ], 'status');
    }

    /**
     * -------------------------------------------------------
     * | Proper Status List.                                 |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function properStatusActiveList()
    {
        return $this->mergeSelectOption([
            0 => config('constant.inactive'),
            1 => config('constant.active'),
            2 => config('constant.deactivate'),
        ], 'status');
    }

    /**
     * -------------------------------------------------------
     * | Grade List.                                         |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function gradeList()
    {
        $gradeList = Grade::pluck('title', 'id');
        return @$this->mergeSelectOption($gradeList->toArray(), __('formname.mock-test.grade_id'));
    }

    /**
     * -------------------------------------------------------
     * | Subject List.                                       |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function subjectList()
    {
        $subjectList = Subject::pluck('title', 'id');
        return $subjectList;
    }

    /**
     * -------------------------------------------------------
     * | School List.                                        |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function schoolList()
    {
        $schoolList = Schools::whereActive(1)->whereNull('deleted_at')->get();
        return @$schoolList;
    }

    /**
     * -------------------------------------------------------
     * | All parent list.                                    |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function allParentList()
    {
        $parents = ParentUser::active()->notDeleted()->pluck('full_name', 'id');
        return @$parents;
    }

    /**
     * -------------------------------------------------------
     * | question type list.                                 |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function questionType()
    {
        return @$this->mergeSelectOption(config('constant.question_type'), __('formname.mock-test.question_type'));
    }

    /**
     * -------------------------------------------------------
     * | question sub type or exam typ list.                 |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function questionSubType()
    {
        return @$this->mergeSelectOption(config('constant.questionSubType'), __('admin_messages.type'));
    }

    /**
     * ------------------------------------------------------
     * | get exam list                                      |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function examType()
    {
        $examType = ExamType::pluck('title', 'id');
        return @$this->mergeSelectOption($examType->toArray, __('formname.test_papers.exam_type'));
    }

    /**
     * ------------------------------------------------------
     * | get interval list                                  |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function intervalList()
    {
        return @$this->mergeSelectOption(config('constant.intervalList'), __('formname.mock-test.interval'));
    }

    /**
     * ------------------------------------------------------
     * | get student list                                   |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function studentList()
    {
        $students = Student::orderBy('student_no', 'asc')->get();
        return @$students;
    }

    /**
     * ------------------------------------------------------
     * | Send Mail to customer                              |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function sendmail($view, $data, $message = null, $subject, $userdata)
    {
        Mail::send($view, $data, function ($message) use ($userdata, $subject) {
            $message->to($userdata->email)->subject($subject);
        });
    }

    /**
     * ------------------------------------------------------
     * | get report type                                    |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function reportType()
    {
        return $this->mergeSelectOption(config('constant.report_type'), 'Report Type');
    }

    /**
     * ------------------------------------------------------
     * | get mock report type                               |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function mockReportType()
    {
        return $this->mergeSelectOption(config('constant.mock_report_type'), 'Report Type');
    }

    /**
     * ------------------------------------------------------
     * | Get Images                                         |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function commonImageIdCheck()
    {
        $stages = Image::orderby('id', 'desc');
        return $stages;
    }

    /**
     * ------------------------------------------------------
     * | Get Country List                                   |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function countryList(){
        $countryList = DB::table('countries')->pluck('id','name');
        return $this->mergeSelectOption($countryList, 'Country');
    }

    /**
     * ------------------------------------------------------
     * | Get Topic List                                     |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function topicList(){
        $topicList = Topic::whereActive(1)->get()->pluck('title_text','id')->toArray();
        return $this->mergeSelectOption($topicList, 'Topic');
    }

    /**
     * -------------------------------------------------------
     * | Subject List.                                       |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function pastPaperSubjectList()
    {
        $subjectList = Subject::whereIn('slug',['english','maths'])->pluck('title', 'id');
        return $subjectList;
    }

    /**
     * -------------------------------------------------------
     * | Grade List.                                         |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function pastPaperGradeList()
    {
        $gradeList = Grade::where('slug','eleven_plus')->pluck('title', 'id');
        return @$this->mergeSelectOption($gradeList->toArray(), __('formname.mock-test.grade_id'));
    }

    /**
     * -------------------------------------------------------
     * | Past Paper Topic List.                              |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function pastPaperTopicList(){
        $topicList = Topic::whereActive(1)->get()->pluck('title_text','id')->toArray();
        return $topicList;
    }

    /**
     * -------------------------------------------------------
     * | School List.                                        |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function pastPaperSchoolList()
    {
        $schoolList = Schools::whereActive(1)->whereNull('deleted_at')->pluck('school_name','id');
        return @$schoolList;
    }

    /**
     * -------------------------------------------------------
     * | Upload image                                        |
     * |                                                     |
     * | @param $requestImage,$folderName,$width,$height     |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function uploadFile($requestImage, $folderName)
    {
        $originalName = $requestImage->getClientOriginalName();
        $path = $requestImage->store($folderName);
        $fileName = pathinfo($path, PATHINFO_FILENAME) . '.' . pathinfo($path, PATHINFO_EXTENSION);
        return [$fileName, $originalName];
    }

    /**
     * -------------------------------------------------------
     * | Subject List with select option.                     |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function properSubjectList()
    {
        $subjectList = Subject::pluck('title', 'id');
        return @$this->mergeSelectOption($subjectList->toArray(), __('formname.mock-test.subject_id'));
    }

    /**
     * ------------------------------------------------------
     * | Generate result and rank based on paper            |
     * |                                                    |
     * |-----------------------------------------------------
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
            // $studentTestPaper->update(['rank'=>$rank]);
            $questions = $studentTestResults->questions;
            $attempted = $studentTestResults->attempted;
            $correctlyAnswered = $studentTestResults->correctly_answered;
            // dd($studentTestResults->questions,$studentTestResults->correctly_answered,$studentTestResults->unanswered);
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
            $rank = 0;
            $query = StudentTestPaper::where(['mock_test_paper_id' => @$studentTestPaper->mock_test_paper_id])
                        ->whereHas('studentResult',function($query) use($startDate,$endDate){
                            $query->whereBetween('created_at',[$startDate,$endDate]);
                        });
            $testPaperResults = $query->orderBy('overall_result', 'desc')->get();
            $studentTestPaper->update(['rank'=>0]);
            if ($testPaperResults) {
                foreach ($testPaperResults as $result) {
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
            // return redirect()->back()->with('error',$e->getMessage());
            return null;
        }
    }

    /**
     * -------------------------------------------------------
     * | Subject List.                                       |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function subjectList2()
    {
        $subjectList = Subject::whereIn('slug',['maths','english'])->pluck('title', 'id');
        return $subjectList;
    }

    /**
     * -------------------------------------------------------
     * | Subject List.                                       |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function practiceSubjectList()
    {
        $subjectList = Subject::whereIn('slug',['maths','english','vr'])->pluck('title', 'id');
        return $subjectList;
    }

    /**
     * ------------------------------------------------------
     * | Get School Year List                               |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function yearList(){
        $schoolYear = config('constant.school_year');
        return $this->mergeSelectOption($schoolYear, 'school year');
    }
    /**
     * ------------------------------------------------------
     * | Get Month List                                     |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function monthList(){
        $monthList = monthList();
        return $this->mergeSelectOption($monthList, 'month');
    }

    /**
     * ------------------------------------------------------
     * | Get Number Of Month List                           |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function noOfMonth($month){
        return date('F', mktime(0,0,0,$month, 1, date('Y')));
    }
}
