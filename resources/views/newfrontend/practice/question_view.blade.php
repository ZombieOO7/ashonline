<div class="col-md-12">
    <div class="in_qstn_box">
        @if(isset($section->passage) && @$section->passage_path !=null)
            <div class="pdfApp border" data-index="00" data-src="{{@$section->passage_path}}">
                <div id="viewport-container00" class="viewport-container" data-index="00"><div role="main" class="viewport" id="viewport00" data-index="00"></div></div>
            </div>
        @endif
        @if(@$question->instruction != null)
            <h3>{!! @$question->instruction !!}</h3>
        @endif
        <div class="inin_qstn_box mt-3">
            <h4><span class='questionNo'>Q{{@$question->question_no}}.&nbsp;</span>{!! @$question->question !!}</h4>
            @if(@$question->image != null)
                @if(@$question->resize_full_image != null)
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                        {!! @$question->resize_full_image !!}
                    </span>
                @else
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                        <img class="img-fluid mb-3" src="{{@$question->image_path}}">
                    </span>
                @endif
            @endif
            @php
                $alphabet = ord("A");
                if(@$question->answer_type == 2){
                    $inputType = 'checkbox';
                }else{
                    $inputType = 'radio';
                }
            @endphp
            <input type="hidden" name='question_list_id' value="{{@$question->id}}" id='questionListId'>
            <input type="hidden" name='question_list_id' value="{{@$testQuestionAnswer->id}}" id='testQuestionAnswerId'>
                @if(@$question->question_type == 1 && @$question->type == 4)
                    @php
                        $inputType = 'checkbox';
                        $answers = @$question->answers??[];
                    @endphp
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                            <ul class="qsa_optns">
                                @forelse ($answers as $akey => $ans)
                                    @if($akey < 3)
                                        <li>
                                            <div class="optn_bbx">
                                                <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer" id="answer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                data-correctAnswerId="{{@$question->correctAnswer->id}}" @if(in_array(@$ans->id,@$testQuestionAnswer->selected_answers)) checked @endif>
                                                <label class="optn_lble">
                                                    @if($inputType == 'checkbox')
                                                        <span class="checkbx_square fa fa-check-square"></span>
                                                    @else
                                                        <span class="checkbx_rund"></span>
                                                    @endif
                                                    <span>{{chr($alphabet)}}.</span>
                                                    {!! @$ans->answer !!}
                                                </label>
                                            </div>
                                        </li>
                                        @php $alphabet++; @endphp
                                    @endif
                                @empty
                                @endforelse
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="qsa_optns">
                                @forelse ($answers as $akey => $ans)
                                    @if($akey > 2)
                                        <li>
                                            <div class="optn_bbx">
                                                <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer" id="answer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                data-correctAnswerId="{{@$question->correctAnswer->id}}" @if(in_array(@$ans->id,@$testQuestionAnswer->selected_answers)) checked @endif>
                                                <label class="optn_lble">
                                                    @if($inputType == 'checkbox')
                                                        <span class="checkbx_square fa fa-check-square"></span>
                                                    @else
                                                        <span class="checkbx_rund"></span>
                                                    @endif
                                                    <span>{{chr($alphabet)}}.</span>
                                                    {!! @$ans->answer !!}
                                                </label>
                                            </div>
                                        </li>
                                        @php $alphabet++; @endphp
                                    @endif
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @elseif(@$question->question_type == 1)
                    <ul class="qsa_optns">
                    @forelse ($question->answers??[] as $ans)
                        <li>
                            <div class="optn_bbx">
                                <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer[]" id="answer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                data-correctAnswerId="{{@$question->correctAnswer->id}}" @if(in_array(@$ans->id,@$testQuestionAnswer->selected_answers)) checked @endif>
                                <label class="optn_lble">
                                    @if($inputType == 'checkbox')
                                        <span class="checkbx_square fa fa-check-square"></span>
                                    @else
                                        <span class="checkbx_rund"></span>
                                    @endif
                                    <span>{{chr(@$alphabet)}}.</span>
                                    {!! @$ans->answer !!}
                                </label>
                            </div>
                        </li>
                        @php $alphabet++; @endphp
                    @empty
                    @endforelse
                    </ul>
                @endif
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-12">
    <ul class="action_lst">
        <li>
            <button type="button" class="btn prvs_btn previousQuestion" @if(@$previousQuestionId == null) disabled @endif
            data-id="{{@$testQuestionAnswer->id}}" data-questionId="{{@$previousQuestionId}}">{{__('frontend.previous_question')}}</button>
        </li>
        <li>
            <button type="button" class="btn nxt_btn nextQuestion" @if(@$nextQuestionId == null) disabled @endif  
            data-id="{{@$testQuestionAnswer->id}}" data-questionId="{{@$nextQuestionId}}">{{__('frontend.next_question')}}</button>
        </li>
        @if($markAsReview == false)
        <li>
            <div class="checkbox agreeckbx markAsReview">
                <input type="checkbox" class="dt-checkboxes" id="agreeCheck" @if(@$testQuestionAnswer->mark_as_review == 1) checked @endif>
                <label for="agreeCheck">{{__('frontend.mark_for_review')}}</label>
            </div>
        </li>
        @endif
        @if($nextSection!=null)
            <li class="float-right">
                <button type="button" class="btn cmplt_btn nextSection" data-id="{{@$testQuestionAnswer->id}}" @if($nextQuestionId != null) disabled @endif >Next Section</button>
            </li>
        @else
            <li class="float-right">
                <button type="button" class="btn cmplt_btn completeBtn" data-id="{{@$testQuestionAnswer->id}}" @if($nextQuestionId != null) disabled @endif >{{__('frontend.submit')}}</button>
            </li>
        @endif
        <div class="clearfix"></div>
    </ul>
</div>
<div class="col-md-12 mt-3">
    <ul class="clr_info_lst">
        <li><span class="crnt_crcl"></span>Current Question</li>
        <li><span class="ans_crcl"></span>Attempted</li>
        <li><span class="ans_unnsrd"></span>Review</li>
    </ul>
</div>
<div class="col-md-12 pt-5">
    <div class="questsn_side_menu">
        <div class="qustn_title">
            <h3 class="qs_h3 blue_clr_txt">Questions:</h3>
        </div>
        <div class="question_list_scn">
            <ul>
                @forelse($previewQuestionList as $qKey => $previewQuestion)
                @php
                    $class2 = '';
                    if(@$previewQuestion['mark_as_review'] == 1){
                        $class = 'yellow_review_actv';
                    }elseif(@$previewQuestion['is_attempted']== 1){
                        $class = 'active_green';
                    }else{
                        $class = '';
                    }
                    if(@$previewQuestion['id'] == @$testQuestionAnswer->id){
                        $class2 = 'font-weight-bold';
                    }
                @endphp
                <li class="quest_lst_n {{$class.' '.$class2}}" data-questionNo="{{@$previewQuestion['q_no']}}" data-id="{{@$testQuestionAnswer->id}}" data-questionId="{{@$previewQuestion['id']}}"><span class="q_counter_num {{$class2}}">{{@$previewQuestion['q_no']}}</span>{{@shortContent(@$previewQuestion['question'],100)}}</li>
                @empty
                @endforelse
            </ul>
        </div>
    </div>
</div>
@php
// exit;
@endphp