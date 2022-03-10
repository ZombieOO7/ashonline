{{ Str::limit(@$payment->description, 30) }}
@if (strlen(@$payment->description) >= 30)
    <a href="javascript:void(0);" class="shw-dsc"  data-description="{{ @$payment->description }}" data-toggle="modal" data-target="#descriptionModal">{{ __('formname.read_more') }}</a>
@endif