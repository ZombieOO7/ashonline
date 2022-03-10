<?php
namespace App\Helpers;

use App\Models\Age;
use App\Models\EmailTemplate;
use App\Models\ExamType;
use App\Models\Grade;
use App\Models\PaperCategory;
use App\Models\ParentPayment;
use App\Models\ParentSubscriber;
use App\Models\ParentSubscriptionInfo;
use App\Models\ParentUser;
use App\Models\PromoCode;
use App\Models\PurchasedMockTest;
use App\Models\Question;
use App\Models\Stage;
use App\Models\Student;
use App\Models\StudentTestPaper;
use App\Models\Subject;
use App\Models\Topic;
use Carbon\Carbon;
use DateTime;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Stripe\Charge;
use Stripe\Stripe;

class BaseHelper
{
    public $mode;
    public function __construct()
    {

    }

    /**
     * -------------------------------------------------------------
     * | DB transation start                                       |
     * |                                                           |
     * | @return Void                                              |
     * -------------------------------------------------------------
     */
    public function dbStart()
    {
        DB::beginTransaction();
    }

    /**
     * -------------------------------------------------------------
     * | DB transation end                                         |
     * |                                                           |
     * | @return Void                                              |
     * -------------------------------------------------------------
     */

    public function dbEnd()
    {
        DB::commit();
    }

    /**
     * -------------------------------------------------------------
     * | DB transation roll back                                   |
     * |                                                           |
     * | @return Void                                              |
     * -------------------------------------------------------------
     */
    public function dbRollBack()
    {
        DB::rollback();
    }

    /**
     * -------------------------------------------------------------
     * | Delete image                                              |
     * |                                                           |
     * | @param $imageName,$viewFolderName                         |
     * | @return Void                                              |
     * -------------------------------------------------------------
     */
    public function deleteImage($imageName, $viewFolderName)
    {
        $path = public_path() . $imageName;
        $path = str_replace('public', '', $path);
        // check if file exist in directory
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    /**
     * -------------------------------------------------------
     * | Upload image                                        |
     * |                                                     |
     * | @param $requestImage,$folderName,$width,$height     |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function uploadImage($requestImage, $folderName, $width, $height)
    {
        // check if width is not 64
        if ($width != config('constant.avatar_img_width')) {
            $folder_name = "/banner/";
        } else {
            $folder_name = "/thumb/";
        }
        $originalName = $requestImage->getClientOriginalName();
        $path = $requestImage->store($folderName);
        $fileName = pathinfo($path, PATHINFO_FILENAME) . '.' . pathinfo($path, PATHINFO_EXTENSION);
        $resizeDirectory = \Storage::path($folderName . $folder_name);
        // check if directory exist
        if (!File::isDirectory($resizeDirectory)) {
            File::makeDirectory($resizeDirectory, 0777, true, true);
        }
        $img = Image::make(\Storage::path($folderName . '/' . $fileName))->resize($width, $height)->save($resizeDirectory . $fileName);
        return [$fileName, $originalName];
    }

    /**
     * -------------------------------------------------------------
     * | Get Paper Category List                                   |
     * |                                                           |
     * | @return Response                                          |
     * -------------------------------------------------------------
     */
    public function paperCategories()
    {
        return PaperCategory::active()
            ->notDeleted()
            ->orderBy('title')->pluck('title', 'id');
    }

    /**
     * -------------------------------------------------------------
     * | Get Subject List                                          |
     * |                                                           |
     * | @return Response                                          |
     * -------------------------------------------------------------
     */
    public function subjects()
    {
        return Subject::active()
            ->notDeleted()
            ->orderBy('order_seq','ASC')->pluck('title', 'id');
    }

    /**
     * -------------------------------------------------------------
     * | Get Exam Types List                                       |
     * |                                                           |
     * | @return Response                                          |
     * -------------------------------------------------------------
     */
    public function examTypes()
    {
        return ExamType::active()
            ->notDeleted()
            ->orderBy('title')->pluck('title', 'id');
    }

    /**
     * -------------------------------------------------------------
     * | Get Ages List                                             |
     * |                                                           |
     * | @return Response                                          |
     * -------------------------------------------------------------
     */
    public function ages()
    {
        return Age::active()
            ->orderBy('id')->pluck('title', 'id');
    }
    /**
     * -------------------------------------------------------------
     * | Get exam type List                                        |
     * |                                                           |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function examTypesList()
    {
        return ExamType::active()
            ->notDeleted()
            ->orderBy('title')->get();
    }
    /**
     * -------------------------------------------------------------
     * | Get Active Ages List                                      |
     * |                                                           |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function agesList()
    {
        return Age::active()
            ->orderBy('id')->get();
    }

    /**
     * -------------------------------------------------------------
     * | Upload pdf file                                           |
     * |                                                           |
     * | @param $requestFile,$folderName                           |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function uploadPdf($requestFile, $folderName)
    {
        $filename = time() . '.' . $requestFile->getClientOriginalExtension();
        $path = $requestFile->storeAs($folderName, $filename);
        return [$path, $filename];
    }

    /**
     * -------------------------------------------------------------
     * | Download medias                                           |
     * |                                                           |
     * | @param $path,$fileName                                    |
     * | @return Void                                              |
     * -------------------------------------------------------------
     */
    public function forceToDownload($path, $fileName = null)
    {
        return response()->download($path, $fileName);
    }

    /**
     * ------------------------------------------------------
     * | convert digit to word                              |
     * | create slug                                        |
     * | @param $title                                      |
     * | @return slug                                       |
     * |-----------------------------------------------------
     */
    public function createSlug($title)
    {
        if (strpos($title, '+') !== false) {
            $slug = explode('+', $title);
            // check if slug is nummeric or not
            if (is_numeric($slug[0])) {
                $slug[0] = $this->numberToWord1($slug[0]);
                $slug = implode('+', $slug);
                $slug = str_replace('+', '-plus-', $slug);
                return $slug;
            }
        }
        return $title;
    }

    /**
     * ------------------------------------------------------
     * | convert digit to word                              |
     * | create slug                                        |
     * | @param $title                                      |
     * | @return slug                                       |
     * |-----------------------------------------------------
     */

    public function numberToWord1($num)
    {
        $ones = array(
            0 => "ZERO",
            1 => "ONE",
            2 => "TWO",
            3 => "THREE",
            4 => "FOUR",
            5 => "FIVE",
            6 => "SIX",
            7 => "SEVEN",
            8 => "EIGHT",
            9 => "NINE",
            10 => "TEN",
            11 => "ELEVEN",
            12 => "TWELVE",
            13 => "THIRTEEN",
            14 => "FOURTEEN",
            15 => "FIFTEEN",
            16 => "SIXTEEN",
            17 => "SEVENTEEN",
            18 => "EIGHTEEN",
            19 => "NINETEEN",
            20 => "TWENTY",
        );
        $tens = array(
            0 => "ZERO",
            1 => "TEN",
            2 => "TWENTY",
            3 => "THIRTY",
            4 => "FORTY",
            5 => "FIFTY",
            6 => "SIXTY",
            7 => "SEVENTY",
            8 => "EIGHTY",
            9 => "NINETY",
        );
        $hundreds = array(
            "HUNDRED",
            "THOUSAND",
            "MILLION",
            "BILLION",
            "TRILLION",
            "QUARDRILLION",
        ); /*limit t quadrillion */
        $num = number_format($num, 2, ".", ",");
        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));
        krsort($whole_arr, 1);
        $rettxt = "";
        foreach ($whole_arr as $key => $i) {
            while (substr($i, 0, 1) == "0") {
                $i = substr($i, 1, 5);
            }

            if ($i < 20) {
                /* echo "getting:".$i; */
                $rettxt .= $ones[$i];
            } elseif ($i < 100) {
                if (substr($i, 0, 1) != "0") {
                    $rettxt .= $tens[substr($i, 0, 1)];
                }

                if (substr($i, 1, 1) != "0") {
                    $rettxt .= " " . $ones[substr($i, 1, 1)];
                }

            } else {
                if (substr($i, 0, 1) != "0") {
                    $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                }

                if (substr($i, 1, 1) != "0") {
                    $rettxt .= " " . $tens[substr($i, 1, 1)];
                }

                if (substr($i, 2, 1) != "0") {
                    $rettxt .= " " . $ones[substr($i, 2, 1)];
                }

            }
            if ($key > 0) {
                $rettxt .= " " . $hundreds[$key] . " ";
            }
        }
        if ($decnum > 0) {
            $rettxt .= " and ";
            if ($decnum < 20) {
                $rettxt .= $ones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
        }
        return $rettxt;
    }

    /**
     * -------------------------------------------------------
     * | Get Settings                                        |
     * |                                                     |
     * -------------------------------------------------------
     */
    public static function settings()
    {
        return PromoCode::whereStatus(1)
            ->whereDate('start_date', '<=', date("Y-m-d"))
            ->whereDate('end_date', '>=', date("Y-m-d"))
            ->where('deleted_at', null)
            ->first();
    }

    /**
     * -------------------------------------------------------
     * | Find coupon code                                    |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function findByCouponCode($code)
    {
        return PromoCode::whereStatus(1)
            ->whereCode($code)
            ->whereDate('start_date', '<=', date("Y-m-d"))
            ->whereDate('end_date', '>=', date("Y-m-d"))
            ->where('deleted_at', null)
            ->first();
    }

    /**
     * -------------------------------------------------------
     * | Coupon calculations                                 |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function couponCalculation($total, $discount)
    {
        return $total * $discount / 100;
    }

    /**
     * -------------------------------------------------------
     * | Flush cart allsessions                              |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function flushAllCartSessions()
    {
        session()->forget('cartProducts');
        session()->forget('emock_coupon_discount');
        session()->forget('mockCartProducts');
        session()->forget('coupon_discount');
        session()->forget('coupon_code');
    }

    /**
     * -------------------------------------------------------
     * | Flush coupon sessions                               |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function flushCouponSessions()
    {
        session()->forget('coupon_discount');
        session()->forget('coupon_code');
    }

    /**
     * -------------------------------------------------------------
     * | Get Stages List                                           |
     * |                                                           |
     * | @return Response                                          |
     * -------------------------------------------------------------
     */
    public function stages()
    {
        return Stage::orderBy('title')->active()->notDeleted()->pluck('title', 'id');
    }

    /**
     * -------------------------------------------------------
     * | Upload paper image                                  |
     * |                                                     |
     * | @param $requestImage,$folderName,$width,$height     |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function uploadPaperImage($requestImage, $folderName, $width, $height)
    {
        $folder_name = "/thumb/"; // Height : 186 & Width : 211
        $folder_name2 = "/detail/"; // Height : 245 & width : 279
        $originalName = $requestImage->getClientOriginalName();
        $path = $requestImage->store($folderName);
        $fileName = pathinfo($path, PATHINFO_FILENAME) . '.' . pathinfo($path, PATHINFO_EXTENSION);
        $resizeDirectory = \Storage::path($folderName . $folder_name);
        // check if directory is exist or not
        if (!File::isDirectory($resizeDirectory)) {
            File::makeDirectory($resizeDirectory, 0777, true, true);
        }
        $img = Image::make(\Storage::path($folderName . '/' . $fileName))->resize($width, $height)->save($resizeDirectory . $fileName);
        // check if directory is exist or not
        $resizeDirectory2 = \Storage::path($folderName . $folder_name2);
        if (!File::isDirectory($resizeDirectory2)) {
            File::makeDirectory($resizeDirectory2, 0777, true, true);
        }
        $img = Image::make(\Storage::path($folderName . '/' . $fileName))->resize(config('constant.test_paper_width'), config('constant.test_paper_height'))->save($resizeDirectory2 . $fileName);
        return [$fileName, $originalName];
    }
    /**
     * -------------------------------------------------------------
     * | Create captcha image                                      |
     * |                                                           |
     * | @return Void                                              |
     * -------------------------------------------------------------
     */
    public static function createCaptcha()
    {
        $text = Str::random(6);
        session()->put('captcha', $text);
        $captcha = imagecreate(200, 100);
        imagecolorallocate($captcha, 255, 255, 255);
        $gray = imagecolorallocate($captcha, 128, 128, 128);
        for ($i = 0; $i < 3; $i++) {
            imageline($captcha, rand(0, 10) * 20, 0, rand(0, 10) * 20, 100, $gray);
            imageline($captcha, 0, rand(0, 10) * 10, 200, rand(0, 10) * 10, $gray);
        }
        for ($i = 0; $i < strlen($text); $i++) {
            $randcolors = imagecolorallocate($captcha, rand(0, 0), rand(0, 0), rand(0, 0));
            imagettftext($captcha, 30, rand(-20, 20), 10 + 30 * $i, rand(40, 70), $randcolors, public_path() . "/frontend/fonts/Arial.ttf", $text[$i]);
        }
        $directory = storage_path() . "/app/frontend/captcha/";
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }
        header("Content-type: image/png");
        imagepng($captcha, storage_path() . "/app/frontend/captcha/captcha.png");
        imagedestroy($captcha);
    }

    /**
     * -------------------------------------------------------------
     * | Get Email Template by slug                                |
     * |                                                           |
     * | @param slug                                               |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function emailTamplate($slug)
    {
        $template = EmailTemplate::whereSlug($slug)->first();
        return @$template;
    }

    /**
     * -------------------------------------------------------------
     * | Format number                                             |
     * |                                                           |
     * -------------------------------------------------------------
     */
    function numberFormat($amount,$digit)
    {
        return number_format((float)$amount, $digit, '.', '');
    }

    /**
     * -------------------------------------------------------
     * | Upload image                                        |
     * |                                                     |
     * | @param $requestImage,$folderName,$width,$height     |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function uploadAudio($requestImage, $folderName)
    {
        $originalName = $requestImage->getClientOriginalName();
        $path = $requestImage->store($folderName);
        $fileName = pathinfo($path, PATHINFO_FILENAME) . '.' . pathinfo($path, PATHINFO_EXTENSION);
        return [$fileName, $originalName];
    }

    /**
     * -------------------------------------------------------
     * | Flush coupon sessions                               |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function flushEmockCouponSessions()
    {
        session()->forget('emock_coupon_discount');
        session()->forget('emock_coupon_code');
    }

    /**
     * -------------------------------------------------------
     * | Flush cart allsessions                              |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function flushAllEmockCartSessions()
    {
        session()->forget('mockCartProducts');
        session()->forget('emock_coupon_discount');
        session()->forget('emock_coupon_code');
    }

    /**
     * -------------------------------------------------------
     * | Monthly Subscription Payment                        |
     * |                                                     |
     * -------------------------------------------------------
     */
    public function monthlyDeduction(){
        // get parent subscription info
        $todayDate = date('Y-m-d');
        $users =ParentUser::where('subscription_status','1')
                ->whereHas('lastSubscription', function($query) use($todayDate){
                    $query->whereDate('payment_date','<=',$todayDate);
                })
                ->get();
        $parentData = [];
        foreach($users as $key => $user){
            $date = explode('-',$todayDate);
            $paymentDay = $user->subscription->payment_date;
            $paymentDate = date('Y-m-d', strtotime($date[0].'-'.$date[1].'-'.$paymentDay));
            $userSubscriptionDate = date('Y-m-d',strtotime($user->subscription_start_date));
            $subscribedAt = date('Y-m-d',strtotime($user->lastSubscription->subscribed_at));
            if(strtotime($userSubscriptionDate) == strtotime($subscribedAt)){
                $subscribedDate = new DateTime(date('Y-m-d',strtotime($user->lastSubscription->subscribed_at)));
            }else{
                $subscribedDate = new DateTime(date('Y-m-d',strtotime($user->subscription_end_date)));
            }
            $currentDate = new DateTime(date('Y-m-d'));
            $nextPaymentDate = date('Y-m-d', strtotime('+1 month', strtotime($paymentDate)));
            $paymentDate = new DateTime(date('Y-m-d',strtotime($paymentDate)));
            if($currentDate == $paymentDate){
                // find parent extra day charges
                $numberOfDays = $subscribedDate->diff($currentDate)->format("%a");
                $totalAmount = $user->subscription->price;
                $message = __('formname.monthly_payment',['price'=> config('constant.default_currency_symbol').$user->subscription->price]);

                // calculate extra charges
                if($numberOfDays > 1 && $user->extra_charges == 1){
                    $numberOfDays = $numberOfDays -1;
                    $dailyCharges = @$user->subscription->daily_charge;
                    $extraCharges = $dailyCharges * $numberOfDays;
                    $totalAmount = $user->subscription->price + $extraCharges;
                    $message = __('formname.extra_charges',['price'=> config('constant.default_currency_symbol').$user->subscription->price, 'charges' => config('constant.default_currency_symbol').$extraCharges , 'day' => $numberOfDays]);
                }
                // expire month and year
                $monthAndYear = explode('/',$user->expiry_date);
                $month = $monthAndYear[0];
                $year = $monthAndYear[1];

                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $status = 0;
                try {
                    // generate stipe token
                    $token = $stripe->tokens->create([
                        'card' => [
                        'number' => $user->card_number,
                        'exp_month' => $month,
                        'exp_year' => $year,
                        'cvc' => $user->cvv,
                        ],
                    ]);

                    /** Set stripe API Key */
                    Stripe::setApiKey(env('STRIPE_SECRET'));

                    /** CHARGE STRIPE */
                    $charge = Charge::create([
                        "amount" => $totalAmount * 100,
                        "currency" => $user->subscription->currency ?? __('frontend.stripe_currency'),
                        "source" => $token,
                        "description" => __('frontend.payment.paper_purchased'),
                    ]);

                    /** Check if payment status is succeeded or not */
                    if ($charge->status == "succeeded") {
                        $status = 1;
                    }
                } catch (\Stripe\Exception\CardException $e) {
                    $message = $e->getMessage(); /** Invalid card details */
                } catch (\Stripe\Exception\RateLimitException $e) {
                    $message = $e->getMessage(); /** Too many requests made to the API too quickly */
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    $message = $e->getMessage(); /** Invalid parameters were supplied to Stripe's API */
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    $message = $e->getMessage(); /** Authentication with Stripe's API failed */
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    $message = $e->getMessage(); /** Network communication with Stripe failed */
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $message = $e->getMessage(); /** Display a very generic error to the user, and maybe send */
                } catch (Exception $e) {
                    $message = $e->getMessage(); /** Something else happened, completely unrelated to Stripe */
                }
                $parentData[] = [
                    'parent_id' => @$user->id,
                    'subscription_id' => @$user->subscription_id,
                    'transaction_id' => @$charge->id,
                    'amount' => @$totalAmount,
                    'currency' => @$user->subscription->currency,
                    'payment_date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => @$status,
                    'method' => 2,
                    'description' => @$message,
                ];
                $user->lastSubscription()->update(['subscribed_at'=>date('Y-m-d H:i:s'),'payment_date' =>$nextPaymentDate,'extra_charges' => $extraCharges??0,'subscription_end_date'=>$nextPaymentDate]);
                $user->update(['subscription_end_date'=>$nextPaymentDate,'subscription_status'=>@$status]);
            }
        }
        ParentPayment::insert($parentData);
    }

    /**
     * -------------------------------------------------------
     * | Get Billing Info                                    |
     * |                                                     |
     * | @return billingAddress                              |
     * -------------------------------------------------------
     */
    public function onlyAddress($address)
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
     * | Week list                                           |
     * |                                                     |
     * | @return Array                                       |
     * -------------------------------------------------------
     */
    public function weekList(){
        $year = date('Y');
        $previousYear = $year-1;
        $startDate = date('Y-m-d',strtotime($previousYear.'-09-01'));
        $endDate = date('Y-08-t');
        $nextMonday = strtotime('next monday', strtotime($startDate));
        $nextSunday =  strtotime('next sunday', $nextMonday);
        $i = 1;
        $weekList = [];
        while (date('Y-m-d',$nextSunday) <= $endDate) {
            $weekList[$i]['id'] = $i;
            $weekList[$i]['name'] = 'Week - '.$i;
            $weekList[$i]['start_date'] = date('d-m-Y',$nextMonday);
            $weekList[$i]['end_date'] = date('d-m-Y',$nextSunday);
            $nextMonday = strtotime('+1 week', $nextMonday);
            $nextSunday = strtotime('+1 week', $nextSunday);
            $i++;
        }
        return @$weekList;
    }

    /**
     * -------------------------------------------------------------
     * | Get Test Assessment List                                  |
     * |                                                           |
     * | @return Array                                             |
     * -------------------------------------------------------------
     */
    public function findChild($uuid=NULL){
        if($uuid != NULL){
            $student = Student::whereUuid($uuid)->first();
            $studentId = @$student->id;
        }else{
            if(Auth::guard('parent')->user() != null){
                $student = Auth::guard('parent')->user()->childs[0];
                $studentId = @$student->id;
                $uuid = @$student->uuid;
            }else{
                $student = Auth::guard('student')->user();
                $studentId = @$student->id;
                $uuid = @$student->uuid;
            }
        }
        return [$studentId,$uuid];
    }

    /**
     * -------------------------------------------------------
     * | Upload image                                        |
     * |                                                     |
     * | @param $requestImage,$folderName,$width,$height     |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function uploadFile($requestImage, $folderName,$flag=null)
    {
        // check if width is not 64
        $originalName = $requestImage->getClientOriginalName();
        $directory = storage_path('app/'.$folderName);
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }
        $path = $requestImage->store($folderName);
        if($flag == true && pathinfo($path, PATHINFO_EXTENSION) != 'pdf'){
            Storage::move($path, $folderName.'/'.pathinfo($path, PATHINFO_FILENAME) . '.pdf');
            $extension='pdf';
        }else{
            $extension = pathinfo($path, PATHINFO_EXTENSION);
        }
        $fileName = pathinfo($path, PATHINFO_FILENAME) . '.' . $extension;
        return [$fileName, $originalName];
    }

    /**
     * -------------------------------------------------------
     * | Get subject                                         |
     * |                                                     |
     * | @return Object                                      |
     * -------------------------------------------------------
     */
    public function getSubject($slug){
        $subject = Subject::where('slug',$slug)->withTrashed()->first();
        return $subject;
    }

    /**
     * -------------------------------------------------------
     * | Get grade                                           |
     * |                                                     |
     * | @return Object                                      |
     * -------------------------------------------------------
     */
    public function getGrade($slug){
        $grade = Grade::where('slug',$slug)->withTrashed()->first();
        return $grade;
    }

    /** 
     * -------------------------------------------------------
     * | Get grade                                           |
     * |                                                     |
     * | @return Object                                      |
     * -------------------------------------------------------
     */
    public function getTopicByIds($ids){
        $topics = Topic::whereIn('id',$ids)->get();
        return $topics;
    }

    /**
     * -------------------------------------------------------
     * | Genrate Result                                      |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function updateResultRank($studentTestPaper){
        try{
            $studentTestResults = $studentTestPaper->studentResult;
            $startDate = date('Y-m-01',strtotime($studentTestResults->created_at)).' 00:00:00';
            $endDate = date('Y-m-t',strtotime($studentTestResults->created_at)).' 23:59:59';
            $totalStudentAttemptTest = StudentTestPaper::where(['mock_test_paper_id'=>$studentTestPaper->mock_test_paper_id,'is_completed'=>1])
                                        ->select('id','mock_test_paper_id','is_completed')
                                        ->whereHas('studentResult',function($query) use($startDate,$endDate){
                                            $query->whereBetween('created_at',[$startDate,$endDate]);
                                        })
                                        ->count();
            $student = $studentTestPaper->student;
            $mockTest = $studentTestResults->mockTest;
            $studentTest = $studentTestPaper->studentTest;
            $attemptedCount = $studentTestResults->currentStudentTestQuestionAnswers()
                                ->where('is_attempted','1')
                                ->count();
            $correctlyAnswered = $studentTestResults->currentStudentTestQuestionAnswers()
                                ->where('is_attempted','1')
                                ->where('is_correct','1')
                                ->count();
            $unAnswered = $studentTestResults->currentStudentTestQuestionAnswers()
                        ->where('is_attempted','!=','1')
                        ->count();
            if($mockTest->stage_id == 1){
                $questionIds = $studentTestResults->currentStudentTestQuestionAnswers()->where('is_correct','1')->pluck('question_id');
                $obtainedMark = Question::whereIn('id', $questionIds)->sum('marks');
            }else{
                $obtainedMark = $studentTestResults->obtained_marks;
            }
            $overAllResult = 0;
            if ($attemptedCount > 0 && $studentTestResults->total_marks > 0 && $obtainedMark >0) {
                $overAllResult = ($obtainedMark * 100) / $studentTestResults->total_marks;
                $overAllResult = number_format($overAllResult,2);
            }
            $questions = ($studentTestResults->studentTestQuestionAnswers != null && !empty($studentTestResults->studentTestQuestionAnswers->toArray())) ? $studentTestResults->studentTestQuestionAnswers->count() : 0;
            $studentTestResults->update([
                'attempted' => $attemptedCount,
                'correctly_answered' => $correctlyAnswered,
                'unanswered' => $unAnswered,
                'obtained_marks' => $obtainedMark,
                'overall_result' => $overAllResult,
                'questions' => $questions,
            ]);
            $questions = $studentTestResults->questions;
            $attempted = $studentTestResults->attempted;
            $correctlyAnswered = $studentTestResults->correctly_answered;
            $unanswered = $studentTestResults->unanswered;
            $totalMarks = $studentTestResults->total_marks;
            $obtainedMarks = $studentTestResults->obtained_marks;
            $overAllResult = 0;
            if ($attempted > 0 && $totalMarks > 0) {
                $overAllResult = ($obtainedMarks * 100) / $totalMarks;
                $overAllResult = number_format($overAllResult,2);
            }
            $studentTestPaper->update([
                'questions' => $questions,
                'attempted' => $attempted,
                'correctly_answered' => $correctlyAnswered,
                'unanswered' => $unanswered,
                'overall_result' => $overAllResult,
                'total_marks' => $totalMarks,
                'obtained_marks' =>$obtainedMarks,
                'is_completed'=>1,
            ]);
            $rank = 1;
            $query = StudentTestPaper::where(['mock_test_paper_id' => @$studentTestPaper->mock_test_paper_id])
                        ->whereHas('studentResult',function($query) use($startDate,$endDate){
                            $query->whereBetween('created_at',[$startDate,$endDate]);
                        });
            $testPaperResults = $query->orderBy('overall_result', 'desc')->get();
            $studentTestPaper->update(['rank'=>0]);
            if ($testPaperResults) {
                foreach ($testPaperResults as $rkey =>  $result) {
                    if($result->overall_result > 0 ){
                        if($result->overall_result != $studentTestPaper->overall_result){
                            $rank++;
                        }
                        if($result->mock_test_paper_id == $studentTestPaper->mock_test_paper_id && $studentTestPaper->student_test_id == $result->student_test_id && $studentTestPaper->student_id == $result->student_id){
                            $studentTestPaper->update(['rank'=>$rank]);
                        }
                    }
                }
            }
            $purchasedMock = PurchasedMockTest::whereMockTestId($mockTest->id)->whereStudentId($student->id)->first();
            $flag = false;
            $status = 2;
            if($studentTest){
                $paperIds = $studentTest->studentTestPapers->pluck('mock_test_paper_id')->toArray();
                $mockPaperIds = $mockTest->papers->pluck('id')->toArray();
                sort($paperIds);
                sort($mockPaperIds);
                if($paperIds == $mockPaperIds){
                    $flag = true;
                }
                // dd($paperIds,$mockPaperIds,$flag);
                if($flag == true){
                    if($mockTest->stage_id == 2){
                        $status = 3;
                        $studentTest->update(['status' => 3]);
                    }
                    if ($purchasedMock != null) {
                        $studentTest->update(['status' => $status]);
                        $purchasedMock->update(['status' => $status]);
                    }
                }
            }
            return [$totalStudentAttemptTest,$studentTestResults];
        }catch(Exception $e){
            // dd($e->getMessage());
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Months from september to current month          |
     * |                                                     |
     * | @return Object                                      |
     * -------------------------------------------------------
     */
    public function getMonths(){
        $year = date('Y');
        $previousYear = $year-1;
        $startMonth = date('Y-m',strtotime($previousYear.'-09'));
        $endMonth = date('Y-08');
        $currentMonth = date('Y-m');
        $months =[];
        // dd($startMonth,$endMonth,$currentMonth);
        while($startMonth <= $endMonth) {
            if(strtotime($currentMonth) >= strtotime($startMonth)){
                $month = intval(date('m',strtotime($startMonth)));
                $months[] = $month;
            }
            $startMonth = date('Y-m',strtotime('+1 month',strtotime($startMonth)));
        }
        return $months;
    }
}
