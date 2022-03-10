<div class="row col-md-12">
    <div class="col-md-12 mrgn_bt_30 mrgn_tp_40">
    <div class="row">
        <div class="col-lg-12 text-center cart_empty_cntnt">
        <div class="row justify-content-left">
            <div class="col-lg-5">
            <img src="{{ asset('frontend/images/empty_ic.png') }}" alt="empty logo" title="empty logo">
            <h1>{{__('frontend.cart.your_cart_is_empty')}}</h1>
            <a href="{{route('e-mock')}}" class="btn btncheckout">{{ __('frontend.cart.continue_shopping') }}</a>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>