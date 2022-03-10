<?php

namespace App\Http\Controllers;

use App\Models\MockTestSubjectDetail;
use Carbon\Carbon;
use App\Models\CMS;
use App\Models\WebSetting;
use App\Helpers\BlockHelper;
use App\Helpers\PaperHelper;
use Illuminate\Http\Request;
use App\Models\NotificationOrderItem;
use App\Models\ExamBoard;
use App\Models\MockTest;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PurchasedMockTestRating;
use App\Models\PromoCode;
use App\Models\Question;
use DB;
use function Ramsey\Uuid\v1;

class HomeController extends Controller
{
    private $helper, $paperHelper;
    protected $notification;
    public $examBoard;
    public $mockTests;


    public function __construct(BlockHelper $helper, NotificationOrderItem $notification, PaperHelper $paperHelper, WebSetting $setting, ExamBoard $examBoard, MockTest $mockTests)
    {
        $this->helper = $helper;
        $this->paperHelper = $paperHelper;
        $this->helper->mode = config('constant.frontend');
        $this->notification = $notification;
        $this->setting = $setting;
        $this->examBoard = $examBoard;
        $this->mockTests = $mockTests;

    }

    /**
     * -------------------------------------------------------
     * | Landing page with all sections and blocks           |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function firstPage()
    {
        $projectType = 3;
        $examBoard = $this->examBoard->with('mockTests')->get();
        $schools = CMS::whereType(3)->limit(14)->get();
        $webSetting = getWebSettings();
        $promoCode = PromoCode::whereStatus(1)
            ->whereDate('start_date', '<=', date("Y-m-d"))
            ->whereDate('end_date', '>=', date("Y-m-d"))
            ->first();

        //parent reviews section
        $reviewSlide1 = PurchasedMockTestRating::orderBy('id','desc')->limit(6)->get();
        $reviewSlide2 = PurchasedMockTestRating::orderBy('id','desc')->offset(6)->limit(6)->get();
        $reviewSlide3 = PurchasedMockTestRating::orderBy('id','desc')->offset(12)->limit(6)->get();

        $totalQuestions = Question::count(); 

        $data['homeSliderSection'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.home_banner_section'), $projectType);
        $data['homeOurModules'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.our_module_section'), $projectType);
        $data['homeAboutAsh'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.about_ash_ace'), $projectType);
        $data['homeWhyChooseAsh'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.why_choose_ash_ace'), $projectType);
        $data['homeVideoSection'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.video_section'), $projectType);
        $data['homeHelpSection'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.help_section'), $projectType);
        $data['homeSchoolSection'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.school_section'), $projectType);
        $data['homeSubscribeSection'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.subscribe_section'), $projectType);
        $data['subjectsCount'] = $this->helper->subjects()->count(); 
        $data['papersCount'] = $this->paperHelper->paperList()->count();
        $data['schools'] = @$schools;
        $data['examBoard'] = @$examBoard;
        $data['reviewSlide1'] = @$reviewSlide1;
        $data['totalQuestions'] =@$totalQuestions;
        $data['reviewSlide2'] = @$reviewSlide2;
        $data['reviewSlide3'] = @$reviewSlide3;
        $data['webSetting'] = $webSetting; 
        $data['promoCode'] = $promoCode;
        return view('newfrontend.index', $data);
    }

    /**
     * -------------------------------------------------------
     * | Home page with all sections                         |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function index()
    {
        $projectType = 0;
        $arr['homeBannerSection'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.home'), config('constant.block_sub_types.ePaper.home_banner_section'), $projectType);
        $arr['homeDesignedByExperts'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.home'), config('constant.block_sub_types.ePaper.home_designed_by_experts'), $projectType);
        $arr['homeAllSubjects'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.home'), config('constant.block_sub_types.ePaper.home_all_subjects'), $projectType);
        $arr['homeExamFormats'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.home'), config('constant.block_sub_types.ePaper.home_exam_formats'), $projectType);
        $arr['homeExamStyles'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.home'), config('constant.block_sub_types.ePaper.home_exam_styles'), $projectType);
        $arr['subjectsCount'] = $this->helper->subjects()->count();
        $arr['papersCount'] = $this->paperHelper->paperList()->count();
        return view('frontend.home', $arr);
    }
     /**
     * -------------------------------------------------
     * | Converting Currency Numbers to words          |
     * |                                               |
     * | @param $sectionId                             |
     * | @return response                              |
     * |------------------------------------------------
     */

    public function numberToWords($number)
    {
        $no = floor($number);
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety', '+' => 'plus');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? '-and-' : null;
                $str [] = ($number < 21) ? $words[$number] .
                    "-" . $digits[$counter] . $plural . "" . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . "-" . $words[$number % 10] . ""
                    . $digits[$counter] . $plural . "" . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        return $result;
    }
     /**
     * -------------------------------------------------
     * | For get notification                          |
     * |                                               |
     * | @param $sectionId                             |
     * | @return response                              |
     * |------------------------------------------------
     */
  
    public function getNotification(Request $request)
    {
        $result = $this->notification;
        $setting = $this->setting::first();
        if ($request->last_id && $request->last_id != null) {
            $result = $result->where('id', '>', $request->last_id);
        } else {
            $result = $result->orderBy('id');
        }
        $result = $result->where('paper_id','!=',null)->with('user', 'paper')->first();
        if (!$result && $request->last_id) {
            $result = $this->notification->where('paper_id','!=',null)->orderBy('id')->with('billingAddress', 'paper')->first();
        }
        if ($result != null) {
            $userName = strtoupper(@$result->order->parent->full_name) . '. ';
            return response()->json([
                'id' => $result->id,
                'user' => @$userName . ' in ' . @$result->billingAddress->city . ', ' . @$setting->notification_content,
                'paper' => $result->paper->title,
                'link' => route('paper-details', [@$result->paper->category->slug, @$result->paper->slug]),
                'time' => Carbon::parse(strtotime($result->created_at))->diffForHumans(),
                'img' => $result->paper->path,
                'status'=>'success',
            ]);
        } else {
            return response()->json(['status'=>'info']);
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Privacy Policy Page                             |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function getPrivacyPolicy()
    {
        $cms = $this->pageContent('privacy-policy');
        return view('frontend.cms.detail', ['cms' => $cms]);
    }

    /**
     * -------------------------------------------------------
     * | Get Terms & Conditions Page                         |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function getTermsConditions()
    {
        $cms = $this->pageContent('terms-conditions');
        return view('frontend.cms.detail', ['cms' => $cms]);
    }

    /**
     * -------------------------------------------------------
     * | Get Page Content                                    |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function pageContent($slug)
    {
        return CMS::wherePageSlug($slug)->first();
    }
    /**
     * -------------------------------------------------
     * | Contact us                                    |
     * |                                               |
     * | @param $sectionId                             |
     * | @return response                              |
     * |------------------------------------------------
     */
  

    public function contactUs()
    {
        return view('newfrontend.contact');
    }

    /**
     * -------------------------------------------------------
     * | Get Legal And Other Documents Content               |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function legalAndOtherDocument()
    {
        return view('newfrontend.legal_and_other_document');
    }

    /**
     * -------------------------------------------------------
     * | Get Practice                                        |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function practice()
    {
        return view('newfrontend.practice.index');
    }

    /**
     * -------------------------------------------------------
     * | Mock Exam Page                                      |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function eMock()
    {
        $examBoardBoth = $this->examBoard->with('mockTests')->orderBy('id','desc')->get();
        $examBoardEveryOne = $this->examBoard->with(['mockTests' => function ($q) {
            $q->where('show_mock', '=', 2);
        }])->orderBy('id','asc')->get();
        //parent reviews section
        $reviewSlide1 = PurchasedMockTestRating::orderBy('id','desc')->limit(6)->get();
        $reviewSlide2 = PurchasedMockTestRating::orderBy('id','desc')->offset(6)->limit(6)->get();
        $reviewSlide3 = PurchasedMockTestRating::orderBy('id','desc')->offset(12)->limit(6)->get();
        $projectType = 1;
        $array['emockSliderSection'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.banner_section'), $projectType);
        $array['emockPaperSection'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.paper_section'), $projectType);
        $array['emockExamWorkSection'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.how_exam_work_section'), $projectType);
        $array['emockQuestionSection'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.question_section'), $projectType);
        $array['emockChildSection'] = $this->helper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.aceMock.child_performance_section'), $projectType);
        $array['examBoardBoth'] = @$examBoardBoth;
        $array['examBoardEveryOne'] = @$examBoardEveryOne;
        $array['reviewSlide1'] = @$reviewSlide1;
        $array['reviewSlide2'] = $reviewSlide2;
        $array['reviewSlide3'] = @$reviewSlide3;
        return view('newfrontend.e_mock.index', $array);
    }

    /**
     * -------------------------------------------------------
     * | generate random string                              |
     * |                                                     |
     * | @return String                                      |
     * -------------------------------------------------------
     */
    public function random_strings($length_of_string)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    /**
     * -------------------------------------------------------
     * | check Login User guard                              |
     * |                                                     |
     * | @return Redirect                                    |
     * -------------------------------------------------------
     */
    public function checkGuard()
    {
        if (\Auth::guard('admin')) {
            return redirect()->intended(route('admin_dashboard'));
        } else {
            return redirect('admin/login');
        }
    }
}
