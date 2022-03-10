@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('payment view')))
<a class="view" href="{{route('payment_view',['uuid' => @$payment->uuid])}}" title="View">
    <i class="fas fa-eye"></i>
</a>
@endif
