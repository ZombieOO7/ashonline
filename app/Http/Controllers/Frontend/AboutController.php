<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\BlockHelper;
use App\Helpers\PaperCategoryHelper;
use App\Http\Controllers\Admin\BaseController;
use Exception;

class AboutController extends BaseController
{
    private $helper,$paperCategoryHelper;
    public function __construct(BlockHelper $helper,PaperCategoryHelper $paperCategoryHelper)
    {
        $this->helper = $helper;
        $this->paperCategoryHelper = $paperCategoryHelper;
        $this->helper->mode = config('constant.frontend');
    }

    /**
     * -------------------------------------------------------
     * | About page with sections                            |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    
    public function index()
    {
        try{
            $projectType = 0;
            $array['aboutBannerSection'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_banner_section'),$projectType);
            $array['aboutMainSection'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_main_section'),$projectType);
            $array['aboutWeProvide'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_we_provide'),$projectType);
            $array['aboutMinds'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_mind_behind_the_scene'),$projectType);
            $array['aboutSubSection'] = $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_sub_section'),$projectType);
            $array['paperCategoryList'] = $this->paperCategoryHelper->getPaperCategoryListForAbout();
            return view('frontend.about.index',@$array);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
