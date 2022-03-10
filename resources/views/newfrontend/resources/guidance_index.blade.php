@extends('newfrontend.layouts.default')

@php
$title = __('admin/resorces.list_title', ['type' => $category->name]);
@endphp

@section('title', @$title)

@section('breadcrumbs', Breadcrumbs::render('resources', $title, route('eresources/index', $type)))

@section('content')
<link rel="stylesheet" href="{{asset('frontend/css/blog.css')}}">
<div class="container">
    <div class="row">
        <div class="col-md-12 mrgn_bt_30">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page_title def_ttitle">{{ $category->name }}</h2>
                    <p class="def_p mrgn_bt_30">{!! nl2br(e($category->content)) !!}</p>
                </div>
                <div class="col-lg-12 mrgn_bt_30">
                    <div class="guidence_scn">
                        <ul class="blog_tabs mrgn_bt_30">
                            <a class="filter @if($catSlug == '') active @endif e-mck-btn" href="JavaScript:Void(0);" data-values="all">All</a>
                            @forelse (blogPaperCategory() as $key => $item)
                                <a class="filter  e-mck-btn @if($catSlug == $key) active @endif"
                                   href="JavaScript:Void(0);"
                                   data-values="{{ $key }}">{{ $item }}</a>
                            @empty
                            @endforelse
                        </ul>
                        <div class="blog-details">
                            <div class="row" id="all_resources">
                                @include('newfrontend.resources.load_guidance_resources', ['resources' => $resources])
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
<script src="{{ asset('frontend/js/resources/guidance_index.js') }}" ></script>
@endsection

