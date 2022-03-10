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
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-wrapper">
                            <div class="m-portlet__head-caption">
                                <h3 class="m-portlet__head-text">{{__('formname.student.test_detail')}} </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <a href="{{route('student-assessment-report.index')}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
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
                                    <div class="float-left">
                                        <ul class="ex_tp_dtls" style="background-color: #fff;">
                                            <li>
                                                <label>{{__('formname.student.student_no')}}</label>
                                                <p>{{@$student->ChildIdText}}</p>
                                            </li>
                                            {{-- <li>
                                                <label>Name</label>
                                                <p>{{@$student->full_name}}</p>
                                            </li> --}}
                                            <li>
                                                <label>{{__('formname.total_test')}}</label>
                                                <p>{{@$count}}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="">
                                <h3>{{__('formname.test_assessment')}}</h3>
                                <div class="">
                                    <table class="table table-striped- table-bordered table-hover table-checkable" cellspacing="10" id="mock_test_table" data-url="{{route('assessment-datatable')}}">
                                        <thead>
                                        <tr>
                                            <th class="">{{__('formname.test_assessment')}}</th>
                                            <th class="">{{__('formname.start_date')}}</th>
                                            <th class="">{{__('formname.end_date')}}</th>
                                            <th class="">{{__('formname.completed')}}</th>
                                            <th class="">{{__('formname.no_of_attempt')}}</th>
                                            <th class="">{{__('formname.action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id='studentId' name="student_id" value="{{$student->id}}">
                                    <input type="hidden" id='start_date' name="start_date" value="{{$fromDate}}">
                                    <input type="hidden" id='end_date' name="end_date" value="{{$toDate}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('inc_script')
<script src="{{ asset('backend/js/test-assessment-report/index.js') }}" type="text/javascript"></script>
@stop
