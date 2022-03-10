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
                            <a href="{{route('student_test_index')}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
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
                                            {{-- <li>
                                                <label>Total Test</label>
                                                <p>{{count(@$studentTest)}}</p>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="">
                                <h3>Student Tests</h3>
                                <div class="">
                                    <table class="table table-striped- table-bordered table-hover table-checkable" cellspacing="10" id="mock_test_table">
                                        <thead>
                                        <tr>
                                            <th class="">Papers</th>
                                            <th class="">Completed</th>
                                            <th class="">No Of Attempt</th>
                                            <th class="">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($studentTest->studentTestPapers as $key => $testPaper)
                                                <tr>
                                                    <td>{{@$testPaper->paper->name}}</td>
                                                    <td>{{@$testPaper->completed}}</td>
                                                    <td>{{@$testPaper->attempt}}</td>
                                                    <td>
                                                        <a href="{{route('student_test_detail',['uuid'=>@$testPaper->uuid])}}" class="glyphicon glyphicon-list-alt" title="Detail">
                                                            <i class="fa fa-eye">
                                                            </i>
                                                        </a>
                                                        {{-- <a href="{{route('download-report',['uuid'=>@$testPaper->uuid])}}" class="glyphicon glyphicon-list-alt" title="Download Report">
                                                            <i class="fa fa-download">
                                                            </i>
                                                        </a> --}}
                                                        {{-- <a href="javascript:void(0);" data-url="{{route('email-report',['uuid'=>@$testPaper->uuid])}}" class="glyphicon glyphicon-list-alt send-mail" title="Send Mail">
                                                            <i class="flaticon-mail-1">
                                                            </i>
                                                        </a> --}}
                                                        {{-- @if($testPaper->completed <= 50) --}}
                                                            @if(isset($testPaper->studentResult))
                                                                <a href="javascript:;" data-url="{{route('reset-attempt',['uuid'=>@$testPaper->uuid])}}" class="glyphicon glyphicon-list-alt resetTest" title='reset'>
                                                                    <i class="fa fa-redo-alt">
                                                                    </i>
                                                                </a>
                                                            @endif
                                                        {{-- @endif --}}
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <input type="hidden" id='studentId' name="student_id" value="{{$student->id}}">
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
<script src="{{ asset('backend/js/student-test/index.js') }}" type="text/javascript"></script>
@stop
