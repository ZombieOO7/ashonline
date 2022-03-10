
{{ Str::limit(@$testAssessment->title, 30) }}
@if (strlen(@$testAssessment->title) >= 30)
    <a href="javascript:void(0);" class="shw-dsc"  data-description="{{ @$testAssessment->title }}" data-toggle="modal" data-target="#DescModal">{{ __('formname.read_more') }}</a>
@endif