@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.payment.list'))
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
                </div>
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="payment_table"
                    data-type="" data-url="{{ route('payment_datatable') }}">
                    <thead>
                        <tr>
                            <th>{{__('formname.payment.order_number')}}</th>
                            <th>{{__('formname.payment.amount')}}</th>
                            <th>{{__('formname.payment.method')}}</th>
                            <th>{{__('formname.payment.payment_date')}}</th>
                            <th>{{__('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.payment.order_number')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.payment.amount')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.payment.method')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.payment.payment_date')}}"></th>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

@stop

<?php /*Load script to footer section*/?>

@section('inc_script')
<script>
var url = "{{ route('payment_datatable') }}";
</script>
<script src="{{ asset('backend/js/payment/index.js') }}" type="text/javascript"></script>
@stop