<a class=" view" href="{{ route('parent-payment.detail',['uuid'=>@$payment->id]) }}" title="{{__('formname.view_payments')}}">
    <i class="fas fa-eye"></i>
</a>
<a href="javascript:;" data-url="{{route('send-invoice')}}" data-id='{{@$payment->id}}' class="sendMail" title="{{__('formname.send_mail')}}">
    <i class="flaticon-multimedia-3"></i>
</a>