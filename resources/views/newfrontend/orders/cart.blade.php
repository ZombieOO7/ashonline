@extends('newfrontend.layouts.default')
@section('title','Cart')
@section('content')
@php
$websetting = getWebSettings();
$routeArray = [
	[
		'title' => __('frontend.emock.title'),
		'route' => route('e-mock'),
	],
	[
		'title' => 'Cart',
		'route' => route('emock-cart'),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
<div class="container">
	<div class="row">
		<div class="col-md-12 in_ttl mrgn_bt_30">
			<h1 class="df_h3">Cart</h1>
		</div>
		<div class="col-lg-7">
			<div class="rspnsv_table wt_brdr_bt">
				@if(count($checkoutProducts) > 0)
				<table class="table-bordered table-striped table-condensed cf">
					<thead class="cf">
						<tr>
							<th class="img_hd">{{__('formname.mock.image')}}</th>
							<th>{{__('formname.mock.exam_name')}}</th>
							<th>{{__('formname.mock.price')}}</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($checkoutProducts as $product)
						<tr>
							@if($product->paper !=null)
								<td data-title="Images"><img src="{{ @$product->paper->thumb_path }}" style="width: 100px;height:100px;"></td>
							@else
								<td data-title="Images"><img src="{{@$product->mockTest->image_path }}" style="width: 100px;height:100px;"></td>
							@endif
							@if($product->paper !=null)
							<td data-title="Exam Name"><a href="{{route('paper-details',['category' => @$product->paper->category->slug, 'slug' => @$product->paper->slug])}}">{{@$product->paper->title}}</a></td>
							@else
								<td data-title="Exam Name"><a href="{{ route('mock-detail', @$product->mockTest->uuid ) }}">{{@$product->mockTest->title}}</a></td>
							@endif
							<td data-title="Price">{{@$product->price_text}}</td>
							@if($product->paper !=null)
							<td data-title="Action" class="min-wd-140"><button class="btn btndelete dlt-crt-prdt" data-paper-id="{{ @$product->paper->id }}"><span
								class="ash-delete"></span></button></td>
							@else
								<td data-title="Action" class="min-wd-140"><button class="btn btndelete dlt-crt-prdt" data-mock-id="{{ @$product->mockTest->id }}"><span class="ash-delete"></span></button></td>
							@endif
						</tr>
						@empty
						@endforelse
					</tbody>
				</table>
				@else
				<div class="row">
					<div class="col-lg-5 mb-5">
						<img src="{{ asset('frontend/images/empty_ic.png') }}" alt="empty logo" title="empty logo">
						<h1>{{__('frontend.cart.your_cart_is_empty')}}</h1>
						<div class="">
							<a href="{{route('e-mock')}}" class="cntn_spn_btn">{{__('frontend.emock.continue_shop')}}</a>
						</div>
					</div>
				</div>
				@endif
			</div>
			@if((isset($checkoutProducts) && count($checkoutProducts) >0))
			<a href="#" class="clear_btn clr-cart">Clear Cart</a>
			@endif
			{{ Form::open(['route' => 'remove-exam','method'=>'POST','class' => 'rmv-prdt-frm-id']) }}
            @csrf
            {{ Form::hidden('mock_id','',['id' => 'hidden-mock-id']) }}
            {{ Form::hidden('paper_id','',['id' => 'hidden-paper-id']) }}
            {{ Form::close() }}

            {{ Form::open(['route' => 'clear-emock-cart','method'=>'POST','class' => 'clr-crt-frm-id']) }}
                @csrf
            {{ Form::close() }}
		</div>
		{{-- @endif --}}
		@if(count($checkoutProducts)>0 )
		<div class="col-lg-5 cart_sidebar">
			@if(@$promoCode && @$websetting->code_status ==1 && $promoCode)
				@if($couponDiscount)
					{{ Form::open(['route' => 'emock-apply-code','method'=>'POST','id' => 'code-frm-id','autocomplete' => 'off']) }}
					@csrf
					<div class="cart_sd">
						<span class="ash-coupons"></span>
						<h2 class="small_title">Promocode</h2>
						<p>{{@$promoCode->discount_1}}% OFF ORDERS ABOVE {{@config('constant.default_currency_symbol').@$promoCode->amount_1}}. {{@$promoCode->discount_2}}% OFF ORDERS ABOVE {{@config('constant.default_currency_symbol').@$promoCode->amount_2}}. USE CODE: {{@$promoCode->code}}</p>
						<div class="newsletter">
							<div class="input-group">
								<input type="text" name="code" value="{{@$promoCode->code}} ({{ __('frontend.coupon.you_saved') }} {{ config('constant.default_currency_symbol').@$couponDiscount }})" readonly class="form-control" placeholder="Enter Promocode">
								<span class="input-group-btn">
									<button class="btn remove_btn" type="submit">{{ __('frontend.coupon.remove') }}</button>
								</span>
							</div>
						</div>
					</div>
					{{ Form::hidden('type','remove') }}
					{{ Form::close() }}
				@else
					{{ Form::open(['route' => 'emock-apply-code','method'=>'POST','id' => 'code-frm-id','autocomplete' => 'off']) }}
					@csrf
					<div class="cart_sd">
						<span class="ash-coupons"></span>
						<h2 class="small_title">Promocode</h2>
						<p>{{@$promoCode->discount_1}}% OFF ORDERS ABOVE {{@config('constant.default_currency_symbol').@$promoCode->amount_1}}. {{@$promoCode->discount_2}}% OFF ORDERS ABOVE {{@config('constant.default_currency_symbol').@$promoCode->amount_2}}. USE CODE: {{@$promoCode->code}}</p>
						<div class="newsletter">
							<div class="input-group ">
								<input type="text" name="code" value="{{ old('code') }}" class="form-control" placeholder="Enter Promocode">
								<span class="input-group-btn">
									<button class="btn" type="submit">{{ __('frontend.coupon.apply_now') }}</button>
								</span>
							</div>
						</div>
					</div>
					{{ Form::hidden('type','apply') }}
					{{ Form::hidden('total',@$total) }}
					{{ Form::close() }}
				@endif
			@endif
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
							<td class="text-right clr_pnk">{{ config('constant.default_currency_symbol').@$couponDiscount }}</td>
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
			@if(Auth::guard('parent')->user() !=null)
			<a href="{{ route('emock-checkout') }}" class="btn btncheckout">{{__('frontend.emock.checkout')}}</a>
			@else
			<a href="javascript:;" class="btn btncheckout loginAlert">{{__('frontend.emock.checkout')}}</a>
			@endif
			<div class="text-center">
				<a href="{{route('e-mock')}}" class="cntn_spn_btn">{{__('frontend.emock.continue_shop')}}</a>
			</div>
		</div>
		@endif
		@include('newfrontend.orders.related_papers')
	</div>
</div>
@stop
@section('pageJs')
<script>
	var flag = true;
</script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
@endsection
