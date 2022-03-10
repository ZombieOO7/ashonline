<?php

use App\Http\Controllers\HomeController;
use App\Models\Block;
use App\Models\Cart;
use App\Models\FaqCategory;
use App\Models\MockTest;
use App\Models\PaperCategory;
use App\Models\PromoCode;
use App\Models\ResourceCategory;
use App\Models\ResultGrade;
use App\Models\Student;
use App\Models\StudentTest;
use App\Models\StudentTestResults;
use App\Models\Subject;
use App\Models\WebSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 *
 * @param [type] $array
 * @return void
 */
function orderDateFormat($date)
{
    $newDateTime = date('d/m/Y h:i A', strtotime($date));
    return $newDateTime;
}

// Datatable status list
function statusList()
{
    return [
        '' => 'Select',
        '1' => 'Active',
        '0' => 'Inactive',
    ];
}

// Resource category list
function resourceCategory()
{
    return ResourceCategory::pluck('name', 'id')->toArray();
}

// Resource category list for admin sidebar
function sidebarResourceCategory()
{
    return ResourceCategory::where('slug', '!=', 'blog')->orderBy('id', 'asc')->pluck('name', 'slug')->toArray();
}

/** This function is used for image upload  */
function commonUpload($requestImage, $folderName, $id, $width = null, $height = null)
{
    // check if directory exist
    if (!File::isDirectory($folderName)) {
        File::makeDirectory($folderName, 0755, true, true);
    }
    $directory = Storage::path($folderName . $id . "/");
    // check if directory exist
    if (!File::isDirectory($directory)) {
        File::makeDirectory($directory, 0755, true, true);
    }
    $originalName = $requestImage->getClientOriginalName();
    $path = $requestImage->store($folderName . "/" . $id);
    $fileName = pathinfo($path, PATHINFO_FILENAME) . '.' . pathinfo($path, PATHINFO_EXTENSION);
    // check if width and height not null
    if ($width && $height) {
        $resizeDirectory = $directory . "resize/";
        if (!File::isDirectory($resizeDirectory)) {
            File::makeDirectory($resizeDirectory, 0755, true, true);
        }
        $img = Image::make($directory . $fileName)->resize($width, $height)->save($resizeDirectory . $fileName);
    }
    return [$fileName, $originalName];
}

function truncate($string = null, $length = null)
{
    // check string length is greater than or qual or not to length
    if (strlen(@$string) >= $length) {
        return Str::limit(@$string, $length);
    } else {
        return @$string;
    }

}

// For blog/gudance category list
function paperCategory()
{
    return PaperCategory::active()->orderBy('position', 'asc')->pluck('title', 'id')->toArray();
}

// For blog category list
function blogPaperCategory()
{
    return PaperCategory::active()->orderBy('position', 'asc')->pluck('title', 'slug')->toArray();
}

/**
 * ------------------------------------------------------
 * | Get Paper Category List with papers                |
 * | in frontend                                        |
 * |-----------------------------------------------------
 */
function getPaperCategoryList()
{
    return PaperCategory::active()
        ->notDeleted()
        ->orderBy('position', 'ASC')
        ->get();
}

/**
 * ------------------------------------------------------
 * | Get Paper Category List for header with papers     |
 * | in frontend                                        |
 * |-----------------------------------------------------
 */
function footerPaperCategoryList()
{
    return PaperCategory::orderBy('sequence', 'asc')
        ->active()
        ->notDeleted()
        ->get();
}

/**
 * -------------------------------------------------------
 * | Get cart items count                                |
 * |                                                     |
 * -------------------------------------------------------
 */
function getCartItemsCount()
{
    $product = session()->get('cartProducts');
    return $product ? count($product) : 0;
}

/**
 * -------------------------------------------------------
 * | Get Settings                                        |
 * |                                                     |
 * -------------------------------------------------------
 */
function settings()
{
    return PromoCode::whereStatus(1)
        ->whereDate('start_date', '<=', date("Y-m-d"))
        ->whereDate('end_date', '>=', date("Y-m-d"))
        ->where('deleted_at', null)
        ->first();
}

/**
 * -------------------------------------------------------
 * | Get Website Settings                                |
 * |                                                     |
 * -------------------------------------------------------
 */
function getWebSettings()
{
    $setting = WebSetting::first();
    return @$setting;
}

function monthList()
{
    $months = [
        1 => "January",
        2 => "February",
        3 => "March",
        4 => "April",
        5 => "May",
        6 => "June",
        7 => "July",
        8 => "August",
        9 => "September",
        10 => "October",
        11 => "November",
        12 => "December",
    ];

    return $months;
}

function dateList()
{
    $days = [];
    $days[''] = 'Select Date';
    for ($i = 1; $i <= 31; $i++) {
        if ($i <= 9) {
            $days[$i] = '0' . $i;
        } else {
            $days[] = $i;
        }
    }
    return $days;
}

/**
 * -------------------------------------------------------
 * | Get Block Type                                      |
 * |                                                     |
 * -------------------------------------------------------
 */
function getBlockByType($projectType, $type)
{
    return Block::whereType($type)
        ->whereProjectType($projectType)
        ->orderBy('id', 'ASC')
        ->pluck('title');
        // ->get();
}

/**
 * -------------------------------------------------------
 * | Get Footer faq                                      |
 * |                                                     |
 * -------------------------------------------------------
 */
function getFooterFaqs()
{
    return FaqCategory::whereHas('frontendFaqs')
        ->whereStatus(1)
        ->whereDeletedAt(null)
        ->get();
}

function reportYearList()
{
    $year = [2019 => 2019];
    $yesterday = date('d.m.Y', strtotime("-1 days"));
    $yesterdayYear = date('Y', strtotime($yesterday));
    // check yesterdayYear is not equal to current year
    if ($yesterdayYear != date('Y')) {
        $year[$yesterdayYear] = $yesterdayYear;
    } else {
        $min = date('Y');
        $max = $min;
        for ($i = $min; $i <= $max; $i++) {

            $year[$i] = $i;
        }
    }
    return $year;
}

function monthNameList()
{
    return [
        '01' => "Jan",
        '02' => "Feb",
        '03' => "Mar",
        '04' => "Apr",
        '05' => "May",
        '06' => "Jun",
        '07' => "Jul",
        '08' => "Aug",
        '09' => "Sep",
        '10' => "Oct",
        '11' => "Nov",
        '12' => "Dec",
    ];
}

// Paper subject list
function subjectList()
{
    return Subject::whereStatus(1)->pluck('title', 'id')->toArray();
}


/**
 * ------------------------------------------------------
 * | Exapire or disable  mock exam                      |
 * |                                                    |
 * | @param $uuid                                       |
 * |-----------------------------------------------------
 */
function disableMockExam()
{
    $today = Carbon::now();
    $mockExam = MockTest::where('end_date', '<', $today)
        ->update(['start_date' => null, 'end_date' => null, 'status' => 0]);
    return;
}

/** This function is used for image upload  */
function uploadOtherImage($requestImage, $folderName, $userId=null)
{
    // $originalName = $requestImage->getClientOriginalName();
    //  check if folder exist in directory
    if (!File::isDirectory($folderName)) {
        File::makeDirectory($folderName, 0777, true, true);
    }
    if($userId != null){
        $dir = $folderName . $userId . '/';
    }else{
        $dir = $folderName;
    }
    $subDirectory = Storage::path($dir);
    //  check if sub folder exist in directory
    if (!File::isDirectory($subDirectory)) {
        File::makeDirectory($subDirectory, 0777, true, true);
    }
    $path = $requestImage->store($dir);
    $fileName = pathinfo($path, PATHINFO_FILENAME) . '.' . pathinfo($path, PATHINFO_EXTENSION);

    return $fileName;
}

// Datatable status list
function properStatusList()
{
    return [
        '' => 'Select',
        config('constant.active') => 'Active',
        config('constant.inactive') => 'Inactive',
    ];
}

// Datatable status list
function properStatusList2()
{
    return [
        '' => 'Select',
        config('constant.active') => 'Active',
        config('constant.inactive') => 'Inactive',
        config('constant.deactivate') => 'Deactivate',
    ];
}

function schoolYearList()
{
    for ($i = 1; $i <= 13; $i++) {
        $years[$i] = $i;
    }
    return $years;
}

function generateStudentNo()
{
    $last = 1001;
    $lastStudent = Student::orderBy('id', 'desc')->withTrashed()->first();
    if ($lastStudent) {
        $lastStudentId = $lastStudent->student_no;
        $newStudentNo = $lastStudentId + 1;
    } else {
        $newStudentNo = $last;
    }
    return $newStudentNo;
}

/**
 * -------------------------------------------------------
 * | Get emock cart items count                          |
 * |                                                     |
 * -------------------------------------------------------
 */
function getEmockCartItemsCount()
{
    Cart::whereParentId(Auth::guard('parent')->id())
        ->whereHas('mockTest', function ($q) {
            $q->whereStatus(0);
        })->delete();
    Cart::whereParentId(Auth::guard('parent')->id())
        ->whereHas('paper', function ($q) {
            $q->whereStatus(0);
        })->delete();
    $cartProducts = Cart::whereParentId(Auth::guard('parent')->id())
        ->count();
    return $cartProducts;
}

function hoursAndMins($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes) . ':' . '00';
}

/**
 * -------------------------------------------------------
 * | Get Subscribe section                               |
 * |                                                     |
 * -------------------------------------------------------
 */
function getSubscribeSection()
{
    $subscription = Block::whereType(1)
        ->whereSubType(8)
        ->whereProjectType(3)
        ->orderBy('id', 'ASC')
        ->first();
    return $subscription;
}

/**
 * -------------------------------------------------------
 * | trim content                                        |
 * |                                                     |
 * -------------------------------------------------------
 */
function trimContent($data)
{
    $content = strip_tags($data);
    $content = str_replace('  ', ' ', $data);
    $content = str_replace('&nbsp;&nbsp;', '', $data);
    $content = str_replace(',,', ',', $content);
    return $content;
}


/**
 * -------------------------------------------------------
 * | Image Upload                                        |
 * |                                                     |
 * -------------------------------------------------------
 */

function commonImageUpload($data)
{
    $folder_name = config('constant.image.storage_path');
    $imageName = $data->getClientOriginalExtension();
    $destinationPath = storage_path() .'/'. $folder_name;
    $filename = Str::random(25) . '.' . $imageName;
    $data->move($destinationPath, $filename);
    $getClientOriginalName = $data->getClientOriginalName();
    $mimeType = $data->getClientMimeType();
    $ImageSave = \App\Models\Image::create(['path' => $filename, 'extension' => $imageName, 'mime_type' => $mimeType,
        'original_name' => $getClientOriginalName]);
    return $ImageSave;
}


/**
 * -------------------------------------------------------
 * | Image id check                                      |
 * |                                                     |
 * -------------------------------------------------------
 */
function commonImageId($imageId)
{
    $ImageCheck = \App\Models\Image::where('id', $imageId)->first();
    return $ImageCheck;

}

/**
 * -------------------------------------------------------
 * | get Country List                                    |
 * |                                                     |
 * -------------------------------------------------------
 */
function countyList(){
    $counties = config('constant.counties');
    sort($counties);
    $countyList = [];
    foreach($counties as $county){
        $countyList[$county] = $county;
    }
    return $countyList;
}

/**
 * -------------------------------------------------------
 * | get Student test result                             |
 * |                                                     |
 * -------------------------------------------------------
 */
function studentTestResults(){
    $tests = StudentTest::whereProjectType(1)->orderBy('id', 'desc')->get();
    $rank = 0;
    foreach($tests as $test){
        $testResult = StudentTestResults::where(['student_test_id'=>$test->id,'is_reset'=>0])
                        ->orderBy('id', 'desc')
                        ->first();
        $rank++;
        $testResult = StudentTestResults::find($testResult->id)->update(['rank'=>$rank]);
    }
}

/**
 * -------------------------------------------------------
 * | logout user if login in another device              |
 * |                                                     |
 * -------------------------------------------------------
 */
function logoutUser(){
    if(Auth::guard('parent')->user() != NULL){
        $user = Auth::guard('parent')->user();
        $sessionId = session()->get('user_session_id');
        if($sessionId != $user->session_id){
            Auth::guard('parent')->logout();
            return 1;
        }
    }
    if(Auth::guard('student')->user() != NULL){
        $user = Auth::guard('student')->user();
        $sessionId = session()->get('user_session_id');
        if($sessionId != $user->session_id){
            Auth::guard('student')->logout();
            return 1;
        }
    }
    return 0;
}

/**
 * -------------------------------------------------------------
 * | Get promocode data                                        |
 * |                                                           |
 * | @return array                                             |
 * -------------------------------------------------------------
 */
function promocode(){
    $promocode = App\Models\PromoCode::whereStatus(1)
                    ->whereDate('start_date', '<=', date("Y-m-d"))
                    ->whereDate('end_date', '>=', date("Y-m-d"))
                    ->first();
    return @$promocode;
}

/**
 * -------------------------------------------------------------
 * | Get number of current week                                |
 * |                                                           |
 * | @return number                                            |
 * -------------------------------------------------------------
 */
function weekNumber(){
    $date = new DateTime('01-01-2021');
    $week = $date->format("W");
    return $week;
}

/**
 * -------------------------------------------------------------
 * | Get parent data and check it is parent                    |
 * |                                                           |
 * | @return Array                                             |
 * -------------------------------------------------------------
 */
function parentData(){
    $isParent = false;
    $parent = [];
    if(Auth::guard('student')->user() != null || Auth::guard('parent')->user()!=null){
        if(Auth::guard('parent')->user()!=null){
            $parent = Auth::guard('parent')->user();
            $isParent = true;
        }
    }
    return [$parent,$isParent];
}

/**
 * -------------------------------------------------------
 * | generate Student test result rank                   |
 * |                                                     |
 * -------------------------------------------------------
 */
function studentTestResultRank(){
    $tests = StudentTest::whereProjectType(2)->orderBy('id', 'desc')->get();
    foreach($tests as $key => $test){
        $rank = 0;
        $studentTests = StudentTest::where([
                            'test_assessment_id'=>$test->test_assessment_id,
                        ])->get()
                        ->sortByDesc(function($test, $key) {
                            if(isset($test->lastTestAssessmentResult)){
                                return @$test->lastTestAssessmentResult->obtained_marks;
                            }
                        })->all();
        $previousStudentTestData = null;
        foreach($studentTests as $sTest){
            $rank++;
            if(isset($sTest->lastTestAssessmentResult) && $sTest->lastTestAssessmentResult != null){
                if($sTest->lastTestAssessmentResult->attempted > 0 && $sTest->lastTestAssessmentResult->correctly_answered > 0){
                    if($previousStudentTestData != null){
                        if($previousStudentTestData->overall_result == $sTest->lastTestAssessmentResult->overall_result){
                            $sTest->lastTestAssessmentResult->update(['rank'=>$previousStudentTestData->rank]);
                        }else{
                            $sTest->lastTestAssessmentResult->update(['rank'=>$rank]);
                        }
                    }else{
                        $sTest->lastTestAssessmentResult->update(['rank'=>$rank]);
                        $previousStudentTestData = @$sTest->lastTestAssessmentResult;
                    }
                }else{
                    $sTest->lastTestAssessmentResult->update(['rank'=>0]);
                }
            }
        }
    }
    return;
}

function forgotTestSession()
{
    $routeName= Route::currentRouteName();
    if($routeName == 'attempt-test-assessment' || $routeName == 'submit-paper' || $routeName == 'review-paper' || $routeName == 'attempt-topic-test' || $routeName == 'topic.submit-paper' || $routeName == 'topic.review-paper'){
        session()->put('isExam','yes');
    }else{
        if(session()->has('result_id')){
            session()->forget('result_id');
        }
        if(session()->has('isExam')){
            session()->forget('isExam');
        }
    }
}
function subject()
{
    return Subject::whereStatus(1)->orderBy('order_seq', 'asc')->first();
}

function isParent(){
    if(!empty(Auth::guard('student')->user())){
        $flag = false;
    }elseif(!empty(Auth::guard('parent')->user())){
        $flag = true;
    }else{
        $flag = false;
    }
    return $flag;
}

function hours()
{
    $hours = [];
    for($i=0;$i<=24;$i++){
        if($i < 10){
            $i = (int)'0'.$i;
        }
        $hours[$i] = $i;
    }
    return $hours;
}

function minutes()
{
    $minutes = [];
    for($i=0;$i<=60;$i++){
        if($i < 10){
            $i = (int)'0'.$i;
        }
        $minutes[$i] = $i;
    }
    return $minutes;
}

function seconds()
{
    $seconds = [];
    for($i=0;$i<=60;$i++){
        if($i < 10){
            $i = (int)'0'.$i;
        }
        $seconds[$i] = $i;
    }
    return $seconds;
}

function shortContent($text=null,$length=null){
    if($length == null){
        $length = 70;
    }
    if($text != null){
        $string = Str::limit(@$text, $length);
        return $string;
    }
    return;
}

function percentages(){
    $pr = [];
    for($i=0; $i <= 100; $i++){
        $pr[$i] = $i.'%';
    }
    return $pr;
}

function setResultType($score,$paperId){
    $resultType = ResultGrade::where('mock_test_paper_id',$paperId)->first();
    $veryGoodMax= @$resultType->very_good_max??config('constant.very_good_max');
    $excellentMax= @$resultType->excellent_max??config('constant.excellent_max');
    $goodMax= @$resultType->good_max??config('constant.good_max');
    $fairMax= @$resultType->fair_max??config('constant.fair_max');
    $improveMax= @$resultType->improve_max??config('constant.improve_max');
    $improveMin= @$resultType->improve_min??config('constant.improve_min');
    if($score >= $veryGoodMax && $score <= $excellentMax)
        $resultType = __('formname.excellent');
    elseif($score >= $goodMax && $score <= $veryGoodMax)
        $resultType = __('formname.very_good');
    elseif($score >= $fairMax && $score <= $goodMax)
        $resultType = __('formname.good');
    elseif($score >= $improveMax && $score <= $fairMax)
        $resultType = __('formname.fair');
    elseif($score >= $improveMin && $score <= $improveMax)
        $resultType = __('formname.need_improvement');
    else
        $resultType = '---';

    return $resultType;
}

/**
 * -------------------------------------------------------
 * | Get Billing Info                                    |
 * |                                                     |
 * | @return billingAddress                              |
 * -------------------------------------------------------
 */
function onlyAddress($address)
{
    $billingInfo = [];
    foreach($address as $key => $value){
        if(($value != '' && $value != ' ' && $value != NULL && $value != null) && ($key != 'full_name' && $key !='short_city')){
            $billingInfo[$key] = $value;
        }
    }
    return implode(', ',$billingInfo);
}

/**
 * -------------------------------------------------------
 * | Get Month List                                      |
 * |                                                     |
 * | @return billingAddress                              |
 * -------------------------------------------------------
 */
function month()
{
    $months = [];
    for ($i=1; $i<=12; $i++) {
        $month = date('F', mktime(0,0,0,$i, 1, date('Y')));
        $months = $month;
    }
    return $months;
}

/**
 * ------------------------------------------------------
 * | Get Number Of Month List                           |
 * |                                                    |
 * |-----------------------------------------------------
 */
function noOfMonth($month){
    return date('F', mktime(0,0,0,$month, 1, date('Y')));
}

/**
 * ------------------------------------------------------
 * | Get Parent Or child school year                     |
 * |                                                    |
 * |-----------------------------------------------------
 */
function schoolYears(){
    // if login user is parent
    if(Auth::guard('parent')->check() == true){
        // get child school years
        $parent = Auth::guard('parent')->user();
        $schoolYears = $parent->child_school_years;
    }else{
        // get child school year
        $student = Auth::guard('student')->user();
        // if child school year is 6 then child can show year 5 and year 6 mocks
        if($student->school_year == 6){
            $schoolYears[] = [5,6];
        }
        $schoolYears[] = $student->school_year;
    }
    return $schoolYears;
}