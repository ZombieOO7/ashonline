@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('order view')))
<a class="view" href="{{route('order_view',['uuid' => @$order->uuid])}}" title="View">
    <i class="fas fa-eye"></i>
</a>
@endif
