@php
  $paperCategories = getPaperCategoryList();
  $footerCategories = footerPaperCategoryList();
  $cartItemsTotal = getEmockCartItemsCount();
  $settings = settings();
  $routeName = Route::currentRouteName();
@endphp

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    @if ( $routeName != "blogs/detail" && $routeName != "resource/detail" )
      <meta name="description" content="{{ @getWebSettings()->meta_description != null ? @getWebSettings()->meta_description  : "Welcome to AshACE Papers" }}">
      <meta name="keywords" content="{{ @getWebSettings()->meta_keywords != null ? @getWebSettings()->meta_keywords : 'AshACE Papers' }}">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    @endif
    @yield('meta_tags')
    <link rel="canonical" href="{{ config('app.url')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('frontend/images/favicon.png') }}" rel="icon">
    <link href="{{ asset('images/apple-touch-icon.png')}}" rel="apple-touch-icon">
    @include('frontend.includes.headcss')
    @yield('pageCss')
    <title>@yield('title') | {{config('app.name')}}</title>
  </head>
  <body>
    @include('frontend.includes.header')
    @yield('breadcrumbs')
    @yield('content')
    @include('frontend.includes.footer')
    @include('frontend.includes.footjs')
    @yield('pageJs')
    @include('vendor.sweetalert.view')
</body>
</html>