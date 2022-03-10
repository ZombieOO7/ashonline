@extends('newfrontend.layouts.default')
@section('title','Checkout')
@section('content')
@php
$parent = Auth::guard('parent')->user();
$routeArray = [
    [
		'title' => __('frontend.emock.title'),
		'route' => route('e-mock'),
	],
	[
		'title' => 'Cart',
		'route' => route('emock-cart'),
	],
    [
		'title' => 'Checkout',
		'route' => route('emock-checkout'),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <div class="container">
        {{ Form::open(['route' => 'emock_make_payment','method'=>'POST','class' => 'def_form','id' => 'billing-frm-id','data-cc-on-file'=> "false",'data-stripe-publishable-key'=> env('STRIPE_KEY'),'autocomplete' =>'off' ]) }}
        @csrf
        <div class="row">
            @php  $addType = 'default_address' @endphp
            
            <input type="hidden" name="address_type" id="addressType" value="{{$addType}}" >
            <input type="hidden" name="submit_pressed" id="submitPressed" value="0" >
            <div class="col-md-12 in_ttl mrgn_bt_30">
                <h1 class="df_h3">Checkout</h1>
            </div>
            <div class="col-lg-8 chckut_left" id="defaultAddress">
                <h3 class="ckt_ttl">Billing Address</h3>
                <div class="row mrgn_bt_40">
                    <div class="col-xl-9">
                        <div class="billing_defalt_address mrgn_bt_40">
                            <div class="cusm-radio rdio rdio-primary">
                                <input type="radio" name="selected_address" id="billing_address_{{$parent->id}}" value="{{$parent->id}}" checked>
                                <label for="billing_address_{{$parent->id}}"></label>
                            </div>
                            <div class="defult_blng_adress">
                                <a href="#" class="default_btn"> Default </a>
                                <p>{{@$parent->full_name}}</p>
                                <p>{{(isset($parent->address)&&$parent->address!=null)?$parent->address.', ':''}}
                                    {{(isset($parent->address2)&&$parent->address2!=null)?$parent->address2.', ':'' }}<br>
                                    {{(isset($parent->city)&&$parent->city!=null)?$parent->city.', ':''}}
                                    {{(isset($parent->state)&&$parent->state!=null)?$parent->state.'-':''}}
                                    {{(isset($parent->postal_code)&&$parent->postal_code!=null)?$parent->postal_code:''}}</p>
                                <p>{{@$parent->mobile}}</p>
                            </div>
                            <span class="addressError"></span>
                        </div>
                        {{-- <a href="javascript:void(0)" class="add_new_address" id="add_new_address">+ ADD NEW ADDRESS</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 chckut_right">
                <h3 class="ckt_ttl">Payment Details</h3>
                <div class="row">
                    <div class="col-md-12">

                        <div class="cusm-radio rdio rdio-primary">
                            <input type="radio" name="payment_method" id="Paypalid" onclick="cardRadionone();"
                                   checked="checked" value="{{ __('frontend.paypal') }}">
                            <label for="Paypalid">Paypal</label>
                        </div>
                        <div class="cusm-radio rdio rdio-primary">
                            <input type="radio" name="payment_method" id="Cardid" onclick="cardRadio();"
                                   value="{{ __('frontend.stripe') }}">
                            <label for="Cardid">Stripe</label>
                        </div>
                    </div>
                    <div class="col-md-12" id="forCardpayment" style="display: none;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" name="card_number" class="form-control"
                                           placeholder="{{ __('frontend.card_number' )}}" id="card_number"
                                           maxlength="16">
                                    <span class="error card_number_err"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" name="name_on_card" class="form-control"
                                           placeholder="{{ __('frontend.name_on_card') }}" id="name_on_card"
                                           maxlength="50">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="expire_date" class="form-control" id="Start_Date"
                                           placeholder="{{ __('frontend.expiry_on') }}" onkeypress="return false;">
                                    <span class="error exp_date_err"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="password" name="cvv" class="form-control"
                                           placeholder="{{ __('frontend.cvv') }}" id="cvv" maxlength="3"
                                           autocomplete="off">
                                    <span class="error cvv_err"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mrgn_tp_30 mrgn_bt_30">
                        <div class="checkbox agreeckbx">
                            <input type="checkbox" name="agree" class="dt-checkboxes" id="paymentAgreeCheck">
                            {{--<label for="agreeCheck">I agree to all the <a href="#">Terms & Conditions</a> of AshACE</label>--}}
                            <label for="paymentAgreeCheck">
                                {{ __('frontend.payment.i_agree_to_all_the_msg') }} <a href="{{ route('cms_terms') }}"
                                                                                       target="_blank">{{ __('frontend.payment.terms_conditions') }}</a> {{ __('frontend.payment.of_ashace_papers') }}
                            </label>

                        </div>
                        {{-- <label for="agree" class="error"></label> --}}
                        <span class="error agree_err"></span>
                    </div>
                    <div class="payment-errors">
                    </div>
                    <div class="col-lg-12 mrgn_bt_40">


                        <div id="paypal-button-container">
                            <p class="amount_label">
                                <span>{{ __('frontend.amount_to_pay') }} :</span> {{ config('constant.default_currency_symbol').@$total }}
                            </p>
                        </div>
                        <button style="display:none;" type="submit" id="pay-now" class="btn btncheckout wdt100 "
                                style="display:block;">{{ __('frontend.payment.pay_now') }} {{ config('constant.default_currency_symbol').@$total }}</button>
                    </div>
                    <input type="hidden" name="order_id" id="order_id" value="">
                </div>
            </div>


        </div>


        {{ Form::close() }}
    </div>
@stop
@section('pageJs')
    <script>
        var site_url = "{{url('/emock/')}}";
        var base_url = "{{url('/')}}";
        var thankYouRoute = '{{route("emock-thank-you")}}';
        var paymentUrl = "{{route('paypal')}}";
        var amount = '{{@$total}}';
        var currency_code = "{{__('frontend.stripe_currency')}}";
        var description = "{{__('frontend.paper_purchased')}}";
        var return_url = "{{route('payment.success')}}";
        var cancel_url = "{{route('payment.cancel')}}";
    </script>

    <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
    {{-- Paypal Script --}}
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.client_id') }}&currency=GBP" data-sdk-integration-source="button-factory"></script>
    {{-- End Paypal Script --}}
    <script src="{{ asset('newfrontend/js/emock-payment.js') }}"></script>

@stop
