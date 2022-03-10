
{{ Str::limit(@$mockTest->title, 30) }}
@if (strlen(@$mockTest->title) >= 30)
    <a href="javascript:void(0);" class="shw-dsc"  data-description="{{ @$mockTest->title }}" data-toggle="modal" data-target="#DescModal">{{ __('formname.read_more') }}</a>
@endif