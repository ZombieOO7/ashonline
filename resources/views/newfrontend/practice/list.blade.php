@extends('newfrontend.layouts.default')
@section('title', __('frontend.practice_by_week'))
@section('content')
@php
    $routeArray = [
        [
            'title' => __('frontend.practice'),
            'route' => route('practice'),
        ],
        [
            'title' => __('frontend.practice_by_week'),
            'route' => route('weekly-assessments',['slug'=> @$slug,'studentId'=>@$uuid]),
        ],
    ];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
@php
$parentData = parentData();
$parent = @$parentData[0];
$isParent = @$parentData[1];
$currentDate = date('Y-m-d');
$previous2weekDate = date('Y-m-d',strtotime("-2 week"));
@endphp
<section class="mock_papers">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3 class="df_h3 mdl_tilte">{{ @$homePracticeSection->title}}</h3>
                <p class="df_pp w-960">{!! @$homePracticeSection->content !!}</p>
            </div>
            <div class="col-md-12 wktas_tp_sc mb-5">
                <h4>Informations</h4>
                <ul class="bnr_in_list">
                    {!! @$homePracticeSection->note !!}
                </ul>
            </div>
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                            @if($isParent== true)
                                @forelse(@$parent->childs as $key => $child)
                                    <li class="nav-item">
                                        <a class="nav-link e-mck-btn e-mck-btn-child @if($studentId==$child->id)active @endif" href="{{route('weekly-assessments',['slug'=>@$slug,'studentId'=>@$child->uuid])}}">
                                            <span class="pbwa_ic pbwa_ic01" style="background: url('{{@$child->image_thumb}}') !important;background-size: 50px !important;border-radius: 25px;"></span>
                                            {{@$child->full_name}}
                                        </a>
                                    </li>
                                @empty
                                @endforelse
                            @endif
                        </ul>
                        <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                            @forelse($subjects as $key => $subject)
                                    <li class="nav-item">
                                        <a class="nav-link e-mck-btn e-mck-btn-v2 @if($slug==@$subject->slug)active @endif" id="{{@$subject->slug}}-tab"
                                            href="{{route('weekly-assessments',['slug'=>@$subject->slug,'studentId'=>@$uuid])}}" aria-controls="{{@$subject->slug}}" aria-selected="true">
                                            <span class="pbwa_ic pbwa_ic01"></span>
                                            {{@$subject->title}}
                                        </a>
                                    </li>
                                @empty
                                @endforelse
                            {{-- <li class="nav-item"><a href="#" class="e-mck-btn e-mck-btn-v2 vwprvsdt_btn">VIEW PREVIOUS
                                    DATA</a></li> --}}
                        </ul>
                        <div class="col-md-12 mt-3">
                            <ul class="clr_info_lst">
                                <li><span class="ans_crcl"></span>Current Week</li>
                                <li><span class="ans_unnsrd"></span>Last Two Week</li>
                                <li><span class="ans_incrcl"></span>Expired</li>
                            </ul>
                        </div>
                        <div class="tab-content mt-4 mb-4" id="pills-tabContent">
                            {{-- @forelse($subjects as $key => $subject) --}}
                                    <div class="tab-pane fade show active " id="{{@$subjectData->slug}}" role="tabpanel" aria-labelledby="{{@$subjectData->slug}}-tab">
                                        <div class="rspnsv_table rspnsv_table_allinfo">
                                            <table class="table-bordered table-striped table-condensed cf v-align-bottom sm_txt_tbl">
                                                <thead class="cf">
                                                    <tr>
                                                        <th>{{__('frontend.papers_lbl')}}</th>
                                                        <th>{{__('frontend.issue_date')}}</th>
                                                        <th>{{__('frontend.attempt_by')}}</th>
                                                        <th>{{__('frontend.expiry_date')}}</th>
                                                        <th>{{__('frontend.total_attempt_1')}}</th>
                                                        <th>{{__('frontend.out_of_attempt_1')}}</th>
                                                        <th>{{__('frontend.percentage_attempt_1')}}</th>
                                                        <th>{{__('frontend.total_attempt_1')}}</th>
                                                        <th>{{__('frontend.out_of_attempt_1')}}</th>
                                                        <th>{{__('frontend.percentage_attempt_1')}}</th>
                                                        <th>{{__('frontend.status')}}</th>
                                                        <th>{{__('frontend.action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($subjectData->allAssessment(@$studentId)??[] as $key => $weekAssessment)
                                                        <tr class="{{$weekAssessment->class}}">
                                                            @php
                                                                $studentTest = @$weekAssessment->studentAssessment($studentId);
                                                                $studentTestResult = @$studentTest->twoPracticeTestResult;
                                                                $firstResult = @$studentTestResult[0];
                                                                $secondResult = @$studentTestResult[1];
                                                                // $thirdResult = @$studentTestResult[2];
                                                            @endphp
                                                            <td data-title="Papers">{{@$weekAssessment->title}}</td>
                                                            <td data-title="Date">{{@$weekAssessment->start_date_month}}</td>
                                                            <td data-title="Date">{{@$weekAssessment->end_date_month}}</td>
                                                            <td data-title="Date">{{@$weekAssessment->expiry_date}}</td>
                                                            <td data-title="TotalAttempt 1">{{@$firstResult->total_marks ?? '-'}}</td>
                                                            <td data-title="Out ofAttempt 1">{{@$firstResult->obtained_marks ?? '-'}}</td>
                                                            <td data-title="PercentageAttempt 1">{{@$firstResult->overall_result_per ?? '-'}}</td>
                                                            <td data-title="TotalAttempt 2">{{@$secondResult->total_marks ?? '-'}}</td>
                                                            <td data-title="Out ofAttempt 2">{{@$secondResult->obtained_marks ?? '-'}}</td>
                                                            <td data-title="PercentageAttempt 2">{{@$secondResult->overall_result_per ?? '-'}}</td>
                                                            <td data-title="Status">
                                                                {{$weekAssessment->assessment_status}}
                                                            </td>
                                                            <td data-title="Action">
                                                                @if($firstResult == NULL || $secondResult == NULL)
                                                                    @if($weekAssessment->action_flag == true)
                                                                        <a href="{{route('assessments-detail',['testAssessmentId'=>@$weekAssessment->uuid])}}" class="btn btn-light btn-md text-white">{{__('frontend.start')}}</a>
                                                                    @endif
                                                                @endif
                                                                @if($firstResult != NULL)
                                                                    <a href="{{route('review-test-result',['uuid'=>@$studentTest->uuid])}}" class="tbl_btn @if($studentTestResult == null) unread_tr @endif">{{__('frontend.review_lbl')}}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="15" class="">{{__('formname.records_not_found')}}</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                {{-- @empty --}}
                                {{-- @endforelse --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop