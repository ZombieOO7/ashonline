{{ Str::limit(@$question->question, 30) }}
@if (strlen(@$question->question) >= 30)
    <a href="javascript:void(0);" class="shw-dsc" data-backdrop="static" data-keyboard="false" data-subject="{{ @$title }}" data-description="{{ @$question->question }}" data-toggle="modal" data-target="#DescModal">{{ __('formname.read_more') }}</a>
@endif