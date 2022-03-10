@extends('newfrontend.layouts.default')
@section('title','Thank You')
@section('content')
    <div class="container">
        <div class="thank_you_scn">
            <div class="row">
                <div class="col-md-12 in_ttl mrgn_bt_30">
                    <h1 class="df_h3">Thanks For Joining</h1>
                </div>
                <div class="col-lg-12 thank_content">
                    <div class="row">
                        <div class="col-lg-7 col-xl-6">
                            <img src="{{ asset('newfrontend/images/thankyou_img.png') }}" alt="thank you" title="thank you">
                            <h2>Success</h2>
                            <p>You'll receive email regarding your child login details.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
