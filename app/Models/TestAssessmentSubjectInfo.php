<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TestAssessmentSubjectInfo extends Model
{
    /**
     * This function is used for getting table name
     *
     * @return void
     */
    public function getTableName()
    {
        return $this->getTable();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_assessment_id', 'subject_id', 'time', 'questions','report_question','question_id','uuid','name','description','image','instruction_read_time',
        'passage'
    ];

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string)\Str::uuid();
            }
        });
        self::updating(function ($query) {
            if (\Schema::hasColumn($query->getTableName(), 'uuid')) {
                $query->uuid = (string)\Str::uuid();
            }
        });
    }

    /**
     * get that own mock test subject detail
     *
     */
    public function subject(){
        return $this->belongsTo('App\Models\Subject','subject_id');
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function subjectQuestions(){
        return $this->hasMany('App\Models\TestAssessmentQuestion','subject_id','subject_id')->where('test_assessment_id',$this->test_assessment_id);
    }

    /**
     * get that own mock test subject time attribute
     *
     */
    public function getProperTimeAttribute(){
        return $this->time.' Minutes';
    }

    /**
     * -------------------------------------------------------------
     * | Get that subject assessment                               |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function assessment(){
        return  $this->belongsTo('App\Models\TestAssessment','test_assessment_id')
                ->select('id','uuid','title','slug','created_at','start_date');
    }

    /**
     * -------------------------------------------------------------
     * | Get that assessment test                                  |
     * |                                                           |
     * | @param studentId                                          |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function studentAssessment($studentId = null){
        if($studentId==NULL){
            if(Auth::guard('parent')->user()!=NULL){
                $studentId = Auth::guard('parent')->user()->childs[0]->id;
            }elseif(Auth::guard('student')->user() != NULL){
                $studentId =Auth::guard('student')->user();
            }
        }
        return $this->hasOne(StudentTest::class,'test_assessment_id','test_assessment_id')->where('student_id',$studentId)->first();
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function questionList(){
        return $this->hasMany('App\Models\PracticeQuestionList','question_id','question_id')
                    ->orderBy(\DB::raw('CAST(practice_question_lists.question_no AS INTEGER)'),'asc');
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function question(){
        return $this->hasOne('App\Models\PracticeQuestion','id','question_id');
    }

        /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getImagePathAttribute()
    {
        $path = ($this->image !=null && file_exists(storage_path(config('constant.question-list.storage_path').'/'.$this->image))) ?
        url(config('constant.question-list.url_path').'/'.$this->image) : null;
        return $path;
    }

    /**
     * get that own mock test subject time attribute
     *
     */
    public function getInstructionHoursAttribute(){
        $time = explode(':',$this->instruction_read_time);
        return $time[0];
    }

    /**
     * get that own mock test subject time attribute
     *
     */
    public function getInstructionMinutesAttribute(){
        $time = explode(':',$this->instruction_read_time);
        return $time[1];
    }

    /**
     * get that own mock test subject time attribute
     *
     */
    public function getInstructionSecondsAttribute(){
        $time = explode(':',$this->instruction_read_time);
        return $time[2];
    }

    /**
     * get that own mock test subject time attribute
     *
     */
    public function getSectionHoursAttribute(){
        $time = explode(':',$this->time);
        return $time[0];
    }

    /**
     * get that own mock test subject time attribute
     *
     */
    public function getSectionMinutesAttribute(){
        $time = explode(':',$this->time);
        return $time[1];
    }

    /**
     * get that own mock test subject time attribute
     *
     */
    public function getSectionSecondsAttribute(){
        $time = explode(':',$this->time);
        return $time[2];
    }

    /**
     * get total questions
     *
     */
    public function getTotalQuestionAttribute(){
        return $this->questionList->count();
    }

    /**
     * get section time in seconds
     *
     */
    public function getSectionTimeAttribute(){
        $time = explode(':', $this->time);
        $hour = ($time[0] == null || $time[0]=='')?'00':$time[0] * 3600;
        $minutes = ($time[1] == null || $time[1]=='')?'00':$time[1] * 60;
        $seconds = ($time[2] == null || $time[2]=='')?'00':$time[2];
        $examTotalTimeSeconds = $hour + $minutes + $seconds;
        return $examTotalTimeSeconds;
    }

    /**
     * get instruction read time in seconds
     *
     */
    public function getInstructionReadSecondsAttribute(){
        $time = explode(':', $this->instruction_read_time);
        $hour = ($time[0] == null || $time[0]=='')?'00':$time[0] * 3600;
        $minutes = ($time[1] == null || $time[1]=='')?'00':$time[1] * 60;
        $seconds = ($time[2] == null || $time[2]=='')?'00':$time[2];
        $examTotalTimeSeconds = $hour + $minutes + $seconds;
        return $examTotalTimeSeconds;
    }
     /**
     * get correct answer count
     *
     */
    public function correctAnswerCount($testResultId=null){
        $count = 0;
        if($testResultId != null){
            $count = $this->hasMany('App\Models\StudentTestQuestionAnswer','assessment_section_id')
                ->where(['student_test_result_id'=>$testResultId,'is_correct'=>'1'])
                ->count();
        }
        return $count;
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function questionList2(){
        return $this->hasMany('App\Models\TestAssessmentQuestion','test_assessment_subject_id','id');
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function questionList3(){
        return $this->belongsToMany('App\Models\PracticeQuestion','test_assessment_questions','test_assessment_subject_id','question_id')
                ->orderBy(\DB::raw('CAST(question_no AS INTEGER)'),'asc');
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getPassagePathAttribute()
    {
        $path = ($this->passage !=null && file_exists(storage_path(config('constant.passage.storage_path').$this->id.'/'.$this->passage))) ? 
        url(config('constant.passage.url_path').$this->id.'/'.$this->passage) : null;
        return $path;
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getQuestionIdsAttribute()
    {
        $ids = $this->questionList3->pluck('id')->toArray();
        if(!empty($ids)){
            $ids = implode(',',$ids);
        }else{
            $ids = null;
        }
        return $ids;
    }
}
