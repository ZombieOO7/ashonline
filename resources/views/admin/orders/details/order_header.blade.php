<div class="form-group m-form__group row row_div">
    <div class="col-lg-8">
        <label class="col-form-label">
            <b>{{ __('formname.orders.number') }} : </b>
            {{ @$order->order_no }}
            <span class="tddvdr">|</span>
            {!! @$order->proper_created_at !!}
        </label>
    </div>
    {{-- <div class="col-lg-4">
        <label class="col-form-label">
            <b>{{ __('formname.orders.invoice_number') }} : </b>
            {{ @$order->invoice_no }}
        </label>
    </div> --}}
</div>