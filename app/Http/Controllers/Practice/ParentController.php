<?php

namespace App\Http\Controllers\Practice;

use App\Helpers\PracticeHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\MockTest;
use App\Models\Subject;
use App\Models\TestAssessment;
use Exception;

class ParentController extends BaseController
{
    /* Global variables */
    public $viewConstant = 'newfrontend.user.';
    public $subject, $assessment,$helper;

    public function __construct(Subject $subject,TestAssessment $assessment,PracticeHelper $helper)
    {
        $this->subject = $subject;
        $this->assessment = $assessment;
        $this->helper = $helper;
    }

    /**
     * -------------------------------------------------------
     * | Parent Weekly Assessment List By Subjects           |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function weeklyAssessment($studentId=null){
        try{
            $student = $this->helper->findChild($studentId);
            $studentId = @$student[0];
            $uuid = @$student[1];
            $subjects = $this->subject::orderBy('order_seq','asc')->get();
            return view($this->viewConstant.'weekly-assessment',['uuid'=>@$uuid,'studentId'=>@$studentId,'subjects'=>@$subjects]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------------
     * | Practice by topic list                              |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function practiceByTopic($studentId=null){
        try{
            $student = $this->helper->findChild($studentId);
            $studentId = @$student[0];
            $uuid = @$student[1];
            $subjects = $this->subject::orderBy('order_seq','asc')->get();
            return view($this->viewConstant.'topic_list',['uuid'=>@$uuid,'studentId'=>@$studentId,'subjects'=>@$subjects]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
