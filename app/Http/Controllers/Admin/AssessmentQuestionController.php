<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuestionExport;
use Illuminate\Http\Request;
use App\Imports\ImportFile;
use App\Models\PracticeAnswer;
use App\Models\PracticeQuestion;
use App\Models\PracticeQuestionList;
use App\Models\QuestionMedia;
use App\Models\Subject;
use App\Models\TestAssessment;
use App\Models\TestAssessmentQuestion;
use App\Models\TestAssessmentSubjectInfo;
use App\Models\Topic;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Response;
use Session;
use Excel;
class AssessmentQuestionController extends BaseController
{
    public $viewConstant = 'admin.practice-question.';

    public function __construct()
    {
    }

    /**
     * -------------------------------------------------
     * | Display Question list                         |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        try{
            $subjectList =  Subject::orderBy('id', 'desc')->pluck('title', 'id');
            $topicList =  Topic::orderBy('id', 'desc')->pluck('title', 'id');
            return view($this->viewConstant.'index',['topicList'=>@$topicList,'subjectList'=>@$subjectList]);
        }catch (Exception $e)  {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Question                               |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($id=null)
    {
        try{
            $subject = Subject::orderBy('id', 'desc')->pluck('title', 'id');
            $methodType = __('formname.question.label',['type'=>isset($id)?__('formname.update'):__('formname.create')]);
            $question = PracticeQuestion::where('uuid', $id)->first();
            $type = $this->questionType();
            $questionSubType = $this->questionSubType();
            $topics = $this->topicList();
            return view($this->viewConstant.'create_edit', ['questionType'=>@$questionSubType,'type'=>@$type ,'subject' =>  @$subject, 'methodType' => @$methodType, 'question' => @$question,'topics'=>@$topics]);
        }catch(Exception $e){
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------
     * | Get Question blade                            |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getBlade(Request $request)
    {
        try{
            $subject = $request->subject_id;
            $type = $request->type;
            $question = PracticeQuestion::where('id', $request->question_id)
                        ->whereQuestionType($request->question_type)
                        ->where('type', $type)
                        ->whereSubjectId($subject)
                        ->first();

            if($request->question_type == 2){
                $returnHTML = view($this->viewConstant.'templates.standard',['question' => @$question,'subject'=>@$subject,'type'=>@$type])->render();
            }
            else if ($request->question_type == 1) {
                $returnHTML = view($this->viewConstant.'templates.mcq', ['question' => @$question,'type'=>@$type,'subject'=>@$subject])->render();
            } else {
                $returnHTML = "";
            }
            return response()->json(array('html' => $returnHTML));
        }catch(Exception $e){
            return response()->json(['msg' =>$e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Store Question details                        |
     * |                                               |
     * | @param MockTestFormRequest $request           |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(Request $request,$uuid=null)
    {
        $this->dbStart();
        try  {
            $questionAnswersArr =  $request->text;
            foreach ($questionAnswersArr as $questionAnswers) {
                array_set($request, 'question', $questionAnswers['question']);
                array_set($request, 'uuid', @$questionAnswers['uuid']);
                array_set($request, 'marks', @$questionAnswers['marks']);
                // array_set($request, 'hint', @$questionAnswers['hint']);
                array_set($request, 'explanation', @$questionAnswers['explanation']);
                array_set($request, 'answer_type', @$questionAnswers['answer_type']);
                array_set($request, 'instruction', @$questionAnswers['instruction']);
                array_set($request, 'resize_full_image', @$questionAnswers['resize_full_image']);
                array_set($request, 'resize_question_image', @$questionAnswers['resize_question_image']);
                array_set($request, 'resize_answer_image', @$questionAnswers['resize_answer_image']);
                $quesionList = PracticeQuestion::updateOrCreate(['uuid'=>@$questionAnswers['uuid']],$request->all());
                if(isset($questionAnswers['image']) && $questionAnswers['image'] != null){
                    $quesionImg = uploadOtherImage($questionAnswers['image'], 'questionList');
                    $quesionList->update(['image'=> $quesionImg, 'resize_full_image' => null]);
                }
                if(isset($questionAnswers['question_file']) && $questionAnswers['question_file'] != null){
                    $quesionImg = uploadOtherImage($questionAnswers['question_file'], 'questionList');
                    $quesionList->update(['question_image'=> $quesionImg, 'resize_question_image' => null]);
                    $request['resize_question_image'] = null;
                }
                if(isset($questionAnswers['answer_file']) && $questionAnswers['answer_file'] != null){
                    $quesionImg = uploadOtherImage($questionAnswers['answer_file'], 'questionList');
                    $quesionList->update(['answer_image'=>$quesionImg, 'resize_answer_image' =>null]);
                }
                foreach ($questionAnswers['answer'] as $i => $answer) {
                    if(isset($answer['answer']) != null){
                        array_set($request, 'question_id', $quesionList->id);
                        array_set($request, 'answer', $answer['answer']);
                        $correct = 0;
                        if (isset($answer['is_correct']) && $answer['is_correct'] == "on") {
                            $correct = 1;
                        }
                        array_set($request, 'is_correct', $correct);
                        $answer = PracticeAnswer::updateOrCreate(['question_id' => $quesionList->id, 'id' =>@$answer['answer_id']],$request->all());
                    }
                }
            }
            $this->dbCommit();
            $msg = __('admin_messages.action_msg',['action'=>($uuid==null)?__('formname.created'):__('formname.updated'),'type' => __('admin_messages.question.question')]);
            return redirect()->route('assessment.question.index')->with('message', $msg);
        }catch (Exception $e)  {
            $this->dbEnd();
            return redirect()->back()->with('error', $e->getMessage());
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Get Question datatable                        |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function show(Request $request)
    {
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        if($request->subject_id != null){
            $request->session()->put('subject_id',$request->subject_id);
        }else{
            $request->session()->pull('subject_id');
        }
        if($request->topic_id != null){
            $request->session()->put('topic_id',$request->topic_id);
        }else{
            $request->session()->pull('topic_id');
        }
        $itemQuery = PracticeQuestion::select('*');
        $itemQuery = $itemQuery->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->properActive($request->status);
                }
                if ($request->topic_id) {
                    $query->whereTopicId($request->topic_id);
                }
                if ($request->subject_id) {
                    $query->whereSubjectId($request->subject_id);
                }
            });
        $count_total = $itemQuery->count();
        $itemQuery = $itemQuery->skip($start)->take($limit);
        $questionDataTable = $itemQuery->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return DataTables::of($questionDataTable)
            ->addColumn('action', function ($questionData) {
                return \View::make($this->viewConstant.'action', ['questionData' => $questionData])->render();
            })
            ->editColumn('question_title', function ($questionData) {
                return $this->getPartials($this->viewConstant.'_content', ['questionData' => $questionData, 'title'=>__('formname.question.question_title')]);
            })
            ->addColumn('corrected_answer', function ($questionData) {
                return @$questionData->average_correct_answer;
            })
            ->addColumn('incorrected_answer', function ($questionData) {
                return @$questionData->average_incorrect_answer;
            })
            ->editColumn('progress', function ($questionData) {
                return @$questionData->progress_bar;
            })
            ->with([
                "draw" => $draw, 
                "Total" => $count_total,
                "recordsTotal" => $count_total,
                "recordsFiltered" => $count_filter,
            ])
            ->rawColumns(['question_title','progress','incorrected_answer', 'corrected_answer','action'])
            ->skipPaging()
            ->make(true);
    }

    /**
     * -------------------------------------------------
     * | Delete Question details                       |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        $this->dbStart();
        try{
            $question = PracticeQuestion::where('uuid', $request->id)->delete();
            $this->dbCommit();
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('formname.deleted'),'type' => __('admin_messages.question.question')]), 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            $this->dbEnd();
            return response()->json(['msg' =>$e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Delete questionlist question                  |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function deleteQuestion(Request $request)
    {
        $this->dbStart();
        try{
            $question = PracticeQuestionList::where('uuid', $request->questionId)->delete();
            $this->dbCommit();
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('formname.deleted'),'type' => __('admin_messages.question.question')]), 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            $this->dbEnd();
            return response()->json(['msg' =>$e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Update Student status                         |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request, $id = null)
    {
        $this->dbStart();
        try{
            $question = PracticeQuestion::where('uuid', $id)->first();
            $status = $question->active == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
            $question->update(['active'=>$status]);
            $this->dbCommit();
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>($status == config('constant.status_active_value'))?__('admin_messages.activated'):__('admin_messages.inactivated'),'type' => __('admin_messages.question.question')]), 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            $this->dbEnd();
            return response()->json(['msg' =>$e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | Upload Imported records                       |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function import()
    {
        return view($this->viewConstant.'import');
    }

    /**
     * -------------------------------------------------
     * | Upload export records                         |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function export(Request $request)
    {
        try{
            $limit = @$request->export_limit?? 10;
            $start = @$request->export_start ?? 0;
            $questions = PracticeQuestion::where(function($query) use($request){
                            $query->where('subject_id',$request->subject_id);
                            if($request->topic_id != NULL){
                                $query->where('topic_id',$request->topic_id);
                            }
                        })
                        ->orderBy('created_at','desc')
                        ->skip($start)->take($limit)
                        ->get();
            if(empty($questions) || $questions == NULL || count($questions) == 0){
                return redirect()->back()->with(['error'=>__('formname.not_found')]);
            }
            Excel::store(new QuestionExport($questions), 'question.'.$request->action);
            $response = Response::download(storage_path().'/app/question.'.$request->action)->deleteFileAfterSend(true);
            ob_end_clean();
            return $response;
        }catch(Exception $e){
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------
     * | Insert Imported records                       |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function insert(Request $request)
    {
        $this->dbStart();
        try  {
            // check if request has file
            if ($request->hasFile('import_file')) {
                $import = new ImportFile;
                Excel::import($import, $request->import_file);
                $questionIds = $import->questionIds;
                $questionListIds = $import->questionListIds;
            }
            if($request->hasFile('passage') && $questionIds != null){
                foreach($request->passage as $passage){
                    foreach($questionIds as $id){
                        $mimeType = $passage->getClientOriginalExtension();
                        // check if mime type is pdf
                        $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                        $path = 'question' . $id . '/';
                        $file = $this->uploadFile($passage,$path);
                        $data = QuestionMedia::where('question_id',$id)->where('name',$file[1])->update(['media_type'=>@$mediaType,'name'=>$file[0]]);
                    }
                }
            }
            if($request->hasFile('images') && $questionListIds != null){
                foreach($request->images as $image){
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
            $errorMessage = Session::get('error');
            $this->dbCommit();
            if($request->ajax()){
                if($errorMessage){
                    return response()->json(['status'=>'error','msg'=>'Something went wrong !']);
                }
                return response()->json(['status'=>'success','msg'=>__('admin_messages.question.imported_msg'),'questionIds'=>$questionIds]);
            }else{
                if($errorMessage){
                    return redirect()->back()->withError(__('formname.not_found'));
                }
                return redirect()->back()->with('message', __('admin_messages.question.imported_msg'));
            }
        }catch (Exception $e)  {
            $this->dbEnd();
            if($request->ajax()){
                return response()->json(['status'=>'error','msg'=>'Something went wrong !']);
            }else{
                return redirect()->back()->with('error', $e->getMessage());
            }
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Download Passage                              |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function downloadPdf($uuid){
        try  {
            $questionPdf = QuestionMedia::whereUuid($uuid)->first();
            $path = 'question' . $questionPdf->question_id . '/' . $questionPdf->name;
            // check if directory is exist
            if(file_exists(Storage::path($path))){
                return response()->download(Storage::path($path), $questionPdf->name);
            }else{
                return back()->with(['info' => __('formname.file_not_found')]);
            }
        }catch(Exception $e){
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------
     * | Store Topic                                   |
     * |                                               |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function storeTopic(Request $request){
        $this->dbStart();
        try  {
            if (isset($request->title)) {
                $topicName = strtolower($request->title);
                $topicData = Topic::updateOrCreate(['title' => $topicName], ['title' => $topicName]);
            }
            $this->dbCommit();
            $topicData = Topic::whereActive(1)->get()->pluck('title','id');
            return response(['status'=>'success','topicData'=>@$topicData]);
        }catch(Exception $e){
            $this->dbEnd();
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------
     * | Validate title                                |
     * |                                               |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function validateTitle(Request $request){
        $rules = array(
            'title' => 'required|unique:topics,title,NULL,id,deleted_at,NULL',
        );
        $validator = Validator::make($request->all(), $rules);
        $msg = true;
        if ($validator->fails()) {
            $msg = false;
        }
        return json_encode($msg);
    }

    /**
     * -------------------------------------------------
     * | Show detail                                   |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function detail($uuid){
        try  {
            $question = PracticeQuestion::where('uuid', $uuid)->firstOrFail();
            return view($this->viewConstant.'_detail',['question'=>@$question]);
        }catch(Exception $e){
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------
     * | edit question                                 |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function editQuestion($uuid=null,$mockId=null){
        try  {
            $question = PracticeQuestion::where('uuid', $uuid)->firstOrFail();
            $data['testAssessment'] = TestAssessment::where('uuid',$mockId)->first();
            $testAssessmentQuestion = TestAssessmentQuestion::where(['test_assessment_id'=>$data['testAssessment']->id,'question_id'=>$question->id])->first();
            $data['testAssessmentSubjectId'] = @$testAssessmentQuestion->test_assessment_subject_id;
            $topicList = $this->topicList();
            $data['question']= @$question;
            $data['testAssessmentId']=@$mockId;
            $data['topicList'] = @$topicList;
            $data['question_id']= @$question->question_id;
            $data['type'] = $this->questionType();
            return view($this->viewConstant.'_edit_question',$data);
        }catch(Exception $e){
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------
     * | Store question list question                  |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function storeQuestion(Request $request,$uuid=null){
        $this->dbStart();
        try{
            $testAssessmentSubjectInfo = TestAssessmentSubjectInfo::where('id',$request->test_assessment_subject_id)->first();
            $question = PracticeQuestion::where('uuid', $uuid)->first();
            if($question == null){
                $question = new PracticeQuestion();
            }
            if($request->has('file')){
                $mimeType = $request->file->getClientOriginalExtension();
                // check if mime type is pdf
                $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                $path = 'questionList';
                $file = $this->uploadFile($request->file,$path);
                $request['image'] = $file[0];
                $request['resize_full_image'] = null;
            }else{
                if($request->resize_full_image == null){
                    $request['image'] = null;
                }
            }
            $request['subject_id'] = $testAssessmentSubjectInfo->subject_id;
            if($request->has('question_file')){
                $mimeType = $request->file->getClientOriginalExtension();
                // check if mime type is pdf
                $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                $path = 'questionList';
                $file = $this->uploadFile($request->file,$path);
                $request['question_image'] = $file[0];
            }else{
                if($request->resize_question_image == null){
                    $request['question_image'] = null;
                }
            }
            if($request->has('answer_file')){
                $mimeType = $request->file->getClientOriginalExtension();
                // check if mime type is pdf
                $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                $path = 'questionList';
                $file = $this->uploadFile($request->file,$path);
                $request['answer_image'] = $file[0];
            }else{
                if($request->resize_answer_image == null){
                    $request['answer_image'] = null;
                }
            }
            $question->fill($request->all())->save();
            $question->answers()->delete();
            foreach($request->text as $key => $answer){
                if($request->no_of_option == 5 && $key == 5){
                }else{
                    $answers[$key]['answer'] = $answer['answer'];
                    $answers[$key]['is_correct'] = isset($answer['is_correct'])?1:0;
                }
            }
            $question->answers()->createMany($answers);
            $assessmentQuestion = TestAssessmentQuestion::updateOrCreate([
                'test_assessment_subject_id'=>$testAssessmentSubjectInfo->id,
                'question_id'=>$question->id
            ],[
                'test_assessment_subject_id' => $testAssessmentSubjectInfo->id,
                'subject_id' => $testAssessmentSubjectInfo->subject_id,
                'question_id' => $question->id,
                'test_assessment_id' => $testAssessmentSubjectInfo->test_assessment_id
            ]);
            // dd($assessmentQuestion);
            $this->dbCommit();
            return redirect()->route('test-assessment.detail',['uuid'=>@$request->test_assessment_id])->with(['message'=>'Question updated successfully.']);
        }catch(Exception $e){
            $this->dbEnd();
            return redirect()->route('test-assessment.detail',['uuid'=>@$request->test_assessment_id])->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * -------------------------------------------------
     * | upload question passage                       |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function uploadPassage(Request $request){
        $this->dbStart();
        try{
            // find question
            $question = PracticeQuestion::find($request->question_id);
            if($question){
                // upload passage
                if($request->hasFile('passage')){
                    $mimeType = $request->passage->getClientOriginalExtension();
                    // check if mime type is pdf
                    $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                    $path = 'question' . $question->id . '/';
                    $file = $this->uploadFile($request->passage,$path);
                    $questionMedia = QuestionMedia::create(['question_id'=>$question->id,'name'=>$file[0],'media_type'=>@$mediaType]);
                }
            }
            $this->dbCommit();
            return redirect()->route('mock-test.detail',['uuid'=>@$request->mock_test_id])->with(['msg'=>'Passage Uploaded successfully']);
        }catch(Exception $e){
            $this->dbEnd();
            return redirect()->route('mock-test.detail',['uuid'=>@$request->mock_test_id]);
        }
    }

    /**
     * -------------------------------------------------
     * | delete question                               |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function deleteListQuestion(Request $request,$uuid=null){
        $this->dbStart();
        try{
            // dd($request->all());
            PracticeQuestion::where('uuid', $uuid)->delete();
            $this->dbCommit();
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('formname.deleted'),'type' => __('admin_messages.question.question')]), 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            $this->dbEnd();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | delete question passage                       |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function deletePassage(Request $request,$uuid=null){
        $this->dbStart();
        try{
            QuestionMedia::where('practice_question_id', $request->id)->delete();
            $this->dbCommit();
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('formname.deleted'),'type' => 'Passage']), 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            $this->dbEnd();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | add question                                  |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function addQuestion($uuid=null,$mockId=null){
        try  {
            $topicList = $this->topicList();
            $data['testAssessment'] = TestAssessment::where('uuid',$mockId)->first();
            $data['testAssessmentSubjectId'] = @$uuid;
            $data['question'] = @$question;
            $data['testAssessmentId']= @$mockId;
            $data['topicList'] = @$topicList;
            $data['question_id'] = @$uuid;
            $data['type'] = $this->questionType();
            return view($this->viewConstant.'_edit_question',$data);
        }catch(Exception $e){
            return Redirect::back()->with(['error'=>$e->getMessage()]);
        }
    }
}
