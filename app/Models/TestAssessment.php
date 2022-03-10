<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Auth;

class TestAssessment extends BaseModel
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'exam_board_id', 'grade_id', 'image_id', 'school_id', 'title', 'slug', 'type',
        'description', 'start_date', 'end_date', 'summury', 'header', 'project_type', 'stage_id', 'status',
        'week','school_year',
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
            $query->title = trimContent($query->title);
            $query->description = trimContent($query->description);
            $query->header = trimContent($query->header);
            $query->summury = trimContent($query->summury);
            $query->project_type = 2;
        });
        static::updating(function ($query) {
            $query->title = trimContent($query->title);
            $query->description = trimContent($query->description);
            $query->header = trimContent($query->header);
            $query->summury = trimContent($query->summury);
            $query->project_type = 2;
        });
    }

    /**
     * -------------------------------------------------------------
     * | Return the sluggable configuration array for this model.  |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ],
        ];
    }

    /**
     * This function is used for getting start date in d-m-y
     *
     * @return Date
     */
    public function getProperStartDateAttribute()
    {
        if ($this->attributes['start_date'] != null) {
            $value = $this->attributes['start_date'];
            return '<span class="hid_spn">' . date('Ymd', strtotime($value)) . '</span>' . date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }

    /**
     * This function is used for getting start date in d-m-y
     *
     * @return Date
     */
    public function getProperEndDateAttribute()
    {
        if ($this->attributes['end_date'] != null) {
            $value = $this->attributes['end_date'];
            return '<span class="hid_spn">' . date('Ymd', strtotime($value)) . '</span>' . date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }

    /**
     * This function is used for getting start date in d-m-y
     *
     * @return Date
     */
    public function getProperStartDateTextAttribute()
    {
        if ($this->attributes['start_date'] != null) {
            $value = date('d-m-Y', strtotime($this->attributes['start_date']));
            return $value;
        } else {
            return null;
        }
    }

    /**
     * This function is used for getting end date in d-m-y
     *
     * @return Date
     */
    public function getProperEndDateTextAttribute()
    {
        if ($this->attributes['end_date'] != null) {
            $value = $this->attributes['end_date'];
            return date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }

    /**
     * get that own test exam board
     *
     * @return Object     *
     */
    public function examBoard()
    {
        return $this->belongsTo('App\Models\ExamBoard', 'exam_board_id');
    }

    /**
     * get that own test grade
     *
     * @return Object
     */
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id');
    }

    /**
     * get that own test subjects
     *
     * @return Object
     */
    public function assessmentAudio()
    {
        return $this->hasMany('App\Models\TestAssessmentAudio', 'test_assessment_id')->orderBy('seq','asc');
    }

    /**
     * get that own test subjects
     *
     * @return Object
     */
    public function testAssessmentSubject()
    {
        return $this->belongsToMany('App\Models\TestAssessmentSubject', 'test_assessment_subjects', 'test_assessment_id', 'subject_id');
    }

    /**
     * get that own test subjects
     *
     * @return Object
     */
    public function subjects()
    {
        return $this->hasMany('App\Models\TestAssessmentQuestion', 'test_assessment_id');
    }

    /**
     * Get that mock subject detail
     *
     * @return Array
     */
    public function testAssessmentSubjectDetail()
    {
        return $this->hasMany('App\Models\TestAssessmentSubjectInfo', 'test_assessment_id');
    }

    /**
     * get that own test grade
     *
     * @return Array
     */
    public function image()
    {
        return $this->belongsTo('App\Models\Image', 'image_id');
    }

    /**
     * get that own test topics
     *
     * @return topics
     */
    public function topics()
    {
        return $this->hasMany('App\Models\AssessmentTopic', 'test_assessment_id');
    }

    /**
     * This function is used for getting start date in d-m-y
     *
     * @return Date
     */
    public function getStartDateMonthAttribute()
    {
        if ($this->attributes['start_date'] != null) {
            $value = $this->attributes['start_date'];
            return date('d F', strtotime($value));
        } else {
            return null;
        }
    }

    /**
     * This function is used for getting start date in d-m-y
     *
     * @return Boolean
     */
    public function getIsDisabledAttribute()
    {
        if (Auth::guard('parent')->user() != NULL) {
            $user = Auth::guard('parent')->user();
            if(strtotime($user->created_at) <= strtotime($this->start_date)){
                return false;
            }
            return true;
        }
        if (Auth::guard('student')->user() != NULL) {
            $user = Auth::guard('student')->user()->created_at;
            if(strtotime($user->created_at) <= strtotime($this->start_date)){
                return false;
            }
            return true;
        }
    }

    /**
     * -------------------------------------------------------------
     * | Get total time of assessment                              |
     * |                                                           |
     * | @return time                                              |
     * -------------------------------------------------------------
     */
    public function getTotalTimeAttribute()
    {
        if(isset($this->testAssessmentSubjectInfo) && $this->testAssessmentSubjectInfo != null){
            $times = $this->testAssessmentSubjectInfo;
            $totalTime = 0;
            foreach ($times as $time) {
                $totalTime += strtotime($time->time);
            }
            if($totalTime > 0){
                return date('H:i:s',$totalTime);
            }
            return date('H:i:s',$totalTime);
        }
        return '00:00:00';    }

    /**
     * -------------------------------------------------------------
     * | Get subjects info of assessment                           |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function testAssessmentSubjectInfo(){
        return $this->hasMany('App\Models\TestAssessmentSubjectInfo', 'test_assessment_id');
    }

    /**
     * -------------------------------------------------------------
     * | Get subjects info of assessment                           |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function testAssessmentQuestions(){
        return $this->hasMany('App\Models\TestAssessmentQuestion', 'test_assessment_id')->withCount(['questionList']);
    }

    /**
     * -------------------------------------------------------------
     * | Get total time of assessment                              |
     * |                                                           |
     * | @return time                                              |
     * -------------------------------------------------------------
     */
    public function getTotalQuestionAttribute()
    {
        $count = $this->TestAssessmentSubjectInfo->sum('total_question');
        if($count > 1){
            return $count.' Questions';
        }else{
            return $count.' Question';
        }
    }

        /**
     * -------------------------------------------------------------
     * | Get total time of assessment                              |
     * |                                                           |
     * | @return time                                              |
     * -------------------------------------------------------------
     */
    public function getTotalQuestionCountAttribute()
    {
        return $this->testAssessmentSubjectInfo->sum('questions');
    }


    /**
     * -------------------------------------------------------------
     * | Get total marks of assessment                              |
     * |                                                           |
     * | @return marks                                              |
     * -------------------------------------------------------------
     */
    public function getProperTotalMarksAttribute()
    {
        return $this->testAssessmentQuestions->sum('total_marks');
    }

    /**
     * -------------------------------------------------------------
     * | Get assessment firstQuestion                              |
     * |                                                           |
     * | @return Object                                            |
     * -------------------------------------------------------------
     */
    public function firstQuestion($studentId){
        return $this->hasOne(StudentTestQuestionAnswer::class,'test_assessment_id')
                    ->where('student_id',$studentId)
                    ->orderBy('id','asc')->first();
    }

    /**
     * -------------------------------------------------------------
     * | Get assessment image                                      |
     * |                                                           |
     * | @return Path                                              |
     * -------------------------------------------------------------
     */
    public function getImagePathAttribute()
    {
        $path = ($this->image != null && file_exists(storage_path(config('constant.image.storage_path') . $this->image))) ?
            url(config('constant.image.url_path') . $this->image) : asset('images/mock_img_tbl.png');
        return $path;
    }

    /**
     * -------------------------------------------------------------
     * | Get student test assessment                               |
     * |                                                           |
     * | @param studentId                                          |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function studentAssessment($studentId=null){
        if($studentId==NULL){
            if(Auth::guard('parent')->user()!=NULL){
                $studentId = Auth::guard('parent')->user()->childs[0]->id;
            }elseif(Auth::guard('student')->user() != NULL){
                $studentId =Auth::guard('student')->user();
            }
            return null;
        }
        return $this->hasOne(StudentTest::class,'test_assessment_id')
                    ->where('student_id',$studentId)
                    ->first();
    }

    /**
     * -------------------------------------------------------------
     * | Get student test assessment                               |
     * |                                                           |
     * | @param studentId                                          |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function studentResultAssessment($studentId){
        if($studentId==NULL){
            if(Auth::guard('parent')->user()!=NULL){
                $studentId = Auth::guard('parent')->user()->childs[0]->id;
            }elseif(Auth::guard('student')->user() != NULL){
                $studentId =Auth::guard('student')->user();
            }
            return null;
        }
        return $this->hasOne(StudentTestResults::class,'test_assessment_id')
                    ->where('student_id',$studentId)
                    ->where('is_reset','0')
                    ->orderBy('id','desc')
                    ->first();
    }

    /**
     * -------------------------------------------------------------
     * | Get total time of assessment                              |
     * |                                                           |
     * | @return time                                              |
     * -------------------------------------------------------------
     */
    public function getTotalTimeTextAttribute()
    {
        $totalTime = 0;
        if(isset($this->testAssessmentSubjectInfo) && $this->testAssessmentSubjectInfo != null){
            $totalTime = $this->testAssessmentSubjectInfo->sum('time');
        }
        return $totalTime;
    }

    /**
     * Get that paper total sections
     */
    public function getNoOfSectionAttribute(){
        return $this->testAssessmentSubjectInfo->count();
    }

    /**
     * -------------------------------------------------------------
     * | Get total time of assessment                              |
     * |                                                           |
     * | @return time                                              |
     * -------------------------------------------------------------
     */
    public function getSectionTotalTimeAttribute()
    {
        $totalTime = 0;
        if(isset($this->testAssessmentSubjectInfo) && $this->testAssessmentSubjectInfo != null){
            $totalTime = $this->testAssessmentSubjectInfo->sum('section_time');
        }
        return $totalTime;
    }

    /**
     * get test assessment stage id
     *
     * @return void
     */
    public function getStageIdAttribute()
    {
        return 1;
    }

    /**
     * This function is used for getting start date in d-m-y
     *
     * @return Date
     */
    public function getEndDateMonthAttribute()
    {
        if ($this->attributes['end_date'] != null) {
            $value = $this->attributes['end_date'];
            return date('d F', strtotime($value));
        } else {
            return null;
        }
    }

    /**
     * This function check that child can attempt
     * that assessment or not based on week date 
     * and parent registration date
     * 
     * @return Boolean
     */
    public function getActionFlagAttribute(){
        $isParent = Auth::guard('student')->check()?false:true;
        $currentDate = date('Y-m-d');
        $previous2weekDate = date('Y-m-d',strtotime("-2 week"));
        if($isParent == true){
            $parent = Auth::guard('parent')->user();
            return false;
        }else{
            $child = Auth::guard('student')->user();
            $parent = @$child->childParent;
        }
        if($parent->subscription_status != '1' && @$parent->proper_subscription_end_date < $currentDate){
            return true;
        }
        if($isParent == true || ($this->end_date <= $currentDate  && $this->end_date <= $previous2weekDate)){
            return false;
        }elseif(date('Y-m-d',strtotime($this->start_date)) > $currentDate){
            return false;
        }else{
            // compare parent created date is greater then last week date
            if(date('Y-m-d',strtotime($parent->created_at)) > $this->end_date)
            {
                return false;
            }
            return true;
        }
    }

    /**
     * This function check and set assessment status
     * based on week date
     * @return Boolean
     */
    public function getAssessmentStatusAttribute(){
        $isParent = Auth::guard('student')->check()?false:true;
        $previous2weekDate = date('Y-m-d',strtotime("-2 week"));
        $currentDate = date('Y-m-d');
        $previous2weekDate = date('Y-m-d',strtotime("-2 week"));
        if($isParent == true){
            $parent = Auth::guard('parent')->user();
        }else{
            $child = Auth::guard('student')->user();
            $parent = @$child->childParent;
        }
        if($parent->subscription_status != '1' && @$parent->proper_subscription_end_date < $currentDate){
            return 'Active';
        }
        if($this->end_date <= $currentDate  && $this->end_date <= $previous2weekDate){
            return 'Expired';
        }elseif(date('Y-m-d',strtotime($this->start_date)) > $currentDate){
            return 'To Be Active';
        }else{
            // compare with last week date
            if(date('Y-m-d',strtotime($parent->created_at)) > $this->end_date)
            {
                return 'Expired';
            }
            return 'Active';
        }
    }

    public function getExpiryDateAttribute(){
        if($this->end_date != null){
            return date('d F',strtotime("+2 week",strtotime($this->end_date)));
        }
        return null;
    }

    public function getProperExpiryDateAttribute(){
        if($this->end_date != null){
            return date('Y-m-d',strtotime("+2 week",strtotime($this->end_date)));
        }
        return null;
    }

    public function getClassAttribute(){
        $class = '';
        $currentDate = date('Y-m-d');
        if($currentDate >= $this->start_date && $currentDate <= $this->end_date){
            $class = 'border-current';
            // $class = 'bg-current';
        }elseif($currentDate >= $this->start_date && $currentDate <= $this->proper_expiry_date){
            $class = 'border-previous';
            // $class = 'bg-review';
        }else if($currentDate >= $this->proper_expiry_date){
            $class = 'border-expire';
        }
        return $class;
    }
}
