<?php

namespace App\Helpers;

use App\Models\PracticeTestResult;
use App\Models\Student;

class StudentTopicTestHelper extends BaseHelper
{
    protected $testAssessment,$student,$studentTest;

    public function __construct(Student $student, PracticeTestResult $testResult)
    {
        $this->student = $student;
        $this->testResult = $testResult;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Mock Test list                                 |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function list($request)
    {
        $fromDate = date('Y-m-d 00:00:00',strtotime($request->start_date));
        $toDate = date('Y-m-d 23:59:59',strtotime($request->end_date));
        $students = $this->student->whereId($request->student_id)
                    ->whereHas('practiceTestResult', function($query) use($fromDate,$toDate){
                        if ($fromDate && $toDate) {
                            $query->whereRaw("(created_at >= ? AND created_at <= ?)", [$fromDate, $toDate]);
                        }
                    })
                    ->get();
        return $students;
    }

    /**
     * ------------------------------------------------------
     * | Get child data                                     |
     * |                                                    |
     * | @param uuid                                        |
     * | @return Object                                     |
     * |-----------------------------------------------------
     */
    public function findStudent($uuid)
    {
        $student = $this->student::whereUuid($uuid)->first();
        return $student;
    }

    /**
     * ------------------------------------------------------
     * | Get child data                                     |
     * |                                                    |
     * | @param uuid                                        |
     * | @return Object                                     |
     * |-----------------------------------------------------
     */
    public function findStudentById($id){
        $student = $this->student::whereId($id)->first();
        return $student;
    }

    /**
     * ------------------------------------------------------
     * | Get test data                                      |
     * |                                                    |
     * | @param uuid                                        |
     * | @return Object                                     |
     * |-----------------------------------------------------
     */
    public function studentTest($id){
        $student = $this->testResult::whereUuid($id)->first();
        return $student;
    }

    /**
     * ------------------------------------------------------
     * | Get count of test data                             |
     * |                                                    |
     * | @param uuid                                        |
     * | @return Object                                     |
     * |-----------------------------------------------------
     */
    public function totalTest($studentTest){
        $total = $this->testResult::where('test_assessment_id',$studentTest->test_assessment_id)->count();
        return $total;
    }

}
