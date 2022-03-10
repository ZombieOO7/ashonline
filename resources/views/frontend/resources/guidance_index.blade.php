@extends('frontend.layouts.default')
@php
$title = __('admin/resorces.list_title', ['type' => $category->name]);
@endphp
@section('title', @$title)
@section('breadcrumbs', Breadcrumbs::render('resources', $title, route('resources/index', $type)))
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mrgn_bt_30">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page_title def_ttitle">{{ $category->name }}</h1>
                    <p class="def_p mrgn_bt_30">{!! nl2br(e($category->content)) !!}</p>
                </div>
                <div class="col-lg-12 mrgn_bt_30">
                    <div class="guidence_scn">
                        <ul class="blog_tabs mrgn_bt_30">
                            <li><a class="@if($catSlug == '') active @endif filter" href="JavaScript:Void(0);" data-values="all">All</a></li>
                            @forelse (blogPaperCategory() as $key => $item)
                                <li><a class="filter @if($catSlug == $key) active @endif" href="JavaScript:Void(0);" data-values="{{ $key }}">{{ $item }}</a></li>
                            @empty
                            @endforelse
                        </ul>
                        <div class="blog-details">
                            <div class="row" id="all_resources">
                                @include('frontend.resources.load_guidance_resources', ['resources' => $resources])
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

