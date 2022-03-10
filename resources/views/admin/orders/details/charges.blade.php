<div class="form-group m-form__group row row_div">
    <div class="col-lg-5">
    </div>
    <div class="col-lg-3">
        <label class="col-form-label"><b>{{ __('formname.orders.total') }} : </b>
            {{ config('constant.default_currency_symbol').number_format((float)@$order->amount, 2, '.', '') }}
        </label>
    </div>    
</div>