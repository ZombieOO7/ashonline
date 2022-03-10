
{{ Str::limit(@$contact->message, 60) }}
@if (strlen(@$contact->message) >= 60)
    <a href="javascript:void(0);" class="shw-dsc" data-backdrop="static" data-keyboard="false" data-subject="{{ @$contact->subject }}" data-description="{{ @$contact->message }}" data-toggle="modal" data-target="#DescModal">{{ __('formname.read_more') }}</a>
@endif