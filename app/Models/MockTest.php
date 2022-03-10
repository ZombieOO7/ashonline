<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class MockTest extends BaseModel
{
    use Sluggable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_board_id', 'grade_id', 'subject_id', 'title', 'slug', 'description', 'start_date', 'end_date',
        'stage_id', 'price', 'status', 'school_id', 'image', 'code_status', 'show_mock', 'image_id',
        'no_of_days','instruction'
    ];
    // protected $attributes = ['total_time'];
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
            $query->instruction = trimContent($query->instruction);
        });
        static::updating(function ($query) {
            $query->title = trimContent($query->title);
            $query->description = trimContent($query->description);
            $query->instruction = trimContent($query->instruction);
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
     * @return void
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
     * @return void
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
     * @return void
     */
    public function getProperStartDateTextAttribute()
    {
        if ($this->attributes['start_date'] != null) {
            $value = $this->attributes['start_date'];
            return date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }

    /**
     * This function is used for getting end date in d-m-y
     *
     * @return void
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
     */
    public function examBoard()
    {
        return $this->belongsTo('App\Models\ExamBoard', 'exam_board_id');
    }

    /**
     * get that own test grade
     *
     * @return void
     */
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id');
    }

    /**
     * get that own test subjects
     *
     * @return void
     */
    public function mockTestSubject()
    {
        return $this->belongsToMany('App\Models\MockTest', 'mock_test_subjects', 'mock_test_id', 'subject_id');
    }

    /**
     * get that own test subjects
     *
     * @return void
     */
    public function subjects()
    {
        return $this->hasMany('App\Models\MockTestSubject', 'mock_test_id');
    }

    /**
     * This function is used for getting image path
     *
     * @return path
     */
    public function getImagePathAttribute()
    {
        $path = ($this->image != null && file_exists(storage_path(config('constant.image.storage_path') . $this->image))) ?
            url(config('constant.image.url_path') . $this->image) : asset('images/mock_img_tbl.png');
        return $path;
    }

    /**
     * Get that mock subject detail
     */
    public function mockTestSubjectDetail()
    {
        return $this->hasMany('App\Models\MockTestSubjectDetail', 'mock_test_id');
    }

    /**
     * Search Active  records in List
     *
     * @return void
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Search Active  records in List
     *
     * @return void
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * get that own test grade
     *
     * @return void
     */
    public function school()
    {
        return $this->belongsTo(Schools::class, 'school_id');
    }

    /**
     * get that own test grade
     *
     * @return void
     */
    public function mockPromoCode()
    {
        return $this->belongsTo('App\Models\MockPromoCode', 'id', 'mock_test_id');
    }

    /**
     * get that own test subjects
     *
     * @return void
     */
    public function parentMockTest()
    {
        return $this->hasMany('App\Models\ParentMockTest', 'mock_test_id');
    }

    /**
     * get that own test subjects
     *
     * @return void
     */
    public function mockAudio()
    {
        return $this->hasMany('App\Models\MockAudio', 'mock_test_id');
    }

    /**
     * Get that mock subject price with currency prefix
     */
    public function getPriceTextAttribute()
    {
        return @config('constant.default_currency_symbol') . $this->price;
    }


    /**
     * get that mock test own start and end date
     *
     * @return void
     */
    public function getProperStartDateAndEndDateAttribute()
    {
        $startDate = null;
        $endtDate = null;
        if ($this->start_date != null) {
            $startDate = date('jS M Y', strtotime($this->start_date));
        }
        if ($this->end_date != null) {
            $endtDate = date('jS M Y', strtotime($this->end_date));;
        }
        if ($startDate != null && $endtDate != null)
            return $startDate . ' - ' . $endtDate;
        else
            return null;
    }

    /**
     * Get that mock single subject detail
     */
    public function mockTestSubjectTime()
    {
        return $this->hasOne('App\Models\MockTestSubjectDetail', 'mock_test_id');
//        return $this->hasMany('App\Models\MockTestSubjectDetail', 'mock_test_id');
    }

    public function mockTestSubjectMultipleTime()
    {
        return $this->hasMany('App\Models\MockTestSubjectDetail', 'mock_test_id');
    }


    public function getTotalTimeAttribute()
    {

        if(isset($this->mockTestSubjectMultipleTime) && $this->mockTestSubjectMultipleTime != null){
            $times = $this->mockTestSubjectMultipleTime;
            $totalTime = 0;
            foreach ($times as $time) {
                $totalTime += strtotime($time->time);
            }
            if($totalTime > 0){
                return date('H:i:s',$totalTime);
            }
            return date('H:i:s',$totalTime);
        }
        return '00:00:00';
    }

    /**
     * Get that mock single subject detail
     */
    public function mockTestSubjectQuestion()
    {
        return $this->hasMany('App\Models\MockTestSubjectQuestion', 'mock_test_id');
    }

    /**
     * Get that mock single subject detail
     */
    public function mockTestSubjectList()
    {
        return $this->hasMany('App\Models\MockTestSubject', 'mock_test_id');
    }


    /**
     * Get that mock single subject detail
     */
    public function mockTestReviews()
    {
        return $this->hasMany('App\Models\PurchasedMockTestRating', 'mock_test_id');
    }
    /**
     * Get Average Rate subject detail
     */
    public function getAverageRateAttribute()
    {
        if($this->mockTestReviews->count() > 0){
            $totalRatings = $this->mockTestReviews->count() * 5;
            $sumOfRating = $this->mockTestReviews->sum('rating');
            $averageRating = ($sumOfRating * 5)/$totalRatings;
            return number_format($averageRating,1);
        }
        return 0;
    }
     /**
     * Get Total Review subject detail
     */
    public function getTotalReviewAttribute()
    {
        return $this->mockTestReviews->count();
    }

    /**
     * Get that mock papers
     */
    public function papers()
    {
        return $this->hasMany('App\Models\MockTestPaper', 'mock_test_id')->orderBy('id','asc');
    }

    /**
     * -------------------------------------------------------------
     * | Get mock test paper count                                 |
     * |                                                           |
     * | @return count                                             |
     * -------------------------------------------------------------
    */
    public function getTotalPaperAttribute(){
        return $this->papers->count();
    }

    /**
     * -------------------------------------------------------------
     * | Get mock test paper count                                 |
     * |                                                           |
     * | @return count                                             |
     * -------------------------------------------------------------
    */
    public function getTotalPaperTimeAttribute(){
        $paperTime = $this->papers()->select('time')->pluck('time');
        $totalTime = null;
        foreach($paperTime as $time){
            $totalTime += strtotime($time);
        }
        return date('H:i:s',$totalTime);
    }

    /**
     * Get that mock papers for copy mock
     */
    public function mockPapers()
    {
        return $this->hasMany('App\Models\MockTestPaper', 'mock_test_id')
                ->select('name','time','description','is_time_mandatory','complete_instruction','created_at','updated_at')
                ->orderBy('id','asc');
    }

    /**
     * Get that mock papers
     */
    public function papers2()
    {
        return $this->hasMany('App\Models\MockTestPaper', 'mock_test_id')->orderBy('id','desc');
    }
}
