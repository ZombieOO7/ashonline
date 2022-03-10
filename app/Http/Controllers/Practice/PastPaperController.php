<?php

namespace App\Http\Controllers\Practice;

use App\Helpers\BlockHelper;
use App\Helpers\PastPaperHelper;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\Grade;
use App\Models\PastPaper;
use App\Models\PastPaperQuestion;
use App\Models\PastPaperTopic;
use App\Models\Subject;
use App\Models\Topic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class PastPaperController extends BaseController
{
    protected $viewConstant = 'newfrontend.practice.past-paper.';
    protected $helper,$blockHelper;
    public $isParent = false,$parent=[];
    public function __construct(PastPaperHelper $helper, BlockHelper $blockHelper){
        $this->helper = $helper;
        $this->blockHelper = $blockHelper;
    }

    /**
     * -------------------------------------------------
     * | Practice Past paper listing                   |
     * |                                               |
     * | @param subject,studentId                      |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function index($subject=null,$grade=null){
        try{
            $schoolYears = schoolYears();
            $data['subject'] = Subject::where('slug',$subject)->first();
            // get Paper based on school year and month
            $data['threePastPapers'] =  $this->helper->getPaperQuery($subject,$schoolYears)
                                        ->wherePaperShowTo('1') // display to all member
                                        ->limit(3)
                                        ->get();
            $data['allPastPapers'] =  $this->helper->getPaperQuery($subject,$schoolYears)
                                        ->wherePaperShowTo('1') // display to all member
                                        ->get();
            $projectType = 2;
            $data['homePastPaperSection'] = $this->blockHelper->getBlockDetails(config('constant.block_types.aceMock.home'), config('constant.block_sub_types.practice.past_paper_section_detail'), $projectType);
            return view($this->viewConstant.'index',$data);
        }catch(Exception $e){
            abort('404');
        }
    }

    /**
     * -------------------------------------------------
     * | paper detail                                  |
     * |                                               |
     * | @param paperId                                |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function paperDetail($paperId=null){
        try{
            $pastPaper = $this->helper->detail($paperId);
            $data['pastPaper'] = $pastPaper;
            $data['subject'] = $pastPaper->subject;
            $data['grade'] = $pastPaper->grade;
            $topicIds = [];
            foreach($pastPaper->pastPaperQuestion as $question){
                $topicIds = array_unique(array_merge($question->topic_ids,$topicIds));
            }
            $data['topicList'] = Topic::whereIn('id',$topicIds)->get();
            return view($this->viewConstant.'detail',$data);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
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
        try{
            $pastPaper = $this->helper->detail($uuid);
            // check if file is exist or file path not empty
            if (!empty($pastPaper) && !empty($pastPaper->file_path)) {
                $headers = array('Content-Type: application/pdf');
                  return Response::download($pastPaper->file_path_text, 'filename.pdf', $headers);
            } else {
                return back()->with(['info' => __('formname.file_not_found')]);
            }
        }catch(Exception $e){
            return back()->with(['info' => __('formname.file_not_found')]);
        }
    }

    /**
     * -------------------------------------------------
     * | paper detail                                  |
     * |                                               |
     * | @param paperId                                |
     * | @return View                                  |
     * |------------------------------------------------
     */
    public function topicQuestions($slug=null){
        try{
            $query = $this->helper->getQuestionsByTopic($slug);
            $pastPaperQuestions = $query->orderBy('created_at','desc')
                                    ->paginate(20);
            $topicList = Topic::whereHas('pastPaperQuestions')->pluck('topic_id')->get();
            return view($this->viewConstant.'detail',['pastPaperQuestions'=>@$pastPaperQuestions,'topicList'=>@$topicList]);
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    /**
     * -------------------------------------------------
     * | Get Past Papers datatable based on            |
     * | child school year and month                   |
     * | @param Request $request                       |
     * | @return Datatable                             |
     * |------------------------------------------------
     */
    public function getData(Request $request,$subject=null){
        $schoolYears = schoolYears();
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        // get papers by school year and subject
        $query = $this->helper->getPaperQuery($subject,$schoolYears);
        $pastPaperList =$query->wherePaperShowTo('2'); // display to all member
        $count_total = $query->count();
        $query = $query->skip($start)->take($limit);
        $pastPaperList = $query->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return DataTables::of($pastPaperList)
                ->addIndexColumn()
                ->addColumn('download', function ($pastPaper){
                    return view('newfrontend.practice.past-paper._download',['paper'=>@$pastPaper])->render();
                })
                ->addColumn('answer_sheet', function ($pastPaper){
                    return view('newfrontend.practice.past-paper._answer_sheet',['paper'=>@$pastPaper])->render();
                })
                ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total, "recordsFiltered" => $count_filter])
                ->rawColumns(['id', 'download', 'answer_sheet'])
                ->skipPaging()
                ->make(true);
    }

    /**
     * -------------------------------------------------
     * | Get Past Paper Question datatable             |
     * |                                               |
     * | @param Request $request                       |
     * | @return Datatable                             |
     * |------------------------------------------------
     */
    public function getQuestionDatatable(Request $request,$uuid)
    {
        $draw = intval($request->draw) + 1 ;
        $limit = @$request->length?? 10;
        $start = @$request->start ?? 0;
        $pastPaper = PastPaper::whereUuid($uuid)->first();
        $itemQuery = PastPaperQuestion::wherePastPaperId($pastPaper->id)
                    ->orderBy('created_at', 'desc');
        $count_total = $itemQuery->count();
        $itemQuery = $itemQuery->skip($start)->take($limit);
        $questionDataTable = $itemQuery->orderBy('created_at', 'desc')->get();
        $count_filter = 0;
        if ($count_filter == 0) {
            $count_filter = $count_total;
        }
        return DataTables::of($questionDataTable)
            ->addColumn('question_answers', function ($questionAnswer) {
                return view($this->viewConstant.'_question_answers',['questionAnswer'=>@$questionAnswer])->render();
            })
            ->with([ "draw" => $draw, "Total" => $count_total, "recordsTotal" => $count_total,"recordsFiltered" => $count_filter,])
            ->rawColumns(['question_answers'])
            ->skipPaging()
            ->make(true);
    }
}
