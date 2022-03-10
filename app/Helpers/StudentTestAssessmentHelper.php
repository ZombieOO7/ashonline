<?php

namespace App\Helpers;

use App\Models\Student;
use App\Models\StudentTest;
use App\Models\PracticeTestResult;
use App\Models\StudentTestResults;

class StudentTestAssessmentHelper extends BaseHelper
{
    protected $testAssessment,$student,$studentTest,$studentTestResult;

    public function __construct(Student $student, StudentTest $studentTest,PracticeTestResult $studentTestResult)
    {
        $this->student = $student;
        $this->studentTest = $studentTest;
        $this->studentTestResult = $studentTestResult;
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
                    ->whereHas('testAssessment', function($query) use($fromDate,$toDate){
                        if ($fromDate && $toDate) {
                            // $query->whereRaw("(start_date >= ? AND end_date <= ?)", [$fromDate, $toDate]);
                            $query->whereBetween('updated_at',[$fromDate, $toDate]);
                        }
                    });
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
        $student = $this->studentTest::whereUuid($id)->first();
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
        $total = $this->studentTest::where('test_assessment_id',$studentTest->test_assessment_id)->count();
        return $total;
    }

    /**
     * ------------------------------------------------------
     * | Get test data                                      |
     * |                                                    |
     * | @param uuid                                        |
     * | @return Object                                     |
     * |-----------------------------------------------------
     */
    public function studentTestResult($id){
        $student = $this->studentTestResult::whereUuid($id)->first();
        return $student;
    }

}
