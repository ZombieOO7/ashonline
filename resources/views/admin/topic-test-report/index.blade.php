@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.student-test.label'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text"></h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                </div>
            </div>
            <div class="m-portlet__body width_big">
                <div class="m-form__content">
                    <form action="" id='getData'>
                        <div class="row">
                            <div class="col-sm-3">
                                <select name='student_id' class="form-control" id='studentId'>
                                    <option value="" selected>{{__('formname.select_student')}}</option>
                                    @forelse($studentList as $val)
                                        <option value="{{ $val->id }}">{{ $val->student_no }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" id='start_date' name="from_date" placeholder="{{__('formname.student.start_date')}}" class="form-control" autocomplete="off" value="">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" id='end_date' name="to_date" placeholder="{{__('formname.student.end_date')}}" class="form-control" autocomplete="off" value="">
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-success" id='submitBtn' type="button">@lang('general.submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="m-form__content">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <button class="btn btn-info" style='margin:0px 0px 0px 0px' id='clr_filter'>@lang('general.clear_filter')</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="student_test_table" data-url="{{ route('student-topic-report.datatable') }}">
                    <thead>
                        <tr>
                            <th>{{__('formname.student.student_no')}}</th>
                            {{-- <th>{{__('formname.student.student_name')}}</th> --}}
                            <th>{{__('formname.student.no_of_test')}}</th>
                            <th>{{__('formname.student.parent_name')}}</th>
                            <th>{{__('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.student.student_no')}}"></th>
                            {{-- <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.student.student_name')}}"></th> --}}
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.student.no_of_test')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.student.parent_name')}}"></th>
                            {{-- <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.student.end_date')}}"></th> --}}
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@stop
@section('inc_script')
    <script src="{{ asset('backend/js/topic-test-report/index.js') }}" type="text/javascript"></script>
@stop
