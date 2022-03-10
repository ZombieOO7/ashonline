@extends('newfrontend.layouts.default')
@section('title', __('frontend.result'))
@section('pageCss')
    {{-- <meta http-equiv="refresh" content="0; url={{route('student-mocks')}}"> --}}
    <link rel="stylesheet" href="{{asset('css/pdf.css')}}">
@endsection
@php
    $routeArray = [
        [
            'title' => __('frontend.practice'),
            'route' => route('practice'),
        ],
        [
            'title' => __('frontend.practice_by_week'),
            'route' => route('weekly-assessments',['slug'=> @$subject->slug,'studentId'=>@$student->uuid]),
        ],
        [
            'title' => @$testAssessment->testAssessmentSubjectDetail[0]->subject->title,
            'route' => route('weekly-assessments',['slug'=>@$testAssessment->testAssessmentSubjectDetail[0]->subject->slug,'studentId' => @$studentId]),
        ],
        [
            'title' => __('frontend.review_lbl2'),
            'route' => route('review-test-result',['uuid'=>@$studentTest->uuid]),
        ],
        [
            'title' => __('frontend.result'),
            'route' => '#',
        ],
    ];
    $subject = subject();
@endphp
@section('content')
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <div class="container mrgn_bt_40">
        <div class="row">
            <div class="col-md-12 prfl_ttl">
                <h3 class="mt-3">{{__('frontend.result')}}</h3>
            </div>
            <div class="col-md-12">
                <div class="mn_qs_bx">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-left">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>{{__('formname.child_id')}}</label>
                                        <p>{{ @$student->child_id_text }}</p>
                                    </li>
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
                                        <p>{{@$totalAttemptCount ?? 1}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('frontend.assessment_name')}}</label>
                                        <p>{{@$testAssessment->title}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('frontend.date')}}</label>
                                        <p>{{@$result->proper_date}}</p>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <ul class="ex_bt_dtls ex_bt_dtls_v2">
                                <li>
                                    <span class="ul_in_info ex_i_01">
                                        <h6>{{@$result->questions}}</h6>
                                        <label>{{__('frontend.questions')}}</label>
                                    </span>
                                </li>
                                <li>
                                    <span class="ul_in_info ex_i_02">
                                        <h6>{{@$result->attempted}}</h6>
                                        <label>{{__('frontend.attempted')}}</label>
                                    </span>
                                </li>
                                <li>
                                    <span class="ul_in_info ex_i_04">
                                        <h6>{{@$result->correctly_answered}}</h6>
                                        <label>{{__('frontend.correctly_answered')}}</label>
                                    </span>
                                </li>
                                <li>
                                    <span class="ul_in_info ex_i_05">
                                        <h6>{{@$result->unanswered}}</h6>
                                        <label>{{__('frontend.unanswered')}}</label>
                                    </span>
                                </li>

                                <li class="float-right">
                                    <span class="ul_in_info_v1">
                                        <label>{{__('frontend.marks')}}</label>
                                        <h6>{{__('frontend.out_of_marks',['obtained_marks'=>@$result->obtained_marks,'total_mark'=>@$result->total_marks])}}</h6>
                                    </span>
                                </li>
                                <li class="float-right">
                                    <span class="ul_in_info_v1">
                                        <label>{{__('frontend.overall_result')}}</label>
                                        <h6>{{@$result->overall_result}}%</h6>
                                    </span>
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                            <div class="mrks_box mrks_box100">
                                <h3>{{__('formname.answers')}}</h3>
                                <p class="mrgn_bt_30">{{__('formname.check_answer_label')}}</p>
                                <div class="col-md-12 row mb-2">
                                    <a class='txt-dec-none' href="{{route('show-guidance')}}">
                                        <button type="button" class="btn submit_btn">{{__('formname.show_guidance')}}</button>
                                    </a>
                                </div>
                                <div class="rspnsv_table result_table">
                                    <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd " cellspacing="10">
                                        <thead>
                                        <tr>
                                            <th>{{__('formname.q_no')}}</th>
                                            <th>{{__('formname.questions')}}</th>
                                            <th class="">{{__('formname.detail')}}</th>
                                            <th class="thc_3">{{__('formname.q_topic')}}</th>
                                            {{-- @if($mockTest->stage_id == 1) --}}
                                                <th class="thc_4">{{__('formname.your_ans')}}</th>
                                            {{-- @endif --}}
                                            <th class="thc_5">{{__('formname.correct_answer')}}</th>
                                            <th class="thc_6">{{__('formname.result')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse (@$testQuestionAnswers as $key => $studentTestQuestionAnswer)
                                                @php
                                                    if($studentTestQuestionAnswer->is_correct == 1){
                                                        $correctImage = 'ys_ic.png';
                                                    }else{
                                                        $questionColor = '';
                                                        $correctImage = 'wrng_ic.png';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td data-title="Q No." class="text-center">{{ shortContent(@$studentTestQuestionAnswer->questionData->question_no)}}</td>
                                                    <td data-title="Questions">{{shortContent(@$studentTestQuestionAnswer->questionData->question)}}</td>
                                                    <td data-title="Detail">
                                                        <i class="text-primary questionDetail" data-uuid="{{@$studentTestQuestionAnswer->questionData->uuid}}" data-id="{{@$studentTestQuestionAnswer->uuid}}"><span class="fa fa-eye"></span></i>
                                                    </td>
                                                    <td data-title="Topic">{{shortContent(@$studentTestQuestionAnswer->questionData->topic->title,15)}}</td>
                                                    {{-- @if($mockTest->stage_id == 1) --}}
                                                        <td data-title="Your Answer">{!! shortContent(@$studentTestQuestionAnswer->selected_answer_text,15) !!}</td>
                                                    {{-- @endif --}}
                                                    <td data-title="Correct Answer">{!! shortContent(@$studentTestQuestionAnswer->correct_answer_text,15) !!}</td>
                                                    <td data-title="Result"><img src="{{asset('images/'.@$correctImage)}}"></td>
                                                </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">{{__('formname.question_not_found')}}</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tb_bt_actn">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                {{ @$testQuestionAnswers->links('newfrontend.pagination.default')}}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
    </div>
    <!--start question detil modal-->
    <div class="modal fade def_modal lgn_modal" id="questionDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3>Question Detail</h3>
                    {{--  <p class="mrgn_bt_40">Do you want to attempt next Section ?</p>  --}}
                    <div class="mc_pp_bx">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mc_p_dd_b mc_brdr_nn" id="questionData">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end question detil modal-->
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
<script src="{{asset('js/pdf.min.js')}}"></script>
<script src="{{asset('js/pdf.worker.js')}}"></script>
<script src="{{asset('js/pdf-creator.js')}}"></script>
<script>
    var isExam = '{{@$isExam}}';
    $(document).bind("contextmenu",function(e){
        return false;
    });
    function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };
    $(document).ready(function() {
        if(isExam == 'yes'){

            $(document).on("keydown", disableF5);
            // swal("Please do not refresh or go back data may be lost", {
            //     icon: 'info',
            //     closeOnClickOutside: false,
            // });
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
        $('.optn_bbx input[type="radio"]').change(function(){
            if ($(this).is(':checked')) {
                $(".action_lst li button").removeAttr("disabled");
            } else {
                $(".action_lst li button").attr( "disabled", "disabled" );
            }
        });
    });
    $(document).on('click','.questionDiv',function(){
        var target = $('#pills-tabContent');
        if (target.length) {
            $('html,body').animate({
                scrollTop: target.offset().top - 100
            }, 1000);
            return false;
        }
    });
    initializePdf();
    var questionDetailUrl = '{{route("assessment-question-detail")}}';
    $('.questionDetail').on('click',function(){
        var uuid = $(this).attr('data-uuid');
        var id = $(this).attr('data-id');
        $.ajax({
            url:questionDetailUrl,
            method:'POST',
            data:{
                uuid:uuid,
                id:id,
            },
            success:function(response){
                if(response.status='success'){
                    $('#questionData').html(response.html);
                    $('#questionDetailModal').modal('show');
                }
            },
        })
    })
</script>
@endsection
