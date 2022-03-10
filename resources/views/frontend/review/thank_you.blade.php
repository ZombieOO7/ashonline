@extends('frontend.layouts.default')
@section('title',__('frontend.order.thank_you') )
@section('content')
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',__('frontend.review.feedback') ,route('home')))
<div class="container">
  <div class="row">
    <div class="col-md-12 mrgn_bt_30 mrgn_tp_40">
      <div class="row">
        <div class="col-lg-12 text-center thank_content">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <img src="{{ asset('frontend/images/thankyou_img.png') }}" alt="thank you" title="thank you">
              <h1>{{ __('frontend.order.thank_you') }}</h1>
              <p>{{ __('frontend.review.for_providing_us_feedback') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection