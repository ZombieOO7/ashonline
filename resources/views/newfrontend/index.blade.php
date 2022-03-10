@extends('newfrontend.layouts.default')
@section('title','Home')
@section('content')
<!--inner content-->
{{-- Banner Section --}}
<section class="banner_sc_v1">
	<div id="BannerIndicators" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#BannerIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#BannerIndicators" data-slide-to="1"></li>
			<li data-target="#BannerIndicators" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner">
			<div class="carousel-item active" style="background: url({{asset('newfrontend/images/bnnr_1.jpg')}});">
				<div class="row">
					<div class="col-md-7">
						<div class="banner_content">
							<h1> {!! @$homeSliderSection->slider_1_title !!}</h1>
							{!! @$homeSliderSection->slider_1_sub_title !!}
							{!! @$homeSliderSection->slider_1_description !!}
							<a href="{{route('parent-sign-up')}}" class="btn btn_join">Join Us</a>
						</div>
					</div>
					<div class="col-md-5 text-right d-flex align-items-end">
						<img src="{{asset('newfrontend/images/banner_img.png')}}" class="img-fluid" alt="">
					</div>
				</div>
			</div>
			<div class="carousel-item" style="background: url({{asset('newfrontend/images/bnnr_2.jpg')}});">
				<div class="row">
					<div class="col-md-7">
						<div class="banner_content">
							<h1> {!! @$homeSliderSection->slider_2_title !!}</h1>
							{!! @$homeSliderSection->slider_2_sub_title !!}
							{!! @$homeSliderSection->slider_2_description !!}
							<a href="{{route('parent-sign-up')}}" class="btn btn_join">Join Us</a>
						</div>
					</div>
					<div class="col-md-5 text-right d-flex align-items-end">
						<img src="{{asset('newfrontend/images/bnr_2_img.png')}}" class="img-fluid" alt="">
					</div>
				</div>
			</div>
			<div class="carousel-item" style="background: url({{asset('newfrontend/images/bnnr_3.jpg')}});">
				<div class="row">
					<div class="col-md-7">
						<div class="banner_content">
							<h1> {!! @$homeSliderSection->slider_3_title !!}</h1>
							{!! @$homeSliderSection->slider_3_sub_title !!}
							{!! @$homeSliderSection->slider_3_description !!}

							<a href="{{route('parent-sign-up')}}" class="btn btn_join">Join Us</a>
						</div>
					</div>
					<div class="col-md-5 text-right d-flex align-items-end">
						<img src="{{asset('newfrontend/images/bnr_3_img.png')}}" class="img-fluid" alt="">
					</div>
				</div>
			</div>

		</div>

	</div>
</section>
{{-- our module section --}}
<section class="mlt_sc">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="df_h3 wt_h3">{{@$homeOurModules->title}}</h3>
				<p class="df_pp wt_p">{!! @$homeOurModules->content !!}</p>
			</div>
			<div class="col-lg-4">
				<div class="wt_info_box">
					<div class="top_dlfx">
						<img src="{{asset('newfrontend/images/as_ppr.png')}}" class="img-fluid rsp_sml" alt="" title="">
						<img src="{{asset('newfrontend/images/logo_ppr.png')}}" class="img-fluid" alt="" title="">
					</div>
					<div class="inn_wt_info">
						<h4>{{@$homeOurModules->title_1}}</h4>
						<p>{{@$homeOurModules->content_1}}</p>
						<a href="{{route('papers')}}" class="ash_lgn_btn">Learn More</a>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="wt_info_box">
					<div class="top_dlfx">
						<img src="{{asset('newfrontend/images/as_mkexms.png')}}" class="img-fluid rsp_sml" alt=""
							title="">
						<img src="{{asset('newfrontend/images/logo_mkexms.png')}}" class="img-fluid" alt="" title="">
					</div>
					<div class="inn_wt_info">
						<h4>{{@$homeOurModules->title_2}}</h4>
						<p>{{@$homeOurModules->content_2}}</p>
						<a href="{{route('e-mock')}}" class="ash_lgn_btn">Learn More</a>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="wt_info_box">
					<div class="top_dlfx">
						<img src="{{asset('newfrontend/images/as_prctc.png')}}" class="img-fluid rsp_sml" alt=""
							title="">
						<img src="{{asset('newfrontend/images/logo_prctc.png')}}" class="img-fluid" alt="" title="">
					</div>
					<div class="inn_wt_info">
						<h4>{{@$homeOurModules->title_3}}</h4>
						<p>{{@$homeOurModules->content_3}}</p>
						<a href="{{route('practice')}}" class="ash_lgn_btn">Learn More</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
{{-- about ash ace --}}
<section class="abt_as_sc">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<h3>{{@$homeAboutAsh->title}}</h3>
				<img src="{{asset('newfrontend/images/qt_img.png')}}" class="img-fluid rsp_sml" alt="" title="">
			</div>
			<div class="col-md-8 about_info" id="counter">
				{!! @$homeAboutAsh->content !!}
				<div class="row">
					<div class="col-md-6 col-lg-4">
						<div class="abt_ic_bx">
							<span class="abticon abt_ic_1"></span>
							<h5 class="counter-value" data-count="{{@$homeAboutAsh->subject_title_1}}">0</h5>
							<h6>Total No. Of E-PAPER</h6>
						</div>
					</div>
					<div class="col-md-6 col-lg-4">
						<div class="abt_ic_bx">
							<span class="abticon abt_ic_4"></span>
							<h5 class="counter-value" data-count="{{@$homeAboutAsh->subject_title_2}}">0</h5>
							<h6>Total No. Of Exams</h6>
						</div>
					</div>
					<div class="col-md-6 col-lg-4">
						<div class="abt_ic_bx">
							<span class="abticon abt_ic_2"></span>
							<h5 class="counter-value" data-count="{{@$homeAboutAsh->subject_title_3}}">0</h5>
							<h6>Total No. Of Questions</h6>
						</div>
					</div>
					{{-- <div class="col-md-6 col-lg-3">
						<div class="abt_ic_bx">
							<span class="abticon abt_ic_5"></span>
							<h5 class="counter-value" data-count="942">0</h5>
							<h6>Happy Customers</h6>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</div>
</section>
{{-- why choose ace --}}
<section class="whychooss_sc">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="df_h3">{{@$homeWhyChooseAsh->title}}</h3>
				<p class="df_pp">{{@$homeWhyChooseAsh->content}}</p>
			</div>
			<div class="col-md-4 whychooss_info">
				<i class="wcs_ic wc_crc1"></i>
				<h4>{{@$homeWhyChooseAsh->title_1}}</h4>
				<p>{{@$homeWhyChooseAsh->content_1}}</p>
			</div>
			<div class="col-md-4 whychooss_info">
				<i class="wcs_ic wc_crc2"></i>
				<h4>{{@$homeWhyChooseAsh->title_2}}</h4>
				<p>{{@$homeWhyChooseAsh->content_2}}</p>
			</div>
			<div class="col-md-4 whychooss_info">
				<i class="wcs_ic wc_crc3"></i>
				<h4>{{@$homeWhyChooseAsh->title_3}}</h4>
				<p>{{@$homeWhyChooseAsh->content_3}}</p>
			</div>
			<div class="col-md-4 whychooss_info">
				<i class="wcs_ic wc_crc4"></i>
				<h4>{{@$homeWhyChooseAsh->title_4}}</h4>
				<p>{{@$homeWhyChooseAsh->content_4}}</p>
			</div>
			<div class="col-md-4 whychooss_info">
				<i class="wcs_ic wc_crc5"></i>
				<h4>{{@$homeWhyChooseAsh->title_5}}</h4>
				<p>{{@$homeWhyChooseAsh->content_5}}</p>
			</div>
			<div class="col-md-4 whychooss_info">
				<i class="wcs_ic wc_crc6"></i>
				<h4>{{@$homeWhyChooseAsh->title_6}}</h4>
				<p>{{@$homeWhyChooseAsh->content_6}}</p>
			</div>

		</div>
	</div>
</section>
{{-- video  and review section --}}
<section class="mdl_sc">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="video-container">
					<div class="js-load-video-medium" data-service="youtube" data-placeholder=""
						data-embed="{{@$homeVideoSection->video_url}}">
						<a href="#" class="btn btn__large btn__green btn__notext btn__modal--play"
							title="Video afspelen"></a>
					</div>
				</div>
			</div>
			<div class="col-md-6 vrtcl_algn_mddl">
				<div class="vdcontent">
					<h6>{{@$homeVideoSection->title}}</h6>
					<p>{{@$homeVideoSection->content}}</p>
				</div>
			</div>
			<div class="col-md-12 text-center">
				<h3 class="df_h3">Parents Are Happy & So Their Kids</h3>
			</div>
			@include('newfrontend.testinomial')
		</div>
	</div>
</section>
{{-- help section --}}
<section class="wehelp_sc">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="df_h3">{{@$homeHelpSection->title}}</h3>
				<p class="df_pp">{{@$homeHelpSection->content}}</p>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="mn_hlp_bx">
					<h3>{{@$homeHelpSection->title_1}}</h3>
					<div class="inn_hlp_bx">
						<h4>{{@$homeHelpSection->title_1}}</h4>
						<p>{{@$homeHelpSection->content_1}}</p>
						<h5>01.</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="mn_hlp_bx">
					<h3>{{@$homeHelpSection->title_2}}</h3>
					<div class="inn_hlp_bx">
						<h4>{{@$homeHelpSection->title_2}}</h4>
						<p>{{@$homeHelpSection->content_2}}</p>
						<h5>02.</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="mn_hlp_bx">
					<h3>{{@$homeHelpSection->title_3}}</h3>
					<div class="inn_hlp_bx">
						<h4>{{@$homeHelpSection->title_3}}</h4>
						<p>{{@$homeHelpSection->content_3}}</p>
						<h5>03.</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="mn_hlp_bx">
					<h3>{{@$homeHelpSection->title_4}}</h3>
					<div class="inn_hlp_bx">
						<h4>{{@$homeHelpSection->title_4}}</h4>
						<p>{{@$homeHelpSection->content_4}}</p>
						<h5>04.</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
{{-- top school section --}}
<section class="topschool_sc">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="df_h3">{{@$homeSchoolSection->title}}</h3>
				<p class="df_pp">{{@$homeSchoolSection->content}}</p>
			</div>
			<div class="col-md-12">
				<ul class="scl_list row">
					@forelse($schools as $school)
					@php
						$logoPath = ($school->logo != null && file_exists(storage_path().'/'.'app/public/uploads/'.$school->logo)) ? url('storage/app/public/uploads/'. $school->logo) : asset('images/mock_img_tbl.png');
					@endphp
					<li class="col-md-2">
						<a href="{{route('school',['slug'=>@$school->page_slug])}}">
							<div class="flip-card">
								<div class="flip-card-inner">
									<div class="flip-card-front">
										<img src="{{$logoPath}}" alt="" class="img-fluid" width="150px" height="150px">
									</div>
									<div class="flip-card-back">
										<div class="vrtcl_algn_mddl">
											<p>{{@$school->title}}</p>
										</div>

									</div>
								</div>
							</div>
						</a>
					</li>
					@empty
					@endforelse
				</ul>
			</div>
			<div class="col-md-12 text-center">
				<a href="{{route('school-list')}}" class="ash_lgn_btn">View All</a>
			</div>
		</div>
	</div>
</section>
<!--close inner content-->
@stop
@section('pageJs')
<script>
    var rateImagePath = '{{asset("newfrontend/images")}}';
</script>
<script src="{{asset('newfrontend/js/landing.js')}}"></script>
@endsection
