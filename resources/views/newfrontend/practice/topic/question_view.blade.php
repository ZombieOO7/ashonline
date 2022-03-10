<div class="col-md-12">
    <div class="in_qstn_box">
        <div class="inin_qstn_box">
            @if(@$question->instruction != null)
                {!! @$question->instruction !!}
            @endif
            {!! @$question->question !!}
            @if(@$question->image != null)
                <div>
                    @if(@$question->resize_full_image != null)
                        <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                            {!! @$question->resize_full_image !!}
                        </span>
                    @else
                        <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                            <img class="img-fluid mb-3" src="{{@$question->image_path}}">
                        </span>
                    @endif
                </div>
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
            <input type="hidden" name='practice_test_question_answer_id' value="{{@$testQuestionAnswer->id}}" id='testQuestionAnswerId'>
                @if(@$question->type == 4)
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
                @else
                    @php
                        if(@$question->answer_type == 2){
                            $inputType = 'checkbox';
                        }else{
                            $inputType = 'radio';
                        }
                    @endphp
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
            data-id="{{@$testQuestionAnswer->id}}" data-index="{{@$prevIndex}}" data-questionId="{{@$previousQuestionId}}">{{__('frontend.previous_question')}}</button>
        </li>
        <li>
            <button type="button" class="btn nxt_btn nextQuestion" @if(@$nextQuestionId == null) disabled @endif  
            data-id="{{@$testQuestionAnswer->id}}" data-index="{{@$nextIndex}}" data-questionId="{{@$nextQuestionId}}">{{__('frontend.next_question')}}</button>
        </li>
        <li class="float-right">
            <button type="button" class="btn cmplt_btn completeBtn" data-id="{{@$testQuestionAnswer->id}}" @if($nextQuestionId != null) disabled @endif >{{__('frontend.submit')}}</button>
        </li>
        <div class="clearfix"></div>
    </ul>
</div>
@php
// exit;
@endphp