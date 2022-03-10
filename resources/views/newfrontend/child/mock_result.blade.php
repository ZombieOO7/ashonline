@extends('newfrontend.layouts.default')
@section('title',__('formname.result'))
@section('content')
    <!--inner content-->
    <div class="container mrgn_bt_40">
        <div class="row">
            <div class="row col-md-12 prfl_ttl">
                <div class="col-md-3">
                    <h3>{{__('formname.result')}}</h3>
                </div>
                <div class="col-md-9 mt-5">
                    <div class="float-right">
                        @if(Auth::guard('parent')->user())
                            <a class='txt-dec-none' href="{{route('purchased-mock')}}"><button type="button" class="btn submit_btn">{{__('formname.go_to_mock')}}</button></a>
                        @endif
                        @if(Auth::guard('student')->user())
                            <a class='txt-dec-none' href="{{route('student-mocks')}}"><button type="button" class="btn submit_btn">{{__('formname.go_to_mock')}}</button></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mn_qs_bx">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-left">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>{{__('formname.child_id')}}</label>
                                        <p>{{@$student->ChildIdText}}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="float-right">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>{{__('formname.attempt')}}</label>
                                        {{-- <p>{{@$studentTest->attempt_count}}</p> --}}
                                        <p>{{@$studentTest->attempt}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('formname.mock.exam_name')}}</label>
                                        <p>{{@$mockTest->title}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('formname.exam_id')}}</label>
                                        <p>{{@$mockTest->id}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('formname.report.date')}}</label>
                                        <p>{{@$studentTest->created_at_user_readable}}</p>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <ul class="ex_bt_dtls ex_bt_dtls_v2">
                                <li>
                                <span class="ul_in_info ex_i_01">
                                    <h6>{{@$studentTest->questions}}</h6>
                                    <label>{{__('formname.questions')}}</label>
                                </span>
                                </li>
                                <li>
                                <span class="ul_in_info ex_i_02">
                                    <h6>{{@$studentTest->attempted}}</h6>
                                    <label>{{__('formname.attempted')}}</label>
                                </span>
                                </li>
                                <li>
                                <span class="ul_in_info ex_i_04">
                                    <h6>{{@$studentTest->correctly_answered}}</h6>
                                    <label>{{__('formname.correctly_answered')}}</label>
                                </span>
                                </li>
                                <li>
                                <span class="ul_in_info ex_i_05">
                                    <h6>{{@$studentTest->unanswered}}</h6>
                                    <label>{{__('formname.unanswered')}}</label>
                                </span>
                                </li>

                                <li class="float-right">
                                <span class="ul_in_info_v1">
                                    <label>{{__('formname.marks')}}</label>
                                    <h6>{{__('formname.out_of_marks',['obtained_marks'=>@$studentTest->obtained_marks,'total_mark'=>@$studentTest->total_marks])}}</h6>
                                </span>
                                </li>
                                <li class="float-right">
                                <span class="ul_in_info_v1">
                                    <label>{{__('formname.overall_result')}}</label>
                                    <h6>{{@$studentTest->overall_result}}%</h6>
                                </span>
                                </li>
                                <li class="">
                                    <span class="ul_in_info_v1">
                                        <label>{{__('formname.result_type')}}</label>
                                        <h6>{{setResultType(@$studentTest->overall_result,$studentTest->mock_test_paper_id)}}</h6>
                                    </span>
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                            <div class="rtng_b_box">
                                <img src="{{asset('images/mlt_str.png')}}" alt="">
                                <h4><span>{{__('formname.your_ranking')}}</span></h4>
                                <h4><b>{{@$studentTest->rank}}</b><span> {{__('formname.out_of_rank')}} {{@$totalStudentAttemptTest}}</span></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mrks_box">
                            <h3>{{__('formname.answers')}}</h3>
                            <p class="mrgn_bt_30">{{__('formname.check_answer_label')}}</p>
                            <div class="row col-md-12">
                                <div class="col-md-4">
                                    <a class='txt-dec-none' href="{{route('view-questions',[@$mockTest->uuid])}}"><button type="button"
                                            class="btn submit_btn">{{__('formname.view_all_question')}}</button></a>
                                </div>
                                <div class="col-md-4">
                                    <a class='txt-dec-none' href="{{route('view-incorrect-questions',[@$mockTest->uuid])}}"><button type="button"
                                            class="btn submit_btn ml-3">{{__('formname.view_incorrect_question')}}</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!--close inner content-->
@stop
@section('pageJs')
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
        session()->put('isExam','no');
    }
@endphp
<script type="text/javascript">
    var isStudent = "{{$isStudent}}"; 
    var isExam = "{{$isExam}}";
    $(document).bind("contextmenu",function(e){
        return false;
    });
    $(document).ready(function() {
        if(isExam == 'yes'){
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
        $('.optn_bbx input[type="radio"]').change(function(){
            if ($(this).is(':checked')) {
                $(".action_lst li button").removeAttr("disabled");
            } else {
                $(".action_lst li button").attr( "disabled", "disabled" );
            }
        });
    });
</script>
@stop
