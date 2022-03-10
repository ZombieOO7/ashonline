@if (strlen(@$review->paper->title) >= 15)
    <div class="shw-dsc" data-tooltip="tooltip" title="{{@$review->paper->title}}"> {{isset($review->paper->title)?truncate($review->paper->title, 15):'---'}} </a>
@else
    {{@$review->paper->title}}
@endif