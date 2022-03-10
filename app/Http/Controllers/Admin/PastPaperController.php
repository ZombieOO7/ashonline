<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PastPaperHelper;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PastPaperFormRequest;
use App\Models\PastPaperQuestion;
use App\Models\PracticeQuestion;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class PastPaperController extends BaseController
{
    private $helper;
    public $viewConstant = 'admin.past-paper.';
    public function __construct(PastPaperHelper $helper)
    {
        $this->helper = $helper;
        $this->helper->mode = config('constant.admin');
    }

    /**
     * -------------------------------------------------
     * | Display Topic list                            |
     * |                                               |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index()
    {
        $statusList = $this->statusList();
        return view($this->viewConstant . 'index', ['statusList' => @$statusList]);
    }

    /**
     * -------------------------------------------------
     * | Get Topic datatable data                      |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function getdata(Request $request)
    {
        try {
            $pastPaper = $this->helper->list();
            $pastPaperList = $pastPaper->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->activeSearch($request->status);
                }
            })->get();
            return DataTables::of($pastPaperList)
                ->addColumn('action', function ($pastPaper) {
                    return $this->getPartials($this->viewConstant .'_add_action',['pastPaper'=>@$pastPaper]);
                })
                ->editColumn('status', function ($pastPaper) {
                    return $this->getPartials($this->viewConstant .'_add_status',['pastPaper'=>@$pastPaper]);
                })
                ->editColumn('created_at', function ($pastPaper) {
                    return @$pastPaper->proper_created_at;
                })
                ->editColumn('subject_id', function ($pastPaper) {
                    return @$pastPaper->subject->title;
                })
                ->editColumn('month', function ($pastPaper) {
                    return noOfMonth(@$pastPaper->month);
                })
                ->addColumn('checkbox', function ($pastPaper) {
                    return $this->getPartials($this->viewConstant .'_add_checkbox',['pastPaper'=>@$pastPaper]);
                })
                ->rawColumns(['created_at', 'checkbox', 'action', 'status', 'subject_id','month','school_year'])
                ->make(true);
        } catch (Exception $e) {
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | Create Topic page                             |
     * |                                               |
     * | @param $id                                    |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function create($uuid = null)
    {
        try{
            if (isset($uuid)) {
                $pastPaper = $this->helper->detail($uuid);
            }
            $subjectList = $this->pastPaperSubjectList();
            $statusList = $this->properStatusList();
            $monthList = $this->monthList();
            $yearList = $this->yearList();
            $title = isset($uuid) ? __('formname.past-paper.update') : __('formname.past-paper.create');
            return view($this->viewConstant . 'create', ['monthList'=>@$monthList,'statusList'=>@$statusList,'subjectList'=>@$subjectList,'pastPaper' => @$pastPaper, 'title' => @$title,'yearList'=>@$yearList]);
        }catch(Exception $e){
            return Redirect::back()->with('error',$e->getMessage());
        }
    }

    /**
     * -------------------------------------------------
     * | Store Topic details                           |
     * |                                               |
     * | @param SubjectFormRequest $request            |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function store(PastPaperFormRequest $request, $uuid = null)
    {
        $this->helper->dbStart();
        try {
            $this->helper->store($request, $uuid);
            $msg = isset($request->id)?__('formname.past-paper.updated'):__('formname.past-paper.created');
            $this->helper->dbEnd();
            return Redirect::route('past-paper.index')->with('message', $msg);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return Redirect::back()->with('error',$e->getMessage());
        }
    }
    /**
     * -------------------------------------------------
     * | Delete Topic details                          |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function destroy(Request $request)
    {
        // check if request has id or not
        if (isset($request->id)) {
            $this->helper->delete($request->id);
            return response()->json(['msg' => __('formname.past-paper.deleted'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }
    /**
     * -------------------------------------------------
     * | Delete multiple Stage                         |
     * |                                               |
     * | @param Request $request                       |
     * | @return Response                              |
     * |------------------------------------------------
     */
    public function multidelete(Request $request)
    {
        $this->helper->multiDelete($request);
        if ($request->action == config('constant.inactive') || $request->action == config('constant.active')) {
            return response()->json(['msg' => __('formname.past-paper.status'), 'icon' => __('admin_messages.icon_success')]);
        }
        return response()->json(['msg' => __('formname.past-paper.deleted'), 'icon' => __('admin_messages.icon_success')]);
    }
    /**
     * -------------------------------------------------
     * | Update Stage status details                   |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function updateStatus(Request $request)
    {
        // check if request has id or not
        if (isset($request->id)) {
            $status = $this->helper->statusUpdate($request->id);
            return response()->json(['msg' => __('formname.past-paper.status'), 'icon' => __('admin_messages.icon_success')]);
        } else {
            return response()->json(['msg' => __('formname.not_found'), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------
     * | download uploaded pdf file                    |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function downloadMedia($uuid)
    {
        $pastPaper = $this->helper->detail($uuid);
        // check if file is exist or file path not empty
        if (!empty($pastPaper) && $pastPaper->file_path != null) {
            $headers = array('Content-Type: application/pdf');
              return Response::download($pastPaper->file_path_text, 'filename.pdf', $headers);
        } else {
            return back()->with(['info' => __('formname.file_not_found')]);
        }
    }

    /**
     * -------------------------------------------------
     * | add past paper question                       |
     * |                                               |
     * | @param Request $request                       |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function addQuestion(Request $request)
    {
        if($request->has('uuid') && $request->uuid !=''){
            $pastPaper = $this->helper->detail($request->uuid);
        }
        $topicList = $this->pastPaperTopicList();
        $type = $request->type;
        $html = view($this->viewConstant .'question',['index'=>@$request->index,'topicList'=>@$topicList,'pastPaper'=>@$pastPaper,'type'=>@$type])->render();
        return response()->json(['status'=>'success','html'=>@$html]);
    }
    /** 
     * -----------------------------------------------------
     * | Details Show past paper                           |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */

    public function show($uuid=null){
        try{
            $data['pastPaper'] = $this->helper->detail($uuid);
            return view($this->viewConstant .'_detail',$data);
        }catch(Exception $e){
            return Redirect::back()->with('error',$e->getMessage());
        }
    }
     /** 
     * -----------------------------------------------------
     * | Edit Question Past Paper                          |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function editQuestion($uuid=null){
        try{
            $data['question'] = $this->helper->questionDetail($uuid);
            $data['pastPaperId'] = @$data['question']->past_paper_id;
            $data['pastPaper'] = @$data['question']->pastPaper;
            $data['title'] = 'Edit Question';
            $data['topicList'] = $this->pastPaperTopicList();
            $data['subjectList'] = $this->pastPaperSubjectList();
            return view($this->viewConstant .'_question',$data);
        }catch(Exception $e){
            return Redirect::back()->with('error',$e->getMessage());
        }
    }
      /** 
     * -----------------------------------------------------
     * | Add Question Paper                          |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function addPaperQuestion($uuid=null){
        try{
            $data['title'] = 'Add Question';
            $pastPaper = $this->helper->detail($uuid);
            $data['pastPaper'] = $pastPaper;
            $data['pastPaperId'] = $pastPaper->id;
            $data['topicList'] = $this->pastPaperTopicList();
            $data['subjectList'] = $this->pastPaperSubjectList();
            return view($this->viewConstant .'_question',$data);
        }catch(Exception $e){
            return Redirect::back()->with('error',$e->getMessage());
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
            $question->fill($request->all())->save();
            if($request->topic_ids != null){
                $question->topics()->delete();
                $data = [];
                foreach($request->topic_ids as $key => $topicId){
                    $data[$key]['topic_id'] = $topicId;
                }
                $question->topics()->createMany($data);
            }
            $this->dbCommit();
            return redirect()->route('past-paper.show',['uuid' =>$question->pastPaper->uuid])->with('message', 'Question Saved Successfully.');;
        }catch(Exception $e){
            $this->dbEnd();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
   /** 
     * -----------------------------------------------------
     * | delete Question Paper                             |
     * |                                                   |
     * | @return View                                      |
     * -----------------------------------------------------
     */
    public function deleteQuestion(Request $request){
        $this->dbStart();
        try{
            $question = PastPaperQuestion::where('uuid', $request->id)->first();
            if($question != null){
                $question->delete();
            }else{
                return response()->json(['msg' =>'Question not found !', 'icon' => __('admin_messages.icon_info')]);
            }
            $this->dbCommit();
            return response()->json(['msg' => __('admin_messages.action_msg',['action'=>__('formname.deleted'),'type' => __('admin_messages.question.question')]), 'icon' => __('admin_messages.icon_success')]);
        }catch(Exception $e){
            $this->dbEnd();
            return response()->json(['msg' =>$e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

}
