@extends('frontend.layouts.default')
@section('title',__('formname.tuition'))
@section('content')
<!--inner content-->
    @section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',__('formname.tuition'),route('home')))
    
  <div class="tuition_head">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center bnr-content">
            <h1>
                {!! @$tutionsBannerSection->title !!}
            </h1>
            <h2>
                {!! @$tutionsBannerSection->sub_title !!}<span>!</span>
            </h2>
            <div class="bnr_p">
                {!! @$tutionsBannerSection->content !!}
            </div>
            <a href="{{ route('contact-us') }}" class="btn btn-primary btm-buy">{{ __('formname.contact_us') }}</a>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9 tuition_bnrbtm">
        <h3 class="def_ttitle">{!! @$tutionsMainSection->title !!} </h3>
        {!! @$tutionsMainSection->content !!}
      </div>
    </div>
  </div>
  <div class="tuition_middle">
    <div class="container">
      <div class="row">
        <div class="col-md-5 d-flex align-items-end">
          <img src="{{ asset('frontend/images/tuition_img.png') }}" class="img-fluid" alt="middle image" title="middle image">
        </div>
        <div class="col-md-7">
          <h4 class="def_ttitle">{!! @$tutionsSubSection->title !!}</h4>
            <div class="def_p mrgn_bt_30">
                {!! @$tutionsSubSection->content !!}
            </div>
        </div>
      </div>
    </div>
  </div>
  <!--close inner content-->
  @endsection