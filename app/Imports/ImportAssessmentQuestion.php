<?php

namespace App\Imports;

use App\Models\PracticeAnswer;
use App\Models\PracticeQuestion;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportAssessmentQuestion implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $collection = null;
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
        if(count($rows) == 0 || !isset($collection)){
            return;
        }
        $rows = $collection;
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
        $validator = Validator::make($rows, [
            '*.0' => 'required',
            '*.1' => 'required',
            '*.3'=> 'required',
            '*.4'=> 'required',
            '*.5'=> 'required',
            '*.6'=> 'required',
            '*.7'=> 'required',
            '*.8'=> 'required',
            '*.10' => 'required',
            '*.11' => 'required',
            '*.12' => 'required',
            '*.13' => 'required',
            '*.14' => 'required',
            '*.15' => 'required',
        ],[
            '*.0.required'=>'The subject field is required.',
            '*.1.required'=>'The question no field is required.',
            '*.3.required'=>'The question field is required.',
            '*.4.required'=>'The Option A field is required.',
            '*.5.required'=>'The Option B field is required.',
            '*.6.required'=>'The Option C field is required.',
            '*.7.required'=>'The Option D field is required.',
            '*.8.required'=>'The Option E field is required.',
            '*.10.required'=>'The answer type field is required.',
            '*.11.required'=>'The first correct answer field is required.',
            '*.12.required'=>'The Exam style is required.',
            '*.13.required'=>'The Question type field is required.',
            '*.14.required'=>'The Total answer field is required.',
            '*.14.min'=>'The Total answer field should have minimum 5 value.',
            '*.14.max'=>'The Total answer field should not have more than 6 value.',
            '*.15.between'=>'The points between 0 to 100 required.',
            '*.15.integer'=>'The points should be digits only.',
        ]);
        $k = [];
        if(count($rows) == 0){
            return;
        }
        if($validator->fails() == true){
            $this->errors = $validator->errors();
            return [null,null,$this->errors];
        }else{
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
                $b = 0;
                $k=0;
                // store sub questions 
                foreach($row['questionList'] as $r){
                    $subject = Subject::where('title', 'ILIKE' , $row['subject'])->first();
                    $topic = null;
                    if(isset($r[20]) && $r[20] != null){
                        $topic = Topic::where('title', 'ILIKE' ,strtolower($r[20]))->first();
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
                    // store main questions
                    $questionData = PracticeQuestion::create([
                        'uuid' => \Str::uuid(),
                        'subject_id' => @$subjectData->id,
                        'type' => $qType,
                        'question_type' => (strtolower(@$row['question_type']) == 'mcq')?'1':'2',
                        // 'total_ans' => @$row['total_ans'],
                        'is_passage' => (@$row['questionList'][0][19]!=null)?0:1,
                        'project_type' => 2,
                        'is_entry_type' => 1,
                        'status' => 1,
                        'question' => @$r[3],
                        'marks' => @$r[15],
                        'image' => (isset($r[16]) && @$r[16] != null)?strtolower($r[16]):null,
                        // 'hint' => @$r[15],
                        'question_no' => @$r[1],
                        'question_image' => (isset($r[17]) && @$r[17] != null)?strtolower($r[17]):null,
                        'answer_image' => (isset($r[18]) && @$r[18] != null)?strtolower($r[18]):null,
                        'topic_id' => @$topicData->id,
                        'explanation' => @$r[21],
                        'instruction' => @$r[2],
                        'answer_type' => (isset($r[10]) && $r[10] != null && strtolower($r[10])=='single')?'1':'2',
                    ]);
                    // set paper data
                    $papers[$a]['question_id'][$b] = $questionData->id;
                    $papers[$a]['subject_id'][$b] = $subjectData->id;
                    $j = 4;
                    $limit = 1;
    
                    // check question type is mcq or standard 
                    if(strtolower($row['question_type']) == 'mcq'){
                        $limit =6;
                    }
                    // find correct answer and store answers
                    for($i=1; $i <=$limit; $i++ ){
                        $correct = 0;
                        if($r[11] != null){
                            $answers = explode(',',$r[11]);
                            foreach($answers as $ansKey => $answer){
                                $answer = preg_replace('/\s+/', '', $answer);
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
                        if($r[$j] != null){
                            $answerData = PracticeAnswer::create([
                                'question_id' => $questionData->id,
                                'answer' => $r[$j],
                                'is_correct' => $correct,
                            ]);
                        }
                        $j++;
                    }
                    $k++;
                    $questionIds[] = $questionData->id;
                }
            }
            $this->questionIds = @$questionIds;
            return [$this->questionIds,null];
        }
    }
}
