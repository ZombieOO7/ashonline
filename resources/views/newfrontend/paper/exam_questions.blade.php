<div class="row">
    <div class="col-md-12">
        <div class="row flex-column-reverse flex-md-row">
            <div class="col-md-12">
                <div class="in_qstn_box ajx-dv">
                    <b><p>{{ @$question->questionData->instruction }}</p></b>
                    <h3><span>Q<b class="qus-no">{{ @$question->questionData->question_no }}</b>. </span> {{ @$question->questionData->question }}</h3>
                    <div class="inin_qstn_box mrgn_bt_30 mrgn_tp_40 col-md-12">
                        @if(@$question->questionData->image != null)
                            @if($question->questionData->resize_full_image != null)
                                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->questionData->image_path}}">
                                    {!! @$question->questionData->resize_full_image !!}
                                </span>
                            @else
                                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->questionData->image_path}}">
                                    <img class="img-fluid mb-3" src="{{@$question->questionData->image_path}}">
                                </span>
                            @endif
                        @endif
                        {{-- @else
                            @if(($question->questionData->question_image != null))
                                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->questionData->question_image_path}}">
                                    <img class="img-fluid mb-3" src="{{@$question->questionData->question_image_path}}">
                                </span>
                            @endif
                        @endif --}}
                    @php
                        $alphabet = ord("A");
                        // dd($question->questionData->answer_type);
                        if($question->questionData->answer_type == 2){
                            $inputType = 'checkbox';
                        }else{
                            $inputType = 'radio';
                        }
                    @endphp
                    @if(@$question->questionData->question_type == 1 && @$question->questionData->type == 4)
                    @php $inputType = 'checkbox'; @endphp
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                            <ul class="qsa_optns @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2) unread_tr @endif" style="@if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)pointer-events: none;@endif">
                                @forelse ($answers as $akey => $ans)
                                    @if($akey < 3)
                                        <li>
                                            <div class="optn_bbx">
                                                <input type="{{$inputType}}" class="ans-rdo"
                                                    data-section_id="{{ @$sectionId }}"
                                                    data-current_question_id="0"
                                                    name="asnwer" value="{{ @$ans->id }}"
                                                    id="asnwer_{{chr($alphabet)}}" @if(in_array($ans->id,$question->selected_answers)) checked @endif @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)disabled @endif>
                                                <label class="optn_lble">
                                                    @if($inputType == 'checkbox')
                                                        <span class="checkbx_square fa fa-check-square"></span>
                                                    @else
                                                        <span class="checkbx_rund"></span>
                                                    @endif
                                                    <span>{{chr($alphabet)}}.</span>
                                                    {{ @$ans->answer }}
                                                </label>
                                                <input type="hidden" name="time_taken" value="" id='timeTaken'>
                                            </div>
                                        </li>
                                        @php $alphabet++; @endphp
                                    @endif
                                @empty
                                @endforelse
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="qsa_optns @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2) unread_tr @endif" style="@if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)pointer-events: none;@endif">
                                @forelse ($answers as $akey => $ans)
                                    @if($akey > 2)
                                        <li>
                                            <div class="optn_bbx">
                                                <input type="{{$inputType}}" class="ans-rdo"
                                                    data-section_id="{{ @$sectionId }}"
                                                    data-current_question_id="0"
                                                    name="asnwer" value="{{ @$ans->id }}"
                                                    id="asnwer_{{chr($alphabet)}}" @if(in_array($ans->id,$question->selected_answers)) checked @endif @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)disabled @endif>
                                                <label class="optn_lble">
                                                    @if($inputType == 'checkbox')
                                                        <span class="checkbx_square fa fa-check-square"></span>
                                                    @else
                                                        <span class="checkbx_rund"></span>
                                                    @endif
                                                    <span>{{chr($alphabet)}}.</span>
                                                    {{ @$ans->answer }}
                                                </label>
                                                <input type="hidden" name="time_taken" value="" id='timeTaken'>
                                            </div>
                                        </li>
                                        @php $alphabet++; @endphp
                                    @endif
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @elseif(@$question->questionData->question_type == 1)
                    <ul class="qsa_optns @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2) unread_tr @endif" style="@if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)pointer-events: none;@endif">
                            @forelse ($answers as $ans)
                            <li>
                                <div class="optn_bbx">
                                    <input @if(in_array($ans->id,$question->selected_answers)) checked @endif type="{{$inputType}}" class="ans-rdo" data-mock-test-id="{{ @$mockTest->id }}" data-current_question_id="{{ @$question->id }}" name="asnwer" value="{{ @$ans->id }}" id="asnwer_{{chr($alphabet)}}" @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)disabled @endif>
                                    <label class="optn_lble">
                                        @if($inputType == 'checkbox')
                                            <span class="checkbx_square fa fa-check-square"></span>
                                        @else
                                            <span class="checkbx_rund"></span>
                                        @endif
                                        <span>{{chr($alphabet)}}.</span> {{ @$ans->answer }}
                                    </label>
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
        </div>
    </div>
    <div class="col-md-12">
        <ul class="action_lst p-0">
            <div class="row pl-5 pb-2 text-default">
                @if($mockTest->stage_id == '1')
                    <span class="h4 lastQuestionLabel text-danger" style="display: @if($nextQuestionId != '' || $nextQuestionId != null) none; @endif">Note : {{__('formname.last_question_note')}}</span>
                @else
                    <span class="h4 lastQuestionLabel text-danger" style="display: @if($nextQuestionId != '' || $nextQuestionId != null) none; @endif">Note : {{__('formname.last_paper_question_note')}}</span>
                @endif
            </div>
            <li class="prv-qus-li">
                @if($prevQuestionId != null)
                    <button type="button" class="btn prvs_btn nxt_qus" 
                    data-question-number=""  data-section_id="{{ @$section->id }}" data-current_question_id="{{ @$current_question_id}}" data-type="prev" data-prev-question-id="{{ @$prev_question_id }}" data-mock-test-id="{{ @$mockTest->id }}" data-next-question-id="{{ @$nextQuestionId }}">{{__('formname.previous_question')}}</button>
                @else
                    <button type="button" class="btn prvs_btn" disabled>{{__('formname.previous_question')}}</button>
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
                    <button type="button" class="btn nxt_btn" disabled>{{__('formname.next_question')}}</button>
                @endif
            </li>
            <li>
                <div class="checkbox agreeckbx">
                    <input type="checkbox" name="mark_for_review" class="dt-checkboxes"
                        value="1" id="agreeCheck">
                    <label for="agreeCheck">{{__('formname.mark_for_review')}}</label>
                </div>
            </li>
            {{-- <input type="hidden" name="mark_for_review" class="dt-checkboxes" value="0" id="agreeCheck"> --}}
            <li class="float-right cpmlt-mck">
                @if((string)$prevSectionId != null && $paper->is_time_mandatory == '0')
                    <button type="button" class="drk_blue_btn nxtSubQue" data-toggle="modal" data-target='#StartPrevSectionModal' data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                        data-section_id="{{ @$sectionId }}"
                        data-next_section_id="{{ @$nextSectionId }}"
                        data-mock-test-image="{{ @$mockTest->image_path }}"
                        data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}">{{__('formname.preview_section')}}</button>
                @endif
                @if($mockTest->stage_id == 1 && @$paper->is_time_mandatory == '0' && @$nextSectionId != null)
                    @if(@$nextQuestionId)
                        <button type="button" class="drk_blue_btn nxtSubQue" @if($paper->is_time_mandatory==1) disabled @endif data-toggle="modal" data-target='#StartNextSectionModal' data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                            data-section_id="{{ @$sectionId }}"
                            data-next_section_id="{{ @$nextSectionId }}"
                            data-mock-test-image="{{ @$mockTest->image_path }}"
                            data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}">{{__('formname.next_section')}}
                        </button>
                    @else
                        <button type="button" class="drk_blue_btn nxtSubQue" data-toggle="modal" data-target='#StartNextSectionModal'  data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                            data-section_id="{{ @$sectionId }}"
                            data-next_section_id="{{ @$nextSectionId }}"
                            data-mock-test-image="{{ @$mockTest->image_path }}"
                            data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}">{{__('formname.next_section')}}
                        </button>
                    @endif
                @endif
                @if($mockTest->stage_id == 1 && @$paper->is_time_mandatory == '0' && @$nextSectionId == null && @$nextQuestionId == null)
                    <button type="button" class="btn cmplt_btn " data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                        data-mock-test-image="{{ @$mockTest->image_path }}"
                        data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}">{{__('formname.submit_paper')}}</button>
                @else
                @endif
                @if($mockTest->stage_id == 2 && @$nextSectionId == null)
                    <button type="button" class="btn cmplt_btn " data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                    data-mock-test-image="{{ @$mockTest->image_path }}"
                    data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}" @if($nextQuestionId != '' || $nextQuestionId != null) disabled @endif>{{__('formname.submit_paper')}}</button>
                @endif
                @if($mockTest->stage_id == 2 && @$nextSectionId != null)
                    <button type="button" class="drk_blue_btn nxtSubQue" data-toggle="modal" data-target='#StartNextSectionModal'  data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                        data-section_id="{{ @$sectionId }}"
                        data-next_section_id="{{ @$nextSectionId }}"
                        data-mock-test-image="{{ @$mockTest->image_path }}"
                        data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}">{{__('formname.next_section')}}
                    </button>
                @endif
            </li>
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
                        if($previewQuestion['mark_as_review'] == '1'){
                            $class = 'yellow_review_actv';
                        }elseif($previewQuestion['is_attempted']== '1'){
                            $class = 'active_green';
                        }else{
                            $class = '';
                        }
                        if(@$previewQuestion['question_id'] == @$question->id){
                            $class2 = 'font-weight-bold';
                        }
                    @endphp
                    <li class="quest_lst_n {{$class.' '.$class2}}" data-index="{{$qKey}}"><span class="q_counter_num {{$class2}}">{{@$previewQuestion['q_no']}}</span>{{@shortContent($previewQuestion['question'],120)}}</li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>