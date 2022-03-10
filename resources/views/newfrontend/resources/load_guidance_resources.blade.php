@forelse ($resources as $key => $item)
    <div class="col-md-6">
        <div class="inner_blog_info">
            <ul class="tag-section">
            <li>{{ @$item->guidanceCategory->title}}</li>
            </ul>
            <ul class="date-author">
            <li><span>{{ $item->created_at_date }}</span></li>
            </ul>
            <h2><a href="{{ route('eresource/detail', $item->slug)}}" title="{{ $item->title }}">{{ $item->short_title }}</a></h2>
        </div>
    </div>
@empty
<div class="col-md-6"><h4>{{ __('admin/resorces.no_result_found') }}</h4></div>
@endforelse