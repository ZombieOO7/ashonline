<div class="form-group m-form__group row row_div">
    <div class="col-lg-6">
        <label class="col-form-label">
            <b>{{ __('formname.orders.number') }} : </b>
            {{ @$payment->order->order_no }}
            <span class="tddvdr">|</span>
            {{ orderDateFormat(@$payment->created_at)}}
        </label>
    </div>
    {{-- <div class="col-lg-2">
        <label class="col-form-label"><b>{{__('formname.status')}} : </b>
            @include('admin.payment._add_status',['paymert' => @$paynmet ])
        </label>
    </div> --}}
</div>