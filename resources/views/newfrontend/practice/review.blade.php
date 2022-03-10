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
            'route' => route('weekly-assessments',['slug'=> @$testAssessment->testAssessmentSubjectDetail[0]->subject->slug,'studentId'=>@$studentId]),
        ],
        [
            'title' => @$testAssessment->testAssessmentSubjectDetail[0]->subject->title,
            'route' => route('weekly-assessments',['slug'=>@$testAssessment->testAssessmentSubjectDetail[0]->subject->slug,'studentId' => $studentId]),
        ],
        [
            'title' => __('frontend.review_lbl2'),
            'route' => route('review-test-result',['uuid'=>@$studentTest->uuid]),
        ],
    ];
    $subject = subject();
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <!--inner content-->
    <div class="container mrgn_bt_40">
        <div class="row">
            {{-- <div class="col-md-12 frtp_ttl">
                <nav class="bradcrumb_pr" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('practice') }}">{{ __('frontend.home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('weekly-assessments', ['slug'=>@$subject->slug,'studentId' => $studentId]) }}">{{ __('frontend.practice_by_week') }}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('weekly-assessments', ['slug'=>@$testAssessment->testAssessmentSubjectDetail[0]->subject->slug,'studentId' => $studentId]) }}">{{ __('frontend.review_lbl2') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ @$testAssessment->testAssessmentSubjectDetail[0]->subject->title }}
                            {{ __('frontend.papers_lbl') }}</li>
                    </ol>
                </nav>
            </div> --}}

            <div class="col-md-12 prfl_ttl">
                <h3 class="mt-3">{{ __('frontend.result') }}</h3>
            </div>
            <div class="col-md-12">
                <div class="rspnsv_table rspnsv_table_allinfo">
                    <table class="table-bordered table-striped table-condensed cf v-align-bottom sm_txt_tbl">
                        <thead class="cf">
                            <tr>
                                <th>{{ __('frontend.papers_lbl') }}</th>
                                <th>{{ __('frontend.date') }}</th>
                                <th>{{ __('frontend.practice_test') }}</th>
                                <th>{{ __('formname.total_score') }}</th>
                                <th>{{ __('formname.your_score') }}</th>
                                {{-- <th>{{ __('frontend.percentage') }}</th> --}}
                                <th>{{ __('frontend.best_score') }}</th>
                                <th>{{ __('frontend.action') }}</th>
                            </tr>
                            <!-- <tr class="middle_hdng_rw"><th colspan="6" align="center">Mock Exams</th></tr> -->
                        </thead>
                        <tbody>
                            @forelse(@$testResults??[] as $key => $testResult)
                            <tr>
                                <td data-title="Papers">{{@$testAssessment->title}}</td>
                                <td data-title="Date">{{@$testResult->proper_month_date}}</td>
                                <td data-title="Practice Test"><a href="#" class="add_to_cart btn_sccss">{{__('frontend.completed')}}</a></td>
                                <td data-title="Out of">{{@$testResult->total_marks}}</td>
                                <td data-title="Total">{{@$testResult->obtained_marks}}</td>
                                {{-- <td data-title="Percentage">{{@$testResult->overall_result}}</td> --}}
                                <td data-title="Best Score">
                                    <img src="{{asset('newfrontend/images/snglstr.png')}}" alt="" width="30px" class="str_img"> {{@$testResult->overall_result}}/100</td>
                                <td data-title="Action"><a href="{{route('review-result',['id'=>@$testResult->uuid])}}" class="tbl_btn">{{__('frontend.review_lbl')}}</a></td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Result not founds.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!--close inner content-->
@stop
