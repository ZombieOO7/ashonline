@extends('frontend.layouts.default')
@section('title', '404 - Page Not Found')

@section('content')
<div class="emtpg pg405">
    <div class="container">
      <div class="row">
        <div class="col-xl-5 col-md-7"></div>
        <div class="col-xl-6 col-md-5 text-left pg404">
          <p class="p_404"><span>503.</span>  That's an error.</p>
          <p class="p_404"><span>There was an error. Please try again later. </span></p>
          <p class="p_404">That's all we know.</p>
        </div>
      </div>
    </div>
    <img src="{{ asset('frontend/images/405.jpg') }}" alt="405 image" title="405 image" class="img-fluid">
    
    
  </div>
@endsection  