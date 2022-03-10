@extends('newfrontend.layouts.default')
@section('title',@$title)
@section('content')
@section('pageCss')
<link rel="stylesheet" href="{{asset('css/pdf.css')}}">
@endsection
@php
    $user = Auth::guard('student')->user();
    $routeArray = [
    [
		'title' => __('frontend.my_profile'),
		'route' => Auth::guard('student')->check()==true?route('student-profile'):route('parent-profile'),
	],
    [
		'title' => Auth::guard('student')->check()==true?'My Mocks':'Purchased Mocks',
		'route' => Auth::guard('student')->check()==true?route('student-mocks'):route('purchased-mocks'),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
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
                                    <li>
                                        <label>{{__('formname.child_name')}}</label>
                                        <p>{{ @$student->full_name }}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="float-right">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>{{__('formname.attempt')}}</label>
                                        <p>{{@$studentTest->attempt}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('formname.mock.exam_name')}}</label>
                                        <p>{{@$mockTest->title}}</p>
                                    </li>
                                    @if($mockTest->stage_id == 1)
                                    <li>
                                        <label>{{__('formname.time_taken')}}</label>
                                        <p>{{@$studentTest->proper_time_taken}}</p>
                                    </li>
                                    @endif
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
                                        <label>{{__('formname.total_questions')}}</label>
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
                                <li class="row">
                                    <div class="">
                                        <button class="btn btn-danger btn-lg rounded-circle">
                                            <span class="fa fa-times fa-md"></span>
                                        </button>
                                    </div>
                                    <div class="">
                                        <span class="ul_in_info pl-4">
                                            <h6>{{@$studentTest->incorrect_answer}}</h6>
                                            <label>{{__('formname.incorrectly_answered')}}</label>
                                        </span>
                                    </div>
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
                                <li class="">
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
                            @if($mockTest->stage_id == 1)
                                @if(@$studentTest->is_greater_then_end_date == true)
                                <div class="rtng_b_box">
                                    <img src="{{asset('images/mlt_str.png')}}" alt="">
                                    <h4><span>{{__('formname.your_ranking')}} For {{date('M Y',strtotime(@$studentTest->created_at))}} </span></h4>
                                    <h4><b>{{@$studentTest->rank}}</b><span> {{__('formname.out_of_rank')}} {{@$totalStudentAttemptTest}}</span></h4>
                                </div>
                                @endif
                                <div class="row col-md-12 mt-3">
                                    <label class="font-weight-bold">{{__('formname.note')}} : </label> {{__('formname.final_rank_note')}}</p>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <div class="mrks_box mrks_box100">
                                <h3>{{__('formname.answers')}}</h3>
                                <p class="mrgn_bt_30">{{__('formname.check_answer_label')}}</p>
                                <div class="col-md-12 row mb-2">
                                    <a class='txt-dec-none' href="{{route('show-guidance')}}">
                                        <button type="button" class="btn submit_btn">{{__('formname.show_guidance')}}</button>
                                    </a>
                                </div>
                                <div class="mb-2" id="examData">
                                    @if(isset($section->passage) && $section->passage_path !=null)
                                        <div class="pdfApp border" data-index="00" data-src="{{@$section->passage_path}}">
                                            <div id="viewport-container00" class="viewport-container" data-index="00"><div role="main" class="viewport" id="viewport00" data-index="00"></div></div>
                                        </div>
                                    @endif
                                </div>
                                <div class="rspnsv_table result_table">
                                    <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd " cellspacing="10">
                                        <thead>
                                        <tr>
                                            <th>{{__('formname.q_no')}}</th>
                                            <th>{{__('formname.questions')}}</th>
                                            <th class="">{{__('formname.detail')}}</th>
                                            <th class="thc_3">{{__('formname.q_topic')}}</th>
                                            @if($mockTest->stage_id == 1)
                                                <th class="thc_4">{{__('formname.your_ans')}}</th>
                                            @endif
                                            <th class="thc_5">{{__('formname.correct_answer')}}</th>
                                            <th class="thc_6">{{__('formname.result')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @php
                                            $count = 1;
                                            $studentTestQuestionAnswers = $studentTestQuestionAnswers??[];
                                        @endphp
                                        @forelse (@$studentTestQuestionAnswers as $key => $studentTestQuestionAnswer)
                                            @php
                                                if($studentTestQuestionAnswer->is_correct == 1){
                                                    $correctImage = 'ys_ic.png';
                                                }else{
                                                    $questionColor = '';
                                                    $correctImage = 'wrng_ic.png';
                                                }
                                            @endphp

                                                <tr>
                                                    <td data-title="Q No." class="text-center">{{ shortContent(@$studentTestQuestionAnswer->question->question_no)}}</td>
                                                    <td data-title="Questions">{{shortContent(@$studentTestQuestionAnswer->question->question)}}</td>
                                                    <td data-title="Detail">
                                                        <button class="btn btn-primary btn-size rounded-circle">
                                                            <i class="text-white questionDetail" data-uuid="{{@$studentTestQuestionAnswer->question->uuid}}" data-id="{{@$studentTestQuestionAnswer->uuid}}">
                                                                <span class="fa fa-eye"></span>
                                                            </i>
                                                        </button>
                                                    </td>
                                                    <td data-title="Topic">{{shortContent(@$studentTestQuestionAnswer->question->topic->title,15)}}</td>
                                                    @if($mockTest->stage_id == 1)
                                                        <td data-title="Your Answer">{!! shortContent(@$studentTestQuestionAnswer->selected_answer_text,15) !!}</td>
                                                    @endif
                                                    <td data-title="Correct Answer">{!! shortContent(@$studentTestQuestionAnswer->correct_answer_text,15) !!}</td>
                                                    <td data-title="Result"><img src="{{asset('images/'.@$correctImage)}}"></td>
                                                </tr>
                                        @php $count++; @endphp
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
                                @if(count($studentTestQuestionAnswers)>0)
                                    {{ $studentTestQuestionAnswers->links('newfrontend.pagination.default') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!--close inner content-->
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
@section('pageJs')
<script src="{{asset('js/pdf.min.js')}}"></script>
<script src="{{asset('js/pdf.worker.js')}}"></script>
<script src="{{asset('js/pdf-creator.js')}}"></script>
<script>
    initializePdf();
</script>
<script>
    $(document).bind("contextmenu",function(e){
        return false;
    });
</script>
<script type="text/javascript">
    var questionDetailUrl = '{{route("question-detail")}}';
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
            global:true,
            success:function(response){
                if(response.status='success'){
                    $('#questionData').html(response.html);
                    $('#questionDetailModal').modal('show');
                }
            },
        })
    })
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
