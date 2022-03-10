<form class="qstn_form">
    <div class="row">
        <div class="col-md-12">
            <div class="row flex-column-reverse flex-md-row">
                <div class="col-md-7">
                    <div class="in_qstn_box ajx-dv">
                        @if(isset($question->questionData->questionPdfs->question_pdf))
                            <embed src="{{$question->questionData->questionPdfs->question_pdf}}" type="application/pdf" width="100%" height="400px" />
                        @endif
                        <b><p>{{ @$question->questionData->question_title }}</p></b>
                        <h3><span>Q <b class="qus-no">{{ @$questionNo }}</b>.</span> {{ @$question->questionList->question }}</h3>
                        @if(isset($question->questionList->image_id) && ($question->questionList->image_id != null))
                            <img class="img-fluid" src="{{@$question->questionList->image_path}}" width="250px" height="250px" >
                        @endif
                        <div class="inin_qstn_box mrgn_bt_30 mrgn_tp_40">
                        @php
                            $alphabet = ord("A");
                            if($question->questionList->answer_type == 2){
                                $inputType = 'checkbox';
                            }else{
                                $inputType = 'radio';
                            }
                        @endphp
                        @if(@$question->questionData->question_type == 1)
                        <ul class="qsa_optns @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2) unread_tr @endif" style="@if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)pointer-events: none;@endif">
                                @forelse ($answers as $ans)
                                <li>
                                    <div class="optn_bbx">
                                        <input @if(in_array($ans->id,$question->selected_answers) && $review == true) checked @endif type="{{$inputType}}" class="ans-rdo" data-mock-test-id="{{ @$mockTest->id }}" data-current_question_id="{{ @$question->id }}" name="asnwer" value="{{ @$ans->id }}" id="asnwer_{{chr($alphabet)}}" @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)disabled @endif>
                                        <label class="optn_lble"><span class="checkbx_rund"></span><span>{{chr($alphabet)}}.</span> {{ @$ans->answer }}</label>
                                        <input type="hidden" name="time_taken" value="{{ @$ans->time_taken }}" id='timeTaken'>
                                    </div>
                                </li>
                                @php  $alphabet++; @endphp
                                @empty
                                @endforelse
                            </ul>
                        @endif
                        <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="questsn_side_menu">
                        <div class="qustn_title">
                            <h3 class="qs_h3 blue_clr_txt">Questions:</h3>
                        </div>
                        <div class="question_list_scn">
                            <ul>
                                @forelse($previewQuestionList as $qKey => $previewQuestion)
                                @php
                                    $class2 = '';
                                    if($previewQuestion['is_attempted']== 1){
                                        $class = 'active_green';
                                    }else{
                                        $class = '';
                                    }
                                    if($previewQuestion['question_id'] == @$question->id){
                                        $class2 = 'font-weight-bold';
                                    }
                                @endphp
                                <li class="quest_lst_n {{$class.' '.$class2}}" data-index="{{$qKey}}"><span class="q_counter_num {{$class2}}">{{@$previewQuestion['q_no']}}</span>{{@shortContent($previewQuestion['question'],45)}}</li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <ul class="action_lst">
                <div class="row pl-5 pb-2 text-default">
                    <span class="h5 lastQuestionLabel" style="display: @if($nextQuestionId != '' || $nextQuestionId != null) none; @endif">This is last question of review paper</span>
                </div>
                <li class="prv-qus-li">
                    @if($prevQuestionId != null)
                        <button type="button" class="btn prvs_btn nxt_qus" 
                        data-question-number=""  data-section_id="{{ @$section->id }}" data-current_question_id="{{ @$current_question_id}}" data-type="prev" data-prev-question-id="{{ @$prev_question_id }}" data-mock-test-id="{{ @$mockTest->id }}" data-next-question-id="{{ @$nextQuestionId }}">Previous Question</button>
                    @else
                        <button type="button" class="btn prvs_btn" disabled>Previous Question</button>
                    @endif
                </li>
                @php
                // dd($prevQuestionId,$prevQuestionId != null);
                // exit;
                @endphp
                <li class="nxt-qus-li">
                    @if(@$nextQuestionId)
                        <button type="button" class="btn nxt_btn nxt_qus" data-question-number="" data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}" data-prev-question-id="{{ @$prev_question_id }}" data-mock-test-id="{{ @$mockTest->id }}" data-next-question-id="{{ @$nextQuestionId }}"  >Next Question</button>
                    @else
                        <button type="button" class="btn nxt_btn" disabled>Next Question</button>
                    @endif
                </li>
                <input type="hidden" name="mark_for_review" class="dt-checkboxes" value="1" id="agreeCheck">
                <li class="float-right cpmlt-mck">
                        <button type="button" class="btn cmplt_btn" data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                                data-mock-test-image="{{ @$mockTest->image_path }}"
                                data-url="{{ route('paper-result',[@$studentTestPaper->uuid]) }}">Submit Paper</button>
                </li>
        </div>
    </div>
</form>
@php
// dd($question);
// exit;
@endphp