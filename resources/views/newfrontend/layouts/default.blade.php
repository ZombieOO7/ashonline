@php
    $cartItemsTotal = getEmockCartItemsCount();
    $isParent = isParent();
@endphp
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
{{--      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">--}}

      <link href="{{asset('newfrontend/images/favicon.png')}}" rel="icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrfToken" id="csrfToken" content="{{ csrf_token() }}">
    @include('newfrontend.includes.headcss')
    @yield('pageCss')
    <title>@yield('title') | {{config('app.name')}}</title>

  </head>
  <body>
    @include('newfrontend.includes.header')
    @yield('content')
    @if($isParent == true)
      @include('newfrontend.includes.subscribe')
    @endif
    @include('newfrontend.includes.footer')
    @include('newfrontend.includes.footjs')
    @yield('pageJs')
  </body>
</html>
