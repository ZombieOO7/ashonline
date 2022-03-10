@forelse ($blogs as $key => $item)
    <div class="col-md-6">
        <div class="inner_blog_info">
            <ul class="tag-section">
              <li>{{ @$item->guidanceCategory->title}}</li>
            </ul>
            <ul class="date-author">
              <li><span>{{ $item->created_at_date }}</span></li>
              {{-- <li>{{ __('admin/resorces.written_by')}} : {{ @$item->writtenBy->full_name}}</li> --}}
            </ul>
            <h2><a href="{{ route('eblogs/detail', $item->slug)}}" title="{{ $item->title }}">{{ $item->short_title }}</a></h2>
            <p>{!! $item->short_content !!}</p>
        </div>
    </div>
@empty
<div class="col-md-6"><h4>{{ __('admin/resorces.no_result_found') }}</h4></div>
@endforelse