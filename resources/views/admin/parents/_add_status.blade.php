@if(@$parent->status == config('constant.status_inactive_value'))
    <span class="m-badge  m-badge--danger m-badge--wide">{{__('formname.inactive')}}</span>
@elseif(@$parent->status == config('constant.status_deactivate_value'))
    <span class="m-badge  m-badge--danger m-badge--wide">{{__('formname.deactivate')}}</span>
@else
    <span class="m-badge  m-badge--success m-badge--wide">{{__('formname.active')}}</span>
@endif
