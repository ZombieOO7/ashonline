@extends('admin.layouts.default')
@section('inc_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@section('title', @$title)
<style>
.bootstrap-select > .dropdown-toggle.bs-placeholder.btn-light {
    border: 1px solid #c3c3c3 !important;
}
.bootstrap-select > .dropdown-toggle.btn-light, .bootstrap-select > .dropdown-toggle.btn-secondary{
    border: 1px solid #c3c3c3 !important;
}
.bootstrap-select .dropdown-menu {
    max-height: 200px !important;
    min-width: -moz-available !important;
    width: 300px !important;
    min-width: 410px !important;
    max-width: 410px !important;
}
</style>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"
                    id="main_portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-wrapper">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{@$title}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('parent-subscriber.show',['id'=>@@$paymentDetail->parent_id])}}"
                                    class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{__('formname.back')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Subscription Invoice</th>
                                </tr>
                                <tr>
                                    <th>{{__('formname.parent.full_name')}}</th>
                                    <td>{{@$paymentDetail->parent->full_name}}</td>
                                </tr>
                                <tr>
                                    <th>{{__('formname.payment.currency')}}</th>
                                    <td>{{strtoupper(@$paymentDetail->currency)}}</td>
                                </tr>
                                <tr>
                                    <th>{{__('formname.payment.amount')}}</th>
                                    <td>{{strtoupper(@$paymentDetail->amount)}}</td>
                                </tr>
                                <tr>
                                    <th>{{__('formname.payment.payment_date')}}</th>
                                    <td>{{@$paymentDetail->proper_payment_date}}</td>
                                </tr>
                                <tr>
                                    <th>{{__('formname.description')}}</th>
                                    <td>{{@$paymentDetail->description}}</td>
                                </tr>
                            </table>
                            <a href="javascript:;" data-url="{{route('send-invoice')}}" data-id='{{@$paymentDetail->id}}' class="btn btn-success sendMail">{{__('formname.send_mail')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('inc_script')
<script>
    var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="{{asset('newfrontend/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('backend/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/parents/create.js') }}" type="text/javascript"></script>
<script>
    $addressKey = "{{env('ADDRESS_API_KEY')}}";
</script>
<script src="{{asset('newfrontend/js/getAddress.js')}}"></script>
<script src="{{ asset('backend/js/parent-subscriber/index.js') }}" type="text/javascript"></script>
@stop
