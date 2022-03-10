@extends('newfrontend.layouts.default')
@section('title', __('frontend.practice'))
@section('content')
<div class="container mrgn_bt_40">
    <div class="row">
        <div class="col-md-12 frtp_ttl">
            <nav class="bradcrumb_pr" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @include('newfrontend.practice.bradcrumb')
                </ol>
            </nav>
        </div>

        <div class="col-md-12 prfl_ttl">
            <h3 class="mt-3">{{ @$testAssessment->testAssessmentSubjectDetail[0]->subject->title }}</h3>
        </div>
        <div class="col-md-12">
            <div class="mn_qs_bx">
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-left">
                            <ul class="ex_tp_dtls">
                                <li>
                                    <label>{{__('frontend.name')}}</label>
                                    <p>{{ @$student->full_name }}</p>
                                </li>
                            </ul>
                        </div>
                        <div class="float-right">
                            <ul class="ex_tp_dtls">
                                <li>
                                    <label>{{__('frontend.attempt')}}</label>
                                    <p>{{@$totalAttemptCount}}</p>
                                </li>
                                <li>
                                    <label>{{__('frontend.paper_name')}}</label>
                                    <p>{{@$testAssessment->title}}</p>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <ul class="ex_bt_dtls">
                            <li>
                                <span class="ul_in_info ex_i_01">
                                    <h6><span>Questions</span> <span class='questionNo' data-questionNo="1">1</span> <span>of</span> {{ @$data->count() }}</h6>
                                </span>
                            </li>

                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <form class="qstn_form">
                            <div class="row questionContent">
                                <div class="col-md-12">
                                    <div class="in_qstn_box">
                                        <h3>{{@$question->questionData->title}}</h3>
                                        {{-- <h3>{{@$question->questionList->question}}</h3> --}}
                                        <div class="inin_qstn_box">
                                            <h4><span class='questionNo' data-questionNo="{{@$questionNo}}">Q 1.</span>{{@$question->question}}</h4>
                                            @php
                                                $alphabet = ord("a");
                                            @endphp
                                            <ul class="qsa_optns">
                                                @if($question->questionData->question_type == 1)
                                                    @forelse ($question->answers as $ans)
                                                        <li>
                                                            <div class="optn_bbx">
                                                                <input class="answer" type="radio" name="asnwer" id="asnwer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                data-correctAnswerId="{{$question->correctAnswer->id}}" @if(@$testQuestionAnswer->answer_id==$ans->id) checked @endif>
                                                                <label><span>{{chr($alphabet)}}</span> {{ @$ans->answer }}</label>
                                                            </div>
                                                        </li>
                                                        @php $alphabet++; @endphp
                                                    @empty
                                                    @endforelse
                                                @endif
                                            </ul>
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
                                        <li class="float-right">
                                            <button type="button" class="btn cmplt_btn completeBtn" data-id="{{@$testQuestionAnswer->id}}" @if($nextQuestionId != null) disabled @endif>{{__('frontend.submit')}}</button>
                                        </li>
                                        <div class="clearfix"></div>
                                    </ul>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            {{-- <div class="text-right mt-4 mb-3">
                <button type="button" class="btn prvs_btn rprt_btn"><img src="{{asset('practice/images/flag_ic.png')}}" alt="">{{__('frontend.report_problem')}}</button>
            </div> --}}
            @if(@$testAssessment->summury != null)
            <div class="inf_bx_wpdng pad_0">
                <h4 class="mrgn_bt_15">{{__('frontend.note')}} :</h4>
                <p>{{@$testAssessment->summury}}</p>
            </div>
            @endif
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
                            <a role="button" class="btn submit_btn submitPaper" href="{{route('submit-paper',['resultId'=>@$studentTestResult->uuid])}}">{{__('frontend.submit')}}</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@stop
@section('pageJs')
    <script>
        var storeAnswerUrl = "{{route('store-answer')}}";
        var nextQuestionUrl = "{{route('next-question')}}";
        var previousQuestionUrl = "{{route('previous-question')}}";
        // disable page refresh and and back button
        function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

        $(document).ready(function(){
            $(document).on("keydown", disableF5);
        });
        $(document).bind("contextmenu",function(e){
            return false;
        });
        $(document).find('#header').click(false);
        $(document).find('.subscibe_sc').click(false);
        $(document).find('.footer').click(false);   
        $(document).on('click','#epapersMenu', function(e){
            e.preventDefault();
        });
        $(document).ready(function() {
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
        });
    </script>
    <script src="{{asset('frontend/practice/js/review_weekly_exam.js')}}"></script>
@endsection