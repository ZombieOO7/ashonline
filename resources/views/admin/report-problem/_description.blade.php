{{ Str::limit(@$problem->description, 30) }}
@if (strlen(@$problem->description) >= 30)
    <a href="javascript:void(0);" class="shw-dsc" data-backdrop="static" data-keyboard="false" data-subject="{{ @$title }}" data-description="{{ @$problem->description }}" data-toggle="modal" data-target="#DescModal">{{ __('formname.read_more') }}</a>
@endif