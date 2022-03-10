@extends('frontend.layouts.default')
@section('title', __('frontend.cart.cart') )
@section('pageCss')
    <style>
        .error {
            color: red;
        }
    </style>
@endsection
@section('content')
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',__('frontend.cart.cart'),route('home')))
<!-- CHECK IF CART IS EMPTY OR NOT -->
@if(empty(@$products))
    @include('frontend.cart.empty')
@else 
<div class="container">
    @include('frontend.includes.flashmessages')  
    <div class="row">
        <div class="col-md-12 mrgn_bt_30 mrgn_tp_40">
        <div class="row">
            <div class="col-lg-8">
            <div class="row">
                <div class="col-6"><h1 class="small_title">{{ __('frontend.cart.cart') }}</h1></div>
                <div class="col-6">
                    <div class="cart_action rigth_clear_cart">
                        <a href="javascript:void(0);" class="clear_lnk clr-cart">{{ __('frontend.cart.clear_cart') }}</a>
                    </div>
                </div>
                <div class="col-md-12 mrgn_tp_20">
                <div class="rspnsv_table cart-table">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf">
                        <thead class="cf">
                            <tr>
                            <th></th>
                            <th>{{ __('frontend.cart.product_name') }}</th>
                            <th>{{ __('frontend.cart.price') }}</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (@$checkoutProducts as $paper)
                            <tr>
                                <td data-title="{{ __('frontend.images') }}">
                                    <a href="{{ route('paper-details',['category' => @$paper->category->slug,'slug' => @$paper->slug]) }}" class="pr_img"><img src="{{ @$paper->thumb_path }}" class="img-fluid" alt="english pack" title="{{ @$paper->title }}"></a>
                                </td>
                                <td data-title="{{ __('frontend.product_name') }}"><a href="{{ route('paper-details',['category' => @$paper->category->slug,'slug' => @$paper->slug]) }}" title="{{ @$paper->title }}">{{ @$paper->title_text }}</a></td>
                                <td data-title="{{ __('frontend.price') }}">{{ @$paper->price_text }}</td>
                                <td data-title="{{ __('frontend.action') }}"><button class="btn btndelete dlt-crt-prdt" data-paper-id="{{ @$paper->id }}"><span class="ash-delete"></span></button></td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ Form::open(['route' => 'remove-paper','method'=>'POST','class' => 'rmv-prdt-frm-id']) }}
                    @csrf
                    {{ Form::hidden('paper_id','',['id' => 'hidden-paper-id']) }}
                {{ Form::close() }}

                {{ Form::open(['route' => 'clear-cart','method'=>'POST','class' => 'clr-crt-frm-id']) }}
                    @csrf
                {{ Form::close() }}
                </div>
            </div>
            </div>

            <!-- APPLY COUPON CODE STARTS HERE -->
            @include('frontend.cart.coupon')
            <!-- APPLY COUPON CODE ENDS HERE -->

            <!-- CART RELATED PRODUCTS STARTS HERE -->
            @include('frontend.orders.related_papers')
            <!-- CART RELATED PRODUCTS ENDS HERE -->

        </div>
        </div>
    </div>
    </div>
@endif
@endsection
@section('pageJs')
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/cart/cart.js') }}" ></script>
@endsection