@extends('frontend.layouts.default')
@section('title', 'Checkout')
@section('pageCss')
    <style>
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',__('frontend.checkout.checkout'),route('home')))
<div class="container">
  @include('frontend.includes.flashmessages')  
    <div class="row">
      <div class="col-md-12 mrgn_bt_30 mrgn_tp_40">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="small_title smllwtbrdr">{{ __('frontend.checkout.checkout') }}</h1>
          </div>
          <div class="col-lg-12">
            {{ Form::open(['route' => 'make_payment','method'=>'POST','class' => 'def_form','id' => 'billing-frm-id','data-cc-on-file'=> "false",'data-stripe-publishable-key'=> env('STRIPE_KEY'),'autocomplete' =>'off' ]) }}
            @csrf    
              <div class="row">
                <div class="col-lg-6 ch-lf-6 checkoutinfo">
                  <h2 class="ckt_ttl">{{ __('frontend.checkout.billing_address') }}</h2>
                  <p class="blp_p">{{ __('frontend.checkout.please_enter_your_email_address_msg') }}</p>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="{{ __('frontend.email_address') }}" maxlength="80" id="email" value="{{ old('email') }}">
                        @if ($errors->has('email')) 
                            <p class="error">
                              {{ $errors->first('email') }}
                            </p> 
                        @endif
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" name="confirm_email" class="form-control" placeholder="{{ __('frontend.confirm_email_address') }}" maxlength="80" value="{{ old('confirm_email') }}">
                        @if ($errors->has('confirm_email')) 
                            <p class="error">
                              {{ $errors->first('confirm_email') }}
                            </p> 
                        @endif
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <input type="text" name="first_name" class="form-control" placeholder="{{ __('frontend.first_name') }}" maxlength="35" value="{{ old('first_name') }}" maxlength="30">
                            @if ($errors->has('first_name')) 
                              <p class="error">
                                {{ $errors->first('first_name') }}
                              </p> 
                            @endif
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <input type="text" name="last_name" class="form-control" placeholder="{{ __('frontend.last_name') }}" maxlength="35" value="{{ old('last_name') }}" maxlength="30">
                            @if ($errors->has('last_name')) 
                              <p class="error">
                                {{ $errors->first('last_name') }}
                              </p> 
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" name="phone" class="form-control" placeholder="{{ __('frontend.phone_number') }}" value="{{ old('phone') }}" maxlength="16">
                        @if ($errors->has('phone')) 
                          <p class="error">
                            {{ $errors->first('phone') }}
                          </p> 
                        @endif
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" name="address1"  class="form-control" placeholder="{{ __('frontend.address_1') }}" value="{{ old('address1') }}" maxlength="80">
                        @if ($errors->has('address1')) 
                          <p class="error">
                            {{ $errors->first('address1') }}
                          </p> 
                        @endif
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" name="address2" class="form-control" placeholder="{{ __('frontend.address_2') }}" maxlength="80">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <input type="text" name="city" class="form-control" placeholder="{{ __('frontend.city') }}" maxlength="35" value="{{ old('city') }}" >
                            @if ($errors->has('city')) 
                              <p class="error">
                                {{ $errors->first('city') }}
                              </p> 
                            @endif
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <input type="text" name="postal_code" class="form-control" placeholder="{{ __('frontend.postcode') }}" value="{{ old('postal_code') }}" maxlength="10">
                            @if ($errors->has('postal_code')) 
                              <p class="error">
                                {{ $errors->first('postal_code') }}
                              </p> 
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <input type="text" name="state" class="form-control" placeholder="{{ __('frontend.state_country') }}" value="{{ old('state') }}" maxlength="35">
                            @if ($errors->has('state')) 
                              <p class="error">
                                {{ $errors->first('state') }}
                              </p> 
                            @endif
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <input type="text" name="country" class="form-control" placeholder="{{ __('frontend.uk') }}" value="{{ old('country') }}" maxlength="35">
                            @if ($errors->has('country')) 
                              <p class="error">
                                {{ $errors->first('country') }}
                              </p> 
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 ch-rt-6">
                  <h3 class="ckt_ttl">{{ __('frontend.payment.payment_details') }}</h3>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="cusm-radio rdio rdio-primary">
                          <input type="radio" name="payment_method" id="Cardid" onclick="cardRadio();" checked="checked" value="{{ __('frontend.stripe') }}">
                          <label for="Cardid">{{ __('frontend.payment.credit_debit_card') }}</label>
                          
                      </div>
                      <div class="cusm-radio rdio rdio-primary">
                          <input type="radio" name="payment_method" id="Paypalid" onclick="cardRadionone();" value="{{ __('frontend.paypal') }}">
                          <label for="Paypalid">{{ __('frontend.checkout.paypal') }}</label>
                      </div>
                    </div>
                    <div class="col-md-12" id="forCardpayment" style="display: block;">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <input type="text" name="card_number" class="form-control" placeholder="{{ __('frontend.card_number' )}}" id="card_number" maxlength="16">
                            <span class="error card_number_err" ></span>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="form-group">
                            <input type="text" name="name_on_card" class="form-control" placeholder="{{ __('frontend.name_on_card') }}" id="name_on_card" maxlength="50">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <input type="text" name="expire_date" class="form-control" id="Start_Date" placeholder="{{ __('frontend.expiry_on') }}" onkeypress="return false;">
                            <span class="error exp_date_err" ></span>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <input type="password" name="cvv" class="form-control" placeholder="{{ __('frontend.cvv') }}" id="cvv" maxlength="3" autocomplete="off">
                            <span class="error cvv_err" ></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 mrgn_tp_30 mrgn_bt_30">
                      <div class="checkbox agreeckbx">
                        <input type="checkbox" name="agree" class="dt-checkboxes" id="agreeCheck">
                          <label for="agreeCheck">
                            {{ __('frontend.payment.i_agree_to_all_the_msg') }} <a href="{{ route('cms_terms') }}" target="_blank">{{ __('frontend.payment.terms_conditions') }}</a> {{ __('frontend.payment.of_ashace_papers') }}
                          </label>
                      </div>
                      <label for="agree" class="error"></label>
                      <span class="error agree_err" ></span>
                    </div>

                    <div class="payment-errors">
                    </div>
                    <span></span>
                    <div class="col-lg-12 mrgn_bt_40">
                      
                      <div id="paypal-button-container" style="display:none;">
                        <p class="amount_label"><span>{{ __('frontend.amount_to_pay') }} :</span> {{ config('constant.default_currency_symbol').@$total }}</p>
                      </div>
                      <button type="submit" id="pay-now" class="btn btncheckout wdt100 " style="display:block;">{{ __('frontend.payment.pay_now') }} {{ config('constant.default_currency_symbol').@$total }}</button>
                    </div>
                    <input type="hidden" name="order_id" id="order_id" value="">
                  </div>
                </div>
              </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('pageJs') 
<script>
  var site_url = '{{url("/epaper/")}}';
</script>
  <script src="{{ asset('frontend/js/jquery.validate.min.js') }}" ></script>
  <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
  {{-- Paypal Script --}}
<script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.client_id') }}&currency=GBP" data-sdk-integration-source="button-factory"></script>
  {{-- End Paypal Script --}}
  <script src="{{ asset('frontend/js/payment.js') }}" ></script>
@endsection
