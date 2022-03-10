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
                            <a href="{{ URL::previous() }}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
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
                                                <p>{{@$studentTest->student->ChildIdText}}</p>
                                            </li>
                                            <li>
                                                <label>{{__('formname.attempt')}}</label>
                                                <p>{{@$studentTest->studentTotalTestAssessmentAttempt->count()}}</p>
                                            </li>
                                            <li>
                                                <label>{{__('formname.exam_name')}}</label>
                                                <p>{{@$studentTest->testAssessment->title}}</p>
                                            </li>
                                            <li>
                                                <label>{{__('formname.exam_id')}}</label>
                                                <p>{{@$studentTest->testAssessment->id}}</p>
                                            </li>
                                            <li>
                                                <label>{{__('formname.date')}}</label>
                                                <p>{{@$studentTest->created_at_user_readable??@$studentTest->lastTestAssessmentResult->created_at_user_readable}}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="ex_bt_dtls ex_bt_dtls_v2">
                                        <li>
                                            <span class="ul_in_info ex_i_01">
                                                <h6>{{@$studentTest->questions ?? @$studentTest->lastTestAssessmentResult->questions}}</h6>
                                                <label>{{__('formname.questions')}}</label>
                                            </span>
                                        </li>
                                        <li>
                                            <span class="ul_in_info ex_i_02">
                                                <h6>{{@$studentTest->lastTestAssessmentResult->attempted ?? 0}}</h6>
                                                <label>{{__('formname.attempted')}}</label>
                                            </span>
                                        </li>
                                        <li>
                                            <span class="ul_in_info ex_i_04">
                                                <h6>{{@$studentTest->lastTestAssessmentResult->correctly_answered ?? 0}}</h6>
                                                <label>{{__('formname.correctly_answered')}}</label>
                                            </span>
                                        </li>
                                        <li>
                                            <span class="ul_in_info ex_i_05">
                                                <h6>{{@$studentTest->lastTestAssessmentResult->unanswered ?? 0}}</h6>
                                                <label>{{__('formname.unanswered')}}</label>
                                            </span>
                                        </li>

                                        <li class="float-right">
                                            <span class="ul_in_info_v1">
                                                <label>{{__('formname.marks')}}</label>
                                                <h6>{{@$studentTest->lastTestAssessmentResult->obtained_marks ?? 0}} out of
                                                    {{@$studentTest->total_marks ?? @$studentTest->lastTestAssessmentResult->total_marks ?? 0}}</h6>
                                            </span>
                                        </li>
                                        <li class="float-right">
                                            <span class="ul_in_info_v1">
                                                <label>{{__('formname.overall_result')}}</label>
                                                <h6>{{@$studentTest->lastTestAssessmentResult->overall_result_text ?? 0}}%</h6>
                                            </span>
                                        </li>
                                        <div class="clearfix"></div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- {{dd($studentTest)}} --}}
                        @if(@$studentTest->lastTestAssessmentResult)
                            <div class="col-md-12">
                                <div class="mrks_box mrks_box100">
                                    <h3>{{__('formname.question_analysis')}}</h3>
                                    <p class="mrgn_bt_30">{{__('formname.analysis_label')}}</p>
                                    <div class="rspnsv_table">
                                        <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd" cellspacing="10">
                                            <thead>
                                                {{-- <tr>
                                                    <th>{{__('formname.q_no')}}</th>
                                                    <th>{{__('formname.questions')}}</th>
                                                    <th class="thc_3">{{__('formname.q_topic')}}</th>
                                                    @if(@$studentTest->testAssessment->stage_id == 1)
                                                        <th class="thc_4">{{__('formname.your_ans')}}</th>
                                                    @endif
                                                    <th class="thc_5">{{__('formname.correct_answer')}}</th>
                                                    <th class="thc_6">{{__('formname.result')}}</th>
                                                </tr> --}}
                                                <tr>
                                                    <th>{{__('formname.q_no')}}</th>
                                                    <th>{{__('formname.questions')}}</th>
                                                    <th class="thc_3">{{__('formname.q_topic')}}</th>
                                                    <th class="thc_4">{{__('formname.your_ans')}}</th>
                                                    <th class="thc_5">{{__('formname.correct_answer')}}</th>
                                                    <th class="thc_6">{{__('formname.result')}}</th>
                                                    <th class="">Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $count = 1; @endphp
                                            {{-- {{dd($studentTest->lastTestAssessmentResult)}} --}}
                                            @forelse(@$studentTest->lastTestAssessmentResult->studentTestAssessmentQuestionAnswers as $key => $studentTestQuestionAnswer)
                                                @php
                                                    $correctImage = 'wrng_ic.png';
                                                    if($studentTestQuestionAnswer->is_correct == 1){
                                                        $correctImage = 'ys_ic.png';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td data-title="Q No." class="text-center">{{ shortContent(@$studentTestQuestionAnswer->questionData->question_no)}}</td>
                                                    <td data-title="Questions">{{shortContent(@$studentTestQuestionAnswer->questionData->question)}}</td>
                                                    <td data-title="Topic">{{shortContent(@$studentTestQuestionAnswer->questionData->topic->title,15)}}</td>
                                                    @if($studentTest->testAssessment->stage_id == 1)
                                                        <td data-title="Your Answer">{!! shortContent(@$studentTestQuestionAnswer->selected_answer_text,15) !!}</td>
                                                    @endif
                                                    <td data-title="Correct Answer">{!! shortContent(@$studentTestQuestionAnswer->correct_answer_text,15) !!}</td>
                                                    <td data-title="Result"><img src="{{asset('images/'.@$correctImage)}}"></td>
                                                    <td data-title="Detail">
                                                        <i class="text-primary questionDetail" data-uuid="{{@$studentTestQuestionAnswer->questionData->uuid}}" data-id="{{@$studentTestQuestionAnswer->uuid}}"><span class="fa fa-eye"></span></i>
                                                    </td>
                                                </tr>
                                                @php $count++; @endphp
                                            @empty
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        @endif
                        @if(isset($studentTest) && isset($studentTest->previousStudentAssessmentResult) && count($studentTest->previousStudentAssessmentResult)> 0)
                            @forelse($studentTest->previousStudentAssessmentResult as $studentTestResult)
                                @if(count($studentTestResult->studentTestAssessmentQuestionAnswers)>0)
                                    <div class="col-md-12">
                                        <div class="mrks_box mrks_box100">
                                            <h3>{{@$studentTestResult->proper_date}}</h3>
                                            <div class="rspnsv_table">
                                                <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd" cellspacing="10">
                                                    <thead>
                                                    <tr>
                                                        <th>{{__('formname.q_no')}}</th>
                                                        <th>{{__('formname.questions')}}</th>
                                                        <th class="thc_3">{{__('formname.q_topic')}}</th>
                                                        <th class="thc_4">{{__('formname.your_ans')}}</th>
                                                        <th class="thc_5">{{__('formname.correct_answer')}}</th>
                                                        <th class="thc_6">{{__('formname.result')}}</th>
                                                        <th class="">Detail</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $count = 1; @endphp
                                                    @forelse(@$studentTestResult->studentTestAssessmentQuestionAnswers as $studentTestQuestionAnswer)
                                                    @php
                                                        $correctImage = 'wrng_ic.png';
                                                        if($studentTestQuestionAnswer->is_correct == 1){
                                                            $correctImage = 'ys_ic.png';
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td data-title="Q No." class="text-center">{{ shortContent(@$studentTestQuestionAnswer->questionData->question_no)}}</td>
                                                        <td data-title="Questions">{{shortContent(@$studentTestQuestionAnswer->questionData->question)}}</td>
                                                        <td data-title="Topic">{{shortContent(@$studentTestQuestionAnswer->questionData->topic->title,15)}}</td>
                                                        @if($studentTest->testAssessment->stage_id == 1)
                                                            <td data-title="Your Answer">{!! shortContent(@$studentTestQuestionAnswer->selected_answer_text,15) !!}</td>
                                                        @endif
                                                        <td data-title="Correct Answer">{!! shortContent(@$studentTestQuestionAnswer->correct_answer_text,15) !!}</td>
                                                        <td data-title="Result"><img src="{{asset('images/'.@$correctImage)}}"></td>
                                                        <td data-title="Detail">
                                                            <i class="text-primary questionDetail" data-uuid="{{@$studentTestQuestionAnswer->questionData->uuid}}" data-id="{{@$studentTestQuestionAnswer->uuid}}"><span class="fa fa-eye"></span></i>
                                                        </td>
                                                    </tr>
                                                    @php $count++; @endphp
                                                    @empty
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END EXAMPLE TABLE POYour RankingRTLET-->
</div>
<!--start question detil modal-->
<div class="modal fade show" id="questionDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Question Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="350">
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
@stop
@section('inc_script')
<script>
    var questionDetailUrl = '{{route("assessment-report-question-detail")}}';
</script>
<script src="{{ asset('backend/js/test-assessment-report/index.js') }}" type="text/javascript"></script>
@stop
