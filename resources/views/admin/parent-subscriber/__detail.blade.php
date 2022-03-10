@extends('admin.layouts.default')
@section('content')
@section('title', @$title)
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.payment.list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <button class="btn btn-info" style='margin:0px 0px 0px 0' id='clr_filter'
                                data-table_name="stage_table">{{__('formname.clear_filter')}}</button> 
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{route('parent-subscriber.index')}}"
                            class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                            <span>
                                <i class="la la-arrow-left"></i>
                                <span>{{__('formname.back')}}</span>
                            </span>
                        </a>
                    </div>
                </div>
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="parent_payment_table"
                    data-type="" data-url="{{ route('parent-payment.datatable') }}" data-parent_id = {{@$parentId}}>
                    <thead>
                        <tr>
                            <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="user_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th>
                            <th>{{__('formname.payment.transaction_id')}}</th>
                            <th>{{__('formname.payment.amount')}}</th>
                            <th>{{__('formname.payment.method')}}</th>
                            <th>{{__('formname.payment.payment_date')}}</th>
                            <th>{{__('formname.description')}}</th>
                            <th>{{__('formname.status')}}</th>
                            <th>{{__('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.payment.transaction_id')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.payment.amount')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.payment.method')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.payment.payment_date')}}"></th>
                            <td></td>
                            <th>
                                <select class="statusFilter form-control form-control-sm tbl-filter-column">
                                    <option value="">{{__('formname.select')}}</option>
                                    <option value="{{config('constant.status_inactive_value')}}">{{__('formname.success')}}</option>
                                    <option value="{{config('constant.status_active_value')}}">{{__('formname.failed')}}</option>
                                </select>
                            </th>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<!-- Show Description Modal -->
<div class="modal fade def_mod dtails_mdl" id="DescModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content ">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3 class="mdl_ttl">Description</h3>
                <p class="mrgn_tp_20 show_desc" style="word-wrap: break-word;">
                </p>
                <p class="mrgn_tp_20 show_question"></p>
                <button type="button" class="btn btn-success pull-right" data-dismiss="modal">{{__('formname.close')}}</button>
            </div>
        </div>
    </div>
</div>
@stop

<?php /*Load script to footer section*/?>

@section('inc_script')
<script>
    var url = "{{ route('parent-payment.datatable') }}";
</script>
<script src="{{ asset('backend/js/parent-subscriber/index.js') }}" type="text/javascript"></script>
@stop