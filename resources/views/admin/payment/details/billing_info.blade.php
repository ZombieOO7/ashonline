<div class="form-group m-form__group row row_div">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-4">
                <label class="col-form-label">
                <b>{{ __('formname.payment.info') }} </b>
                </label>
                <p>
                    <b>{{__('formname.payment.amount')}} :</b> {{ @$payment->amount }}
                    <br><b>{{__('formname.payment.date')}} :</b> {{ @$payment->payment_date }}
                </p>          
            </div>
            <div class="col-md-4">
                <label class="col-form-label">
                <b>{{ __('formname.billing_information.payment_method') }} </b>
                </label>
                <p>{{ @$payment->method_text }}</p>          
            </div>
        </div> 
    </div>
</div>