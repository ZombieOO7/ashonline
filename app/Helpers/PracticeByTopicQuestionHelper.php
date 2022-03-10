<?php

namespace App\Helpers;

use App\Imports\PastPaperQuestionImport;
use App\Models\PastPaper;
use App\Models\PastPaperQuestion;
use App\Models\Topic;
use Illuminate\Http\Request;
use Excel;

class PracticeByTopicQuestionHelper extends BaseHelper
{
    protected $pastPaper,$topic;
    public function __construct(PastPaper $pastPaper,PastPaperQuestion $pastPaperQuestion, Topic $topic)
    {
        $this->pastPaper = $pastPaper;
        $this->pastPaperQuestion = $pastPaperQuestion;
        $this->topic = $topic;
        parent::__construct();
    }
    /**
     * ------------------------------------------------------
     * | Get Topic List                                     |
     * |                                                    |
     * |-----------------------------------------------------
     */
    public function list()
    {
        return $this->pastPaper::orderBy('id', 'desc');
    }

    /**
     * ------------------------------------------------------
     * | Topic detail by id                                 |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function detailById($id)
    {
        return $this->pastPaper::whereId($id)->first();
    }

    /**
     * ------------------------------------------------------
     * | Topic store                                        |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        if ($request->hasFile('pdf_file')){
            $fileName = $this->storeFile($request->pdf_file);
            $request['file'] = $fileName;
        }
        $pastPaper = PastPaper::updateOrCreate(['id'=>@$request->id],$request->all());
        if($request->has('import_file')){
            $pastPaper->pastPaperQuestion()->delete();
            $import = new PastPaperQuestionImport;
            Excel::import($import, $request->import_file);
            if(empty($import->questionAnswerData) && $import->errors != null){
                return redirect()->back()->withError($import->errors);
            }
            $pastPaper->pastPaperQuestion()->createMany($import->questionAnswerData);
            $totalDuration = $pastPaper->pastPaperQuestion->sum('solved_question_time');
            $pastPaper->update(['total_duration'=>$totalDuration]);
            if($request->has('images') && $request->images != null){
                foreach($request->images as $key => $image){
                    $mimeType = $image->getClientOriginalExtension();
                    // check if mime type is pdf
                    $mediaType = ($mimeType == config('constant.media_type')[2])?2:1;
                    foreach($pastPaper->pastPaperQuestion as $key => $question){
                        $path = 'paperQuestion';
                        $file = $this->uploadFile($image,$path);
                        $question = PastPaperQuestion::where('id',$question->id)->first();
                        PastPaperQuestion::where('id',$question->id)->where('question_image',strtolower($file[1]))->update(['question_image'=>@$file[0]]);
                        PastPaperQuestion::where('id',$question->id)->where('answer_image',strtolower($file[1]))->update(['answer_image'=>@$file[0]]);
                    }
                }
            }
        }
        if($request->has('images') && $request->images != null){
            foreach($request->images as $key => $image){
                foreach($pastPaper->pastPaperQuestion as $key => $question){
                    $path = 'paperQuestion';
                    $file = $this->uploadFile($image,$path);
                    $question = PastPaperQuestion::where('id',$question->id)->first();
                    PastPaperQuestion::where('id',$question->id)->where('question_image',strtolower($file[1]))->update(['question_image'=>@$file[0]]);
                    PastPaperQuestion::where('id',$question->id)->where('answer_image',strtolower($file[1]))->update(['answer_image'=>@$file[0]]);
                }
            }
        }
        return $pastPaper;
    }

    /**
     * ------------------------------------------------------
     * | Update status                                      |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function statusUpdate($uuid)
    {
        $pastPaper = $this->detail($uuid);
        $status = $pastPaper->status == config('constant.status_active_value') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $this->pastPaper::where('id', $pastPaper->id)->update(['status' => $status]);
        return $status;
    }

    /**
     * ------------------------------------------------------
     * | Topic detail by uuid                               |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function detail($uuid)
    {
        return $this->pastPaper::where('uuid', $uuid)->first();
    }

    /**
     * ------------------------------------------------------
     * | Delete Topic                                       |
     * |                                                    |
     * | @param $uuid                                       |
     * |-----------------------------------------------------
     */
    public function delete($uuid)
    {
        $pastPaper = $this->detail($uuid);
        $pastPaper->delete();
    }

    /**
     * ---------------------------------------------------------------
     * | Delete multiple Topic                                       |
     * |                                                             |
     * | @param Request $request                                     |
     * | @return Void                                                |
     * ---------------------------------------------------------------
     */
    public function multiDelete(Request $request)
    {
        $pastPaper = $this->pastPaper::whereIn('uuid', $request->ids);
        // check if request action is delete
        if ($request->action == config('constant.delete')) {
            $pastPaper->delete();
            return;
        }
        $status = $request->action == config('constant.inactive') ? config('constant.status_inactive_value') : config('constant.status_active_value');
        $pastPaper->update(['status' => $status]);
    }

    /**
     * ------------------------------------------------------
     * | Store image                                        |
     * |                                                    |
     * | @param $request ,$user                             |
     * |-----------------------------------------------------
     */
    public function storeFile($file)
    {
        $folderName = config('constant.past-paper.folder_name');
        $imageFunction = $this->uploadFile($file, $folderName);
        return $imageFunction[0];
    }

    /**
     * ------------------------------------------------------
     * | Get paper list                                     |
     * |                                                    |
     * | @param $subhect ,$grade                            |
     * | @return list                                       |
     * |-----------------------------------------------------
     */
    public function getPaperList($subject,$grade)
    {
        $subject = $this->getSubject($subject);
        $grade = $this->getGrade($grade);
        $papers = $this->pastPaper::where(['grade_id'=>$grade->id,'subject_id'=>$subject->id])
                    ->get();
        return $papers;
    }

    public function getQuestionsByTopic($slug){
        $topic = $this->topic->where('slug',$slug)->first();
        $questions = $this->pastPaperQuestion::whereHas('topic', function($query) use($topic){
                        $query->where('topic_id',$topic->id);
                    });
        return $questions;
    }

    public function questionDetail($uuid){
        $question = $this->pastPaperQuestion::where('uuid',$uuid)->first();
        return $question;
    }

    /**
     * ------------------------------------------------------
     * | Get paper list                                     |
     * |                                                    |
     * | @param $subhect ,$grade                            |
     * | @return list                                       |
     * |-----------------------------------------------------
     */
    public function getPaperQuery($subject,$grade)
    {
        $subject = $this->getSubject($subject);
        $grade = $this->getGrade($grade);
        $papers = $this->pastPaper::where(['grade_id'=>$grade->id,'subject_id'=>$subject->id]);
        return $papers;
    }

}
