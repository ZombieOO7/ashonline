@extends('newfrontend.layouts.default')
@section('title',__('frontend.emock.mock_detail'))
@section('content')
@php
$isParent = isParent();
$routeArray = [
	[
		'title' => __('frontend.emock.title'),
		'route' => route('e-mock'),
	],
	[
		'title' => @$examBoard->title,
		'route' => route('emock-exam',['slug'=>@$examBoard->slug]),
	],
	[
		'title' => __('frontend.emock.mock_detail'),
		'route' => '#',
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
<div class="container">
	<div class="row">
		<div class="col-md-12 in_ttl mrgn_bt_30">
			<h1 class="df_h3">{{__('frontend.emock.mock_detail')}}</h1>

		</div>
		<div class="col-lg-4 dtls-lg-4">
			<img src="{{ @$mockTest->image_path }}" class="img-fluid" width="300px" height="300px">
		</div>
		<div class="col-lg-8 dtls-lg-8 d_sd_info">
			<h3>{{ $mockTest->title }}</h3>
			<span class="d_prize">£ {{ $mockTest->price }} </span>
			<div class="d_ratings">
				<div class="fixedStar fixedStar_readonly" data-score='{{@$mockTest->average_rate}}'></div>
				<span class="rate_counts">{{ @$mockTest->average_rate }} | 5 Reviews</span>
			</div>
			<div class="avlbl_bx">
				@if(@$mockTest->status == 1)
				<h6>Available On</h6>
				@else
				<h6>Not Available</h6>
				@endif

				<h4>
					{{@$mockTest->proper_start_date_and_end_date}}
				</h4>
				<h4>
					Duration : {{@$mockTest->total_paper_time}}
				</h4>
			</div>
			<div class="added-crt">
				@if(count($checkProductInSession)>0)
				<button class="btn btn-addtocar btn_added">{{ __('frontend.papers.added') }}</button>
				@else
					@if($flag==true)
					<button class="btn btn-addtocar add_to_cart addToCart" data-url="{{route('emock-add-to-cart')}}"
					data-mock_id="{{ @$mockTest->id }}">{{__('frontend.emock.buy_now')}}</button>
					@endif
				@endif
				@if(count($checkProductInSession)>0)
				<a href="{{ route('emock-cart') }}" class="btn btnviewcart mt-3">
					{{ __('frontend.cart.view_cart') }} <span class="ash-right-thin-chevron"></span>
				</a>
				@endif
			</div>
			<hr class="def_hr">
				{!! @$mockTest->header !!}
		</div>

		<div class="col-md-12">
			<hr class="def_hr mrgn_bt_25">
			<ul class="nav nav-pills" id="pills-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link e-mck-btn active" id="description-tab" data-toggle="pill"
						href="#pills-description" role="tab" aria-controls="pills-description"
						aria-selected="true">Description</a>
				</li>
				<li class="nav-item">
					<a class="nav-link e-mck-btn" id="instructions-tab" data-toggle="pill" href="#pills-instructions"
						role="tab" aria-controls="pills-instructions" aria-selected="false">Instructions</a>
				</li>
				<li class="nav-item">
					<a class="nav-link e-mck-btn" id="reviewsratings-tab" data-toggle="pill"
						href="#pills-reviewsratings" role="tab" aria-controls="pills-reviewsratings"
						aria-selected="false">Reviews & Ratings</a>
				</li>
			</ul>
			<hr class="def_hr mrgn_tp_15">
		</div>
		<div class="col-md-12">
			<div class="tab-content mb-5 dtl_tabs" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-description" role="tabpanel"
					aria-labelledby="description-tab">
					<div class="unset-list">
						{!! @$mockTest->description !!}
					</div>
				</div>
				<div class="tab-pane fade" id="pills-instructions" role="tabpanel" aria-labelledby="instructions-tab">
					<p class="dpg_p max_100">
						<div class="unset-list">
							{!! @$mockTest->instruction !!}
						</div>
					</p>
				</div>
				<div class="tab-pane fade" id="pills-reviewsratings" role="tabpanel"
					aria-labelledby="reviewsratings-tab">
					<div class="review_sc">
						<div class="jst_sw_bx">
							<h1>{{@$mockTest->average_rate}}</h1>
							<div class="fixedStar" data-score="{{@$mockTest->average_rate}}"></div>
						</div>
						<h2>{{@$mockTest->total_review}} Reviews</h2>
						<div class="content mCustomScrollbar">
							<ul class="inner_rating_scn">
								@forelse($mockTest->mockTestReviews as $review)
								<li>
									<img src="{{ @$review->user->image_thumb }}" alt="jd" title="jd">
									<div class="rating_detail_scn">
										<h3>{{@$review->user->full_name}}</h3>
										<div class="fixedStar" data-score="{{@$review->rating}}"></div>
										<p>{{@$review->msg}}</p>
										<span>{{@$review->review_date}}</span>
									</div>
								</li>
								@empty
								<li>
									<div class="rating_detail_scn">
										<h3>No Review Found</h3>
									</div>
								</li>
								@endforelse
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 mrgn_bt_40">
			<h3 class="more_text">{{__('frontend.mock.related_papers')}}</h3>
			<div class="rspnsv_table">
				<table class="table-bordered table-striped table-condensed cf">
					<thead class="cf">
						<tr>
							<th class="img_hd">{{__('formname.mock.image')}}</th>
							<th>{{__('formname.mock.exam_name')}}</th>
							<th>{{__('formname.mock.date')}}</th>
							<th>{{__('formname.mock.time')}}</th>
							<th>{{__('formname.mock.price')}}</th>
							@if($isParent==true)
								<th>{{__('formname.mock.action')}}</th>
							@endif
						</tr>
						<tr class="middle_hdng_rw">
							<th colspan="6" align="center"> {{ @$examBoard['mockTests'][0]->grade->title }}</th>
						</tr>
					</thead>
					<tbody>
						@forelse($examBoard['mockTests'] as $mkey => $mockTest)
						<tr>
							<td data-title="Images">
								<a href="{{ route('mock-detail', @$mockTest->uuid ) }}">
									<img src="{{@$mockTest->image_path }}"
										class="mx-wd-95" width="100px" height="100px">
								</a>
							</td>
							<td data-title="Exam Name">
								<div>{{ @$mockTest->title }}</div>
								<a href="{{ route('mock-detail', @$mockTest->uuid ) }}" class="text-primary">
									{{__('formname.view_detail')}}
								</a>
							</td>
							<td data-title="Date">
								{{@$mockTest->proper_start_date_and_end_date }}
							</td>
							<td data-title="Time">
								{{ @$mockTest->mockTestSubjectTime->proper_time }}
							</td>
							<td data-title="Price">{{config('constant.default_currency_symbol')}}
								{{@$mockTest->price}}</td>
							@if($isParent==true)
								<td data-title="Action" class="min-wd-140"><a href="javascript:;"
										data-url="{{route('emock-add-to-cart')}}"
										data-mock_id="{{ @$mockTest->id }}"
										class="add_to_cart addToCart">{{__('formname.mock.add_to_cart')}}</a></td>
							@endif
						</tr>
						@empty
						<tr>
							<td colspan="6">
								<center>{{__('formname.records_not_found')}}</center>
							</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>
@stop
@section('pageJs')
<script>
	$(function() {
        $(window).load(function(){
            $("a[rel='load-content']").click(function(e){
                e.preventDefault();
                var url=$(this).attr("href");
                $.get(url,function(data){
                $(".content .mCSB_container").append(data); //load new content inside .mCSB_container
                //scroll-to appended content
                $(".content").mCustomScrollbar("scrollTo","h2:last");
                });
            });

            $(".content").delegate("a[href='top']","click",function(e){
                e.preventDefault();
                $(".content").mCustomScrollbar("scrollTo",$(this).attr("href"));
            });
        });
    });
</script>
<script>
	var cartURL = "{{ route('emock-cart') }}";
	$(document).find('.fixedStar').raty({
		readOnly:  true,
		path    :  '{{asset("newfrontend/images")}}',
		starOff : 'star-off.svg',
		starOn  : 'star-on.svg',
		starHalf:   'star-half.svg',
		start: $(document).find(this).attr('data-score')
	});
</script>

@endsection
