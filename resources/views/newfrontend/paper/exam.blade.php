@extends('newfrontend.layouts.default')
@section('title','Mock Exam')
@section('pageCss')
    {{-- <meta http-equiv="refresh" content="0; url={{route('student-mocks')}}"> --}}
    <link rel="stylesheet" href="{{asset('css/pdf.css')}}">
@endsection
@section('content')
<div class="container mrgn_bt_40">
    <div class="row">
        <div class="col-md-12">
            <div class="mn_qs_bx">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-block">
                            <ul class="ex_tp_dtls">
                                <li>
                                    <label>{{__('formname.mock-test.title')}}</label>
                                    <p>{{@$mockTest->title}}</p>
                                </li>
                                <li>
                                    <label>{{__('formname.paper_name')}}</label>
                                    <p>{{@$paper->name}}</p>
                                </li>
                                <li>
                                    <label>{{__('formname.subject')}}</label>
                                    <p>{{@$section->subject->title}}</p>
                                </li>
                            {{-- </ul>
                        </div>
                        <div class="float-right">
                            <ul class="ex_tp_dtls"> --}}
                                <li>
                                    <label>{{__('formname.child_name')}}</label>
                                    <p>{{ @$student->full_name }}</p>
                                </li>
                                <li>
                                    <label>{{__('formname.parent_email')}}</label>
                                    <p>{{ @$student->parents->email }}</p>
                                </li>
                                <li>
                                    <p>{{ @$ip }}</p>
                                    <h6>{{__('formname.ip_address')}}</h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="ex_bt_dtls">
                            <li>
                                <div class="row pl-2 pr-2">
                                    <label>{{__('formname.total_section')}}</label>&nbsp;:&nbsp;<label class="font-weight-bold"> {{ count($sections) }} </label>
                                </div>
                            </li>
                            <li>
                                <label>{{__('formname.section_name')}}</label>&nbsp;:&nbsp;
                                <label class="font-weight-bold">{{@$section->name}}</label>
                            </li>
                            <li>
                                <div class="row pl-2 pr-2">
                                    <label>{{__('formname.total_questions')}}</label>&nbsp;:&nbsp;
                                    <label class="font-weight-bold">{{ @$section->questions }}</label>
                                </div>
                            </li>
                            @if(@$mockTest->stage_id == 1)
                                <li>
                                    <div class="row pl-2 pr-2">
                                        <label>{{__('formname.attempted')}}</label>&nbsp;:&nbsp;
                                        <label class="font-weight-bold is_attmpt-cls">{{@$attemptedCount??0}}</label>
                                    </span>
                                </li>
                                <li class="float-right">
                                    <span class="row pl-2 pr-2">
                                        <label>{{__('formname.time_left')}}</label>&nbsp;:&nbsp;
                                        <label id="timer" class="font-weight-bold">{{ @$time_left }}</label>
                                    </span>
                                </li>
                            @endif
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        @if(isset($section->passage) && @$section->passage_path !=null)
                            <div class="pdfApp border" data-index="00" data-src="{{@$section->passage_path}}">
                                <div id="viewport-container00" class="viewport-container" data-index="00"><div role="main" class="viewport" id="viewport00" data-index="00"></div></div>
                            </div>
                        @endif
                        <form class="qstn_form" id="examData">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row flex-column-reverse flex-md-row">
                                        <div class="col-md-12">
                                            <div class="in_qstn_box ajx-dv">
                                                <h3><span>Q<b class="qus-no">{{@$firstQuestion->questionData->question_no??1}}</b>. </span> {!! @$firstQuestion->questionData->question !!}</h3>
                                                <div class="inin_qstn_box mrgn_bt_30 mrgn_tp_40 col-md-12">
                                                    {{-- @if(@$firstQuestion->questionData->question_type == 1) --}}
                                                        @if(($firstQuestion->questionData->image != null))
                                                            @if($firstQuestion->questionData->resize_full_image)
                                                                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$firstQuestion->questionData->image_path}}">
                                                                    {!! @$firstQuestion->questionData->resize_full_image !!}
                                                                </span>
                                                            @else
                                                                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$firstQuestion->questionData->image_path}}">
                                                                    <img class="img-fluid mb-3" src="{{@$firstQuestion->questionData->image_path}}">
                                                                </span>
                                                            @endif
                                                        @endif
                                                    {{-- @else
                                                        @if(($firstQuestion->questionData->question_image != null))
                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$firstQuestion->questionData->question_image_path}}">
                                                                <img class="img-fluid mb-3" src="{{@$firstQuestion->questionData->question_image_path}}">
                                                            </span>
                                                        @endif
                                                    @endif --}}
                                                    @php
                                                    $alphabet = ord("A");
                                                    @endphp
                                                        @if(@$firstQuestion->questionData->question_type == 1 && @$firstQuestion->questionData->type == 4)
                                                            @php
                                                                $inputType = 'checkbox';
                                                                $answers = @$firstQuestion->questionData->answers??[];
                                                            @endphp
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
                                                                                            id="asnwer_{{chr($alphabet)}}" @if(in_array($ans->id,$firstQuestion->selected_answers)) checked @endif @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)disabled @endif>
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
                                                                                            id="asnwer_{{chr($alphabet)}}" @if(in_array($ans->id,$firstQuestion->selected_answers)) checked @endif @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)disabled @endif>
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
                                                        @elseif($firstQuestion->questionData->question_type == 1)
                                                            <ul class="qsa_optns @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2) unread_tr @endif" style="@if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)pointer-events: none;@endif">
                                                                @php
                                                                    $answers = @$firstQuestion->questionData->answers??[];
                                                                    if($firstQuestion->questionData->answer_type == 2){
                                                                        $inputType = 'checkbox';
                                                                    }else{
                                                                        $inputType = 'radio';
                                                                    }
                                                                @endphp
                                                                @forelse ($answers as $ans)
                                                                <li>
                                                                    <div class="optn_bbx">
                                                                        <input type="{{$inputType}}" class="ans-rdo"
                                                                            data-section_id="{{ @$sectionId }}"
                                                                            data-current_question_id="0"
                                                                            name="asnwer" value="{{ @$ans->id }}"
                                                                            id="asnwer_{{chr($alphabet)}}" @if(in_array($ans->id,$firstQuestion->selected_answers)) checked @endif @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)disabled @endif>
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
                                            <button type="button" class="btn prvs_btn nxt_qus"
                                             data-section_id="{{ @$sectionId }}"
                                             data-subject_id="{{ @$subjectId }}"
                                             data-current_question_id="0" 
                                             data-type="prev"
                                             data-prev-question-id="{{ @$prevQuestionId }}" 
                                             data-mock-test-id="{{ @$mockTest->id }}" 
                                             data-next-question-id="{{ @$nextQuestionId }}"
                                             {{($prevQuestionId =='' || $prevQuestionId==null)?'disabled':''}}>{{__('formname.previous_question')}}</button>
                                        </li>

                                        <li class="nxt-qus-li">
                                            <button type="button" class="btn nxt_btn nxt_qus"
                                                data-section_id="{{ @$sectionId }}" 
                                                data-subject_id="{{ @$subjectId }}"
                                                data-type="next"
                                                data-current_question_id="0"
                                                data-prev-question-id="{{ @$prevQuestionId }}"
                                                data-mock-test-id="{{ @$mockTest->id }}"
                                                data-next-question-id="{{ @$nextQuestionId }}"
                                                {{($nextQuestionId =='' || $nextQuestionId==null)?'disabled':''}}>{{__('formname.next_question')}}</button>
                                        </li>

                                        <li>
                                            <div class="checkbox agreeckbx">
                                                <input type="checkbox" name="mark_for_review" class="dt-checkboxes"
                                                    value="1" id="agreeCheck" @if(@$firstQuestion->mark_as_review==1) checked @endif>
                                                <label for="agreeCheck">{{__('formname.mark_for_review')}}</label>
                                            </div>
                                        </li>
                                        <input type="hidden" name="mark_for_review" class="dt-checkboxes" value="0" id="agreeCheck">
                                        <li class="float-right cpmlt-mck">
                                            @if((string)$prevSectionId != null && $paper->is_time_mandatory == '0')
                                                    <button type="button" class="drk_blue_btn nxtSubQue" data-toggle="modal" data-target='#StartPrevSectionModal' data-section_id="{{ @$section->id }}" data-current_question_id="0"  data-mock-test-id="{{ @$mockTest->id }}">{{__('formname.preview_section')}}
                                                    </button>
                                             @endif
                                            @if($mockTest->stage_id == 1 && @$nextSectionId != null && $paper->is_time_mandatory == '0')
                                                @if(@$nextQuestionId)
                                                    <button type="button" class="drk_blue_btn nxtSubQue" @if(@$paper->is_time_mandatory=='1') disabled @endif data-toggle="modal" data-target='#StartNextSectionModal' data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="0"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                                                        data-section_id="{{ @$sectionId }}"
                                                        data-next_section_id="{{ @$nextSectionId }}"
                                                        data-mock-test-image="{{ @$mockTest->image_path }}"
                                                        data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}">Next Section
                                                    </button>
                                                {{-- @else
                                                    <button type="button" class="drk_blue_btn nxtSubQue" data-toggle="modal" data-target='#StartNextSectionModal'  data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                                                        data-section_id="{{ @$sectionId }}"
                                                        data-next_section_id="{{ @$nextSectionId }}"
                                                        data-mock-test-image="{{ @$mockTest->image_path }}"
                                                        data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}">Next Section
                                                    </button> --}}
                                                @endif
                                            @endif
                                            @if($mockTest->stage_id == 1 && @$paper->is_time_mandatory == '0' && @$nextSectionId == null && @$nextQuestionId == null)
                                            <button type="button" class="btn cmplt_btn"
                                                    data-section_id="{{ @$sectionId }}" 
                                                    data-subject_id="{{ @$subjectId }}"
                                                    data-type="next"
                                                    data-current_question_id="0"
                                                    data-prev-question-id="{{ @$prevQuestionId }}"
                                                    data-mock-test-id="{{ @$mockTest->id }}"
                                                    data-next-question-id="{{ @$nextQuestionId }}"
                                                    data-mock-test-title="{{ @$mockTest->title }}"
                                                    data-mock-test-image="{{ @$mockTest->image_path }}"
                                                    data-mock-test-image="{{ @$mockTest->image_path}}"
                                                    data-url="{{ route('paper-result',[@$studentTestPaper->uuid]) }}"
                                                @if($nextQuestionId != null && @$paper->is_time_mandatory == '1') disabled @endif
                                                    >{{__('formname.submit_paper')}}
                                            </button>
                                            {{-- @else
                                                <button type="button" class="drk_blue_btn nxtSubQue" @if($paper->is_time_mandatory==1) disabled @endif data-toggle="modal" data-target='#StartNextSectionModal' >Next Section
                                                </button> --}}
                                            @endif
                                            @if($mockTest->stage_id == 2 && @$nextSectionId == null)
                                                <button type="button" class="btn cmplt_btn " data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="0"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                                                data-mock-test-image="{{ @$mockTest->image_path }}"
                                                data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}" @if($nextQuestionId != '' || $nextQuestionId != null) disabled @endif>{{__('formname.submit_paper')}}</button>
                                            @endif
                                            @if($mockTest->stage_id == 2 && @$nextSectionId != null)
                                                <button type="button" class="drk_blue_btn nxtSubQue" data-toggle="modal" data-target='#StartNextSectionModal'  data-section_id="{{ @$section->id }}" data-type="next" data-current_question_id="0"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
                                                    data-section_id="{{ @$sectionId }}"
                                                    data-next_section_id="{{ @$nextSectionId }}"
                                                    data-mock-test-image="{{ @$mockTest->image_path }}"
                                                    data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}" >{{__('formname.next_section')}}
                                                </button>
                                            @endif
                                        </li>
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
                                                    if(@$previewQuestion['question_id'] == @$firstQuestion->id){
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
                        </form>
                    </div>
                </div>
                <div class="d-none">
                    @if(@$firstAudio != '')
                        <audio id="firstAudio" class="audioInput" controls autoplay preload style='display:none;'>
                            <source src="{{@$firstAudio->audio_path}}" type="audio/mpeg">
                        </audio>
                    @endif
                    @if($secondAudio != '')
                        <audio id="secondAudio" class="audioInput" controls preload style='display:none;'>
                            <source src="{{@$secondAudio->audio_path}}" type="audio/mpeg">
                        </audio>
                    @endif
                    @if($thirdAudio != '')
                        <audio id="thirdAudio" class="audioInput" controls preload style='display:none;'>
                            <source src="{{@$thirdAudio->audio_path}}" type="audio/mpeg">
                        </audio>
                    @endif
                    @if($forthAudio != '')
                        <audio id="forthAudio" class="audioInput" controls preload style='display:none;'>
                            <source src="{{@$forthAudio->audio_path}}" type="audio/mpeg">
                        </audio>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade def_modal lgn_modal" data-backdrop="static" data-keyboard="false" id="CompleteMockExamModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <h3>{{__('frontend.complete_mock_lbl')}}</h3>
                        <div class="mc_pp_bx">
                            <div class="row">
                                <div class="col-md-12 mc_d_b">
                                    <div class="d-md-flex align-items-center">
                                        <img src="{{@$mockTest->image_path}}" class="mx-wd-95 img-fluid mck-tst-img">
                                        <div class="row">
                                            <div class="mdl_txt mck-tst-title mdl_txt mck-tst-title col-md-12"><span class='font-weight-bold text-dark'> {{__('formname.mock_test_id')}}</span> : {!! @$mockTest->title !!} </div>
                                            <div class="mdl_txt mck-tst-title mdl_txt mck-tst-title col-md-12"><span class='font-weight-bold text-dark'> {{__('formname.paper')}}</span> : {{ @$paper->name }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 inline_action mrgn_tp_15">
                                    <div class="mb-4">{{__('frontend.confirm_mock')}}</div>
                                    <a href='javascript:;' class="drk_blue_btn section_review_btn" data-dismiss="modal" aria-label="Close">{{__('formname.review_lbl')}}</a>
                                    <button type="button" class="btn submit_btn cmplt_mck"
                                        data-mock-test-id="{{ @$mockTest->id }}"
                                        data-mock-test-title="{{ @$mockTest->title }}"
                                        data-mock-test-image="{{ @$mockTest->image_path }}"
                                        data-url="{{ route('paper-result',[@$studentTestPaper->uuid]) }}">{{__('formname.submit')}}</button>
                                    {{-- @if($paper->is_time_mandatory == '0')
                                        <a href='javascript:;' data-href="{{ route('paper-review',[@$studentTestPaper->uuid]) }}" class="btn submit_btn btn_rvw">Review</a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade def_modal lgn_modal" data-backdrop="static" data-keyboard="false" id="MockExamCompleteModal" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>{{@$section->name}} Time Out</h3>
                        <div class="mc_pp_bx">
                            <div class="row">
                                <div class="col-md-12 mc_d_b">
                                    <div class="d-md-flex align-items-center">
                                        <img src="{{@$mockTest->image_path}}" class="mx-wd-95 img-fluid mck-tst-img">
                                        <div class="row">
                                            <div class="mdl_txt mck-tst-title mdl_txt mck-tst-title col-md-12"><span class='font-weight-bold text-dark'> {{__('formname.mock_test_id')}}</span> : {!! @$mockTest->title !!} </div>
                                            <div class="mdl_txt mck-tst-title mdl_txt mck-tst-title col-md-12"><span class='font-weight-bold text-dark'> {{__('formname.paper')}}</span> : {{ @$paper->name }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 inline_action mrgn_tp_15">
                                    <div class="h5">You'r Mock Exam Time Finished</div>
                                    @if($nextSectionId==null)
                                        <a href='javascript:;' class="drk_blue_btn section_review_btn" data-dismiss="modal" aria-label="Close">{{__('formname.review_lbl')}}</a>
                                        <button type="button" class="btn cmplt_btn cmplt_mck submit_btn"
                                        data-mock-test-id="{{ @$mockTest->id }}"
                                        data-mock-test-title="{{ @$mockTest->title }}"
                                        data-mock-test-image="{{ @$mockTest->image_path }}"
                                        data-url="{{ route('paper-result',[@$studentTestPaper->uuid]) }}">Submit</button>
                                        {{-- @if($paper->is_time_mandatory == '0')
                                        <a href="{{ route('paper-review',[@$studentTestPaper->uuid]) }}"
                                            class="btn submit_btn btn_rvw">Review Question</a>
                                        @endif --}}
                                    @else
                                        <button type="button" class="btn cmplt_btn cmplt_mck submit_btn"
                                        data-mock-test-id="{{ @$mockTest->id }}"
                                        data-mock-test-title="{{ @$mockTest->title }}"
                                        data-mock-test-image="{{ @$mockTest->image_path }}"
                                        data-url="{{route('section.detail',['paperId'=>@$paper->uuid,'sectionId'=>$nextSectionId])}}">Next Section</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade def_modal lgn_modal" id="StartNextSectionModal" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button> --}}
                    <div class="modal-body">
                        <h3>Change Section</h3>
                        <p class="mrgn_bt_40">Do you want to attempt other section ?</p>
                        <div class="mc_pp_bx">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mc_p_dd_b mc_brdr_nn">
                                        <div class="row">
                                            <div class="col-md-6 mc_lfd">
                                                <label>Section Name</label>
                                                <h3 class="secTopicName">{{@$nextSection->name}}</h3>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <div class="mc_rtd">
                                                    <h3 class="secTime">{{@$nextSection->time}}</h3>
                                                    <label>Time to Complete</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="button" id='nextSection' data-href="{{route('section.detail',['paperId'=>$studentTestPaper->uuid,'sectionId'=>@$nextSectionId])}}" class="drk_blue_btn ml-2 mr-2"> Continue</a>
                                    <button type="button" aria-label="Close" data-dismiss="modal" href="javascript:;" class="drk_blue_btn">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade def_modal lgn_modal" id="StartPrevSectionModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button> --}}
                    <div class="modal-body">
                        <h3>Change Section</h3>
                        <p class="mrgn_bt_40">Do you want to attempt other section ?</p>
                        <div class="mc_pp_bx">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mc_p_dd_b mc_brdr_nn">
                                        <div class="row">
                                            <div class="col-md-6 mc_lfd">
                                                <label>Section Name</label>
                                                <h3 class="secTopicName">{{@$prevSection->name}}</h3>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <div class="mc_rtd">
                                                    <h3 class="secTime">{{@$prevSection->time}}</h3>
                                                    <label>Time to Complete</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="button" id='prevSection'  data-href="{{route('section.detail',['paperId'=>$studentTestPaper->uuid,'sectionId'=>@$prevSectionId])}}" class="drk_blue_btn ml-2 mr-2"> Continue</a>
                                    <button type="button" data-dismiss="modal" class="drk_blue_btn">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@php
    session()->put('refresh_flag',true);
@endphp
    @stop
    @section('pageJs')
    <script>
        var nextSubjectId = '{{@$nextSubjectId}}';
        var nextSectionId = '{{@$nextSectionId}}';
        $(document).bind("contextmenu",function(e){
            return false;
        });
    </script>
    <script type="text/javascript">
        var ajaxNextQuestionUrl = "{{ route('ajax-next-question') }}";
        var saveQuestionAnsURL = "{{ route('ajax-store-question-ans') }}";
        var examTotalTimeSeconds = "{{ @$examTotalTimeSeconds }}";
        var studentMocksURL = "{{ route('student-mocks') }}";
        var studentTestId= "{{$studentTest->id}}";
        var mockTestId= "{{@$mockTest->id}}";
        var stageId = "{{@$mockTest->stage_id}}";
        var studentTestResultId ='{{$studentTestResult->id}}';
        var questionListIds = '{{@$questionListIds}}';
        var firstAudioPlayTime = 0;
        var secondAudioPlayTime = parseInt('{{@$secondAudioPlayTime}}');
        var thirdAudioPlayTime = parseInt('{{@$thirdAudioPlayTime}}');
        var forthAudioPlayTime = parseInt('{{@$forthAudioPlayTime}}');
        var examReviewUrl = "{{route('paper-review',[@$studentTestPaper->uuid])}}";
        var ajaxSaveStudentTestUrl = "{{ route('complete-mock') }}";
        var resultUrl = "{{ route('paper-result',[@$studentTestPaper->uuid]) }}";
        var timeArray = @php echo json_encode(@$timeArray) @endphp;
        var inBetweenTime = "{{@$inBetweenTime}}";
        var current_subject_id = "{{@$subjectId}}";
        var updateTestStatus = '{{route("update-test-status")}}';
        var sectionId = "{{@$sectionId}}";
        var subjectIds = [];
        var paperId = "{{$studentTestPaper->id}}";
        subjectIds.push(current_subject_id);
        var saveRemainingTime = "{{route('save-remaining-time')}}";
        var section_taken_time = 0;
        var questionUrl = "{{route('go.to.question')}}";
        var paperName = "{{@$paper->name}}";
    </script>
    <script src="{{asset('js/pdf.min.js')}}"></script>
    <script src="{{asset('js/pdf.worker.js')}}"></script>
    <script src="{{asset('js/pdf-creator.js')}}"></script>
    <script src="{{asset('newfrontend/js/student/mock_exam.js')}}"></script>
    <script>
        $(document).find('#header').click(false);
        $(document).find('.subscibe_sc').click(false);
        $(document).find('.footer').click(false);
        $(document).on('click','#epapersMenu', function(e){
            e.preventDefault();
        });
        $(document).ready(function() {
            var height = $(document).find('#examData').find('.in_qstn_box').height();
            $(document).find('#examData').find('.question_list_scn').css('height',height+'px');
            swal("Please do not refresh or go back data may be lost", {
                icon: 'info',
                closeOnClickOutside: false,
            });
            window.history.pushState(null, "", window.location.href);
            window.onpopstate = function() {
                window.history.pushState(null, "", window.location.href);
            };
            $(window).keydown(function(event){
                if(event.keyCode == 116) {
                    event.preventDefault();
                    return false;
                }
            });
            // window.onbeforeunload = function() {
            //     return "Are you sure you want to leave? it will lost your data";
            // }
        });
        $(document).ready(function(){
            initializePdf();
            if($('#firstAudio').length >0){
                setTimeout(function(){
                document.getElementById("firstAudio").play();
                }, 3000);
            }
            if($('#secondAudio').length >0){
                setTimeout(function(){
                document.getElementById("secondAudio").play();
                }, secondAudioPlayTime);
            }
            if($('#thirdAudio').length >0){
                setTimeout(function(){
                document.getElementById("thirdAudio").play();
                }, thirdAudioPlayTime);
            }
            if($('#forthAudio').length >0){
                setTimeout(function(){
                document.getElementById("forthAudio").play();
                }, forthAudioPlayTime);
            }
          })
    </script>
    @stop