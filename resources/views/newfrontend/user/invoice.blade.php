@extends('newfrontend.layouts.default')
@section('title',__('formname.invoices'))
<style>
.hid_spn{
    display:none;
}
</style>
@section('content')
@php
    $routeArray = [
    [
		'title' => __('frontend.my_profile'),
		'route' => route('parent-profile'),
	],
    [
		'title' => __('frontend.invoice'),
		'route' => route('invoice'),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
<!--inner content-->
<div class="container mrgn_bt_40">
    <div class="row">
        @include('newfrontend.user.leftbar')
        <div class="col-md-9">
                <div class="form_box form_box_v2">
                    <h3>
                        {{__('formname.invoices')}}
                        <div class="float-right rght_fltr">
                            <h6>{{__('formname.filter_by')}} :</h6>
                            <div class="dtpck_bg">
                                <input type="text" class="dtpckr" placeholder="{{__('formname.from_date')}}" id='fromdate' readonly>
                                <input type="text" class="dtpckr" placeholder="{{__('formname.to_date')}}" id='todate' readonly>
                            </div>
                            <div class="clearfix"></div>
                    </h3>
                    </h3>
                    <ul class="nav nav-pills mb-3 top_blue_pannel top_blue_pannel_v2" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-mockinvoices-tab" data-toggle="pill"
                                href="#pills-mockinvoices" role="tab" aria-controls="pills-mockinvoices"
                                aria-selected="true">{{__('formname.orders_lbl')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-epaperinvoices-tab" data-toggle="pill"
                                href="#pills-epaperinvoices" role="tab" aria-controls="pills-epaperinvoices"
                                aria-selected="false">{{__('formname.subscription_payment')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-mockinvoices" role="tabpanel"
                            aria-labelledby="pills-mockinvoices-tab">

                            <div class="pdng_box pdng_tp_0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="rspnsv_table rspnsv_table_scrlb">
                                            <table id='mock_table' class="table-bordered table-striped table-condensed cf moc_tbl">
                                                <thead>
                                                    <tr>
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
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-epaperinvoices" role="tabpanel"
                            aria-labelledby="pills-epaperinvoices-tab">
                            <div class="pdng_box pdng_tp_0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="rspnsv_table rspnsv_table_scrlb">
                                            <table id='paper_table' class="table-bordered table-striped table-condensed cf moc_tbl">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('formname.payment.transaction_id')}}</th>
                                                        <th>{{__('formname.payment.amount')}}</th>
                                                        <th>{{__('formname.payment.method')}}</th>
                                                        <th>{{__('formname.payment.payment_date')}}</th>
                                                        <th>{{__('formname.description')}}</th>
                                                        <th>{{__('formname.status')}}</th>
                                                        <th>{{__('formname.action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
</div>
<!--close inner content-->
<!--Your-feedback-Modal -->
<div class="modal fade def_modal lgn_modal" id="feedback_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3>Your Feedback</h3>
                <p class="mrgn_bt_40">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                </p>
                <div class="fixedStar mx_w_str bg_star" data-score="1"></div>
                <h4 class="middle_mdl_title mrgn_tp_40 mrgn_bt_20">Your Message</h4>
                <p class="middle_content_info mrgn_bt_30">Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                    sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi
                    enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip
                    ex ea commodo consequat. Duis autem vel eum iriure dolore te </p>
                <button type="submit" class="btn submit_btn">Okay</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade def_modal lgn_modal" id="success_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3>Successfully Submitted</h3>
                <p class="mrgn_bt_40">Thank you for sharing your feedback with us. It has been successfully
                    submitted.</p>
                <button type="submit" class="btn submit_btn">Okay</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade def_modal lgn_modal" id="descriptionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3>Description</h3>
                <div class="paymentDescription">

                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('pageJs')
<script>
    var url2 = '{{route("get.payment.invoice")}}';
    var url = '{{route("get.order.invoice")}}';
    var csrf = '{{ csrf_token() }}';
    var rateImagePath = '{{asset("newfrontend/images")}}';
</script>
{{-- <script src="{{ asset('backend/dist/default/assets/vendors/base/vendors.bundle.js') }}" type="text/javascript">
</script> --}}
<script src="{{ asset('backend/dist/default/assets/vendors/custom/datatables/datatables.bundle.js') }}"
    type="text/javascript"></script>
<script src="{{asset('backend/js/common.js')}}"></script>
<script src="{{asset('newfrontend/js/parent/invoice.js')}}"></script>
@stop
