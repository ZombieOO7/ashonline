@extends('newfrontend.layouts.default')
@section('title',__('formname.result'))
@section('content')
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
                            {{-- <div class="float-left"> --}}
                            <div class="">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>{{__('formname.child_id')}}</label>
                                        <p>{{@$student->ChildIdText}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('formname.child_name')}}</label>
                                        <p>{{@$student->full_name}}</p>
                                    </li>
                                {{-- </ul>
                            </div>
                            <div class="float-right">
                                <ul class="ex_tp_dtls"> --}}
                                    <li>
                                        <label>{{__('formname.attempt')}}</label>
                                        <p>{{@$studentTest->attempt}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('formname.mock.exam_name')}}</label>
                                        <p>{{@$mockTest->title}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('formname.paper_name')}}</label>
                                        <p>{{@$mockTestPaper->name}}</p>
                                    </li>
                                    @if(@$mockTest->stage_id == 1)
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
                                @if($mockTest->stage_id == 1)
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
                                                <span class="fa fa-times"></span>
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
                                @endif
                                @if($mockTest->stage_id == 1)
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
                                @else
                                    <li class="">
                                        <span class="">
                                            <h6>{{@$studentTest->obtained_marks}}</h6>
                                            <h6>Your Score</h6>
                                        </span>
                                    </li>
                                    <li class="">
                                        <span class="">
                                            <h6>{{@$studentTest->total_marks}}</h6>
                                            <h6>Total Marks</h6>
                                        </span>
                                    </li>
                                    <li class="">
                                        <span class="">
                                            <h6>{{@$studentTest->overall_result}}%</h6>
                                            <h6>{{__('formname.overall_result')}}</h6>
                                        </span>
                                    </li>
                                    <li class="">
                                        <span class="">
                                            <h6 class="text-primary">{{setResultType(@$studentTest->overall_result,$studentTest->mock_test_paper_id)}}</h6>
                                            <h6>{{__('formname.result_type')}}</h6>
                                        </span>
                                    </li>
                                @endif
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
                    </div>
                    <div class="col-md-12">
                        @if(@$mockTest->stage_id == 2 && $studentTest->evaluate_count < 2)
                        <div class="row m-3">
                            <a href="{{route('evaluation',['uuid'=>@$studentTest->uuid])}}" class="txt-dec-none">
                                <button class="btn submit_btn">Reevaluate</button>
                            </a>
                        </div>
                        @endif
                        <div class="mrks_box mrks_box100">
                            <h3>{{__('formname.answers')}}</h3>
                            <p class="mrgn_bt_30">{{__('formname.check_answer_label')}}</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="rspnsv_table rspnsv_table_scrlb">
                                        @if(@$mockTest->stage_id == 1)
                                            <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd">
                                                <thead class="cf">
                                                    <tr>
                                                        <th>Section Name</th>
                                                        <th>Total Questions</th>
                                                        <th>Correct Answer</th>
                                                        @if(@$showResult == true)
                                                            <th>Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($mockTestPaper->mockTestSubjectDetail as $key => $section)
                                                        <tr>
                                                            <td><span class="p-4">{{@$section->name}}</span></td>
                                                            <td>{{@$section->questions}}</td>
                                                            <td>{{@$section->correctAnswerCount(@$studentTestResults->id)}}</td>
                                                            @if(@$showResult == true)
                                                                <td width="40%">
                                                                    <a class='txt-dec-none' href="{{route('view-questions',['resultId'=>@$studentTestResults->uuid,'sectionId'=>@$section->id])}}">
                                                                        <button type="button" class="drk_blue_btn mt-0">All Questions</button>
                                                                    </a>
                                                                    <a class='txt-dec-none' href="{{route('view-incorrect-questions',['resultId'=>@$studentTestResults->uuid,'sectionId'=>@$section->id])}}">
                                                                        <button type="button" class="drk_blue_btn ml-3 mt-0">Incorrect Questions</button>
                                                                    </a>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        @else
                                            <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd">
                                                <thead class="cf">
                                                    <tr>
                                                        <th>{{__('formname.q_no')}}</th>
                                                        <th>{{__('formname.questions')}}</th>
                                                        <th class="">{{__('formname.detail')}}</th>
                                                        <th class="thc_3">{{__('formname.q_topic')}}</th>
                                                        <th class="thc_4">Question Marks</th>
                                                        <th class="thc_5">Obtained Marks</th>
                                                        <th class="thc_6">Answer</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse (@$questions??[] as $key => $studentTestQuestionAnswer)
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
                                                        {{-- <td data-title="Correct Answer">{!! shortContent(@$studentTestQuestionAnswer->correct_answer_text,15) !!}</td> --}}
                                                        <td data-title="marks">{{@$studentTestQuestionAnswer->question_mark}}</td>
                                                        <td data-title="marks">{{@$studentTestQuestionAnswer->mark_text}}</td>
                                                        <td data-title="Result">{{@config('constant.answer_type')[@$studentTestQuestionAnswer->is_correct]}}</td>
                                                    </tr>
                                                    @empty
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <div class="tb_bt_actn">
                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        @if(count($questions)>0)
                                                            {{ $questions->links('newfrontend.pagination.default') }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
                                    <a class='txt-dec-none' href="{{route('view-questions',[@$studentTest->uuid])}}"><button type="button"
                                            class="btn submit_btn">{{__('formname.view_all_question')}}</button></a>
                                </div>
                                <div class="col-md-4">
                                    <a class='txt-dec-none' href="{{route('view-incorrect-questions',[@$studentTest->uuid])}}"><button type="button"
                                            class="btn submit_btn ml-3">{{__('formname.view_incorrect_question')}}</button></a>
                                </div> --}}
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
<script>
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
            success:function(response){
                if(response.status='success'){
                    $('#questionData').html(response.html);
                }
            },
        })
        $('#questionDetailModal').modal('show');
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
