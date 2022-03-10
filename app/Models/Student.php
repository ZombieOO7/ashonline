<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Student extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $guard = 'student';
    protected $table = 'students';

    /**
     * -------------------------------------------------------------
     * | The attributes that are mass assignable.                  |
     * |                                                           |
     * |  @var array                                               |
     * -------------------------------------------------------------
     */
    protected $fillable = [
        'uuid', 'first_name', 'last_name', 'dob', 'gender', 'email', 'pas
        sword', 'address', 'city', 'zip_code', 'password',
        'mobile', 'active', 'profile_pic', 'student_no', 'region', 'county', 'council', 'parent_id', 'school_year',
        'school_id', 'middle_name', 'child_password','session_id'
    ];

    protected $appends = ['full_name', 'proper_created_at'];

    /**
     * Get that student own full name
     */
    public function getFullNameAttribute()
    {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get that Child Id
     */
    public function getChildIdTextAttribute()
    {
        return ucwords('child'.$this->student_no);
    }

    /**
     * Get parent data
     */
    public function parents()
    {
        return $this->belongsTo('App\Models\ParentUser', 'parent_id');
    }

    /**
     * This function is used for getting created date in d/m/y
     *
     * @return void
     */
    public function getDobTextAttribute()
    {
        return date('m/d/Y', strtotime($this->dob));
    }

    /**
     * -------------------------------------------------------------
     * | Get Auth user password                                    |
     * |                                                           |
     * -------------------------------------------------------------
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * This function is used for getting created date in d/m/y
     *
     * @return void
     */
    public function getProperCreatedAtAttribute()
    {
        $value = $this->attributes['created_at'];
        return '<span class="hid_spn">' . date('Ymd', strtotime($value)) . '</span>' . date('d-m-Y', strtotime($value));
    }

    /*
     * Auto-sets values on creation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->uuid = (string)Str::uuid();
            StudentExamBoard::where('student_id',$query->id)->delete();
        });
        static::updating(function ($query) {
            $query->uuid = (string)Str::uuid();
            StudentExamBoard::where('student_id',$query->id)->delete();
        });
        static::deleting(function ($query) {
            StudentExamBoard::where('student_id',$query->id)->delete();
        });
    }

    /**
     * Set Active in List  // By->Yugank
     *
     * @return void
     */
    public function getActiveTagAttribute()
    {
        $value = $this->active;
        $status = "<span class='m-badge  m-badge--danger m-badge--wide'>" . __('general.inactive') . "</span>";
        if ($value) {
            $status = "<span class='m-badge  m-badge--success m-badge--wide'>" . __('general.active') . "</span>";
        }
        return $status;
    }

    /**
     * -------------------------------------------------------------
     * | Get records with status active                            |
     * |                                                           |
     * | @return array                                             |
     * -------------------------------------------------------------
     */
    public function scopeActiveSearch($query, $status)
    {
        return $query->where('active', ($status == config('constant.active')) ? 1 : 0);
    }

    /**
     * -------------------------------------------------------------
     * | set the enceypted password.                               |
     * |                                                           |
     * | @return $password                                         |
     * -------------------------------------------------------------
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getImageThumbAttribute()
    {
        $file = config('constant.app_path') . config('constant.child_profile_folder') . $this->id . '/' . $this->profile_pic;
        $avatarPath = !empty($this->profile_pic) && file_exists($file) ? url($file) : asset('newfrontend/images/profile_image.png');
        return asset($avatarPath);
    }

    public function school()
    {
        return $this->belongsTo('App\Models\Schools', 'school_id');
    }

    public function examBoard()
    {
        return $this->belongsTo('App\Models\ExamBoard', 'exam_board_id');
    }

    public function examStyle()
    {
        return $this->belongsTo('App\Models\ExamType', 'exam_style_id');
    }

    public function studentTest()
    {
        return $this->hasMany('App\Models\StudentTest', 'student_id')->whereNotNull('mock_test_id');
    }

    /**
     * Get that student own full name with email
     */
    public function getFullNameWithEmailAttribute()
    {
        return ucwords($this->first_name . ' ' . $this->last_name) . ' (' . $this->email . ')';
    }

    public function examBoards()
    {
        return $this->hasMany('App\Models\StudentExamBoard', 'student_id');
    }

    /**
     * Get that student test assessment data
     */
    public function testAssessment()
    {
        return $this->hasMany('App\Models\StudentTest', 'student_id')->whereNotNull('test_assessment_id');
    }

    /**
     * Get that student test assessment data
     */
    public function practiceTestResult()
    {
        return $this->hasMany('App\Models\PracticeTestResult', 'student_id');
    }

    /**
     * Get that student test assessment data
     */
    public function testAssessmentCount($request)
    {
        $fromDate = date('Y-m-d 00:00:00',strtotime($request->start_date));
        $toDate = date('Y-m-d 23:59:59',strtotime($request->end_date));
        $data = $this->testAssessment->whereBetween('updated_at',[$fromDate, $toDate])->count();
        return $data;
    }

    /**
     * Get that student test assessment data
     */
    public function testAssessmentData($request)
    {
        $fromDate = date('Y-m-d 00:00:00',strtotime($request->start_date));
        $toDate = date('Y-m-d 23:59:59',strtotime($request->end_date));
        $data = $this->testAssessment->whereBetween('updated_at',[$fromDate, $toDate]);
        return $data;
    }

    /**
     * Get that student test assessment data
     */
    public function testAssessmentCount2($fromDate,$toDate)
    {
        $fromDate = date('Y-m-d 00:00:00',strtotime($fromDate));
        $toDate = date('Y-m-d 23:59:59',strtotime($toDate));
        $data = $this->testAssessment->whereBetween('updated_at',[$fromDate, $toDate])->count();
        return $data;
    }

        /**
     * Get that student test assessment data
     */
    public function practiceTestCount($request)
    {
        $fromDate = date('Y-m-d 00:00:00',strtotime($request->start_date));
        $toDate = date('Y-m-d 23:59:59',strtotime($request->end_date));
        $data = $this->hasMany('App\Models\PracticeTestResult', 'student_id')->whereBetween("created_at", [$fromDate, $toDate])->count();
        return $data;
    }

    /**
     * Get that student test assessment data
     */
    public function practiceTestData($request)
    {
        $fromDate = date('Y-m-d 00:00:00',strtotime($request->start_date));
        $toDate = date('Y-m-d 23:59:59',strtotime($request->end_date));
        $data = $this->hasMany('App\Models\PracticeTestResult', 'student_id')->whereBetween("created_at", [$fromDate, $toDate])->get();
        return $data;
    }

    /**
     * Get that student test assessment data
     */
    public function practiceTestCount2($fromDate,$toDate)
    {
        $fromDate = date('Y-m-d 00:00:00',strtotime($fromDate));
        $toDate = date('Y-m-d 23:59:59',strtotime($toDate));
        $data = $this->hasMany('App\Models\PracticeTestResult', 'student_id')->whereBetween("created_at", [$fromDate, $toDate])->count();
        return $data;
    }

    /**
     * Get that student test assessment data
     */
    public function studentTestCount($fromDate,$toDate)
    {
        $data = $this->studentTest()->whereBetween('updated_at',[$fromDate, $toDate])
                ->whereHas('mockTest')
                ->count();
        return $data;
    }

    /**
     * Get parent data
     */
    public function childParent()
    {
        return $this->belongsTo('App\Models\ParentUser', 'parent_id');
    }
}
