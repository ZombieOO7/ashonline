@extends('newfrontend.layouts.default')
@section('title',__('frontend.about'))
@section('pageCss')
<link type="text/css" href="{{asset('newfrontend/css/custom.css')}}" rel="stylesheet">
@endsection
@section('content')
{{-- @section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',__('frontend.about'),route('home'))) --}}
<section class="top_link_scn mt-4">
  <section class="top_link_scn mt-4">
		@if(Auth::guard('parent')->user() == null || Auth::guard('parent')->user()['is_tuition_parent'] == 0)
			<div class="container text-center text-md-center">
				@forelse(@$examBoardEveryOne as $key => $board)
					<a href="{{ route('emock-exam',['slug'=>@$board->slug]) }}"
					class="e-mck-btn">{{ @$board->title }}</a>
				@empty
				@endforelse
			</div>
		@elseif(Auth::guard('parent')->user()['is_tuition_parent'] == 1)
			<div class="container text-center text-md-center">
				@forelse(@$examBoardBoth as $key => $boards)
					<a href="{{ route('emock-exam',['slug'=>@$boards->slug]) }}"
					class="e-mck-btn">{{ @$boards->title }}</a>
				@empty
				@endforelse
			</div>
		@endif
	</section>
<div class="tuition_head about_head">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center bnr-content">
            <h1>{!! @$aboutBannerSection->title !!}</h1>
            <h2>{!! @$aboutBannerSection->sub_title !!}<span>!</span></h2>
            <div class="bnr_p"><p>{!! @$aboutBannerSection->content !!}</p></div>
        </div>
      </div>
    </div>
</div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9 tuition_bnrbtm">
        <h3 class="def_ttitle">{!! @$aboutMainSection->title !!} </h3>
        {!! @$aboutMainSection->content !!}
      </div>
    </div>
  </div>
  <div class="we_provide">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="def_ttitle">{!! @$aboutWeProvide->title !!}</h4>
          <div class="def_p mrgn_bt_30">{!! @$aboutWeProvide->content !!}</div>
        </div>
        <div class="col-md-12 text-center">
          <ul class="cat_list">
            @forelse (@$examBoardBoth as $key => $boards)
                <li><a href="{{ route('emock-exam',['slug'=>@$boards->slug]) }}" class="{{@config('constant.bgColor2')[$key]}}">{{ @$boards->title }}</a></li>
            @empty

            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="our_team_sc">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="def_ttitle">{!! @$aboutMinds->title !!}</h4>
        </div>
        <div class="col-md-12 team_sldr">
          <div class="row">
            <div class="col-lg-3 col-sm-6">
              <img src="{{ asset(config('constant.frontend_about.team_img')) }}" class="img-fluid" alt="Team Member" title="{!! @$aboutMinds->sub_title !!}">
              <h4>{!! @$aboutMinds->sub_title !!}</h4>
              <p>{!! @$aboutMinds->note !!}</p>
              <div>
                {!! @$aboutMinds->content !!}
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <img src="{{ asset(config('constant.frontend_about.team_img')) }}" class="img-fluid" alt="Team Member" title="{!! @$aboutMinds->subject_title_1 !!}">
              <h4>{!! @$aboutMinds->subject_title_1 !!}</h4>
              <p>{!! @$aboutMinds->subject_title_4 !!}</p>
              <div>
                {!! @$aboutMinds->subject_title_1_content !!}
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <img src="{{ asset(config('constant.frontend_about.team_img')) }}" class="img-fluid" alt="Team Member" title="{!! @$aboutMinds->subject_title_2 !!}">
              <h4>{!! @$aboutMinds->subject_title_2 !!}</h4>
              <p>{!! @$aboutMinds->exam_format_title_1 !!}</p>
              <div>
                {!! @$aboutMinds->subject_title_2_content !!}
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <img src="{{ asset(config('constant.frontend_about.team_img')) }}" class="img-fluid" alt="Team Member" title="{!! @$aboutMinds->subject_title_3 !!}">
              <h4>{!! @$aboutMinds->subject_title_3 !!}</h4>
              <p>{!! @$aboutMinds->exam_format_title_2 !!}</p>
              <div>
                {!! @$aboutMinds->subject_title_3_content !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bottom_about">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <img src="{{ asset(config('constant.frontend_about.bottom_png')) }}" class="img-fluid" alt="bottom about image" title="bottom about">
          <div class="about_cnt">{!! @$aboutSubSection->content !!}</div>
        </div>
      </div>
    </div>
  </div>
@endsection
