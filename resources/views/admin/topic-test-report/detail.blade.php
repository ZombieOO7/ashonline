@extends('admin.layouts.default')
@section('inc_css')
<style>
    .selectedAns{
        border: 1px solid #000 !important;
        background-color: #212121 !important;
        color: #fff !important;
    }
    .correctAns{
        border: 1px solid #4CAF50 !important;
        background-color: #4CAF50 !important;
        color: #fff !important;
    }
    .inCorrectAns{
        border: 1px solid #F44336 !important;
        background-color: #F44336 !important;
        color: #fff !important;
    }
</style>
<link href="{{asset('newfrontend/css/custom.css')}}" rel="stylesheet">
@endsection
@section('content')
@section('title', __('formname.student.student_test_detail'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                @include('admin.includes.flashMessages')
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"
                id="main_portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-wrapper">
                            <div class="m-portlet__head-caption">
                                <h3 class="m-portlet__head-text">{{__('formname.student.test_detail')}} </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <a href="{{ URL::previous() }}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                <span>
                                    <i class="la la-arrow-left"></i>
                                    <span>{{ __('general.back') }}</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="m-portlet__body width_big users_details_scn">
                        <div class="col-md-12 prfl_ttl">
                            <h3 class="mt-3">{{ @$topic->title }}</h3>
                        </div>
                        <div class="row">
                            <div class="col-xl-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mn_qs_bx">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul class="ex_bt_dtls">
                                                        <li>
                                                            <span class="ul_in_info ex_i_01">
                                                                <h6>
                                                                    <span>{{__('frontend.questions')}}</span> 
                                                                    <span class='questionLabel'>1</span> 
                                                                    <span>of</span>{{ @$result->questions }}
                                                                </h6>
                                                            </span>
                                                        </li>

                                                        <div class="clearfix"></div>
                                                    </ul>
                                                </div>
                                                <div class="col-md-12">
                                                    <form class="qstn_form">
                                                        <div class="row questionContent">
                                                            <div class="col-md-12 questions">
                                                                @forelse($result->testQuestionAnswers as $key => $questionAnswer)
                                                                    @php
                                                                        $question = $questionAnswer->questionList;
                                                                    @endphp
                                                                    <div class="in_qstn_box" data-questionNo="{{$key+1}}">
                                                                        @if(isset($question->questionData->questionPdfs->question_pdf))
                                                                        <embed src="{{@$question->questionData->questionPdfs->question_pdf}}" type="application/pdf" width="100%" height="400px" />
                                                                        @endif
                                                                        @if(isset($question->questionData->questionImages->question_image))
                                                                            <img class="img-fluid" src="{{@$question->questionData->questionImages->question_image}}" width="100%" height="400px" >
                                                                        @endif
                                                                        @if(@$question->instruction != null)
                                                                            <h3>{{ @$question->instruction }}</h3>
                                                                        @endif
                                                                        {{-- <h3>{{@$question->questionList->question}}</h3> --}}
                                                                        <div class="inin_qstn_box mt-3">
                                                                            <h4><span class='questionNo' data-questionNo="{{$key+1}}">Q {{$key+1}}.</span>{{@$question->question}}</h4>
                                                                            @if(isset($question->questionList->image_path) && ($question->questionList->image_path != null))
                                                                                <img class="img-fluid mb-3" src="{{@$question->questionList->image_path}}" width="auto" height="300px" >
                                                                            @endif
                                                                            @php
                                                                                $alphabet = ord("a");
                                                                            @endphp
                                                                            <ul class="qsa_optns">
                                                                                @if($question->questionData->question_type == 1)
                                                                                    @forelse ($question->answers as $ans)
                                                                                    @php
                                                                                        $class='';
                                                                                        // if(@$answer->is_correct == 1){
                                                                                            // $class='correctAns';
                                                                                        if($questionAnswer->answer_id == $ans->id && @$ans->is_correct == 1){
                                                                                            // $class='inCorrectAns';
                                                                                            $class='correctAns';
                                                                                        }elseif($questionAnswer->answer_id == $ans->id){
                                                                                            $class='inCorrectAns';
                                                                                        }else{
                                                                                            $class='';
                                                                                        }
                                                                                    @endphp
                                                                                        <li>
                                                                                            <div class="optn_bbx">
                                                                                                <input class="answer" type="radio" name="asnwer" id="asnwer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                                                data-correctAnswerId="{{$question->correctAnswer->id}}" disabled>
                                                                                                <label class='{{$class}}'><span>{{chr($alphabet)}}</span> {{ @$ans->answer }}</label>
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
                                                                @empty
                                                                @endforelse
                                                            </div>
                                                            <div class="col-md-12">
                                                                <ul class="action_lst">
                                                                    <li>
                                                                        <button id='prev' type="button" class="btn prvs_btn previousQuestion" disabled>{{__('frontend.previous_question')}}</button>
                                                                    </li>
                                                                    <li>
                                                                        <button id='next' type="button" class="btn nxt_btn nextQuestion" @if(count($result->testQuestionAnswers) == 1) disabled @endif 
                                                                        data-id="{{@$testQuestionAnswer->id}}" data-questionId="{{@$nextQuestionId}}">{{__('frontend.next_question')}}</button>
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <ul class="qsrslt_lst">
                                    @forelse($result->testQuestionAnswers as $key => $questionAns)
                                        @php
                                            if($questionAns->is_attempted == 0)
                                                $class = 'unfl_ans_li';
                                            elseif($questionAns->is_correct == 1)
                                                $class = 'right_ans_li';
                                            else
                                                $class = 'wrng_ans_li';
                                        @endphp
                                        <li class="{{$class}}">{{$key+1}}</li>
                                    @empty
                                    @endforelse
                                </ul>
                                {{-- <a href="{{route('topic-list', ['subject' => @$subject->slug])}}" class="btn cncl_btn">{{__('frontend.go_to_list')}}</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END EXAMPLE TABLE POYour RankingRTLET-->
</div>
</div>
@stop
@section('inc_script')
<script src="{{ asset('backend/js/student-test/index.js') }}" type="text/javascript"></script>
<script>
    $(document).find(".questions .in_qstn_box").each(function(e) {
        if (e != 0)
            $(this).hide();
    });
    $(document).find("#next").click(function(){
        if($(document).find('.questions .in_qstn_box:visible').next().is(':last-child') !== false){
            $(document).find("#next").attr('disabled',true);
        }else{
            $(document).find("#next").attr('disabled',false);
        }
        if($(document).find('.questions .in_qstn_box:visible').next().is(':first-child') !== false){
            $(document).find("#prev").attr('disabled',true);
        }else{
            $(document).find("#prev").attr('disabled',false);
        }

        if ($(document).find(".questions .in_qstn_box:visible").next().length != 0){
            $(document).find(".questions .in_qstn_box:visible").next().show().prev().hide();
        }else {
            $(document).find(".questions .in_qstn_box:visible").hide();
            $(document).find(".questions .in_qstn_box:first").show();
        }
        var qNo = $(document).find('.questions .in_qstn_box:visible').attr('data-questionNo');
        $(document).find('.questionLabel').text(qNo);
        return false;
    });

    $(document).find("#prev").click(function(){
        if($(document).find('.questions .in_qstn_box:visible').prev().is(':last-child') !== false){
            $(document).find("#next").attr('disabled',true);
        }else{
            $(document).find("#next").attr('disabled',false);
        }
        if($(document).find('.questions .in_qstn_box:visible').prev().is(':first-child') !== false){
            $(document).find("#prev").attr('disabled',true);
        }else{
            $(document).find("#prev").attr('disabled',false);
        }
        if ($(document).find(".questions .in_qstn_box:visible").prev().length != 0){
            $(document).find(".questions .in_qstn_box:visible").prev().show().next().hide();
        }else {
            $(document).find(".questions .in_qstn_box:visible").hide();
            $(document).find(".questions .in_qstn_box:last").show();
        }
        var qNo = $(document).find('.questions .in_qstn_box:visible').attr('data-questionNo');
        $(document).find('.questionLabel').text(qNo);
        return false;
    });
</script>
@stop
