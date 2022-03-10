@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.subjects.name'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.subscribe.title')}}</h5>
                </div>
                <hr>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="subscriber_table" data-url="{{ route('subscriber/datatable') }}">
                    <thead>
                        <tr>
                            <th>{{__('formname.subscribe.email')}}</th>
                            <th>{{__('formname.subscribe.subscribed_at')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.subscribe.email')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.subscribe.subscribed_at')}}"></th>
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
<script src="{{ asset('backend/js/tablecommon.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/subscriber/index.js') }}" type="text/javascript"></script>
@stop