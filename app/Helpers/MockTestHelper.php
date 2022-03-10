<?php

namespace App\Helpers;

use App\Imports\SectionQuestionImport;
use App\Models\Admin;
use App\Models\EmailTemplate;
use App\Models\ExamBoard;
use App\Models\MockTest;
use App\Models\MockTestPaper;
use App\Models\MockTestSubjectDetail;
use App\Models\MockTestSubjectQuestion;
use App\Models\Question;
use App\Models\QuestionList;
use App\Models\QuestionMedia;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use DB;
use Excel;

class MockTestHelper extends BaseHelper
{
    protected $mockTest;

    public function __construct(MockTest $mockTest, Subject $subject, MockTestSubjectDetail $mockTestSubjectDetail,
                                Question $question, MockTestSubjectQuestion $subjectQuestion, ExamBoard $examBoard,
                                MockTestPaper $mockTestPaper
                                )
    {
        $this->question = $question;
        $this->mockTest = $mockTest;
        $this->subject = $subject;
        $this->subjectQuestion = $subjectQuestion;
        $this->mockTestSubjectDetail = $mockTestSubjectDetail;
        $this->examBoard = $examBoard;
        $this->mockTestPaper = $mockTestPaper;
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
        return $this->mockTest::orderBy('id', 'desc');
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
        return $this->mockTest::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | Mock Test store                                    |
     * |                                                    |
     * | @param Request $request ,$uuid                     |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        $routeName = Route::currentRouteName();
        $questionIds = null;
        $questionListIds = null;
        $subjectQuestionIds = null;
        // store mock exam image
        if ($request->image_path) {
            $request['image'] = $request->image_path;
            $request['image_id'] = $request->image_checkbox;
        }
        // check request has id or not null and route is copy mock
        if ($request->has('id') && $request->id != '' && $routeName == 'mock-test.copy-exam') {
            $mockData = $this->mockTest::findOrFail($request->id);
            // clone mocktest
            $mockTest = $this->cloneMockTest($mockData); 
        // check request has id or not null
        }elseif($request->has('id') && $request->id != ''){
            $mockTest = $this->mockTest::findOrFail($request->id);
        } else {
            $mockTest = new MockTest();
        }
        $request['start_date'] = date('Y-m-d', strtotime($request->start_date));
        $request['end_date'] = date('Y-m-d', strtotime($request->end_date));
        $mockTest->fill($request->all())->save();
        $data = $request->test_detail;
        data_set($data, '*.mock_test_id', $mockTest->id);
        // if request has file
        if ($request->hasFile('test_image')): $this->storeImage($request, $mockTest);
        endif;
        // check if request has parent ids
        if (isset($request->parent_ids)) {
            $data = [];
            foreach ($request->parent_ids as $key => $parentId) {
                $data[$key]['parent_id'] = $parentId;
            }
            $mockTest->parentMockTest()->delete();
            $mockTest->parentMockTest()->createMany($data);
        }
        // store audio data
        $this->storeAudioData($request, $mockTest);

        return ['mockTest'=>$mockTest,'errors'=>null];

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
        $mockTest = $this->detail($uuid);
        $status = $mockTest->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $action = ($status == config('constant.status_active_value')) ? __('formname.activated') : __('formname.inactivated');
        $this->mockTest::where('id', $mockTest->id)->update(['status' => $status]);
        $msg = __('formname.action_msg', ['action' => $action, 'type' => __('formname.mock_test_id')]);
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
        return $this->mockTest::where('uuid', $uuid)->first();
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
        $mockTest = $this->detail($uuid);
        $mockTest->delete();
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
        $mockTest = $this->mockTest::whereIn('id', $request->ids);
        // check if request action to delete record
        if ($request->action == config('constant.delete')) {
            $mockTest->delete();
        } else {
            $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $mockTest->update(['status' => $status]);
        }
    }

    /**
     * ------------------------------------------------------
     * | Store image                                        |
     * |                                                    |
     * | @param $request ,$user                              |
     * |-----------------------------------------------------
     */
    public function storeImage($request, $mockTest)
    {
        $folderName = config('constant.mock-test.folder_name');
        $ImageSave = commonImageUpload($request->file('test_image'));
//        $imageFunction = $this->uploadImage($request->file('test_image'), $folderName,240,320);
        $mockTest = $this->mockTest::updateOrCreate([
            'id' => $mockTest->id,

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
        $mockTestSubjectDetail = $this->mockTestSubjectDetail::whereMockTestId($request->mock_test_id)->get();
        return [@$subjects, @$mockTestSubjectDetail];
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
        $mockExam = MockTest::where('end_date','<',$today)
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
        $folderName = config('constant.mock-test.folder_name');
        $imageFunction = $this->uploadAudio($file, $folderName);
        return @$imageFunction[0];
    }

    /**
     * ------------------------------------------------------
     * | Store audio data                                   |
     * |                                                    |
     * | @param $request , $mockTest                         |
     * |-----------------------------------------------------
     */
    public function storeAudioData($request, $mockTest)
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
            $mockTest->mockAudio()->delete();
            $mockTest->mockAudio()->createMany($audioData);
        }
    }

    /**
     * -------------------------------------------------------
     * | Get Checkout Products                               |
     * |                                                     |
     * | @param $ids |
     * -------------------------------------------------------
     */
    public function getCheckoutProducts($ids)
    {
        return $this->mockTest->whereIn('id', $ids)->get();
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
        $mockTest = $this->mockTest->whereIn('id', $ids)->select('exam_board_id')
            ->groupBy('exam_board_id')
            ->get()
            ->pluck('exam_board_id');
        $categories = [];
        foreach ($mockTest as $key => $val) {
            $board = $this->examBoard->where('id', $val)->first();
            $categories[$key] = $this->examBoard->where('id', $val)->first();
            $categories[$key]['mockExams'] = $board->relatedMockTests->whereNotIn('id', $ids);
            // dd($categories[$key]['mockExams']);
        }
        return $categories;
    }

    /**
     * -------------------------------------------------------
     * | Get MockTest Student Rank                           |
     * |                                                     |
     * | @param $ids                                         |
     * -------------------------------------------------------
     */
    public function getMockTestStudentRank($mockTest, $student)
    {
        $studentRanks = DB::table('student_test_results')
            ->select('id', 'student_id', 'mock_test_id', 'overall_result')
            ->selectRaw("rank() over (order by overall_result desc) as rank")
            ->where('mock_test_id', $mockTest->id)
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

    // try {
    //     $subject = $details['subject'];
    //     $rating = $details['rating'];
    //     $username = $p[0]['full_name'];
    //     $mocktitle = $m['title'];
    //     $review = $details['msg'];
    //     $userdata = Admin::first();
    //     $view = 'newfrontend.email_templates.reviewnrate';
    //     $this->sendMail($view, ['mocktitle'=>$mocktitle,'username'=>$username,'rating'=>$rating,'review'=>$review], null, $subject, $userdata);
    //     return __('formname.order_email_label');
    // } catch (Exception $e) {
    //     return $e->getMessage();
    // }



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

    public function storePaperData($request,$mockTest,$papersData=null){
        // dd($papersData,$request->paper);
        $mockTest->papers()->delete();
        $mockTest->mockTestSubject()->delete();
        $this->mockTestSubjectDetail::whereMockTestId($mockTest->id)->delete();
        $this->subjectQuestion::whereMockTestId($mockTest->id)->delete();
        foreach($request->paper as $paperKey => $paper){
            $mockPaper =  $this->mockTestPaper::create([
                'name' => $paper['paper_name'],
                'mock_test_id' => $mockTest->id
            ]);
            $i = 0;
            foreach($paper['subject'] as $subjectKey => $subjectQuestions){
                $subject = $this->subject::where('slug',$subjectKey)->select('id')->first();
                $questionCount = QuestionList::where('question_id',$papersData[$paperKey]['question_id'][$i])->count();
                foreach($subjectQuestions as $qKey => $questionDetail){
                    $this->mockTestSubjectDetail::create([
                        'mock_test_id' => $mockTest->id,
                        'mock_test_paper_id'=>$mockPaper->id,
                        'subject_id' => @$papersData[$paperKey]['subject_id'][$i],
                        'topic_id' => @$questionDetail['topic_id'],
                        'questions' => @$questionCount,
                        'time' => $questionDetail['time'],
                        'seq' => @$questionDetail['seq'],
                        'report_question' => @$questionDetail['report_question'],
                    ]);

                    if(isset($papersData[$paperKey]) && $papersData != null){
                        $this->subjectQuestion::create([
                            'mock_test_id' => $mockTest->id,
                            'mock_test_paper_id' => $mockPaper->id,
                            'subject_id' => $subject->id,
                            'question_id' => $papersData[$paperKey]['question_id'][$i]
                        ]);
                        $i++;
                    }
                }
            }
            $papers[] = $mockPaper->mockTestSubjectQuestion;
        }
        // dd($papers);
        return;
    }

    public function storePaperBySection($request, $mockTest){
        $mockTest->papers()->delete();
        $mockTest->mockTestSubject()->delete();
        $this->mockTestSubjectDetail::whereMockTestId($mockTest->id)->delete();
        $this->subjectQuestion::whereMockTestId($mockTest->id)->delete();
        foreach($request->paper as $paper){
            $paperTime = 0;
            $mockPaper =  $this->mockTestPaper::updateOrCreate([
                'id' => @$paper['id'],
                'mock_test_id' => $mockTest->id,
            ],[
                'name' => @$paper['name'],
                'mock_test_id' => $mockTest->id,
                'description' => @$paper['description'],
            ]);
            foreach($paper['section'] as $sectionKey => $section){

                // import questions of paper section
                if(isset($section['import_file']) && $section['import_file'] != null){
                    $import = new SectionQuestionImport;
                    Excel::import($import, $section['import_file']);
                    $errorMessage = Session::get('error');
                    if($errorMessage){
                        return redirect()->back()->withError(__('formname.not_found'));
                    }
                    $questionListIds = @$import->questionListIds;
                    $questionId = @$import->questionId;
                }else{
                    $questionId = @$section['question_id'];
                }

                // Store mock test subject section questions
                $this->subjectQuestion::updateOrCreate([
                    'mock_test_id' => $mockTest->id,
                    'mock_test_paper_id' => $mockPaper->id,
                    'subject_id' => $section['subject_id'],
                    'question_id' => $questionId,
                ],[
                    'mock_test_id' => $mockTest->id,
                    'mock_test_paper_id' => $mockPaper->id,
                    'subject_id' => $section['subject_id'],
                    'question_id' => $questionId,
                ]);

                // store section instruction image
                $sectionImage = null;
                if(isset($section['image_id']) && $section['image_id'] != null){
                    $sectionImage = @$section['image_id'];
                }

                // store question passages
                if(isset($section['passage']) && $section['passage'] != null && $questionId != null){
                    $passage = $section['passage'];
                    $mimeType = $passage->getClientOriginalExtension();
                    // check if mime type is pdf
                    $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                    $path = 'question' . $questionId . '/';
                    $file = $this->uploadFile($passage,$path,true);
                    QuestionMedia::where('question_id',$questionId)->where('name',strtolower($file[1]))->get();
                    QuestionMedia::where('question_id',$questionId)->where('name',strtolower($file[1]))->update(['media_type'=>@$mediaType,'name'=>$file[0]]);
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

                if(isset($section['images']) && $section['images'] != null && $questionId != null){
                    foreach($section['images'] as $image){
                        $mimeType = $image->getClientOriginalExtension();
                        // check if mime type is pdf
                        $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                        $questionListIds = QuestionList::where('question_id',$questionId)->select('id')->pluck('id');
                        foreach($questionListIds as $id){
                            $path = 'questionList';
                            $file = $this->uploadFile($image,$path);
                            QuestionList::where('id',$id)->where('image',strtolower($file[1]))->update(['image'=>@$file[0]]);
                            QuestionList::where('id',$id)->where('question_image',strtolower($file[1]))->update(['question_image'=>@$file[0]]);
                            QuestionList::where('id',$id)->where('answer_image',strtolower($file[1]))->update(['answer_image'=>@$file[0]]);
                        }
                    }
                }

                // Store mock test subject detail
                $this->mockTestSubjectDetail::updateOrCreate([
                    'mock_test_id' => $mockTest->id,
                    'mock_test_paper_id'=>$mockPaper->id,
                    'subject_id' => @$section['subject_id'],
                    'seq' => @$section['seq'],
                ],[
                    'mock_test_id' => $mockTest->id,
                    'mock_test_paper_id'=>$mockPaper->id,
                    'subject_id' => @$section['subject_id'],
                    'time' => @$section['time'],
                    'seq' => @$section['seq'],
                    'report_question' => @$section['report_question'],
                    'description' => @$section['description'],
                    'instruction_read_time' => @$section['instruction_read_time'],
                    'image' => $sectionImage,
                    'is_time_mandatory' => @$section['is_time_mandatory'],
                ]);
                $paperTime += @$section['time'];
            }
            $mockPaper->update(['time' => $paperTime]);
        }
    }

    public function storePaper($request, $mockTest){
        $paperTime = 0;
        $mockPaper =  $this->mockTestPaper::updateOrCreate([
            'id' => @$request->id,
            'mock_test_id' => $request->mock_test_id,
        ],$request->all());
        if($request->hasFile('answer_sheet')){
            $path = 'mock-paper' . $mockPaper->id . '/';
            $file = $this->uploadAudio($request->answer_sheet,$path);
            $mockPaper->update(['answer_sheet'=> $file[0]]);
        }
        // $mockPaper->mockTestSubjectQuestion()->delete();
        // $mockPaper->mockTestSubjectDetail()->delete();
        foreach($request->section as $sectionKey => $section){
            // import questions of paper section
            if(isset($section['import_file']) && $section['import_file'] != null){
                $import = new SectionQuestionImport;
                Excel::import($import, $section['import_file']);
                // $questionListIds = @$import->questionListIds;
                $questionIds = @$import->questionId;
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
                    // $questionListIds = QuestionList::where('question_id',$questionId)->select('id')->pluck('id');
                    foreach($questionIds as $id){
                        $path = 'questionList';
                        $file = $this->uploadFile($image,$path);
                        Question::where('id',$id)->where('image',strtolower($file[1]))->update(['image'=>@$file[0]]);
                        Question::where('id',$id)->where('question_image',strtolower($file[1]))->update(['question_image'=>@$file[0]]);
                        Question::where('id',$id)->where('answer_image',strtolower($file[1]))->update(['answer_image'=>@$file[0]]);
                    }
                }
            }
            // $questionList = Question::whereIn('id',$questionIds)->get();
            $isNull = empty(array_filter($section['instruction_read_time'], function ($a) { return $a !== null;}));
            $instructionReadTime = null;
            if($isNull==false){
                $instructionReadTime = implode(':',$section['instruction_read_time']);
            }
            $sectionTime = implode(':',$section['section_time']);
            $questions = $questionIds !=null ? count($questionIds) : 0;
            // Store mock test subject detail
            $data = $this->mockTestSubjectDetail::updateOrCreate([
                'id' => @$section['id']
            ],[
                'mock_test_id' => $request->mock_test_id,
                'name' => @$section['name'],
                'mock_test_paper_id'=>$mockPaper->id,
                'subject_id' => @$section['subject_id'],
                'time' => @$sectionTime,
                'seq' => @$section['seq'],
                'report_question' => @$section['report_question'],
                'description' => @$section['description'],
                'instruction_read_time' => @$instructionReadTime,
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
            // Store mock test subject section questions
            if($questionIds != null){
                $data->questionList2()->delete();
                foreach($questionIds as $questionId){
                    $this->subjectQuestion::create([
                        'mock_test_id' => $request->mock_test_id,
                        'mock_test_paper_id' => $mockPaper->id,
                        'subject_id' => $section['subject_id'],
                        'question_id' => $questionId,
                        'mock_test_subject_detail_id' => $data->id,
                    ]);
                }
            }
            $time = strtotime($sectionTime) + strtotime($paperTime);
            $paperTime = date('H:i:s',$time);
        }
        $mockPaper->update(['time' => $paperTime]);
    }

    /**
     * ------------------------------------------------------
     * | Mock Paper detail by uuid                          |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function paperDetail($uuid)
    {
        return $this->mockTestPaper::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | clone mock exam and papers data                    |
     * |                                                    |
     * | @param $mockTest                                   |
     * | @return mockTest                                   |
     * |-----------------------------------------------------
     */
    public function cloneMockTest($mockTest){
        $mockTestData = $mockTest->replicate();
        $mockTestData->created_at = now();
        $mockTestData->updated_at = now();
        $mockTestData->save();
        // store paper detail
        $papers = $mockTest->papers;
        foreach($papers as $key => $paper){
            // make copy of mock test paper 
            $clonePaper = $paper->replicate();
            $clonePaper->mock_test_id = $mockTestData->id;
            $clonePaper->save();
            // make copy of paper section detail
            foreach($paper->mockTestSubjectDetail as $subKey => $subjectDetail){
                $paperSubjectData = $subjectDetail->replicate();
                $paperSubjectData->mock_test_id = $mockTestData->id;
                $paperSubjectData->mock_test_paper_id = $clonePaper->id;
                $paperSubjectData->save();
                // make copy of paper section questions
                foreach($subjectDetail->questionList2 as $qKey=> $sectionQuestionData){
                    $cloneSectionQuestion = $sectionQuestionData->replicate();
                    $cloneSectionQuestion->question_id = $sectionQuestionData->question_id;
                    $cloneSectionQuestion->mock_test_id = $mockTestData->id;
                    $cloneSectionQuestion->mock_test_paper_id = $clonePaper->id;
                    $cloneSectionQuestion->mock_test_subject_detail_id = $paperSubjectData->id;
                    $cloneSectionQuestion->save();
                }
            }
        }
        return $mockTestData;
    }
}
