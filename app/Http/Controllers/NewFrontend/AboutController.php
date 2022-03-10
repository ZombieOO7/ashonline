<?php

namespace App\Http\Controllers\NewFrontend;

use App\Helpers\BlockHelper;
use App\Helpers\PaperCategoryHelper;
use App\Http\Controllers\Admin\BaseController;
use App\Models\ExamBoard;
use Exception;

class AboutController extends BaseController
{
    private $helper,$paperCategoryHelper;
    public function __construct(BlockHelper $helper,PaperCategoryHelper $paperCategoryHelper, ExamBoard $examBoard)
    {
        $this->examBoard = $examBoard;
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
    public function aboutUs()
    {
        try{
            $projectType = 0;
            $examBoardBoth = $this->examBoard->with('mockTests')->get();
            $examBoardEveryOne = $this->examBoard->with(['mockTests' => function ($q) {
                $q->where('show_mock', '=', 2);
            }])->get();
            $array = [
                'aboutBannerSection' => $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_banner_section'),$projectType),
                'aboutMainSection' => $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_main_section'),$projectType),
                'aboutWeProvide' => $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_we_provide'),$projectType),
                'aboutMinds' => $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_mind_behind_the_scene'),$projectType),
                'aboutSubSection' => $this->helper->getBlockDetails(config('constant.block_types.ePaper.about_us'),config('constant.block_sub_types.ePaper.aboutus_sub_section'),$projectType),
                'paperCategoryList' => $this->paperCategoryHelper->getPaperCategoryListForAbout(),'examBoardBoth' => @$examBoardBoth,
                'examBoardEveryOne' => @$examBoardEveryOne
            ];
            return view('newfrontend.cms.about',@$array);
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    
}
