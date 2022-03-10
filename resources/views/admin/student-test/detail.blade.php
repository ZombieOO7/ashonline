@extends('admin.layouts.default')
@section('inc_css')
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
                            <a href="{{route('student_test_papers',[@$studentTest->studentTest->uuid])}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                <span>
                                    <i class="la la-arrow-left"></i>
                                    <span>{{ __('general.back') }}</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="m-portlet__body width_big users_details_scn">
                        <div class="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">
                                        <ul class="ex_tp_dtls" style="background-color: #ebeff7;">
                                            <li>
                                                <label>{{__('formname.student.student_no')}}</label>
                                                <p>{{@$student->ChildIdText}}</p>
                                            </li>
                                            <li>
                                                <label>Attempt</label>
                                                <p>{{@$studentTest->attempt}}</p>
                                            </li>
                                            <li>
                                                <label>Exam Name</label>
                                                <p>{{@$mockTest->title}}</p>
                                            </li>
                                            @if(@$studentTest->stage_id == 1)
                                            <li>
                                                <label>Time Taken</label>
                                                <p>{{@$studentTest->proper_time_taken}}</p>
                                            </li>
                                            @endif
                                            <li>
                                                <label>Date</label>
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
                                                <label>Questions</label>
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
                                                    <button class="btn btn-danger btn-md rounded-circle">
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
                                                    <h1>{{@$studentTest->obtained_marks}}</h1>
                                                    <h5>Your Score</h5>
                                                </span>
                                            </li>
                                            <li class="">
                                                <span class="">
                                                    <h1>{{@$studentTest->total_marks}}</h1>
                                                    <h5>Total Marks</h5>
                                                </span>
                                            </li>
                                            <li class="">
                                                <span class="">
                                                    <h1>{{@$studentTest->overall_result}}%</h1>
                                                    <h5>{{__('formname.overall_result')}}</h5>
                                                </span>
                                            </li>
                                            <li class="">
                                                <span class="">
                                                    <h1 class="text-primary">{{setResultType(@$studentTest->overall_result,$studentTest->mock_test_paper_id)}}</h1>
                                                    <h5>{{__('formname.result_type')}}</h5>
                                                </span>
                                            </li>
                                        @endif
                                        <div class="clearfix"></div>
                                    </ul>
                                    <div class="rtng_b_box">
                                        <img src="{{asset('images/mlt_str.png')}}" alt="">
                                        <h4><span>Your Ranking</span></h4>
                                        <h4><b>{{@$studentTest->rank}}</b><span> out of {{@$totalStudentAttemptTest}}</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($studentTest->studentResult)
                            <div class="col-md-12">
                                <div class="mrks_box mrks_box100">
                                    <h3>Question Analysis</h3>
                                    <p class="mrgn_bt_30">Want to check the answers for the questions you didn’t attempt and the wrong answered ones?</p>
                                    <div class="rspnsv_table">
                                        <div class="col-md-12">
                                            <div class="rspnsv_table rspnsv_table_scrlb">
                                                @if(@$mockTest->stage_id == 1)
                                                    <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd">
                                                        <thead class="cf">
                                                            <tr>
                                                                <th>Section Name</th>
                                                                <th>Total Questions</th>
                                                                <th>Correct Answer</th>
                                                                {{-- @if(@$showResult == true) --}}
                                                                    <th>Action</th>
                                                                {{-- @endif --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($mockTestPaper->mockTestSubjectDetail as $key => $section)
                                                            <tr>
                                                                <td><span class="p-4">{{@$section->name}}</span></td>
                                                                <td>{{@$section->questions}}</td>
                                                                <td>{{@$section->correctAnswerCount(@$studentTestResult->id)}}</td>
                                                                {{-- @if(@$showResult == true) --}}
                                                                    <td width="40%">
                                                                        <a class='txt-dec-none btn btn-info' href="{{route('view-result-questions',['resultId'=>@$studentTestResult->uuid,'sectionId'=>@$section->id,'questionId'=>@$section->id])}}">
                                                                            All Questions</button>
                                                                        </a>
                                                                        <a class='txt-dec-none btn btn-info' href="{{route('view-result-incorrect-questions',['resultId'=>@$studentTestResult->uuid,'sectionId'=>@$section->id,'questionId'=>@$section->id])}}">
                                                                            Incorrect Questions</button>
                                                                        </a>
                                                                    </td>
                                                                {{-- @endif --}}
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
                                                                <th class="thc_3">{{__('formname.q_topic')}}</th>
                                                                <th class="thc_4">Marks</th>
                                                                <th class="thc_5">Obtained Marks</th>
                                                                <th class="thc_6">Answer</th>
                                                                <th class="">{{__('formname.detail')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse (@$questions??[] as $key => $studentTestQuestionAnswer)
                                                            <tr>
                                                                <td data-title="Q No." class="text-center">{{ shortContent(@$studentTestQuestionAnswer->question->question_no)}}</td>
                                                                <td data-title="Questions">{{shortContent(@$studentTestQuestionAnswer->question->question)}}</td>
                                                                <td data-title="Topic">{{shortContent(@$studentTestQuestionAnswer->question->topic->title,15)}}</td>
                                                                {{-- <td data-title="Correct Answer">{!! shortContent(@$studentTestQuestionAnswer->correct_answer_text,15) !!}</td> --}}
                                                                <td data-title="marks">{{@$studentTestQuestionAnswer->question_mark}}</td>
                                                                <td data-title="marks">{{@$studentTestQuestionAnswer->mark_text}}</td>
                                                                <td data-title="Result">{{@config('constant.answer_type')[@$studentTestQuestionAnswer->is_correct]}}</td>
                                                                <td data-title="Detail">
                                                                    <button class="btn btn-primary btn-size rounded-circle">
                                                                        <i class="text-white questionDetail" data-uuid="{{@$studentTestQuestionAnswer->question->uuid}}" data-id="{{@$studentTestQuestionAnswer->uuid}}">
                                                                            <span class="fa fa-eye"></span>
                                                                        </i>
                                                                    </button>
                                                                </td>
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
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END EXAMPLE TABLE POYour RankingRTLET-->
    <!--start question detil modal-->
    <div class="modal fade def_modal lgn_modal" id="questionDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
</div>
</div>
@stop
@section('inc_script')
<script src="{{ asset('backend/js/student-test/index.js') }}" type="text/javascript"></script>
<script>
    var questionDetailUrl = '{{route("report-question-detail")}}';
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
</script>
@stop
