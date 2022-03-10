@extends('newfrontend.layouts.default')
@section('title', __('frontend.exam'))
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
                        <div class="float-left">
                            <ul class="ex_tp_dtls">
                                <li>
                                    <label>{{__('formname.test-assessment.title')}}</label>
                                    <p>{{@$testAssessment->title}}</p>
                                </li>
                                <li>
                                    <label>{{__('formname.subject')}}</label>
                                    <p>{{@$section->subject->title}}</p>
                                </li>
                            </ul>
                        </div>
                        <div class="float-right">
                            <ul class="ex_tp_dtls">
                                <li>
                                    <label>{{__('formname.child_name')}}</label>
                                    <p>{{ @$student->full_name }}</p>
                                </li>
                                <li>
                                    <label>{{__('formname.parent_email')}}</label>
                                    <p>{{ @$student->parents->email }}</p>
                                </li>
                                <li>
                                    <label>{{__('frontend.attempt')}}</label>
                                    <p>{{@$studentTest->studentTotalTestAssessmentAttempt->count()}}</p>
                                </li>
                                <li>
                                    <label>{{__('formname.ip_address')}}</label>
                                    <p>{{ @$ip }}</p>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <ul class="ex_bt_dtls">
                            {{-- <li>
                                <span class="ul_in_info ex_i_01">
                                    <h6><span>{{__('frontend.total_questions')}}</span> <span class='questionNo' data-questionNo="1">{{@$question->question_no}}</span> <span>of</span> {{ @$section->questions }}</h6>
                                </span>
                            </li> --}}
                            <li>
                                <div class="row pl-2 pr-2">
                                    <label>{{__('formname.total_questions')}}</label>&nbsp;:&nbsp;
                                    <label class="font-weight-bold">{{ @$section->questions }}</label>
                                </div>
                            </li>
                            <li>
                                <div class="row pl-2 pr-2">
                                    <label>{{__('formname.attempted')}}</label>&nbsp;:&nbsp;
                                    <label class="font-weight-bold attempted">{{@$attemptedCount??0}}</label>
                                </div>
                            </li>
                            <li class="float-right">
                                <div class="row pl-2 pr-2">
                                    <label>{{__('frontend.time_left')}}</label>&nbsp;:&nbsp;
                                    <label id="timer" class="font-weight-bold">{{ @$timeLeft }}</h6>
                                </div>
                            </li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="col-md-12" id="examData">
                        <form class="qstn_form">
                            <div class="row questionContent">
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
                                        {{-- <h3>{{@$question->questionList->question}}</h3> --}}
                                        <div class="inin_qstn_box mt-3">
                                            <h4><span class='questionNo' data-questionNo="{{@$question->question_no}}">Q{{@$question->question_no}}. </span>{!!@$question->question !!}</h4>
                                            @if(($question->image != null))
                                                @if($question->resize_full_image)
                                                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                                                        {!! @$question->resize_full_image !!}
                                                    </span>
                                                @else
                                                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                                                        <img class="img-fluid mb-3" src="{{@$question->image_path}}">
                                                    </span>
                                                @endif
                                            @endif
                                            <input type="hidden" name='question_list_id' value="{{@$question->id}}" id='questionListId'>
                                            <input type="hidden" name='question_list_id' value="{{@$testQuestionAnswer->id}}" id='testQuestionAnswerId'>
                                                @if(@$question->question_type == 1 && @$question->type == 4)
                                                    @php
                                                        $alphabet = ord("A");
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
                                                                                <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer[]" id="asnwer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                                data-correctAnswerId="{{$question->correctAnswer->id}}" @if(in_array($ans->id,$testQuestionAnswer->selected_answers)) checked @endif>
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
                                                                                <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer[]" id="asnwer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                                data-correctAnswerId="{{$question->correctAnswer->id}}" @if(in_array($ans->id,$testQuestionAnswer->selected_answers)) checked @endif>
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
                                                @elseif($question->question_type == 1)
                                                    @php
                                                        $alphabet = ord("A");
                                                        $answers = @$question->answers??[];
                                                        if($question->answer_type == 2){
                                                            $inputType = 'checkbox';
                                                        }else{
                                                            $inputType = 'radio';
                                                        }
                                                    @endphp
                                                    <ul class="qsa_optns">
                                                        @forelse ($question->answers as $ans)
                                                            <li>
                                                                <div class="optn_bbx">
                                                                    <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer[]" id="asnwer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                    data-correctAnswerId="{{$question->correctAnswer->id}}" @if(in_array($ans->id,$testQuestionAnswer->selected_answers)) checked @endif>
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
                                            <button type="button" class="btn prvs_btn previousQuestion" disabled>{{__('frontend.previous_question')}}</button>
                                        </li>
                                        <li>
                                            <button type="button" class="btn nxt_btn nextQuestion" @if($nextQuestionId == null) disabled @endif 
                                            data-id="{{@$testQuestionAnswer->id}}" data-questionId="{{@$nextQuestionId}}">{{__('frontend.next_question')}}</button>
                                        </li>
                                        <li>
                                            <div class="checkbox agreeckbx markAsReview">
                                                <input type="checkbox" class="dt-checkboxes" id="agreeCheck" @if(@$testQuestionAnswer->mark_as_review == 1) checked @endif>
                                                <label for="agreeCheck">{{__('frontend.mark_for_review')}}</label>
                                            </div>
                                        </li>
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
                                                    if($previewQuestion['mark_as_review'] == 1){
                                                        $class = 'yellow_review_actv';
                                                    }elseif($previewQuestion['is_attempted']== 1){
                                                        $class = 'active_green';
                                                    }else{
                                                        $class = '';
                                                    }
                                                    if($previewQuestion['question_id'] == @$question->id){
                                                        $class2 = 'font-weight-bold';
                                                    }
                                                    // dd($previewQuestion['question_id'] , @$question->id);
                                                @endphp
                                                <li class="quest_lst_n {{$class.' '.$class2}}" data-questionNo="{{@$previewQuestion['q_no']}}" data-id="{{@$testQuestionAnswer->id}}" data-questionId="{{$previewQuestion['id']}}"><span class="q_counter_num {{$class2}}">{{@$previewQuestion['q_no']}}</span>{{@shortContent($previewQuestion['question'],100)}}</li>
                                                @empty
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="text-right mt-4 mb-3">
                <button type="button" data-toggle="modal" data-target='reportProblemModal' class="btn prvs_btn rprt_btn"><img src="{{asset('practice/images/flag_ic.png')}}" alt="">{{__('frontend.report_problem')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade def_modal lgn_modal" id="reportProblemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3>{{__('frontend.report_problem')}}</h3>
                <form class="def_form" id='reportProblem' aria-label="{{ __('frontend.login') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
							<div class="form-group">
                                <textarea name="description" class="form-control" placeholder="Enter Problem" id="problem" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
							<div class="form-group">
								<button type="button" class="btn submit_btn submitReport">{{__('frontend.submit')}}
									<div class="lds-ring" style="display:none;">
										<div></div>
										<div></div>
										<div></div>
									</div>
								</button>
							</div>
						</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade def_modal lgn_modal" id="CompleteMockExamModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3>{{__('frontend.complete_paper')}}</h3>
                <p class="mrgn_bt_40">{{__('frontend.sure_complete_paper')}}</p>
                <div class="mc_pp_bx">
                    <div class="row">
                        <div class="col-md-12 mc_d_b">
                            <div class="d-md-flex align-items-center">
                                <a href="#"><img src="{{@$testAssessment->image_path}}" class="mx-wd-95 img-fluid"></a>
                                <a href="#">
                                    <p class="mdl_txt"> {{@$testAssessment->title}}</p>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-12 inline_action mrgn_tp_15">
                            <a role="button" class="btn submit_btn reviewPaper btn_rvw" data-dismiss="modal" aria-label="Close">{{__('frontend.review_now')}}</a>
                            <a role="button" class="btn submit_btn submitPaper" href="{{route('submit-paper',['resultId'=>@$studentTestResult->uuid])}}">{{__('frontend.submit')}}</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@php
$sessionFlag = Session::put('refresh_flag',false);
@endphp
@stop
@section('pageJs')
<script src="{{asset('js/pdf.min.js')}}"></script>
<script src="{{asset('js/pdf.worker.js')}}"></script>
<script src="{{asset('js/pdf-creator.js')}}"></script>
    <script>
        var storeAnswerUrl = "{{route('store-answer')}}";
        var nextQuestionUrl = "{{route('next-question')}}";
        var previousQuestionUrl = "{{route('previous-question')}}";
        var firstAudioPlayTime = 0;
        var secondAudioPlayTime = parseInt('{{@$secondAudioPlayTime}}');
        var thirdAudioPlayTime = parseInt('{{@$thirdAudioPlayTime}}');
        var forthAudioPlayTime = parseInt('{{@$forthAudioPlayTime}}');
        var examTotalTimeSeconds = parseInt('{{@$examTotalTimeSeconds}}');
        var resultUrl = "{{route('submit-paper',['resultId'=>@$studentTestResult->uuid])}}";
        var examReviewUrl = "{{route('review-paper',['resultId'=>@$studentTestResult->uuid])}}";
        var testAssessmentId = '{{@$testAssessment->id}}';
        var reportProblemUrl = '{{route("report-problem")}}';
        var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
        var getReportProblemUrl = '{{route("get-report-problem")}}';
        var sectionId = "{{$section->id}}";
        var nextSectionId = "{{@$nextSection->uuid}}";
        var nextSectionUrl = "{{route('next.section.detail',['id'=>@$testAssessment->uuid,'sectionId'=>@$nextSection->uuid])}}"
        var section_taken_time = 0;
        var saveRemainingTime = "{{route('save-remaining-time')}}";
        initializePdf();
    </script>
    <script src="{{asset('frontend/practice/js/weekly_exam.js')}}"></script>
@endsection