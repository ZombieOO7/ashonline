@if(@$payment->status == config('constant.status_inactive_value'))
    <span class="m-badge  m-badge--danger m-badge--wide">{{__('Unpaid')}}</span>
@else
    <span class="m-badge  m-badge--success m-badge--wide">{{__('Paid')}}</span>
@endif