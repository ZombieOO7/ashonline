@extends('newfrontend.layouts.default')

@section('meta_tags')
<meta name="keywords" content="{{ @$blog->meta_keyword }}">
<meta name="description" content="{{ @$blog->meta_description }}">
@endsection

@php
$title = __('admin/resorces.blog_title');
@endphp

@section('title', @$blog->meta_title)
@if($detailType == "blogs")
    @section('breadcrumbs', Breadcrumbs::render('blogs', $title, route('eblogs/index')))
@else
    @section('breadcrumbs', Breadcrumbs::render('resources', @$category->name, route('resources/index', @$category->slug)))
@endif
@section('content')
<link rel="stylesheet" href="{{asset('frontend/css/blog.css')}}">
<div class="container">
    <div class="row">
        <div class="col-md-12 mrgn_bt_30 mrgn_tp_30">
            <div class="row">
            <div class="col-lg-12 mrgn_bt_30">
                    <div class="row">
                    <div class="col-lg-8 order-2 order-lg-1">
                        <div class="inner-blog-details">
                            <div class="inner_blog_info">
                                <ul class="tag-section">
                                <li>{{ @$blog->guidanceCategory->title}}</li>
                                </ul>
                                <ul class="date-author">
                                <li><span>{{ $blog->created_at_date }}</span></li>
                                {{-- <li>{{ __('admin/resorces.written_by')}} : {{ @$blog->writtenBy->full_name}}</li> --}}
                                </ul>
                                <h2>{{ $blog->title }}</h2>
                                <img src="{{ $blog->featured_img }}" alt="{{ $blog->featured_original_name }}" title="blog" class="img-fluid">
                                {!! $blog->content !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  order-1 order-lg-2">
                        <div id ="bar-fixed" class="categories_scn">
                        <h4 class="small_title">{{ __('admin/resorces.blog_category') }}</h4>
                        <ul class="blog_tabs">
                            <li><a class="active" href="@if($detailType == "blogs") {{ route('eblogs/index') }} @else {{ route('eresources/index', $detailType) }} @endif">{{ __('admin/resorces.all') }}</a></li>
                            @forelse (blogPaperCategory() as $key => $item)
                                <li><a class="filter" href="@if($detailType == "blogs") {{ route('eblogs/index', $key) }} @else {{ route('eresources/index', [$detailType, $key]) }} @endif" data-values="{{ $key }}">{{ $item }}</a></li>
                            @empty
                            @endforelse
                        </ul>
                        </div>
                    </div>
                    </div>
                <div class="blog-details latest_blog">
                    <h3 class="small_title mrgn_bt_20">{{ __('admin/resorces.latest_blog', ['type' => (($detailType == "blogs") ? 'Blog' : 'Guidance')]) }}</h3>
                    <div class="row" id="all_blogs">
                        @include('newfrontend.blog.load_blog', ['blogs' => $latestBlog])
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
    $(document).ready(function(){
      {var topLimit=$('#bar-fixed').offset().top;topLimit=topLimit-155;$(window).scroll(function(){if(topLimit<=$(window).scrollTop()){$('#bar-fixed').addClass('stickIt');$('#bar-fixed').css('top','155px');}
      else if($(window).scrollTop()){$('#bar-fixed').removeClass('stickIt');$('#bar-fixed').css('top','');}
        if($('#bar-fixed').offset().top+$("#bar-fixed").height()>$(".latest_blog").offset().top){$('#bar-fixed').css('top',-($("#bar-fixed").offset().top+$("#bar-fixed").height()-$(".latest_blog").offset().top));}});}},1000);

    /////view more less
</script>
@endsection

