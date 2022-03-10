<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MockTestPaper extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mock_test_id','name','time','description','is_time_mandatory','image','complete_instruction','uuid',
        'answer_sheet'
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
    }

    /**
     * Get that mock single subject detail
     */
    public function mockTestSubjectQuestion()
    {
        return $this->hasMany('App\Models\MockTestSubjectQuestion', 'mock_test_paper_id')->orderBy('question_id','asc');
    }

    /**
     * Get that mock single subject detail
     */
    public function mockTestSubjectDetail()
    {
        return $this->hasMany('App\Models\MockTestSubjectDetail', 'mock_test_paper_id')->orderBy('subject_id','asc');
    }

    /**
     * Get that paper subject ids attribute
     */
    public function getSubjectIdsAttribute(){
        return $this->mockTestSubjectDetail->pluck('subject_id')->toArray();
    }

    /**
     * Get that paper total sections
     */
    public function getNoOfSectionAttribute(){
        return $this->mockTestSubjectDetail->count();
    }

    /**
     * Get that test paper of login child
     */
    public function testPaper()
    {
        return $this->hasOne('App\Models\StudentTestPaper', 'mock_test_paper_id')
                ->where('student_id',Auth::guard('student')->id())
                ->orderBy('id','desc');
    }

    /**
     * Get that test paper of login child
     */
    public function studentTestPaper()
    {
        return $this->hasOne('App\Models\StudentTestPaper', 'mock_test_paper_id')
                // ->where('student_id',Auth::guard('student')->id())
                ->orderBy('id','desc');
    }

    /**
     * Get that mock single subject detail
     */
    public function mockTest(){
        return $this->belongsTo('App\Models\MockTest', 'mock_test_id');
    }

    /**
     * Get that test paper of login child
     */
    public function testPaper2()
    {
        return $this->hasOne('App\Models\StudentTestPaper', 'mock_test_paper_id')
                ->where('is_reset','0')
                ->where('is_completed','1')
                ->where('student_id',Auth::guard('student')->id())
                ->orderBy('id','desc');
    }

    /**
     * Get that mock single subject detail
     */
    public function copyMockTestSubjectDetail()
    {
        return $this->hasMany('App\Models\MockTestSubjectDetail', 'mock_test_paper_id')
                    ->orderBy('id','asc')
                    ->select('subject_id','time','questions','report_question','mock_test_paper_id','topic_id','seq',
                        'description','image','instruction_read_time','is_time_mandatory','name','created_at','updated_at');
    }

    /**
     * Get that mock single subject detail
     */
    public function resultGrade(){
        return $this->hasOne('App\Models\ResultGrade', 'mock_test_paper_id')->orderBy('id','desc');
    }

    /**
     * Get that mock paper answer sheet path
     */
    public function getAnswerSheetPathAttribute(){
        $path = ($this->answer_sheet != null && file_exists(storage_path(config('constant.mock-test-paper.storage_path').$this->id . '/' . $this->answer_sheet))) ?
        url(config('constant.mock-test-paper.url_path'). $this->id . '/' . $this->answer_sheet) : null;
        return $path;
    }

    /**
     * Get that mock paper answer sheet path
     */
    public function getAnswerSheetPath2Attribute(){
        $path = ($this->answer_sheet != null && file_exists(storage_path(config('constant.mock-test-paper.storage_path').$this->id . '/' . $this->answer_sheet))) ?
        storage_path(config('constant.mock-test-paper.storage_path').$this->id . '/' . $this->answer_sheet) : null;
        return $path;
    }
}
