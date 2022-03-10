<div class="form-group m-form__group row row_div">
    <div class="col-lg-4">
        <label class="col-form-label">
            <b>{{ __('admin_messages.commission_recevied_from_vendor') }} : </b>
            {{ config('constant.default_currency_symbol').commissionCalculation(@$itemTotalAmount,@$vendor_commission) }}
        </label>
    </div>
    <div class="col-lg-4">
        <label class="col-form-label">
            <b>{{ __('frontend.shop.total_amount') }} : </b>
            {{ config('constant.default_currency_symbol').totalAmountWithCommission(@$itemTotalAmount,commissionCalculation(@$itemTotalAmount,@$vendor_commission)) }}
        </label>
    </div>
    <div class="col-lg-4">
        <label class="col-form-label">
            <b>{{ __('admin_messages.total_amount_without_commission') }}: </b>
            {{ config('constant.default_currency_symbol').number_format((float)@$itemTotalAmount, 2, '.', '') }}
        </label>
    </div>  
</div>
{{-- <div class="form-group m-form__group row row_div">
    <div class="col-lg-4">
        <label class="col-form-label">
            <b>Refund Amount : </b>
            $0.00
        </label>
    </div>
    <div class="col-lg-4">
        <label class="col-form-label">
            <b>Final Amount : </b>
            $0.00
        </label>
    </div>
</div> --}}