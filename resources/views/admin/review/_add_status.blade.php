@if(@$review->status == 2)
    <span class="m-badge  m-badge--danger m-badge--wide">{{__('Unpublished')}}</span>
@else
    <span class="m-badge  m-badge--success m-badge--wide">{{__('Published')}}</span>
@endif