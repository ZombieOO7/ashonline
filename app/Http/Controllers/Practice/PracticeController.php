<?php

namespace App\Http\Controllers\Practice;

use App\Helpers\BlockHelper;
use App\Helpers\PracticeHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\ExamBoard;
use App\Models\Subject;
use Exception;
use Illuminate\Support\Facades\Auth;

class PracticeController extends BaseController
{
    protected $viewConstant = 'newfrontend.practice.';
    protected $helper,$blockHelper,$examBoard;
    public $isParent = false,$parent=[];
    public function __construct(PracticeHelper $helper,BlockHelper $blockHelper,ExamBoard $examBoard){
        $this->helper = $helper;
        $this->blockHelper = $blockHelper;
        $this->examBoard = $examBoard;
    }

    /**
     * -------------------------------------------------
     * | Display Practice home page or landing         |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        try {
            if(Auth::guard('parent')->user() != NULL || Auth::guard('student')->user() != NULL){
                return redirect()->route('practice-home');
            }
            //parent reviews section
            $projectType = 2;
            $array['emockSliderSection'] = $this->blockHelper->getBlockDetails(config('constant.block_types.practice.home'), config('constant.block_sub_types.practice.banner_section'), $projectType);
            $array['homeOurModules'] = $this->blockHelper->getBlockDetails(config('constant.block_types.practice.home'), config('constant.block_sub_types.practice.our_module_section'), $projectType);
            $array['homeAboutAsh'] = $this->blockHelper->getBlockDetails(config('constant.block_types.practice.home'), config('constant.block_sub_types.practice.about_ash_ace'), $projectType);
            $array['homeWhyChooseAsh'] = $this->blockHelper->getBlockDetails(config('constant.block_types.practice.home'), config('constant.block_sub_types.practice.why_choose_ash_ace'), $projectType);
            $array['homeVideoSection'] = $this->blockHelper->getBlockDetails(config('constant.block_types.practice.home'), config('constant.block_sub_types.practice.video_section'), $projectType);
            $array['homeHelpSection'] = $this->blockHelper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.practice.help_section'), $projectType);
            $array['homePaySection'] = $this->blockHelper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.practice.pay_section'), $projectType);
            return view($this->viewConstant . 'index',$array);
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * -------------------------------------------------
     * | Display Practice landing page                 |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function home($studentId=null)
    {
        try {
            $student = $this->helper->findChild($studentId);
            $studentId = @$student[0];
            $uuid = @$student[1];
            // if(Auth::guard('parent')->user() != NULL || Auth::guard('student')->user() != NULL){
                $subjects = $this->helper->subjectList();
                $examBoardBoth = $this->examBoard->with('mockTests')->orderBy('id','desc')->get();
                $examBoardEveryOne = $this->examBoard->with(['mockTests' => function ($q) {
                    $q->where('show_mock', '=', 2);
                }])->orderBy('id','asc')->get();
                //parent reviews section
                $projectType = 2;
                $array['examBoardBoth'] = @$examBoardBoth;
                $array['examBoardEveryOne'] = @$examBoardEveryOne;
                $array['subjects'] = @$subjects;
                $array['studentId'] = @$studentId;
                $array['uuid']=@$uuid;
                $array['homePracticeSection'] = $this->blockHelper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.practice.practice_section'), $projectType);
                $array['homeTopicSection'] = $this->blockHelper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.practice.topic_section'), $projectType);
                $array['homePastPaperSection'] = $this->blockHelper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.practice.past_paper_section'), $projectType);
                return view($this->viewConstant . 'landing_page',$array);
            // }
            // return redirect()->route('practice');
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * -------------------------------------------------
     * | Weekly Assessment Listing                     |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function allAssessment($slug=null,$studentId=null){
        try {
            $student = $this->helper->findChild($studentId);
            $studentId = @$student[0];
            $uuid = @$student[1];
            $subjects = $this->helper->subjectList();
            $subject = $this->helper->subject($slug);
            $projectType = 2;
            $array['homePracticeSection'] = $this->blockHelper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.practice.practice_section_detail'), $projectType);
            $array['subjectData']=$subject;
            $array['slug']=@$slug;
            $array['subjects']=@$subjects;
            $array['studentId']=@$studentId;
            $array['uuid']=@$uuid;
            return view($this->viewConstant . 'list',$array);
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * -------------------------------------------------
     * | GEt Assessment detail                         |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function assessmentDetail($uuid=null){
        try {
            $data['testAssessment'] = $this->helper->testAssessmentDetail($uuid);
            $data['subjectData'] = $data['testAssessment']->testAssessmentSubjectDetail[0]->subject;
            $data['uuid'] = Auth::guard('student')->user()->uuid;
            return view($this->viewConstant . 'detail',$data);
        } catch (Exception $e) {
            abort(404);
        }
    }
    
    /**
     * -------------------------------------------------
     * | Student Test paper results                    |
     * |                                               |
     * | @param uuid                                   |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function reviewTestResult($uuid=null){
        $studentTest = $this->helper->studentTest($uuid);
        $testResults = $studentTest->practiceTestResults;
        $testAssessment = @$studentTest->testAssessment;
        $studentId = $studentTest->student->uuid;
        return view($this->viewConstant . 'review',['studentTest' => $studentTest,'studentId'=>@$studentId,'testAssessment'=>@$testAssessment,'testResults'=>@$testResults]);
    }
}
