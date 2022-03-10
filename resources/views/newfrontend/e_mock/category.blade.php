@extends('newfrontend.layouts.default')
@section('title',__('frontend.emock.category'))
@section('content')
<section class="mock_categoris pdng_btm_90">
	<div class="container">
		<div class="row">
			<div class="col-xl-11">
				<div class="row">
					<div class="col-md-12 in_ttl">
						<h3 class="df_h3">{{__('frontend.emock.category')}}</h3>
						{{-- <p class="df_pp">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit lectus ac
							dolor rhoncus malesuada. Morbi at cursus odio. Morbi pulvinar libero a purus tincidunt
							pharetra.</p> --}}
					</div>
					<div class="col-md-12">
						<div class="rspnsv_table categry_tble">
							<table class="table-bordered table-striped table-condensed cf">
								<thead class="cf">
									<tr>
										<th class="img_hd">Images</th>
										<th>Category</th>
										<th>Types</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@forelse($examBoards as $board)
									@php
										$color = array_rand(config('constant.bgColor'),1);
									@endphp
									<tr class="{{$color}}">
										<td data-title="Images">
											<img src="{{ asset('newfrontend/images/mock_cat_exam.png') }}" class="mx-wd-95">
										</td>
										<td data-title="Category">{{@$board->title}}</td>
										<td data-title="Types">
											@forelse($board->relatedMockTests as $mockTest)
												<p> {{@$mockTest->title}}</p>
											@empty
											@endforelse
											@if(count($board->mockTests) > 5)
											<a href="{{route('emock-exam',['slug'=>@$board->slug])}}" class="view_all">View All</a>
											@endif
										</td>
										<td data-title="" class="min-wd-140">
											<a href="{{route('emock-exam',['slug'=>@$board->slug])}}" class="add_to_cart">{{__('frontend.emock.view_all')}}</a>
										</td>
									</tr>
									@empty
									@endforelse
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop
