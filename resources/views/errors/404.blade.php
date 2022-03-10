@extends('frontend.layouts.default')
@section('title', '404 - Page Not Found')

@section('content')
    <div class="emtpg">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center pg404">
              <p class="p_404">We couldn’t ﬁnd the page you’re looking for. Visit the <a href="{{ route('home') }}">Homepage</a> or <a href="{{ route('contact-us') }}">Contact us</a></p>
            </div>
          </div>
        </div>
        <img src="{{ asset('frontend/images/404.jpg') }}" alt="404 image" title="404 image" class="img-fluid">
        
        
      </div>
@endsection  