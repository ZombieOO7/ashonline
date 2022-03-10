<div class="col-lg-4 cart_sidebar">
    <div class="cart_sd">
        <span class="ash-coupons"></span>
        <h2 class="small_title">{{ __('frontend.coupon.coupons')}}</h2>
        <!-- Remove coupon if already added -->
        @if(@$couponDiscount)
            {{ Form::open(['route' => 'apply-code','method'=>'POST','id' => 'code-frm-id','autocomplete' => 'off']) }}
            @csrf
            <div class="newsletter">
                <div class="input-group">
                <div class="cpncd">{{__('frontend.xxxxx')}} <span>({{ __('frontend.coupon.you_saved') }} {{ config('constant.default_currency_symbol').@$couponDiscount }})</span></div>
                <span class="input-group-btn">
                    <button class="btn" type="submit">{{ __('frontend.coupon.remove')}}</button>
                </span>
                </div>
            </div>
            {{ Form::hidden('type','remove') }}
            {{ Form::close() }}
        @else 
            <div class="newsletter">
                {{ Form::open(['route' => 'apply-code','method'=>'POST','id' => 'code-frm-id','autocomplete' => 'off']) }}
                    @csrf
                    <div class="input-group">
                        <input type="text" name="code" value="{{ old('code') }}" class="form-control" placeholder="{{ __('frontend.enter_coupon_code') }}">
                        <span class="input-group-btn">
                            <button class="btn" type="submit">{{ __('frontend.coupon.apply_now') }}</button>
                        </span>
                    </div>
                    @if ($errors->has('code')) 
                        <p class="help-block" style="color:red;">
                            {{ $errors->first('code') }}
                        </p> 
                    @endif
                    {{ Form::hidden('type','apply') }}
                    {{ Form::hidden('total',@$total) }}
                {{ Form::close() }}
            </div>
        @endif
    </div>
    <div class="summry_main">
    <h3 class="small_title wtborder">{{ __('frontend.coupon.summary') }}</h3>
      <div class="price_table">
        <table class="ttltbl">
          <tbody>
            <tr>
              <td>{{ __('frontend.coupon.sub_total')}}</td>
              <td class="text-right">{{ config('constant.default_currency_symbol').@$cartSubTotal }}</td>
            </tr>
            @if(@$couponDiscount)
                <tr>
                    <td>{{ __('frontend.coupon.coupon_discount')}}</td>
                    <td class="text-right"> - {{ config('constant.default_currency_symbol').@$couponDiscount }}</td>
                </tr>
            @endif
          </tbody>
          <tfoot>
            <tr>
              <td>Total</td>
              <td class="text-right">{{ config('constant.default_currency_symbol').@$total }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
     <a class="btn btncheckout" href="{{ route('checkout') }}">{{ __('frontend.coupon.checkout_now')}}</a>
    </div>
        <div class="cart_action continue_shpng">
            <a href="{{ route('papers') }}">{{ __('frontend.cart.continue_shopping') }}</a>
        </div>
  </div>