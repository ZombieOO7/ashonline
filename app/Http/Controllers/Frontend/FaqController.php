<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\FaqHelper;
use Exception;

class FaqController extends Controller
{
    private $helper;
    public function __construct(FaqHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.frontend');
    }

    /**
     * -------------------------------------------------------
     * | Get FAQ Page                                        |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function index($slug) 
    {
        try{
            $array = [
                'faqCategories' => $this->helper->getAllFaqs(),
                'faqDetail' => $this->helper->getFaqBySlug($slug)
            ];
            return view('frontend.faqs.index',$array);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
