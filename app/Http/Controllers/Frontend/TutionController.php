<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\BlockHelper;
use App\Http\Controllers\Admin\BaseController;

class TutionController extends BaseController
{
    private $helper;
    public function __construct(BlockHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.frontend');
    }

    /**
     * -------------------------------------------------------
     * | Tuition page with all sections                      |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function index()
    {
        $projectType = 0;
        $arr = [ 
            'tutionsBannerSection' => $this->helper->getBlockDetails(config('constant.block_types.ePaper.tutions'),config('constant.block_sub_types.ePaper.tutions_banner_section'),$projectType), 
            'tutionsMainSection' => $this->helper->getBlockDetails(config('constant.block_types.ePaper.tutions'),config('constant.block_sub_types.ePaper.tutions_main_section'),$projectType),
            'tutionsSubSection' => $this->helper->getBlockDetails(config('constant.block_types.ePaper.tutions'),config('constant.block_sub_types.ePaper.tutions_sub_section'),$projectType) 
        ];
        return view('frontend.tutions.index',$arr);
    }
}
