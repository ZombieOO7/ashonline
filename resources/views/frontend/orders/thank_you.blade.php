@extends('frontend.layouts.default')
@section('title', __('frontend.order.thank_you') )
@section('content')
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb', __('frontend.order.thank_you') ,route('home')))
<div class="container">
  <div class="row">
    <div class="col-md-12 mrgn_bt_30 mrgn_tp_40">
      <div class="row">
        <div class="col-lg-12 thank_content">
          <div class="row">
              <div class="col-lg-12">
                <img src="{{ asset('frontend/images/thankyou_img.png') }}" alt="thank you" title="{{ __('frontend.order.thank_you') }}">
                <h1>{{ __('frontend.order.thank_you') }}</h1>
                <p>{{ __('frontend.order.your_order_number_is') }}: <span style="color:#03a9f4;">{{ @$order->order_no }}</span></p>
                <p>{{ __('frontend.order.you_will_receive_msg') }}</p>
              </div>
              @if(@$order->discount > 0)
                @php 
                  $amount = @$order->amount - @$order->discount;
                @endphp
              @else 
                @php 
                  $amount = @$order->amount;
                @endphp
              @endif
              <div class="col-md-10 mrgn_bt_20">
                 <ul class="pament_panel">
                   <li>
                     <h2>{{ date('d M, Y',strtotime(@$order->created_at)) }} </h2>
                     <p>{{ __('frontend.order.date') }}</p>
                   </li>
                   <li>
                     <h2>{{ config('constant.default_currency_symbol').@$amount }}</h2>
                     <p>{{ __('frontend.order.total_amount') }}</p>
                   </li>
                   <li>
                      <h2>{{ @$order->payment_text }}</h2>
                     <p>{{ __('frontend.order.payment_method') }}</p>
                   </li>
                 </ul>
                <div class="table-responsive thank-you-table">
                   <table class="table">
                      <thead>
                        <tr>
                          <th>{{ __('frontend.order.product_name') }}</th>
                          <th>{{ __('frontend.order.price') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                         @forelse ($orderItems as $item)
                          <tr>
                            <td>{{ @$item->paper->title }}</td>
                            <td>{{ @$item->paper->price_text }}</td>
                          </tr>
                         @empty
                             
                         @endforelse
                         
                      <tfoot>
                        <tr class="cart-subtotal">
                          <td>{{ __('frontend.order.cart_subtotal') }}</td>
                          <td>{{ config('constant.default_currency_symbol').@$order->amount }}</td>
                        </tr>
                        @if(@$order->discount > 0)
                          <tr class="cart-subtotal">
                            <td>{{ __('frontend.order.discount') }}</td>
                            <td>{{ config('constant.default_currency_symbol').@$order->discount }}</td>
                          </tr>
                        @endif
                        
                        <tr class="cart-total">
                          <td>{{ __('frontend.order.total') }}</td>
                          <td>{{ config('constant.default_currency_symbol').@$amount }}</td>
                        </tr>
                      </tfoot>
                   </table>
                </div>
              </div>
              <div class="col-md-12">
                  <div class="customer-information">
                    <h3 class="small_title mrgn_bt_20">{{ __('frontend.billing_address.customer_information') }}</h3>
                    <div class="row">
                      <div class="col-md-7">
                        <div class="row">
                          <div class="col-md-6">
                              <h4>{{ __('frontend.billing_address.billing_address') }} :</h4>
                              <p>{{ @$billingAddress->full_name }}</p>
                              <p>{{ @$billingAddress->address1 }}</p>
                              @if(@$billingAddress->address2)
                                <p>{{ @$billingAddress->address2 }}</p>
                              @endif
                              <p>{{ @$billingAddress->city }}, {{ @$billingAddress->state }}, {{ @$billingAddress->postal_code }}</p>
                              <p>{{ @$billingAddress->country }}</p>
                              <p>Email: {{ @$billingAddress->email }} </p>
                              <p>T: {{ @$billingAddress->phone }} </p>
                          </div>
                          {{-- <div class="col-md-6">
                            <h4>Billing Address :</h4>
                            <p>Credit Card</p>
                          </div> --}}
                        </div>
                        <a class="btn btncheckout mrgn_tp_20" href="{{ route('papers') }}">{{ __('frontend.billing_address.continue_shopping') }}</a>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


  
@endsection