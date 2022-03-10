@extends('newfrontend.layouts.default')
@section('title', __('frontend.result'))
@section('content')
@php
    $routeArray = [
    [
		'title' => __('frontend.practice'),
		'route' => route('practice'),
	],
    [
		'title' => __('frontend.practice_by_topic'),
		'route' => route('topic-list',['subject'=>'maths']),
	],
    [
		'title' => @$subject->title,
		'route' => route('topic-list',['subject'=>@$subject->slug]),
	],
	[
		'title' => @$practiceExam->title,
		'route' => '#',
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <div class="container mrgn_bt_40">
        <div class="row">
            <div class="col-md-12 prfl_ttl">
                <h3 class="mt-3">{{ @$practiceExam->title }}</h3>
            </div>
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
                                                @forelse($result->testQuestionAnswers??[] as $key => $questionAnswer)
                                                    @php
                                                        $question = $questionAnswer->questionData;
                                                        $alphabet = ord("A");
                                                    @endphp
                                                    <div class="in_qstn_box" data-questionNo="{{$key+1}}">
                                                        @if(@$question->instruction != null)
                                                                {!! @$question->instruction !!}
                                                        @endif
                                                        {!!@$question->question !!}
                                                        @if(($question->image != null))
                                                            <div>
                                                                @if($question->resize_full_image)
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
                                                        @endphp
                                                        @if(@$question->type == 4)
                                                            @php
                                                                $inputType = 'checkbox';
                                                                $answers = @$question->answers??[];
                                                            @endphp
                                                            <div class="col-md-12 row">
                                                                <div class="col-md-6">
                                                                    <ul class="qsa_optns" style="pointer-events: none;">
                                                                        @forelse ($answers as $akey => $ans)
                                                                            @if($akey < 3)
                                                                                <li>
                                                                                    <div class="optn_bbx">
                                                                                        <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer" id="answer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$questionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                                        data-correctAnswerId="{{@$question->correctAnswer->id}}" @if(in_array(@$ans->id,@$questionAnswer->selected_answers)) checked @endif>
                                                                                        <label class="optn_lble @if(in_array(@$ans->id,@$questionAnswer->selected_answers)) selectedAns @endif">
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
                                                                                        <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer" id="answer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$questionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                                        data-correctAnswerId="{{@$question->correctAnswer->id}}" @if(in_array(@$ans->id,@$questionAnswer->selected_answers)) checked @endif>
                                                                                        <label class="optn_lble @if(in_array(@$ans->id,@$questionAnswer->selected_answers)) selectedAns @endif">
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
                                                                        <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer[]" id="answer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$questionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                        data-correctAnswerId="{{@$question->correctAnswer->id}}" @if(in_array(@$ans->id,@$questionAnswer->selected_answers)) checked @endif>
                                                                        <label class="optn_lble @if(in_array(@$ans->id,@$questionAnswer->selected_answers)) selectedAns @endif">
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
                                                @empty
                                                @endforelse
                                            </div>
                                            <div class="col-md-12">
                                                <ul class="action_lst">
                                                    <li>
                                                        <button id='prev' type="button" class="btn prvs_btn previousQuestion" disabled>{{__('frontend.previous_question')}}</button>
                                                    </li>
                                                    <li>
                                                        <button id='next' type="button" class="btn nxt_btn nextQuestion" @if($nextQuestionId == null) disabled @endif 
                                                        data-id="{{@$questionAnswer->id}}" data-questionId="{{@$nextQuestionId}}">{{__('frontend.next_question')}}</button>
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
                <a href="{{route('topic-list', ['subject' => @$subject->slug])}}" class="btn cncl_btn">{{__('frontend.go_to_list')}}</a>
            </div>
        </div>
    </div>
@stop
@php
    $isStudent = 'no';
    if(Auth::guard('parent')->user()){
        $isStudent = 'no';
    }else{
        $isStudent = 'yes';
    }
    $isExam = 'no';
    if(session()->has('isExam')){
        $isExam = session()->get('isExam');
    }
@endphp
@section('pageJs')
    <script type="text/javascript">
    $(document).ready(function(){
        $(".questions .in_qstn_box").each(function(e) {
            if (e != 0)
                $(this).hide();
        });
        $("#next").click(function(){
            if($('.questions .in_qstn_box:visible').next().is(':last-child') == true){
                $("#next").attr('disabled',true);
            }else{
                $("#next").attr('disabled',false);
            }
            if($('.questions .in_qstn_box:visible').next().is(':first-child') == true){
                $("#prev").attr('disabled',true);
            }else{
                $("#prev").attr('disabled',false);
            }

            if ($(".questions .in_qstn_box:visible").next().length != 0){
                $(".questions .in_qstn_box:visible").next().show().prev().hide();
            }else {
                $(".questions .in_qstn_box:visible").hide();
                $(".questions .in_qstn_box:first").show();
            }
            var qNo = $('.questions .in_qstn_box:visible').attr('data-questionNo');
            $('.questionLabel').text(qNo);
            return false;
        });

        $("#prev").click(function(){
            if($('.questions .in_qstn_box:visible').prev().is(':last-child') == true){
                $("#next").attr('disabled',true);
            }else{
                $("#next").attr('disabled',false);
            }
            if($('.questions .in_qstn_box:visible').prev().is(':first-child') == true){
                $("#prev").attr('disabled',true);
            }else{
                $("#prev").attr('disabled',false);
            }
            if ($(".questions .in_qstn_box:visible").prev().length != 0){
                $(".questions .in_qstn_box:visible").prev().show().next().hide();
            }else {
                $(".questions .in_qstn_box:visible").hide();
                $(".questions .in_qstn_box:last").show();
            }
            var qNo = $('.questions .in_qstn_box:visible').attr('data-questionNo');
            $('.questionLabel').text(qNo);
            return false;
        });
    });
    var isExam = '{{@$isExam}}';
    $(document).bind("contextmenu",function(e){
        return false;
    });
    function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };
    $(document).ready(function() {
        if(isExam == 'yes'){

            $(document).on("keydown", disableF5);
            swal("Please do not refresh or go back data may be lost", {
                icon: 'info',
                closeOnClickOutside: false,
            });
            window.history.pushState(null, "", window.location.href);
            window.onpopstate = function() {
                window.history.pushState(null, "", window.location.href);
            };
            function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };
            $(document).ready(function(){
                $(document).on("keydown", disableF5);
            });
        }
    });
    /*profile-upload*/
    $(document).ready(function() {
            $('.optn_bbx input[type="radio"]').change(function() {
                if ($(this).is(':checked')) {
                    $(".action_lst li button").removeAttr("disabled");
                } else {
                    $(".action_lst li button").attr("disabled", "disabled");
                }
            });
        });

    </script>
@stop
