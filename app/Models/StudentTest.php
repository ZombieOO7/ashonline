<?php

namespace App\Models;

class StudentTest extends BaseModel
{
    protected $table= 'student_tests';

    /* Exatra details 
    * status 1 =  
    /*

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =[
        'uuid', 'student_id', 'mock_test_id', 'status', 'duration', 'start_date', 'end_date','ip_address',
        'start_date','end_date','test_assessment_id','project_type','student_test_paper_id','questions',
        'attempted', 'correctly_answered', 'unanswered', 'overall_result','total_marks','obtained_marks',
        'rank','attempt_count'
    ];

    protected $appends = ['proper_created_at'];

    /**
     * get that own test student
     *
     * @return void
     */
    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    /**
     * get that own test mock
     *
     * @return void
     */
    public function mockTest()
    {
        return $this->belongsTo('App\Models\MockTest', 'mock_test_id');
    }

    /**
     * This function is used for getting start date in d-m-y
     *
     * @return void
     */
    public function getStartDateTextAttribute()
    {
        $value = $this->attributes['start_date'];
        return date('d-m-Y', strtotime($value));
    }

    /**
     * This function is used for getting end date in d-m-y
     *
     * @return void
     */
    public function getEndDateTextAttribute()
    {
        $value = $this->attributes['end_date'];
        return date('d-m-Y', strtotime($value));
    }

    /**
     * This function is used for getting created date in d-m-y format
     *
     * @return void
     */
    public function getCreatedAtTextAttribute()
    {
        $value = $this->attributes['created_at'];
        return date('d-m-Y', strtotime($value));
    }

    /**
     * This function is used for getting created date in user readabale format
     *
     * @return void
     */
    public function getCreatedAtUserReadableAttribute()
    {
        $value = $this->attributes['created_at'];
        return date('dS F Y', strtotime($value));
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function studentTestResult(){
        return $this->hasOne('App\Models\StudentTestResults','student_test_id')
                ->orderBy('id','desc')
                ->where('is_reset',0);
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function previousStudentTestResult(){
        return $this->hasMany('App\Models\StudentTestResults','student_test_id')
                ->orderBy('id','desc')
                ->where('is_reset',1);
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function studentTotalTestAttempt(){
        return $this->hasMany('App\Models\StudentTestResults','student_test_id')
                ->where('test_assessment_id',NULL)
                ->orderBy('id','desc');
    }

    /**
     * get that own test student
     *
     * @return void
     */
    public function child()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get that test first result                                |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function lastThreeTestResult(){
        return $this->hasMany(PracticeTestResult::class,'student_test_id')->where('is_reset','0')->orderBy('id','asc')->limit(3);
    }

    /**
     * get that own test assessment
     *
     * @return Object
     */
    public function testAssessment()
    {
        return $this->belongsTo('App\Models\TestAssessment', 'test_assessment_id')->withTrashed();
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function previousStudentAssessmentResult(){
        $id = @$this->lastTestAssessmentResult->id;
        return $this->hasMany('App\Models\PracticeTestResult','student_test_id')
                    ->where(function($q) use($id){
                        if($id != null){
                            $q->where('id','!=',$id);
                        }
                    })
                    ->orderBy('id','desc');
    }

    /**
     * Get Student Tests
     *
     * @return void
     */
    public function getTotalRankAttribute(){
        return $this->hasMany('App\Models\StudentTest','test_assessment_id')->count();
    }

    /**
     * -------------------------------------------------------------
     * | Get that test first result                                |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function lastTestAssessmentResult(){
        return $this->hasOne(PracticeTestResult::class,'student_test_id')->where('is_reset','0')->orderBy('id','desc');
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function studentTotalTestAssessmentAttempt(){
        return $this->hasMany('App\Models\PracticeTestResult','student_test_id')
                // ->where('mock_test_id',NULL)
                ->orderBy('id','desc');
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function studentTestResults(){
        return $this->hasMany('App\Models\StudentTestResults','student_test_id')
                ->orderBy('id','desc')
                ->where('is_reset',0);
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function studentTestPapers(){
        return $this->hasMany('App\Models\StudentTestPaper','student_test_id')
                // ->where(function($query){
                //     $query->whereHas('papers');
                // })
                ->orderBy('id','desc');
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function completedStudentTestPapers(){
        return $this->hasMany('App\Models\StudentTestPaper','student_test_id')
                ->where('is_completed','1')
                ->orderBy('id','desc');
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function studentPracticeTestResult(){
    return $this->hasOne('App\Models\PracticeTestResult','student_test_id')
                ->orderBy('id','desc')
                ->where('is_reset',0);
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function practiceTestResult(){
        return $this->hasOne('App\Models\PracticeTestResult','student_test_id')
                ->orderBy('id','desc')
                ->where('is_reset',0);
    }

    public function getIsPaperCompletedAttribute()
    {
        $testPaperCount = $this->completedStudentTestPapers->count();
        $mockPapersCount = $this->mockTest->mockPapers->count();
        if($mockPapersCount == $testPaperCount){
            return '1';
        }
        return '0';
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function studentTestCompleted(){
        return $this->hasMany('App\Models\StudentTestPaper','student_test_id')
                ->where('status','1')
                ->orderBy('id','desc');
    }

    /**
     * Student Test Result
     *
     * @return void
     */
    public function twoPracticeTestResult(){
        return $this->hasMany('App\Models\PracticeTestResult','student_test_id')
            ->orderBy('id','desc')
            ->where('is_reset',0)
            ->limit(2);
    }

    /**
     * Student Practice Results
     *
     * @return void
     */
    public function practiceTestResults(){
        return $this->hasMany('App\Models\PracticeTestResult','student_test_id')
                    ->orderBy('id','desc')
                    ->where('is_reset',0);
        }
}
