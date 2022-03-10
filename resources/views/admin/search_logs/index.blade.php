@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.paper_search_log'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.paper_search_log')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <select class="form-control" name="action" id='action' aria-invalid="false">
                                <option value="">{{__('formname.action')}}</option>
                                <option value="{{config('constant.delete')}}">{{__('formname.delete')}}</option>
                            </select>
                            <a href="javascript:;" class="btn btn-primary submit_btn" id='action_submit'
                                data-url="{{route('logs_multi_delete')}}"
                                data-table_name="search_logs_table" data-module_name="Search Log">{{__('formname.submit')}}</a>
                            <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter'
                                data-table_name="stage_table">{{__('formname.clear_filter')}}</button> 
                        </div>
                    </div>
                    
                </div>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="search_logs_table"
                    data-type="" data-url="{{ route('search_logs_datatable') }}">
                    <thead>
                        <tr>
                            <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="trade_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th> 
                            <th>Keywords</th>
                            <th>IP Address</th>
                            <th>Searched At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <th>
                                <input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Keywords">
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="IP Address">
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Searched At">
                            </th>
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
<script>
var url = "{{ route('search_logs_datatable') }}";
</script>
<script src="{{ asset('backend/js/search_logs/index.js') }}" type="text/javascript"></script>
@stop