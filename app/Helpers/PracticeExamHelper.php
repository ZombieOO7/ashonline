<?php

namespace App\Helpers;

use App\Models\Admin;
use App\Models\EmailTemplate;
use App\Models\ExamBoard;
use App\Models\TestAssessment;
use App\Models\PracticeExam;
use App\Models\PracticeExamQuestion;
use App\Models\PracticeQuestion;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use DB;
use Exception;

class PracticeExamHelper extends BaseHelper
{
    protected $practiceExam;

    public function __construct(PracticeExam $practiceExam, Subject $subject, PracticeExamQuestion $practiceQuestion, ExamBoard $examBoard)
    {
        $this->practiceExam = $practiceExam;
        $this->subject = $subject;
        $this->examBoard = $examBoard;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Mock Test list                                 |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function list()
    {
        return $this->practiceExam::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | Mock Test detail by id                             |
     * |                                                    |
     * | @param $id |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->practiceExam::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | Mock Test store                                    |
     * |                                                    |
     * | @param Request $request ,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        $routeName = Route::currentRouteName();
        // check request has id or not null and route is copy mock
        if ($request->has('id') && $request->id != null && $request->id != '' && $routeName == 'practice-exam.copy-exam') {
            $this->practiceExam::findOrFail($request->id);
            $request->request->remove('id');
            $practiceExam = new PracticeExam();
        // check request has id or not null
        }elseif($request->has('id') && $request->id != '' && $request->id != null){
            $practiceExam = $this->practiceExam::findOrFail($request->id);
        } else {
            $request->request->remove('id');
            $practiceExam = new PracticeExam();
        }
        // if request has file
        if ($request->hasFile('test_image')): $this->storeImage($request, $practiceExam);
        endif;
        // store audio data
        $request->request->remove('topic_id');
        $practiceExam->fill($request->all())->save();
        if($request->topic != null || $routeName == 'practice-exam.copy-exam'){
            $topicData = $request->topic;
            $request->request->remove('topic');
            $practiceExam->practiceExamTopic()->delete();
            $practiceExam->practiceExamTopic()->createMany($topicData);
        }
        return $practiceExam;
    }

    /**
     * ------------------------------------------------------
     * | Update status                                      |
     * |                                                    |
     * | @param $uuid |
     * |-----------------------------------------------------
     */
    public function statusUpdate($uuid)
    {
        $practiceExam = $this->detail($uuid);
        $status = $practiceExam->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $action = ($status == config('constant.status_active_value')) ? __('formname.activated') : __('formname.inactivated');
        $this->practiceExam::where('id', $practiceExam->id)->update(['status' => $status]);
        $msg = __('formname.action_msg', ['action' => $action, 'type' => __('formname.practice_exam_id')]);
        return $msg;
    }

    /**
     * ------------------------------------------------------
     * | Mock Test detail by uuid                           |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->practiceExam::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Delete Mock Test                                   |
     * |                                                    |
     * | @param $uuid |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $practiceExam = $this->detail($uuid);
        $practiceExam->delete();
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple Mock Test                                   |
     * |                                                             |
     * | @param Request $request |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $practiceExam = $this->practiceExam::whereIn('id', $request->ids);
        // check if request action to delete record
        if ($request->action == config('constant.delete')) {
            $practiceExam->delete();
        } else {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $practiceExam->update(['status' => $status]);
        }
    }

    /**
     * ------------------------------------------------------
     * | Store image                                        |
     * |                                                    |
     * | @param $request ,$user                              |
     * |-----------------------------------------------------
     */
    public function storeImage($request, $practiceExam)
    {
        $folderName = config('constant.practice-exam.folder_name');
        $ImageSave = commonImageUpload($request->file('test_image'));
//        $imageFunction = $this->uploadImage($request->file('test_image'), $folderName,240,320);
        $practiceExam = $this->practiceExam::updateOrCreate([
            'id' => $practiceExam->id,

        ], [
            'image_id' => $ImageSave->id,
            'image' => $ImageSave->path,
        ]);
        return $request;
    }

    /**
     * ------------------------------------------------------
     * | Mock Test subject detail                           |
     * |                                                    |
     * | @param $uuid |
     * |-----------------------------------------------------
     */
    public function subjectDetail($request)
    {
        $ids = (is_array($request->subject_ids) == true) ? $request->subject_ids : [$request->subject_ids];
        $subjects = $this->subject::whereIn('id', $ids)->get();
        $mockTestDetail = $this->testAssessmentDetail::whereTestAssessmentId($request->test_assessment_id)->get();
        return [@$subjects, @$mockTestDetail];
    }

    /**
     * ------------------------------------------------------
     * | Mock Test question list                            |
     * |                                                    |
     * | @param $uuid |
     * |-----------------------------------------------------
     */
    public function questionList($request)
    {
        $questions = $this->question::whereSubjectId($request->subject_id)
                    ->get();
        return $questions;
    }
    /**
     * ------------------------------------------------------
     * | Exapire or disable  mock exam                      |
     * |                                                    |
     * | @param $uuid |
     * |-----------------------------------------------------
     */
    public function disableMockExam()
    {
        $today = Carbon::now();
        $mockExam = TestAssessment::where('end_date','<',$today)
                    ->update(['start_date'=>null,'end_date'=>null,'status'=>0]);
        return;
    }

    /**
     * ------------------------------------------------------
     * | Store audio                                        |
     * |                                                    |
     * | @param $file                                       |
     * |-----------------------------------------------------
     */
    public function storeAudio($file)
    {
        $folderName = config('constant.practice-exam.folder_name');
        $imageFunction = $this->uploadAudio($file, $folderName);
        return @$imageFunction[0];
    }

    /**
     * ------------------------------------------------------
     * | Store audio data                                   |
     * |                                                    |
     * | @param $request , $practiceExam                    |
     * |-----------------------------------------------------
     */
    public function storeAudioData($audio, $practiceExam)
    {
        if($audio != null){
            $audioData=$this->storeAudio($audio);
        }
        return $audioData;
    }

    /**
     * -------------------------------------------------------
     * | Get Checkout Products                               |
     * |                                                     |
     * | @param $ids                                         |
     * -------------------------------------------------------
     */
    public function getCheckoutProducts($ids)
    {
        return $this->practiceExam->whereIn('id', $ids)->get();
    }

    /**
     * -------------------------------------------------------
     * | Get Cart Related Papers                             |
     * |                                                     |
     * | @param $ids |
     * -------------------------------------------------------
     */
    public function getCartRelatedProducts($ids)
    {
        $practiceExam = $this->practiceExam->whereIn('id', $ids)->select('exam_board_id')
            ->groupBy('exam_board_id')
            ->get()
            ->pluck('exam_board_id');
        $categories = [];
        foreach ($practiceExam as $key => $val) {
            $board = $this->examBoard->where('id', $val)->first();
            $categories[$key] = $this->examBoard->where('id', $val)->first();
            $categories[$key]['mockExams'] = $board->relatedMockTests->whereNotIn('id', $ids);
            // dd($categories[$key]['mockExams']);
        }
        return $categories;
    }

    /**
     * -------------------------------------------------------
     * | Get TestAssessment Student Rank                           |
     * |                                                     |
     * | @param $ids                                         |
     * -------------------------------------------------------
     */
    public function getMockTestStudentRank($practiceExam, $student)
    {
        $studentRanks = DB::table('student_test_results')
            ->select('id', 'student_id', 'test_assessment_id', 'overall_result')
            ->selectRaw("rank() over (order by overall_result desc) as rank")
            ->where('test_assessment_id', $practiceExam->id)
            ->get();

        $rank = $studentRanks->filter(function ($item) use ($student) {
            return $item->student_id == $student->id;
        })->first();

        $rankCounts = $studentRanks->count();

        $result = ['rank' => $rank->rank, 'rankCounts' => $rankCounts];

        return $result;
    }


    /**
     * ------------------------------------------------------
     * | Send Mail to Parent & Admin                        |
     * |                                                    |
     * |-----------------------------------------------------
     */
    function sendmail($view, $data, $message=null, $subject, $userdata)
    {
        Mail::send($view, $data, function ($message) use ($userdata, $subject) {
            $message->to($userdata->email)->subject($subject);

        });

    }

    /*
    * -------------------------------------------------------
    * | Send Email To Admin                                 |
    * |                                                     |
    * | @param $details                                     |
    * -------------------------------------------------------
    */
    function sendMailToAdmin($details,$p,$m)
    {
        try {
            $slug = config('constant.email_template.9');
            $template = EmailTemplate::whereSlug($slug)->first();
            $subject = $template->subject;
            $rating = $details['rating'];
            $username = $p[0]['full_name'];
            $mocktitle = $m['title'];
            $review = $details['msg'];
            $userdata = Admin::first();
            $view = 'newfrontend.email_templates.reviewnrate';
            $this->sendMail($view, ['mocktitle'=>$mocktitle,'username'=>$username,'rating'=>$rating,'review'=>$review,'content'=>$template->body], null, $subject, $userdata);
            return __('formname.order_email_label');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /*
    * -------------------------------------------------------
    * | Send Email To Parent                                 |
    * |                                                     |
    * | @param $details                                     |
    * -------------------------------------------------------
    */
    function sendMailToParent($details,$userdata)
    {
        try {
            $subject = $details->subject;
            $content = $details->template;
            $userdata = $userdata;
            $view = '';
            $this->sendMail($view, ['details'=>$details,'content'=>$template->body], null, $subject, $userdata);
            return __('formname.order_email_label');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
