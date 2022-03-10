<?php

namespace App\Helpers;

use DB;
use Excel;
use Exception;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Subject;
use App\Models\Question;
use App\Models\ExamBoard;
use App\Imports\ImportFile;
use App\Models\QuestionList;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\QuestionMedia;
use App\Models\TestAssessment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Models\TestAssessmentQuestion;
use App\Imports\ImportAssessmentQuestion;
use App\Models\PracticeQuestion;
use App\Models\PracticeQuestionList;
use App\Models\TestAssessmentSubjectInfo;

class TestAssessmentHelper extends BaseHelper
{
    protected $testAssessment;

    public function __construct(TestAssessment $testAssessment, Subject $subject, TestAssessmentSubjectInfo $testAssessmentDetail,Question $question, TestAssessmentQuestion $subjectQuestion, ExamBoard $examBoard)
    {
        $this->question = $question;
        $this->testAssessment = $testAssessment;
        $this->subject = $subject;
        $this->subjectQuestion = $subjectQuestion;
        $this->testAssessmentDetail = $testAssessmentDetail;
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
        return $this->testAssessment::orderBy('id', 'desc');
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
        return $this->testAssessment::whereId($id)->first();
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
        if ($request->has('id') && $request->id != '' && $routeName == 'test-assessment.copy-exam') {
            $data = $this->testAssessment::findOrFail($request->id);
            $testAssessment = new TestAssessment();
        // check request has id or not null
        }elseif($request->has('id') && $request->id != ''){
            $testAssessment = $this->testAssessment::findOrFail($request->id);
        } else {
            $testAssessment = new TestAssessment();
        }
        if($request->start_date != null){
            $request['start_date'] = date('Y-m-d', strtotime($request->start_date));
        }
        if($request->end_date != null){
            $request['end_date'] = date('Y-m-d', strtotime($request->end_date));
        }
        $testAssessment->fill($request->all())->save();
        foreach($request->section as $sectionKey => $section){
            // import questions of paper section
            if(isset($section['import_file']) && $section['import_file'] != null){
                $testAssessment->testAssessmentSubjectDetail()->delete();
                $import = new ImportAssessmentQuestion;
                Excel::import($import, $section['import_file']);
                if(isset($import->errors) && $import->errors != null){
                    return ['error'=>$import->errors];
                }
                $questionIds = @$import->questionIds;
            }else{
                $questionIds = explode(',',@$section['question_ids']);
            }
            // store section instruction image
            $sectionImage = null;
            if(isset($section['image_id']) && $section['image_id'] != null){
                $sectionImage = @$section['image_id'];
            }

            // store question images
            if(isset($section['image']) && $section['image'] != null){
                $mimeType = $section['image']->getClientOriginalExtension();
                // check if mime type is pdf
                $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                $path = 'questionList';
                $file = $this->uploadFile($section['image'],$path);
                $sectionImage = @$file[0];
            }

            if(isset($section['images']) && $section['images'] != null && $questionIds != null){
                foreach($section['images'] as $image){
                    $mimeType = $image->getClientOriginalExtension();
                    // check if mime type is pdf
                    $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                    foreach($questionIds as $id){
                        $path = 'questionList';
                        $file = $this->uploadFile($image,$path);
                        PracticeQuestion::where('id',$id)->where('image',strtolower($file[1]))->update(['image'=>@$file[0]]);
                        PracticeQuestion::where('id',$id)->where('question_image',strtolower($file[1]))->update(['question_image'=>@$file[0]]);
                        PracticeQuestion::where('id',$id)->where('answer_image',strtolower($file[1]))->update(['answer_image'=>@$file[0]]);
                    }
                }
            }
            $sectionTime = implode(':',$section['section_time']);
            $questions = PracticeQuestion::whereIn('id',$questionIds)->count();
            // Store mock test subject detail
            $data = $this->testAssessmentDetail::updateOrCreate([
                'id' => @$section['id'],
                'test_assessment_id' => $testAssessment->id,
            ],[
                'test_assessment_id' => $testAssessment->id,
                'name' => @$section['name'],
                'subject_id' => @$section['subject_id'],
                'time' => @$sectionTime,
                'seq' => @$section['seq'],
                'report_question' => @$section['report_question'],
                'description' => @$section['description'],
                'image' => $sectionImage,
                'is_time_mandatory' => @$section['is_time_mandatory'],
                'questions' => $questions,
            ]);
            // store question passages
            if(isset($section['passage']) && $section['passage'] != null && $data != null){
                $passage = $section['passage'];
                $mimeType = $passage->getClientOriginalExtension();
                // check if mime type is pdf
                $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                $path = 'passage' . $data->id . '/';
                $file = $this->uploadFile($passage,$path,true);
                $sectionPassage = $file[0];
                $data->update(['passage' => @$sectionPassage]);
            }

            if($questionIds != null){
                $data->questionList2()->delete();
                foreach($questionIds as $questionId){
                    $this->subjectQuestion::create([
                        'test_assessment_id' => $testAssessment->id,
                        'subject_id' => $section['subject_id'],
                        'question_id' => $questionId,
                        'test_assessment_subject_id' => $data->id,
                    ]);
                }
            }
        }
        return $testAssessment;
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
        $testAssessment = $this->detail($uuid);
        $status = $testAssessment->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $action = ($status == config('constant.status_active_value')) ? __('formname.activated') : __('formname.inactivated');
        $this->testAssessment::where('id', $testAssessment->id)->update(['status' => $status]);
        $msg = __('formname.action_msg', ['action' => $action, 'type' => __('formname.test_assessment_id')]);
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
        return $this->testAssessment::where('uuid', $uuid)->first();
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
        $testAssessment = $this->detail($uuid);
        $testAssessment->delete();
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
        $testAssessment = $this->testAssessment::whereIn('id', $request->ids);
        // check if request action to delete record
        if ($request->action == config('constant.delete')) {
            $testAssessment->delete();
        } else {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $testAssessment->update(['status' => $status]);
        }
    }

    /**
     * ------------------------------------------------------
     * | Store image                                        |
     * |                                                    |
     * | @param $request ,$user                              |
     * |-----------------------------------------------------
     */
    public function storeImage($request, $testAssessment)
    {
        $folderName = config('constant.test-assessment.folder_name');
        $ImageSave = commonImageUpload($request->file('test_image'));
//        $imageFunction = $this->uploadImage($request->file('test_image'), $folderName,240,320);
        $testAssessment = $this->testAssessment::updateOrCreate([
            'id' => $testAssessment->id,

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
        $folderName = config('constant.test-assessment.folder_name');
        $imageFunction = $this->uploadAudio($file, $folderName);
        return @$imageFunction[0];
    }

    /**
     * ------------------------------------------------------
     * | Store audio data                                   |
     * |                                                    |
     * | @param $request , $testAssessment                         |
     * |-----------------------------------------------------
     */
    public function storeAudioData($request, $testAssessment)
    {
        $audioData = [];
        $i = 1;
        foreach ($request->data as $key => $item) {
            // check if interval not null then store audio data
            if($item['interval'] != null){
                $audioData[$key]['interval'] = $item['interval'];
                if(isset($item['audio'])){
                    $audioData[$key]['audio']=$this->storeAudio($item['audio']);
                }else{
                    $audioData[$key]['audio']=(isset($item['stored_audio_name']) && $item['stored_audio_name'] != null)?$item['stored_audio_name']:'';
                }
                $audioData[$key]['seq'] = $i;
                $i++;
            }
        }
        // check if audiodata array not null then delete and insert data
        if(count($audioData)>0){
            $testAssessment->assessmentAudio()->delete();
            $testAssessment->assessmentAudio()->createMany($audioData);
        }
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
        return $this->testAssessment->whereIn('id', $ids)->get();
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
        $testAssessment = $this->testAssessment->whereIn('id', $ids)->select('exam_board_id')
            ->groupBy('exam_board_id')
            ->get()
            ->pluck('exam_board_id');
        $categories = [];
        foreach ($testAssessment as $key => $val) {
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
    public function getMockTestStudentRank($testAssessment, $student)
    {
        $studentRanks = DB::table('student_test_results')
            ->select('id', 'student_id', 'test_assessment_id', 'overall_result')
            ->selectRaw("rank() over (order by overall_result desc) as rank")
            ->where('test_assessment_id', $testAssessment->id)
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

    public function assessmentAudio($testAssessment){
        // allAudios
        $firstAudio = '';
        $secondAudio = '';
        $thirdAudio = '';
        $forthAudio = '';
        $secondAudioPlayTime = 0;
        $thirdAudioPlayTime = 0;
        $forthAudioPlayTime = 0;
        $examTotalTime = $testAssessment->testAssessmentSubjectDetail->sum('section_time');
        $examTotalSeconds = $examTotalTime;
        if (count($testAssessment->assessmentAudio) > 0) {
            $firstAudio = $testAssessment->assessmentAudio->where('seq', 1)->first();
            $secondAudio = $testAssessment->assessmentAudio->where('seq', 3)->first();
            $thirdAudio = $testAssessment->assessmentAudio->where('seq', 4)->first();
            $forthAudio = $testAssessment->assessmentAudio->where('seq', 2)->first();
            $secondAudioPlayTime = ($examTotalSeconds / 2) * 1000;
            $thirdAudioPlayTime = ($examTotalSeconds - 60) * 1000;
            $forthAudioPlayTime = ($examTotalSeconds - 1) * 1000;
        }
        return [@$firstAudio,@$secondAudio,@$thirdAudio, @$forthAudio,@$secondAudioPlayTime,@$thirdAudioPlayTime,@$forthAudioPlayTime];
    }
}
