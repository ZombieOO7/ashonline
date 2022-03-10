<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Support\Facades\Auth;
use Cviebrock\EloquentSluggable\Sluggable;

class Subject extends BaseModel
{
    use Sluggable;

    /**
     * -------------------------------------------------------------
     * | The table associated with the model.                      |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    protected $table = 'subjects';
    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'title', 'slug', 'content', 'status', 'created_at', 'updated_at', 'uuid', 'image_name',
        'image_path', 'thumb_path', 'extension', 'mime_type', 'deleted_at','order_seq',
    ];
    /**
     * -------------------------------------------------------------
     * | The storage format of the model's date columns.           |
     * |                                                           |
     * |  @var string                                              |
     * -------------------------------------------------------------
     */
    public $dates = [
        'deleted_at',
    ];

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
                'onUpdate' => false,
            ],
        ];
    }
    /**
     * -------------------------------------------------------------
     * | Get subject status active                                 |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    /**
     * -------------------------------------------------------------
     * | Get subject not deleted                                   |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }
    /**
     * -------------------------------------------------------------
     * | Get subject paper categoy                                 |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function subjectCategories()
    {
        return $this->belongsToMany('App\Models\PaperCategory', 'subject_paper_categories', 'subject_id', 'paper_category_id');
    }
    /**
     * -------------------------------------------------------------
     * | Get paper categoy                                         |     
     * |                                                           | 
     * | @return array                                             | 
     * -------------------------------------------------------------
     */
    public function papers(){
        return  $this->belongsToMany('App\Models\Paper','subjects','id', 'id');
    }

    /**
     * -------------------------------------------------------------
     * | Get paper categoy subject                                 |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function categoryPapers(){
        return  $this->hasMany('App\Models\Paper','subject_id','id');
     }

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
        });
        static::updating(function ($query) {
            $query->title = trimContent($query->title);
            $query->content = trimContent($query->content);
        });
    }

    /**
     * -------------------------------------------------------------
     * | Get that subject current week and previous two            |
     * | week assessment                                           |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function threeWeeklyAssessment($studentId=null){
        $fromDate = date("Y-m-d",strtotime("last sunday -14 days"));
        $toDate = date("Y-m-d",strtotime("+1 day"));
        $year = date("Y");
        $isParent = Auth::guard('student')->check()?false:true;
        if($isParent == true){
            $parent = Auth::guard('parent')->user();
            $child = Student::find($studentId);
        }else{
            $child = Auth::guard('student')->user();
            $parent = @$child->childParent;
        }
        $currentDate = date('d-m-Y');
        // trail period assessments
        if($parent->subscription_status != '1' && @$parent->proper_subscription_end_date < $currentDate){
            $assessmentList = $this->belongsToMany(TestAssessment::class,'test_assessment_subject_infos','subject_id','test_assessment_id')
                                ->where('test_assessments.status','1')
                                ->where('test_assessments.school_year',$child->school_year)
                                ->where('week','53')
                                ->active()
                                ->orderBy('created_at','desc')->get();
            return $assessmentList;
        }
        $assessmentList = $this->belongsToMany(TestAssessment::class,'test_assessment_subject_infos','subject_id','test_assessment_id')
                            ->where(function($query) use($fromDate,$year,$toDate,$parent){
                                $query->whereDate('test_assessments.end_date','>=',date('Y-m-d',strtotime($parent->created_at)))
                                        ->whereDate('test_assessments.start_date','>=',$fromDate)
                                        ->whereDate('test_assessments.start_date','<=',$toDate)
                                        ->whereYear('test_assessments.start_date',$year);
                            })
                            ->where('test_assessments.status','1')
                            ->where('test_assessments.school_year',@$child->school_year)
                            ->active()
                            ->orderBy('test_assessments.start_date','desc')
                            ->distinct()->get();
        return $assessmentList;
    }

    /**
     * -------------------------------------------------------------
     * | Get that subject all assessment                           |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function allAssessment($studentId=null){
        $isParent = Auth::guard('student')->check()?false:true;
        if($isParent == true){
            $parent = Auth::guard('parent')->user();
            $child = Student::find($studentId);
        }else{
            $child = Auth::guard('student')->user();
            $parent = @$child->childParent;
        }
        $currentDate = date('d-m-Y');
        // trail period assessments
        if($parent->subscription_status != '1' && @$parent->proper_subscription_end_date < $currentDate){
            $assessmentList = $this->belongsToMany(TestAssessment::class,'test_assessment_subject_infos','subject_id','test_assessment_id')
                                ->where('test_assessments.status','1')
                                ->where('week','53')
                                ->where('test_assessments.school_year',@$child->school_year)
                                ->active()
                                ->orderBy('created_at','desc')->get();
            return $assessmentList;
        }
        $assessmentList = $this->belongsToMany(TestAssessment::class,'test_assessment_subject_infos','subject_id','test_assessment_id')
                                ->where('test_assessments.status','1')
                                ->where('test_assessments.school_year',@$child->school_year)
                                ->active()
                                ->distinct()
                                ->orderBy('start_date','desc')->get();
        return $assessmentList;
    }

    /**
     * -------------------------------------------------------------
     * | Get that subject all assessment                           |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function topicList(){
        return $this->belongsToMany(Topic::class,'questions','subject_id','topic_id')
                ->where('topics.active','1')
                ->whereHas('questions')
                ->orderBy('topics.id','asc')
                ->select('topics.*')
                ->distinct();
    }

}
