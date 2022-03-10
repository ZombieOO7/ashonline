@extends('frontend.layouts.default')
@section('title', @$cms->title)
@section('content')
@section('breadcrumbs', Breadcrumbs::view('partials/breadcrumbs','common_breadcrumb',@$cms->title,Route::currentRouteName()))
<div class="container">
    <div class="row">
      <div class="col-md-12 mrgn_bt_30 mrgn_tp_40">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="small_title">{{ @$cms->title }}</h1>
          </div>
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-12 pdng_right">
                <div class="info-title">{!! @$cms->content !!}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
