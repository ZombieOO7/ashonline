<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockTestSubjectDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mock_test_id', 'subject_id', 'time', 'questions','report_question','mock_test_paper_id','topic_id','seq',
        'description', 'image', 'instruction_read_time', 'is_time_mandatory','name','question_id', 'passage'
    ];
    /**
     * @var mixed
     */

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
        return $this->hasMany('App\Models\MockTestSubjectQuestion','subject_id','subject_id')->where('mock_test_id',$this->mock_test_id);
    }

    /**
     * get that own mock test subject time attribute
     *
     */
    public function getProperTimeAttribute(){
        return $this->time.' Minutes';
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function paperSubjectQuestions(){
        return $this->hasMany('App\Models\MockTestSubjectQuestion','mock_test_paper_id','mock_test_paper_id')->where('subject_id',$this->subject_id)->orderBy('subject_id','asc');
    }


    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getImagePathAttribute()
    {
        $path = ($this->image !=null && file_exists(storage_path(config('constant.question-list.storage_path').'/'.$this->image))) ?
        url(config('constant.question-list.url_path').'/'.$this->image) : asset('images/mock_img_tbl.png');
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

    public function correctAnswerCount($testResultId=null){
        $count = 0;
        if($testResultId != null){
            $count = $this->hasMany('App\Models\StudentTestQuestionAnswer','section_id')
                ->where(['student_test_result_id'=>$testResultId,'is_correct'=>'1','is_attempted'=>'1'])
                ->count();
        }
        return $count;
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function questionList(){
        return $this->hasMany('App\Models\QuestionList','question_id','question_id')
                ->orderBy(\DB::raw('CAST(question_lists.question_no AS INTEGER)'),'asc');
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function question(){
        return $this->hasOne('App\Models\Question','id','question_id');
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function questionList2(){
        return $this->hasMany('App\Models\MockTestSubjectQuestion','mock_test_subject_detail_id','id');
    }

    /**
     * get that own mock test subject questions
     *
     */
    public function questionList3(){
        return $this->belongsToMany('App\Models\Question','mock_test_subject_questions','mock_test_subject_detail_id','question_id')
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
