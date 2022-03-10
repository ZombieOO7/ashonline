<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StudentTestResults extends BaseModel
{
    use SoftDeletes;
    protected $table= 'student_test_results';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =[
        'uuid', 'student_id', 'mock_test_id', 'questions', 'attempted','student_test_id',
        'correctly_answered', 'unanswered', 'overall_result', 'marks','is_reset','obtained_marks',
        'total_marks','rank', 'test_assessment_id','student_test_paper_id'
    ];

    /**
     * get that own test student
     *
     * @return Object
     */
    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id')->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function mockTest()
    {
        return $this->belongsTo('App\Models\MockTest', 'mock_test_id')->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function studentTestQuestionAnswers()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('test_assessment_id','=',NULL)
                    ->orderBy('id','asc')
                    ->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function attemptTestQuestionAnswers()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('test_assessment_id','=',NULL)
                    ->whereIsAttempted(1)
                    ->orderBy('id','asc')
                    ->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return attribute
     */
    public function getOverallResultTextAttribute()
    {
        return number_format($this->overall_result,2);
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function correctAnswers()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('test_assessment_id','=',NULL)
                    ->whereIsCorrect(1)
                    ->orderBy('id','asc')
                    ->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function halfCorrectAnswer()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('test_assessment_id','=',NULL)
                    ->whereIsCorrect(4)
                    ->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function fairCorrectAnswer()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('test_assessment_id','=',NULL)
                    ->whereIsCorrect(3)
                    ->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function mostlyCorrectAnswer()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('test_assessment_id','=',NULL)
                    ->whereIsCorrect(5)
                    ->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function unanswerdQuestionAnswers()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('test_assessment_id','=',NULL)
                    ->whereIsAttempted(0)
                    ->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function studentTest()
    {
        return $this->belongsTo('App\Models\StudentTest','student_test_id')->withTrashed();
    }

    /**
     * get that own test question answers
     *
     * @return Object
     */
    public function currentTestQuestionAnswers()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('mock_test_id','=',NULL)
                    ->orderBy('id','asc');
    }

    /**
     * get that own test question answers
     *
     * @return Object
     */
    public function markAsReviewCount()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('mock_test_id','=',NULL)
                    ->where('mark_as_review',1)
                    ->orderBy('id','asc');
    }

    /**
     * get that own test question answers
     *
     * @return Object
     */
    public function unansweredTestQuestionAnswers()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('mock_test_id','=',NULL)
                    ->whereIsAttempted(0)
                    ->orderBy('id','asc');
    }
    /**
     * get that own test question answers
     *
     * @return Object
     */
    public function getOverallResultPerAttribute()
    {
        $per = 0;
        if($this->obtained_marks > 0 && $this->total_marks > 0){
            $per = ($this->obtained_marks * 100) / $this->total_marks;
            $per = number_format($per,2);
        }
        return $per;
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
     * get that test assessment result date
     *
     * @return Object
     */
    public function getProperDateAttribute(){
        return date('jS F Y',strtotime($this->created_at));
    }

    /**
     * get that test assessment result date
     *
     * @return Object
     */
    public function getProperMonthDateAttribute(){
        return date('jS F',strtotime($this->created_at));
    }

    /**
     * get that own test mock
     *
     * @return attribute
     */
    public function getProperOverallResultAttribute()
    {
        return round($this->overall_result,2);
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function correctAnswers2()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('mock_test_id','=',NULL)
                    ->whereIsCorrect(1)
                    ->orderBy('id','asc');
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function studentTestAssessmentQuestionAnswers()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('mock_test_id','=',NULL)
                    ->orderBy('id','asc')
                    ->withTrashed();
    }

    /**
     * get that own test mock
     *
     * @return Object
     */
    public function attemptTestQuestionAnswers2()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('mock_test_id','=',NULL)
                    ->whereIsAttempted(1)
                    ->orderBy('id','asc')
                    ->withTrashed();
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
     * get that own test mock
     *
     * @return Object
     */
    public function currentStudentTestQuestionAnswers()
    {
        return $this->hasMany('App\Models\StudentTestQuestionAnswer','student_test_result_id')
                    ->where('test_assessment_id','=',NULL)
                    ->orderBy('id','asc');
    }

    public function studentTestPaper(){
        return $this->belongsTo('App\Models\StudentTestPaper','student_test_paper_id');
    }

    public function getTotalMarkTextAttribute(){
        return $this->studentTestAssessmentQuestionAnswers->sum('question_mark');
    }

    public function getIncorrectAnswerAttribute(){
        return $this->attemptTestQuestionAnswers->where('is_correct','!=','1')->where('is_attempted','1')->count();
    }
}
