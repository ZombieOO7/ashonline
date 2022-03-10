<?php

namespace App\Imports;

use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionList;
use App\Models\QuestionMedia;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;

class SectionQuestionImport implements ToCollection
{
    public $questionIds,$questionListIds,$subjectQuestionIds,$papers,$errors;

    public function collection(Collection $rows)
    {
        foreach($rows as $key => $row){
            if($row->filter()->isEmpty()){
                unset($rows[$key]);
            }
            $count = 1;
            foreach($row as $rkey => $r){
                if($r== null && $rkey > 21){
                }else{
                    if($key != '0' && ($rkey == 3 || $rkey == 4 || $rkey == 11)){
                        if($rkey == 3 && $r == null && @$row[17] != null){
                            $r = ' ';
                        }
                        if($rkey == 4 && $r == null && @$row[18] != null){
                            $r = ' ';
                        }
                        if($rkey == 11 && $r == null && @$row[18] != null){
                            $r = 'A';
                        }
                    }
                    $collection[$key][$rkey] = $r;
                }
            }
        }
        foreach($collection as $key=> $collect){
            $count = 1;
            foreach($collect as $c){
                if($c == null){
                    $count++;
                }
            }
            if($count > 15){
                unset($collection[$key]);
            }
        }
        $rows = $collection;
        $a = 1;//for number of Sub Questions
        $b = 1;//for paper total questions
        $validator = Validator::make($rows, 
                    [
                        '*.0' => 'required',
                        '*.1' => 'required',
                        '*.3'=> 'required',
                        // '*.4'=> 'required',
                        '*.10' => 'required',
                        // '*.11' => 'required',
                        '*.12' => 'required',
                        '*.13' => 'required',
                        '*.14' => 'required',
                        '*.15' => 'required',
                    ],[
                        '*.0.required'=>'The subject field is required.',
                        '*.1.required'=>'The question no field is required.',
                        '*.3.required'=>'The question field is required.',
                        '*.4.required'=>'The answer field is required.',
                        '*.10.required'=>'The answer type field is required.',
                        '*.11.required'=>'The first correct answer field is required.',
                        '*.12.required'=>'The Exam style is required.',
                        '*.13.required'=>'The Question type field is required.',
                        '*.14.required'=>'The total answer field is required.',
                        '*.15.between'=>'The points between 0 to 100 required.',
                        '*.15.integer'=>'The points should be digits only.',
                    ]);
        $k = [];
        if(count($rows) == 0){
            return;
        }
        if($validator->fails()){
            $this->errors = $validator->errors();
            return [null,null,$this->errors];
        }
        $k=1;
        for($i = 1; $i < count($rows); $i++ ){
            $type = strtolower($rows[$i][12]);
            if($type == 'mcq')
                $qType = 1;
            elseif($type == 'cloze')
                $qType = 3;
            elseif($type == 'comprehension')
                $qType = 2;
            elseif($type == 'compound')
                $qType = 4;
            // elseif($type == '2-column')
            //     $qType = 5;
            $multipleQuestionData[0]['subject'] = @$rows[$i][0];
            // $multipleQuestionData[0]['topic'] = @$rows[$i][20];
            $multipleQuestionData[0]['question_type'] = @$rows[$i][12];
            $multipleQuestionData[0]['type'] = @$rows[$i][13];
            $multipleQuestionData[0]['total_ans'] = @$rows[$i][14];
            $multipleQuestionData[0]['project_type'] = 2;
            $multipleQuestionData[0]['is_entry_type'] = 1;
            $multipleQuestionData[0]['active'] = 1;
            $multipleQuestionData[0]['questionList'][] = @$rows[$k];
            $k++;
        }
        // exit;
        $a = 0;
        foreach($multipleQuestionData as $paperKey=> $row){
            $papers[$a]['name'] = $paperKey;
            foreach($row['questionList'] as $qKey => $r){
                $subject = Subject::where('title', 'ILIKE' , $row['subject'])->first();
                $topic = null;
                if(isset($row['topic']) && @$row['topic'] != null){
                    $topic = Topic::where('title', 'ILIKE' ,strtolower($row['topic']))->first();
                }
                $subjectName =  isset($subject) ? strtolower($subject->title) : strtolower($row[0]);
                if($subject){
                    $subjectData = $subject;
                }else{
                    $subjectData = Subject::create([
                        'uuid' => \Str::uuid(),
                        'title' =>  ucfirst($subjectName),
                    ]);
                }
                $topicName = isset($topic) ? strtolower(@$topic->title) : strtolower(@$row['topic']);
                if($topic){
                    $topicData = $topic;
                }else{
                    if($topicName != null || $topicName != ''){
                        $topicData = Topic::create([
                            'uuid' => \Str::uuid(),
                            'title' => $topicName,
                        ]);
                    }
                }
                $type = strtolower($row['type']);
                if($type == 'mcq')
                    $qType = 1;
                elseif($type == 'cloze')
                    $qType = 3;
                elseif($type == 'comprehension')
                    $qType = 2;
                elseif($type == 'compound')
                    $qType = 4;
                // elseif($type == '2-column')
                //     $qType = 5;

                $topic = null;
                if(isset($r[20]) && $r[20] != null){
                    $topic = Topic::where('title', 'ILIKE' ,strtolower(@$r[20]))->first();
                }
                $topicName = isset($topic) && $topic != null ? strtolower(@$topic->title) : strtolower(@$r[20]);
                if($topic != null){
                    $topicData = $topic;
                }else{
                    if($topicName != null || $topicName != ''){
                        $topicData = Topic::create([
                            'uuid' => \Str::uuid(),
                            'title' => $topicName,
                        ]);
                    }
                }
                $questionData = Question::create([
                    'uuid' => \Str::uuid(),
                    'subject_id' => @$subjectData->id,
                    'type' => $qType,
                    'question_type' => (strtolower(@$row['question_type']) == 'mcq')?'1':'2',
                    'total_ans' => @$row['total_ans'],
                    'is_passage' => (@$row['questionList'][0][19]!=null)?0:1,
                    'project_type' => 2,
                    'is_entry_type' => 1,
                    'active' => 1,
                    'question' => @$r[3],
                    'marks' => @$r[15],
                    'image' => (isset($r[16]) && @$r[16] != null)?strtolower($r[16]):null,
                    'question_no' => @$r[1],
                    'question_image' => (isset($r[17]) && @$r[17] != null)?strtolower($r[17]):null,
                    'answer_image' => (isset($r[18]) && @$r[18] != null)?strtolower($r[18]):null,
                    'topic_id' => @$topicData->id,
                    'explanation' => @$r[21],
                    'instruction' => @$r[2],
                    'answer_type' => (isset($r[10]) && $r[10] != null && strtolower($r[10])=='single')?'1':'2',
                ]);
                // set paper data
                $papers[$a]['question_id'][] = $questionData->id;
                $papers[$a]['subject_id'][] = $subjectData->id;
                $j = 4;
                $limit = 1;

                // check question type is mcq or standard 
                if(strtolower($row['question_type']) == 'mcq'){
                    $limit =6;
                }
                // find correct answer and store answers
                for($i=1; $i <=$limit; $i++ ){
                    $correct = 0;
                    if(@$r[11] != null){
                        $answers = explode(',',@$r[11]);
                        foreach($answers as $ansKey => $answer){
                            if(strtolower($answer) == 'a' && $j == 4){
                                $correct = 1;
                            }elseif(strtolower($answer) == 'b' && $j == 5){
                                $correct = 1;
                            }elseif(strtolower($answer) == 'c' && $j == 6){
                                $correct = 1;
                            }elseif(strtolower($answer) == 'd' && $j == 7){
                                $correct = 1;
                            }elseif(strtolower($answer) == 'e' && $j == 8){
                                $correct = 1;
                            }elseif(strtolower($answer) == 'f' && $j == 9){
                                $correct = 1;
                            }
                        }
                    }
                    // store question list answers
                    if((string)$r[$j] != null && (string)$r[$j] != ''){
                        $answerData[] = Answer::create([
                            'question_id' => $questionData->id,
                            'answer' => (string)$r[$j],
                            'is_correct' => $correct,
                        ]);
                    }
                    // store passage 
                    // if(isset($r[19]) && @$r[19] != null){
                    //     QuestionMedia::create([
                    //         'uuid' => \Str::uuid(),
                    //         'question_id' => $questionData->id,
                    //         'name' => strtolower($r[19]),
                    //         'media_type' => 1,
                    //         'project_type' => 1,
                    //     ]);
                    // }
                    $j++;
                }
                $questionId[] = $questionData->id;
                $questions[] = $questionData;
            }
        }
        $this->questionId = @$questionId;
        return [$this->questionListIds,$this->questionId,null];
    }
}
