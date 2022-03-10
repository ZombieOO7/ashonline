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
                            <a href="{{route('student_test_detail',[@$studentTest->uuid])}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
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
                                            <li>
                                                <label>Time Taken</label>
                                                <p>{{@$studentTest->proper_time_taken}}</p>
                                            </li>
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
                                        <li>
                                            <span class="ul_in_info ex_i_02">
                                                <h6>{{@$studentTest->attempted ?? 0}}</h6>
                                                <label>Attempted</label>
                                            </span>
                                        </li>
                                        <li>
                                            <span class="ul_in_info ex_i_04">
                                                <h6>{{@$studentTest->correctly_answered ?? 0}}</h6>
                                                <label>Correctly Answered</label>
                                            </span>
                                        </li>
                                        <li>
                                            <span class="ul_in_info ex_i_05">
                                                <h6>{{@$studentTest->unanswered ?? 0}}</h6>
                                                <label>Unanswered</label>
                                            </span>
                                        </li>

                                        <li class="float-right">
                                            <span class="ul_in_info_v1">
                                                <label>Marks</label>
                                                <h6>{{@$studentTest->obtained_marks ?? 0}} out of
                                                    {{@$studentTest->total_marks ?? 0}}</h6>
                                            </span>
                                        </li>
                                        <li class="float-right">
                                            <span class="ul_in_info_v1">
                                                <label>Overall Result</label>
                                                <h6>{{@$studentTest->overall_result ?? 0}}%</h6>
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
                                    <div class="col-md-12 row mb-2">
                                        @if(isset($questionData->questionPdfs->question_pdf))
                                            <div class="form-group m-form__group row col-md-12">
                                                <embed src="{{@$questionData->questionPdfs->question_pdf}}" type="application/pdf" width="100%" height="400px" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="rspnsv_table">
                                        <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd" cellspacing="10">
                                            <thead>
                                                <tr>
                                                    <th>Q No.</th>
                                                    <th>Questions</th>
                                                    <th class="">Detail</th>
                                                    <th class="thc_3">Topic</th>
                                                    @if($mockTest->stage_id == 1)
                                                        <th class="thc_4">Your Answer</th>
                                                    @endif
                                                    <th class="thc_5">Correct Answer</th>
                                                    <th class="thc_6">Result</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $count = 1; @endphp
                                            @forelse(@$studentTestQuestionAnswers as $key => $studentTestQuestionAnswer)
                                                @php
                                                    $correctImage = 'wrng_ic.png';
                                                    if($studentTestQuestionAnswer->is_correct == 1){
                                                        $correctImage = 'ys_ic.png';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td data-title="Q No." class="text-center">{{ shortContent(@$studentTestQuestionAnswer->question->question_no)}}</td>
                                                    <td data-title="Questions">{{shortContent(@$studentTestQuestionAnswer->question->question)}}</td>
                                                    <td data-title="Detail">
                                                        <i class="text-primary questionDetail" data-uuid="{{@$studentTestQuestionAnswer->question->uuid}}" data-id="{{@$studentTestQuestionAnswer->uuid}}"><span class="fa fa-eye"></span></i>
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
                                            @endforelse
                                            </tbody>
                                        </table>
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END EXAMPLE TABLE POYour RankingRTLET-->
    <!--start question detil modal-->
    <div class="modal fade show" id="questionDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="min-height: 650px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Question Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="500">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="" id="questionData">
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
<script>
    var questionDetailUrl = '{{route("report-question-detail")}}';
</script>
<script src="{{ asset('backend/js/student-test/index.js') }}" type="text/javascript"></script>
@stop
