<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuestionExport;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionMedia;
use App\Models\QuestionList;
use App\Models\Subject;
use App\Models\Answer;
use App\Models\Topic;
use Yajra\Datatables\Datatables;
use Excel;
use App\Imports\ImportFile;
use App\Models\MockTest;
use App\Models\MockTestSubjectDetail;
use App\Models\MockTestSubjectQuestion;
use Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Session;
use Illuminate\Support\Facades\Validator;

class QuestionController extends BaseController
{
    /**
     * -------------------------------------------------
     * | Display Question list                         |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $subjectList =  Subject::orderBy('id', 'desc')->pluck('title', 'id');
        $topicList =  Topic::orderBy('id', 'desc')->pluck('title', 'id');
        return view('admin.question_management.index',['topicList'=>@$topicList,'subjectList'=>@$subjectList]);
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
        $subject = Subject::orderBy('id', 'desc')->pluck('title', 'id');
        $methodType = __('formname.question.label',['type'=>isset($id)?__('formname.update'):__('formname.create')]);
        $question = Question::where('uuid', $id)->first();
        $type = $this->questionType();
        $questionSubType = $this->questionSubType();
        $topics = $this->topicList();
        return view('admin.question_management.create_edit', ['questionType'=>@$questionSubType,'type'=>@$type ,'subject' =>  @$subject, 'methodType' => @$methodType, 'question' => @$question,'topics'=>@$topics]);
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
        $subject = $request->subject_id;
        $type = $request->type;
        $question = Question::where('id', $request->question_id)
                    ->whereQuestionType($request->question_type)
                    ->where('type', $type)
                    ->whereSubjectId($subject)
                    ->first();

        if($request->question_type == 2){
            $returnHTML = view('admin.question_management.templates.standard',['question' => @$question,'subject'=>@$subject,'type'=>@$type])->render();
        }
        else if ($request->question_type == 1) {
            $returnHTML = view('admin.question_management.templates.mcq', ['question' => @$question,'type'=>@$type,'subject'=>@$subject])->render();
        } else {
            $returnHTML = "";
        }

        return response()->json(array('html' => $returnHTML));
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
        try {
            $questionAnswersArr =  $request->text;
            foreach ($questionAnswersArr as $questionAnswers) {
                array_set($request, 'question', $questionAnswers['question']);
                array_set($request, 'uuid', @$questionAnswers['uuid']);
                array_set($request, 'marks', @$questionAnswers['marks']);
                array_set($request, 'hint', @$questionAnswers['hint']);
                array_set($request, 'explanation', @$questionAnswers['explanation']);
                if($request->type == 4){
                    array_set($request, 'answer_type', 2);
                }
                array_set($request, 'instruction', @$questionAnswers['instruction']);
                array_set($request, 'resize_full_image', @$questionAnswers['resize_full_image']);
                array_set($request, 'resize_question_image', @$questionAnswers['resize_question_image']);
                array_set($request, 'resize_answer_image', @$questionAnswers['resize_answer_image']);
                $quesionList = Question::updateOrCreate(['uuid'=>@$questionAnswers['uuid']],$request->all());
                if(isset($questionAnswers['file']) && $questionAnswers['file'] != null){
                    $quesionImg = uploadOtherImage($questionAnswers['file'], 'questionList');
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
                        Answer::updateOrCreate(['question_id' => $quesionList->id, 'id' =>@$answer['answer_id']],$request->all());
                    }
                }
            }
            $this->dbCommit();
            $msg = __('admin_messages.action_msg',['action'=>($uuid==null)?__('formname.created'):__('formname.updated'),'type' => __('admin_messages.question.question')]);
            return redirect()->route('question.index')->with('message', $msg);
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
        $itemQuery = Question::select('*');

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
        return Datatables::of($questionDataTable)
            ->addColumn('action', function ($questionData) {
                return \View::make('admin.question_management.action', ['questionData' => $questionData])->render();
            })
            ->editColumn('question_title', function ($questionData) {
                return $this->getPartials('admin.question_management._content', ['questionData' => $questionData, 'title'=>__('formname.question.question_title')]);
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
        $question = Question::where('uuid', $request->id)->delete();
        return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('formname.deleted'),'type' => __('admin_messages.question.question')]), 'icon' => __('admin_messages.icon_success')]);
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
        $question = QuestionList::where('uuid', $request->questionId)->delete();
        return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('formname.deleted'),'type' => __('admin_messages.question.question')]), 'icon' => __('admin_messages.icon_success')]);
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
        $question = Question::where('uuid', $id)->first();
        $status = $question->active == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $question->update(['active'=>$status]);
        return response()->json(['msg' => __('admin_messages.action_msg',['action'=>($status == config('constant.status_active_value'))?__('admin_messages.activated'):__('admin_messages.inactivated'),'type' => __('admin_messages.question.question')]), 'icon' => __('admin_messages.icon_success')]);
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
        return view('admin.question_management.import');
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
        $limit = @$request->export_limit?? 10;
        $start = @$request->export_start ?? 0;
        $questions = Question::where(function($query) use($request){
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
                Excel::import($import, request()->file('import_file'));
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
                        Question::where('id',$id)->where('image',strtolower($file[1]))->update(['image'=>@$file[0]]);
                        Question::where('id',$id)->where('question_image',strtolower($file[1]))->update(['question_image'=>@$file[0]]);
                        Question::where('id',$id)->where('answer_image',strtolower($file[1]))->update(['answer_image'=>@$file[0]]);
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
        $questionPdf = QuestionMedia::whereUuid($uuid)->first();
        $path = 'question' . $questionPdf->question_id . '/' . $questionPdf->name;
        // check if directory is exist
        if(file_exists(Storage::path($path))){
            return response()->download(Storage::path($path), $questionPdf->name);
        }else{
            return back()->with(['info' => __('formname.file_not_found')]);
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
        if (isset($request->title)) {
            $topicName = strtolower($request->title);
            $topicData = Topic::updateOrCreate(['title' => $topicName], ['title' => $topicName]);
        }
        $topicData = Topic::whereActive(1)->get()->pluck('title','id');
        return response(['status'=>'success','topicData'=>@$topicData]);
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
        $question = Question::where('uuid', $uuid)->firstOrFail();
        return view('admin.question_management._detail',['question'=>@$question]);
    }

    /**
     * -------------------------------------------------
     * | edit question                                 |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function editQuestion($uuid=null,$mockId=null){
        $question = Question::where('uuid', $uuid)->firstOrFail();
        $data['mockTest'] = MockTest::where('uuid',$mockId)->first();
        $mockTestSubjectQuestion = MockTestSubjectQuestion::where(['mock_test_id'=>$data['mockTest']->id,'question_id'=>$question->id])->first();
        $data['mockTestSubjectDetailId'] = @$mockTestSubjectQuestion->mock_test_subject_detail_id;
        $questionData = $question;
        $topicList = $this->topicList();
        $data['type'] = $this->questionType();
        $data['question']= @$question;
        $data['mockId'] = @$mockId;
        $data['topicList']= @$topicList;
        $data['question_id']= @$question->id;
        $data['questionData']=@$questionData;
        $data['title'] = 'Edit Question';
        return view('admin.question_management._edit_question',$data);
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
            $mockTestSubjectDetail = MockTestSubjectDetail::where('id',$request->mock_test_subject_detail_id)->first();
            $question = Question::where('uuid', $uuid)->first();
            if($question == null){
                $question = new Question();
                $request['subject_id'] = $question->subject_id;
            }
            if($request->has('file')){
                $mimeType = $request->file->getClientOriginalExtension();
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
            if($request->has('question_file')){
                $mimeType = $request->question_file->getClientOriginalExtension();
                // check if mime type is pdf
                $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                $path = 'questionList';
                $file = $this->uploadFile($request->question_file,$path);
                $request['question_image'] = $file[0];
                $request['resize_question_image'] = null;
            }else{
                if($request->resize_question_image == null){
                    $request['question_image'] = null;
                }
            }
            if($request->has('answer_file')){
                $mimeType = $request->answer_file->getClientOriginalExtension();
                // check if mime type is pdf
                $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                $path = 'questionList';
                $file = $this->uploadFile($request->answer_file,$path);
                $request['answer_image'] = $file[0];
                $request['resize_answer_image'] = null;
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
                    $answers[$key]['answer'] = @$answer['answer'];
                    $answers[$key]['is_correct'] = isset($answer['is_correct'])?1:0;
                }
            }
            $question->answers()->createMany($answers);
            MockTestSubjectQuestion::updateOrCreate([
                'mock_test_subject_detail_id'=>$mockTestSubjectDetail->id,
                'question_id'=>$question->id
            ],[
                'mock_test_subject_detail_id' => $mockTestSubjectDetail->id,
                'mock_test_paper_id' => $mockTestSubjectDetail->paper_id,
                'subject_id' => $mockTestSubjectDetail->subject_id,
                'question_id' => $question->id,
                'mock_test_id' => $mockTestSubjectDetail->mock_test_id
            ]);
            $this->dbCommit();
            return redirect()->route('edit-list-question',['uuid'=>@$question->uuid,'mockId'=>@$request->mockId])->with(['message'=>'Question updated successfully.']);
        }catch(Exception $e){
            $this->dbEnd();
            return redirect()->route('mock-test.detail',['uuid'=>@$request->mockId])->with(['error' => $e->getMessage()]);
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
        // try{
            // find question
            // $question = Question::find($request->question_id);
            // if($question){
            //     // upload passage
            //     if($request->hasFile('passage')){
            //         $mimeType = $request->passage->getClientOriginalExtension();
            //         // check if mime type is pdf
            //         $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
            //         $path = 'question' . $question->id . '/';
            //         $file = $this->uploadFile($request->passage,$path);
            //         $questionMedia = QuestionMedia::create(['question_id'=>$question->id,'name'=>$file[0],'media_type'=>@$mediaType]);
            //     }
            // }
            $section = MockTestSubjectDetail::find($request->id);
            if($section){
                // upload passage
                if($request->hasFile('passage')){
                    $mimeType = $request->passage->getClientOriginalExtension();
                    // check if mime type is pdf
                    $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                    $path = 'passage' . $section->id . '/';
                    $file = $this->uploadFile($request->passage,$path);
                    $sectionImage = @$file[0];
                    $section->update(['passage' => @$sectionImage]);
                }
            }
            $this->dbCommit();
            return redirect()->route('mock-test.paper',['uuid'=>@$request->mock_test_id])->with(['msg'=>'Passage Uploaded successfully']);
        // }catch(Exception $e){
            $this->dbEnd();
            return redirect()->route('mock-test.paper',['uuid'=>@$request->mock_test_id]);
        // }
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
            Question::where('uuid', $uuid)->delete();
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
            $section = MockTestSubjectDetail::where('id', $request->id)->first();
            if($section != null){
                $section->update(['passage'=>null]);
            }else{
                return response()->json(['msg' => 'Something went wrong !', 'icon' => __('admin_messages.icon_info')]);
            }
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
        $data['topicList'] = $this->topicList();
        $data['mockTest'] = MockTest::where('uuid',$mockId)->first();
        // $data['questionData'] = Question::find($uuid);
        $data['title'] = 'Add Question';
        $data['mockId'] = @$mockId;
        $data['mockTestSubjectDetailId'] = @$uuid;
        $data['type'] = $this->questionType();
        $data['question'] = @$question;
        return view('admin.question_management._edit_question',$data);
    }

    public function uploadImage(Request $request){
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
            //Upload File
            $request->file('upload')->storeAs('public/uploads', $filenametostore);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = url('/storage/app/public/uploads/'.$filenametostore); 
            $msg = 'Image successfully uploaded'; 
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            // Render HTML output 
            @header('Content-type: text/html; charset=utf-8'); 
            echo $re;
        }
    }
}
