@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.orders.list'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.orders.list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <button class="btn btn-info" id='clr_filter'
                                data-table_name="stage_table">{{__('formname.clear_filter')}}</button> 
                        </div>
                    </div>
                    <div class=" m-portlet__head-caption">
                        <input type="text" class="form-control" name="created_at" id="created_at" placeholder="Select Order Date" readonly>
                    </div>
                </div>
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="order_table"
                    data-type="" data-url="{{ route('order_datatable') }}">
                    <thead>
                        <tr>
                            {{-- <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="trade_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th> --}}
                            <th>{{__('formname.orders.number')}}</th>
                            <th>{{__('formname.orders.invoice_number')}}</th>
                            <th>{{__('formname.orders.amount')}}</th>
                            <th>{{__('formname.orders.discount')}}</th>
                            <th>{{__('formname.orders.total')}}</th>
                            <th>{{__('formname.orders.created_at')}}</th>
                            {{-- <th>{{__('formname.status')}}</th> --}}
                            <th>{{__('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.orders.number')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.orders.invoice_number')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.orders.amount')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.orders.discount')}}"></th>
                                <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="Total"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.orders.created_at')}}"></th>
                            {{-- <th class="slct-wdth">
                                <select class="statusFilter form-control form-control-sm tbl-filter-column">
                                    @forelse ($statusList as $key => $item)
                                    <option value="{{$key}}">{{$item}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </th> --}}
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
var url = "{{ route('order_datatable') }}";
</script>
<script src="{{ asset('backend/js/orders/index.js') }}" type="text/javascript"></script>
@stop