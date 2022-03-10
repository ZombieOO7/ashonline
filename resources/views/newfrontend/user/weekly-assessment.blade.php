@extends('newfrontend.layouts.default')
@section('title', __('frontend.practice_by_week'))
@section('content')
@php
    $parentData = parentData();
    $parent = @$parentData[0];
    $isParent = @$parentData[1];
@endphp
    <div class="container mrgn_bt_40">
        <div class="row">
            @include('newfrontend.user.leftbar')
            <div class="col-md-9">
                <div class="form_box">
                    <h3>{{ __('frontend.practice_by_week') }}</h3>
                    <div class="pdng_box">
                        <div class="row">
                            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                                @if($isParent== true)
                                    @forelse(@$parent->childs as $key => $child)
                                        <li class="nav-item">
                                            <a class="nav-link e-mck-btn e-mck-btn-child @if(@$studentId==$child->id)active @endif" href="{{route('parent.weekly-assessments',['studentId'=>@$child->uuid])}}">
                                                <span class="pbwa_ic pbwa_ic01" style="background: url('{{@$child->image_thumb}}') !important;background-size: 50px !important;border-radius: 25px;"></span>
                                                {{@$child->full_name}}
                                            </a>
                                        </li>
                                    @empty
                                    @endforelse
                                @endif
                            </ul>
                            @forelse($subjects as $subject)
                                <div class="col-md-12">
                                    <h4 class="tbl_ttl">{{__('formname.subj_papers',['subject'=>@$subject->title])}}</h4>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="rspnsv_table rspnsv_table_allinfo">
                                        <table class="table-bordered table-striped table-condensed cf">
                                            <thead class="cf">
                                                <tr>
                                                    <th width="20%">{{__('frontend.weeks')}}</th>
                                                    <th width="20%">{{__('frontend.date')}}</th>
                                                    <th width="20%">{{__('frontend.practice_test')}}</th>
                                                    <th class="text-center" width="20%">{{__('frontend.score')}}</th>
                                                    <th width="20%">{{__('frontend.action')}}</th>
                                                </tr>
                                                <!-- <tr class="middle_hdng_rw"><th colspan="6" align="center">Mock Exams</th></tr> -->
                                            </thead>
                                            <tbody>
                                                @forelse($subject->threeWeeklyAssessment as $key => $weekAssessment)
                                                @php
                                                    $studentTest = @$weekAssessment->studentAssessment($studentId);
                                                    $studentTestResult = @$weekAssessment->studentResultAssessment($studentId);
                                                @endphp
                                                <tr>
                                                    <td width="20%" data-title="Weeks">{{@$weekAssessment->title}}</td>
                                                    <td width="20%" data-title="Date">{{@$weekAssessment->start_date_month}}</td>
                                                    <td width="20%" data-title="Practice Test">
                                                        @if($studentTestResult != NULL)
                                                            <a href="javascript:;" class="add_to_cart btn_sccss">{{__('frontend.completed')}}</a>
                                                        @else
                                                            <a href="{{route('assessments-detail',['uuid'=>@$weekAssessment->uuid])}}" class="add_to_cart btn_flwr @if($isParent == true) unread_tr @endif">{{__('frontend.start')}}</a>
                                                        @endif
                                                    <td class="text-center" width="20%" data-title="Score">
                                                        @if($studentTestResult)
                                                        <img src="{{asset('newfrontend/images/snglstr.png')}}" alt="" width="30px" class="str_img">
                                                            {{@$studentTestResult->proper_overall_result}}/100
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td width="20%" data-title="Action" class="min-wd-140">
                                                        <a href="{{route('review-test-result',['uuid'=>@$studentTest->uuid])}}" class="tbl_btn @if($studentTestResult == null) unread_tr @endif">{{__('frontend.review_lbl')}}</a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5">{{__('frontend.record_not_found')}}</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('pageJs')
@stop
