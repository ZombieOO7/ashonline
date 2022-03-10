{{truncate(@$review->content, 20)}}
@if (strlen(@$review->content) >= 20)
    <a href="javascript:void(0);" class="shw-dsc" data-description="{{ @$review->content }}" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#DescModal">{{__('formname.more')}}</a>
@endif