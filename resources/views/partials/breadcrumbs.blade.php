@php
    $routeName = Route::currentRouteName();
@endphp
@if (count($breadcrumbs))
    <div class="container cmn_brdcm @if($routeName == 'paper.detail' || $routeName == 'papers') d-flex-scn @endif">
        <ul class="braedcrumb_li">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li class=""><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @else
                    <li class="">{{ $breadcrumb->title }}</li>
                @endif
            @endforeach
        </ul>
        @if ($routeName == 'paper.detail' || $routeName == 'papers')
            <form id='searchPaper'>
                <div class="title_serach">
                    <div class="categories_serach_bar">
                        {!! Form::text('search_text', null, array('placeholder' => 'Search Papers','class' => 'form-control','id'=>'search_text')) !!}
                        <button class="btn btn-primary" type="button" onclick="search();">Search</button>
                    </div>
                    <span class="searchError"></span>
                </div>
            </form>
        @endif
    </div>
@endif
