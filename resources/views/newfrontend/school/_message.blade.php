{!! Str::limit(@$school->short_description, 30) !!}
@if (strlen(@$school->short_description) >= 30)
    <a href="{{ route('school',['slug'=>@$school->page_slug]) }}" class="shw-dsc"  data-description="{{ @$school->short_description }}">{{ __('formname.read_more') }}</a>
@endif