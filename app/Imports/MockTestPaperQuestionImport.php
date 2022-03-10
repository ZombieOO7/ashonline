<?php

namespace App\Imports;

use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionList;
use App\Models\QuestionMedia;
use App\Models\Subject;
use App\Models\Topic;
use App\Rules\CheckNoOfQuestions;
use App\Rules\TotalQuestion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;

class MockTestPaperQuestionImport implements ToCollection
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
                if($r== null){
                    $count++;
                }
            }
            if($count > 13){
                unset($rows[$key]);
            }
        }
        $a = 1;//for number of Sub Questions
        $b = 1;//for paper total questions
        $validator = Validator::make($rows->toArray(), 
                    [
                        '*.0' => 'required',
                        '*.1'=> new TotalQuestion($rows,$b),
                        '*.3'=> new CheckNoOfQuestions($rows,$a),
                        '*.4' => 'required',
                        '*.5' => 'required',
                        '*.11' => 'required',
                        '*.13' => 'required',
                        '*.14' => 'required',
                        '*.16' => 'required',
                        '*.16' => 'integer',
                        '*.16' => 'between:1,100',
                    ],[
                        '*.0.required'=>'The subject field is required.',
                        '*.3.required'=>'The number of sub question field is required.',
                        '*.4.required'=>'The question field is required.',
                        '*.5.required'=>'The answer field is required.',
                        '*.11.required'=>'The first correct answer field is required.',
                        '*.13.required'=>'The Exam style is required.',
                        '*.14.required'=>'The Question type field is required.',
                        '*.16.required'=>'The points field is required.',
                        '*.16.between'=>'The points between 0 to 100 required.',
                        '*.16.integer'=>'The points should be digits only.',
                    ]);
        $k = [];
        if(count($rows) == 0){
            return;
        }
        if($validator->fails()){
            $this->errors = $validator->errors();
            return [null,null,null,null,$this->errors];
        }
        $k=1;
        for($i = 1; $i < count($rows); $i++ ){
            for($j=1;$j<=$rows[$i][3];$j++){
                // for($l=1;$l<=$rows[$i][3];$l++){
                    $type = strtolower($rows[$j][14]);
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

                    $multipleQuestionData[$rows[$i][0]][$i]['subject'] = @$rows[$i][2];
                    $multipleQuestionData[$rows[$i][0]][$i]['topic'] = @$rows[$j][20];
                    $multipleQuestionData[$rows[$i][0]][$i]['question_type'] = @$rows[$j][13];
                    $multipleQuestionData[$rows[$i][0]][$i]['type'] = @$rows[$j][14];
                    $multipleQuestionData[$rows[$i][0]][$i]['total_ans'] = @$rows[$i][15];
                    $multipleQuestionData[$rows[$i][0]][$i]['project_type'] = 2;
                    $multipleQuestionData[$rows[$i][0]][$i]['is_entry_type'] = 1;
                    $multipleQuestionData[$rows[$i][0]][$i]['active'] = 1;
                    $multipleQuestionData[$rows[$i][0]][$i]['questionList'][] = @$rows[$k];
                    $k++;
                // }
                // $i = $k-1;
                // echo"<pre>";print_r($i);
            }
        }
        // exit;   
        // dd($multipleQuestionData);
        $a = 0;
        foreach($multipleQuestionData as $paperKey=> $rows){
            $papers[$a]['name'] = $paperKey;
            $b = 0;
            foreach($rows as $row){
                $subject = Subject::where('title', 'ILIKE' , $row['subject'])->first();
                $topic = null;
                if(isset($row['topic']) && $row['topic'] != null){
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

                if (isset($subjectData)) {
                    // store main questions
                    $questionData = Question::create([
                        'uuid' => \Str::uuid(),
                        'subject_id' => @$subjectData->id,
                        'topic_id' => @$topicData->id,
                        'type' => $qType,
                        'question_type' => (strtolower(@$row['question_type']) == 'mcq')?'1':'2',
                        'total_ans' => @$row['total_ans'],
                        'is_passage' => (@$row['questionList'][0][20]!=null)?0:1,
                        'project_type' => 2,
                        'is_entry_type' => 1,
                        'active' => 1,
                    ]);

                    // set paper data
                    $papers[$a]['question_id'][$b] = $questionData->id;
                    $papers[$a]['subject_id'][$b] = $subjectData->id;
                    $k=0;

                    // store sub questions 
                    foreach($row['questionList'] as $r){
                        $questionList = QuestionList::create([
                            'uuid' => \Str::uuid(),
                            'question_id' => $questionData->id,
                            'question' => @$r[4],
                            'marks' => @$r[16],
                            'image' => (isset($r[18]) && @$r[18] != null)?strtolower($r[18]):null,
                            'hint' => @$r[17],
                            'explanation' => @$r[22],
                        ]);
                        if(isset($r[18]) && $r[18] != null){
                            $questionListIds[]= $questionList->id;
                        }
                        $j = 5;
                        $limit = 1;

                        // check question type is mcq or standard 
                        if(strtolower($row['question_type']) == 'mcq'){
                            $limit =6;
                        }
                        // find correct answer and store answers
                        for($i=1; $i <=$limit; $i++ ){
                            $correct = 0;
                            if(strtolower($row['question_type']) == 'mcq'){
                                if($r[11] != null){
                                    if(strtolower($r[11]) == 'a' && $j == 5){
                                        $correct = 1;
                                    }elseif(strtolower($r[11]) == 'b' && $j == 6){
                                        $correct = 1;
                                    }elseif(strtolower($r[11]) == 'c' && $j == 7){
                                        $correct = 1;
                                    }elseif(strtolower($r[11]) == 'd' && $j == 8){
                                        $correct = 1;
                                    }elseif(strtolower($r[11]) == 'e' && $j == 9){
                                        $correct = 1;
                                    }
                                }
                                if($r[12] != null){
                                    if(strtolower($r[12]) == 'a' && $j == 5){
                                        $correct = 1;
                                    }elseif(strtolower($r[12]) == 'b' && $j == 6){
                                        $correct = 1;
                                    }elseif(strtolower($r[12]) == 'c' && $j == 7){
                                        $correct = 1;
                                    }elseif(strtolower($r[12]) == 'd' && $j == 8){
                                        $correct = 1;
                                    }elseif(strtolower($r[12]) == 'e' && $j == 9){
                                        $correct = 1;
                                    }elseif(strtolower($r[12]) == 'f' && $j == 10){
                                        $correct = 1;
                                    }
                                }
                            }else{
                                $correct = 1;
                            }
                            // store question list answers
                            if($r[$j] != null){
                                $answerData = Answer::create([
                                    'question_list_id' => $questionList->id,
                                    'answer' => $r[$j],
                                    'is_correct' => $correct,
                                ]);
                            }
                            $j++;
                        }
                        // store passage 
                        if(isset($r[19]) && @$r[19] != null){
                            QuestionMedia::create([
                                'uuid' => \Str::uuid(),
                                'question_id' => $questionData->id,
                                'name' => strtolower($r[19]),
                                'media_type' => 1,
                                'project_type' => 1,
                            ]);
                        }
                        $k++;
                    }
                    $questionIds[] = $questionData->id;
                    $subjectQuestionIds[$subjectData->id]['question_ids'][] = $questionData->id;
                }
                $b++;
            }
            $a++;
        }
        $this->questionListIds = @$questionListIds;
        $this->questionIds = @$questionIds;
        $this->subjectQuestionIds = @$subjectQuestionIds;
        $this->papers = @$papers;
        return [$this->questionListIds,$this->questionIds,$this->subjectQuestionIds,$this->papers,null];
    }
}
