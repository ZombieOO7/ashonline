@extends('newfrontend.layouts.default')
@section('title',__('frontend.about'))
@section('content')
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',__('frontend.about'),route('home')))
<div class="tuition_head about_head">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center bnr-content">
            <h3>{!! @$aboutBannerSection->title !!}</h3>
            <h3>{!! @$aboutBannerSection->sub_title !!}<span>!</span></h3>
            <div class="bnr_p">{!! @$aboutBannerSection->content !!}</div>
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
            @forelse (@$paperCategoryList as $category)
                <li><a href="{{ route('paper.detail',['slug' => @$category->slug ]) }}" style="background-color:{{@$category->color_code}}">{{ @$category->title }}</a></li>
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
