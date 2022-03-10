<?php

namespace App\Http\Controllers\NewFrontend;

use App\Http\Controllers\Admin\BaseController;
use App\Helpers\FaqHelper;
use App\Models\CMS;
use App\Models\PurchasedMockTestRating;
use App\Models\StudentTestPaper;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CMSController extends BaseController
{
    private $helper;
    public function __construct(FaqHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.frontend');
    }

    /**
     * -------------------------------------------------------
     * | About page with sections                            |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function aboutus()
    {
        try{
            $projectType = 0;
            $array['aboutBannerSection'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_banner_section'),$projectType);
            $array['aboutMainSection'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_main_section'),$projectType);
            $array['aboutWeProvide'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_we_provide'),$projectType);
            $array['aboutMinds'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_mind_behind_the_scene'),$projectType);
            $array['aboutSubSection'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_sub_section'),$projectType);
            $array['paperCategoryList'] = $this->paperCategoryHelper->getPaperCategoryListForAbout();
            return view('newfrontend.cms.about',@$array);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Privacy Policy with sections                        |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function privacyPolicy()
    {
        try{
            $cms = $this->pageContent('privacy-policy');
            return view('newfrontend.cms.privacypolicy',['cms' => $cms]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Terms and Conditions with sections                  |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function termsandconditions()
    {
        try{
            $cms = $this->pageContent('terms-conditions');
            return view('newfrontend.cms.termsandconditions',['cms' => $cms]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
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
     * -------------------------------------------------------
     * | FAQ with sections                  |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function faq($slug)
    {
        try{
            $array = [
                'faqCategories' => $this->helper->getAllFaqs(),
                'faqDetail' => $this->helper->getFaqBySlug($slug)
            ];
            return view('newfrontend.cms.faq',$array);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Payments and Security with sections                  |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function paymentsandsecurity()
    {
        try{
            $cms = $this->pageContent('payments-and-security');
            return view('newfrontend.cms.paymentsandsecurity',['cms' => $cms]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

     /**
     * -------------------------------------------------------
     * | Contact Us Page                                     |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function contactUs()
    {
        try{
            $cms = $this->pageContent('contact-us');
            $subjectList = $this->contactUsSubjectList();
            return view('newfrontend.cms.contactus',['cms' => $cms,'subjectList' => @$subjectList]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Benefits                                        |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function benefits()
    {
        try{
            $cms = $this->pageContent('benefits');
            return view('newfrontend.benefits',['cms'=>@$cms]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Testimonials                                    |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function testimonials()
    {
        try{
            $cms = $this->pageContent('testimonials');
            $query = PurchasedMockTestRating::query();
            $total = $query->count();
            $five = $query->where('rating',5)->count();
            $fiveStar = ($five != 0) ? (($five * 100)/ $total) : 0;
            $properFiveStar = number_format($fiveStar,2);
            $four = PurchasedMockTestRating::where('rating','=',4)->orWhere('rating','=',4.5)->count();
            $fourStar = ($four != 0) ? (($four * 100)/ $total) : 0;
            $properFourStar = number_format($fourStar,2);
            $three = PurchasedMockTestRating::where('rating',3)->orWhere('rating','=',3.5)->count();
            $threeStar = ($three != 0) ? (($three * 100)/ $total) : 0;
            $properThreeStar = number_format($threeStar,2);
            $two = PurchasedMockTestRating::where('rating',2)->orWhere('rating','=',2.5)->count();
            $twoStar = ($two  != 0) ? (($two * 100)/ $total) : 0;
            $properTwoStar = number_format($twoStar,2);
            $one = PurchasedMockTestRating::where('rating',1)->orWhere('rating','=',1.5)->count();
            $oneStar = ($one != 0) ? (($one * 100)/ $total) : 0;
            $properOneStar = number_format($oneStar,2);
            $ratings = $query->get();
            // dd($oneStar,$twoStar,$threeStar,$fourStar,$fiveStar);
            return view('newfrontend.testimonials',['total'=>@$total,'cms'=>@$cms,'ratings'=>@$ratings,'fiveStar'=>$properFiveStar,'fourStar' => $properFourStar,'threeStar' => $properThreeStar,'twoStar' => $properTwoStar,'oneStar' => $properOneStar]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Show guidance                                       |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function showGuidance()
    {
        try{
            $cms = $this->pageContent('exam-guidance');
            return view('newfrontend.benefits',['cms'=>@$cms]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Testimonials                                    |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function getData(Request $request)
    {
        $reviews = PurchasedMockTestRating::orderBy('rating','desc')
                    ->where(function($q) use($request){
                        if($request->rating != null){
                            $ratings = array_unique($request->rating); 
                            foreach($ratings as $key => $rate){
                                if($rate == 5){
                                    $q->orWhere('rating',5);
                                }elseif($rate == 4){
                                    $q->orWhere('rating',4.5);
                                    $q->orWhere('rating',4);
                                }elseif($rate == 3){
                                    $q->orWhere('rating',4.5);
                                    $q->orWhere('rating',4);
                                }elseif($rate == 2){
                                    $q->orWhere('rating',2.5);
                                    $q->orWhere('rating',2);
                                }else{
                                    $q->orWhere('rating',2.5);
                                    $q->orWhere('rating',1);
                                }
                            }
                        }
                    })
                    ->get();
        return DataTables::of($reviews)
                ->addColumn('review', function ($rating) {
                    return $this->getPartials('newfrontend._testimonial_column',['rating'=>@$rating]);
                })
                ->rawColumns(['review', 'path'])
                ->make(true);
    }

    /**
     * -------------------------------------------------------
     * | Get Purchased Mock Content.                         |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function purchasedMock()
    {
        try{
            $cms = $this->pageContent('purchased-mocks');
            return view('newfrontend.benefits',['cms'=>@$cms]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Evaluate Mock Content.                          |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function evaluationInfo($uuid=null)
    {
        try{
            $cms = $this->pageContent('evaluate-mock');
            $paper = StudentTestPaper::where(['uuid'=>$uuid])->first();
            $mockTest = $paper->paper->mockTest;
            $mockTestPaper = $paper->paper;
            return view('newfrontend.user.__evaluate',['cms'=>@$cms,'uuid'=>@$uuid,'mockTestPaper'=>$mockTestPaper]);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
