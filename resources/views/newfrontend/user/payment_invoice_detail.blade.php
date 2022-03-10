@extends('newfrontend.layouts.default')
@section('title',__('formname.invoices'))
<style>
.hid_spn{
    display:none;
}
</style>
@section('content')
<!--inner content-->
<div class="container mrgn_bt_40">
    <div class="row">
        @include('newfrontend.user.leftbar')
        <div class="col-md-9">
                <div class="form_box form_box_v2">
                    <h3>
                        Subscription Invoice
                        <div class="float-right rght_fltr">
                            <div class="dtpck_bg">
                                <a href="{{route('invoice')}}" class="btn btn-default">Back</a>
                            </div>
                        </div>
                    </h3>
                    <div class="p-3">
                        <!-- ORDERED ITEMS LIST -->
                        <table class="table">
                            <tr>
                                <th>{{__('formname.parent.full_name')}}</th>
                                <td>{{@$payment->parent->full_name}}</td>
                            </tr>
                            <tr>
                                <th>{{__('formname.payment.currency')}}</th>
                                <td>{{strtoupper(@$payment->currency)}}</td>
                            </tr>
                            <tr>
                                <th>{{__('formname.payment.amount')}}</th>
                                <td>{{strtoupper(@$payment->amount)}}</td>
                            </tr>
                            <tr>
                                <th>{{__('formname.payment.payment_date')}}</th>
                                <td>{{@$payment->proper_payment_date}}</td>
                            </tr>
                            <tr>
                                <th>{{__('formname.description')}}</th>
                                <td>{{@$payment->description}}</td>
                            </tr>
                        </table>
                        <!-- SUB TOTAL, SHIPPING CHARGES & DISCOUNT -->
                        {{--@include('admin.orders.details.charges')   --}}
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
@stop
@section('pageJs')
<script>
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
