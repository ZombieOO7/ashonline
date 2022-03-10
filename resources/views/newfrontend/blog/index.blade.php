@extends('newfrontend.layouts.default')

@php
$title = __('admin/resorces.blog_title');
@endphp

@section('title', @$title)

@section('breadcrumbs', Breadcrumbs::render('blogs', $title, route('eblogs/index')))
@section('content')
<link rel="stylesheet" href="{{asset('frontend/css/blog.css')}}">
<div class="container">
    <div class="row">
        <div class="col-md-12 mrgn_bt_30 mrgn_tp_30">
            <div class="row">
                {{-- <div class="col-md-12 mrgn_bt_10"><br>
                    <h1 class="small_title">{{ $title }}</h1>
                </div> --}}
                <div class="col-lg-12 mrgn_bt_30">
                    <div class="guidence_scn">
                        <ul class="blog_tabs mrgn_bt_30">
                            <li><a class="e-mck-btn filter @if($catSlug == '') active @endif" href="JavaScript:Void(0);" data-values="all">{{ __('admin/resorces.all') }}</a></li>
                            @forelse (blogPaperCategory() as $key => $item)
                                <li><a class="e-mck-btn filter @if($catSlug == $key) active @endif" href="JavaScript:Void(0);" data-values="{{ $key }}">{{ $item }}</a></li>
                            @empty
                            @endforelse
                        </ul>
                        <div class="blog-details">
                            <div class="row" id="all_blogs">
                                @include('newfrontend.blog.load_blog', ['eblogs' => $blogs])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageJs')
<script>
var catSlug = "all";
@if($catSlug)
    catSlug = "{{ $catSlug }}";
@endif
</script>
<script src="{{ asset('frontend/js/blog/index.js') }}" ></script>
@endsection

