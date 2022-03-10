@extends('newfrontend.layouts.default')
@section('title','Thank You')
@section('content')
    <div class="container">
        <div class="thank_you_scn">
            <div class="row">
                <div class="col-md-12 in_ttl mrgn_bt_30">
                    <h1 class="df_h3">Thank You</h1>
                </div>
                <div class="col-lg-12 thank_content">
                    <div class="row">
                        <div class="col-lg-7 col-xl-6">
                            <img src="{{ asset('newfrontend/images/thankyou_img.png') }}" alt="thank you" title="thank you">
                            <h2>Success</h2>
                            <p>Your order number is: {{@$order->order_no}} </p>
                            <p>You'll receive email regarding order confirmation details and other info.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{route('firstpage')}}" class="btn btn_join">Go To Home</a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('home')}}" class="btn btn_join">Go To E-Paper</a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('e-mock')}}" class="btn btn_join">Go To E-Mock</a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('purchased-mock')}}" class="btn btn_join">Go To Purchased Mock</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
