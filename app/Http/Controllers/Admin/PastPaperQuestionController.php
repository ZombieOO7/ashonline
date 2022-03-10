<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PastPaperQuestionHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PastPaperQuestion;
use App\Models\Subject;
use App\Models\Topic;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class PastPaperQuestionController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.past-paper-question.';
    public function __construct(PastPaperQuestionHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
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
        $subjectList =  Subject::orderBy('id', 'desc')->pluck('title', 'id');
        $topicList =  Topic::orderBy('id', 'desc')->pluck('title', 'id');
        return view($this->viewConstant.'index',['topicList'=>@$topicList,'subjectList'=>@$subjectList]);
    }

    /**
     * -------------------------------------------------
     * | Create Question                               |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create()
    {
        try{
            $data['title'] = 'Add Question';
            $data['topicList'] = $this->pastPaperTopicList();
            $data['subjectList'] = $this->pastPaperSubjectList();
            return view($this->viewConstant .'create',$data);
        }catch(Exception $e){
            return Redirect::back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------
     * | Edit Question                                 |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function edit($uuid=null){
        try{
            $data['question'] = $this->helper->questionDetail($uuid);
            $data['title'] = 'Edit Question';
            $data['topicList'] = $this->pastPaperTopicList();
            $data['subjectList'] = $this->pastPaperSubjectList();
            return view($this->viewConstant .'create',$data);
        }catch(Exception $e){
            return Redirect::back()->with('error',$e->getMessage());
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
    public function getData(Request $request)
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
        $itemQuery = PastPaperQuestion::orderBy('created_at', 'desc')
            ->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->properActive($request->status);
                }
                if ($request->topic_id != null) {
                    $query->whereHas('topics',function($query2) use($request){
                        $query2->whereTopicId($request->topic_id);
                    });
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
            ->editColumn('question_image', function ($questionData) {
                return $this->getPartials($this->viewConstant.'_image', ['question' => $questionData,'type'=>'question_image']);
            })
            ->editColumn('answer_image', function ($questionData) {
                return $this->getPartials($this->viewConstant.'_image', ['question' => $questionData,'type'=>'answer_image']);
            })
            ->addColumn('subject', function ($questionData) {
                return @$questionData->subject->title;
            })
            ->addColumn('topic', function ($questionData) {
                return @$questionData->topic_names;
            })
            ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
            ->rawColumns(['subject','topic','action','question_image','answer_image'])
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
        try{
            $question = PastPaperQuestion::where('uuid', $request->id)->delete();
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('formname.deleted'),'type' => __('admin_messages.question.question')]), 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            return response()->json(['msg' =>$e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }
    /** 
     * -----------------------------------------------------
     * | Store Question Paper                              |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function storeQuestion(Request $request){
        $this->dbStart();
        try{
            if($request->uuid != null){
                $question = PastPaperQuestion::where('uuid', $request->uuid)->first();
            }else{
                $question = new PastPaperQuestion();
            }
            if($request->has('question_file')){
                $mimeType = $request->question_file->getClientOriginalExtension();
                // check if mime type is pdf
                $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                $path = 'paperQuestion';
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
                $path = 'paperQuestion';
                $file = $this->uploadFile($request->answer_file,$path);
                $request['answer_image'] = $file[0];
                $request['resize_answer_image'] = null;
            }else{
                if($request->resize_answer_image == null){
                    $request['answer_image'] = null;
                }
            }
            $question->fill($request->except('topic_id'))->save();
            if($request->topic_id != null){
                $question->topics()->delete();
                $data = [];
                foreach($request->topic_id as $key => $topicId){
                    $data[$key]['topic_id'] = $topicId;
                }
                $question->topics()->createMany($data);
            }
            $this->dbCommit();
            return redirect()->route('past-paper-question.index')->with('message', 'Question Saved Successfully.');;
        }catch(Exception $e){
            $this->dbEnd();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
