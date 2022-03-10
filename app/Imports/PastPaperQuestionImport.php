<?php

namespace App\Imports;

use App\Models\PastPaperQuestion;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;

class PastPaperQuestionImport implements ToCollection
{
    public $questionAnswerData=[],$errors,$paperId;

    public function __construct($paperId=null)
    {
        $this->paperId = $paperId;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $key => $row){
            if($row->filter()->isEmpty()){
                unset($rows[$key]);
            }
            foreach($row as $rkey => $r){
                if($r == null && isset($rows[$key][$rkey])){
                    unset($rows[$key][$rkey]);
                }
            }
        }
        $validator= Validator::make($rows->toArray(),[ 
                        '*.0' => 'required',
                        '*.1' => 'required',
                        '*.2' => 'required',
                        '*.3' => 'required',
                        '*.4' => 'required',
                        '*.5' => 'required',
                    ]);
        if($validator->fails() == true){
            $this->errors = $validator->errors();
            return [$this->questionAnswerData,$this->errors];
        }else{
            foreach($rows as $key => $data){
                if($key != '0'){
                    $topicNames = explode(',',$data[4]);
                    $topicId = [];
                    foreach($topicNames as $topicName){
                        $topicName = strtolower($topicName);
                        $topic = Topic::where('title', 'ILIKE' ,'%' .$topicName.'%' )->first();
                        if($topic == null && $data[4] != '' && $data[4] != null){
                            $topic = Topic::create(['title'=>$topicName])->first();
                        }
                        $topicId[] = $topic->id;
                    }
                    $subject = Subject::where('title', 'ILIKE' ,strtolower($data[0]))->first();
                    if($subject == null){
                        $subject = Subject::create(['title',$data[0]])->first();
                    }
                    $questionAnswerData['question_image'] = strtolower(@$data[2]);
                    $questionAnswerData['answer_image'] = strtolower(@$data[3]);
                    $questionAnswerData['solved_question_time'] = @$data[5];
                    $questionAnswerData['question_no'] = @$data[1];
                    // $questionAnswerData['topic_ids'] = @$topicIds;
                    $questionAnswerData['subject_id'] = @$subject->id;
                    $questionAnswerData['past_paper_id'] = @$this->paperId;
                    $question = new PastPaperQuestion();
                    $question->fill($questionAnswerData)->save();
                    if($topicId != null){
                        $question->topics()->delete();
                        $data = [];
                        foreach($topicId as $key => $topicId){
                            $data[$key]['topic_id'] = $topicId;
                        }
                        $question->topics()->createMany($data);
                    }
                    array_push($this->questionAnswerData, $question);
                }
            }
            return [$this->questionAnswerData,$this->errors];
        }
    }
}
