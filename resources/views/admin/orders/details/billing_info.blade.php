<div class="form-group m-form__group row row_div">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-4">
                <label class="col-form-label">
                <b>{{ __('formname.billing_information.title') }} </b>
                </label>
                <p>
                    {{-- @if(@$order->biilingAddress->address1 != null)
                        {{ @$order->biilingAddress->address1 }},<br> 
                    @endif
                    @if(@$order->biilingAddress->address2 != null)
                        {{ @$order->biilingAddress->address2 }},<br>
                    @endif
                    @if(@$order->biilingAddress->postal_code !=null)
                        {{ @$order->biilingAddress->postal_code }} 
                    @endif
                    @if(@$order->biilingAddress->city !=null)
                        {{ @$order->biilingAddress->city }},<br> 
                    @endif
                    @if(@$order->biilingAddress->state !=null)
                        {{ @$order->biilingAddress->state }}
                    @endif
                    @if(@$order->biilingAddress->country != null)
                        {{ @$order->biilingAddress->country }}.<br>
                    @endif --}}
                    {{@$billingInfo}}.
                    <br>
                    @if(@$order->biilingAddress->first_name!=null || @$order->biilingAddress->last_name !=null)
                        <b>{{__('formname.billing_information.name')}} :</b> {{ @$order->biilingAddress->first_name }} {{ @$order->biilingAddress->last_name }} <br>
                    @endif
                    @if(@$order->biilingAddress->email != null)
                        <b>{{__('formname.billing_information.email')}} :</b> {{ @$order->biilingAddress->email }} <br>
                    @endif
                    @if(@$order->biilingAddress->phone !=null)
                        <b>{{__('formname.phone')}} :</b> {{ @$order->biilingAddress->phone }}
                    @endif
                </p>          
            </div>
            <div class="col-md-4">
                <label class="col-form-label">
                <b>{{ __('formname.billing_information.payment_method') }} </b>
                </label>
                <p>{{ (@$order->payment->method_text) }}</p>
            </div>
            @if(isset($order->papers) && count($order->papers) > 0)
                <div class="col-md-4">
                    <label class="col-form-label">
                    <b>{{ __('formname.billing_information.password') }} </b>
                    </label>
                    <p>{{ @$order->biilingAddress->email }}</p>          
                </div>
            @endif
        </div> 
    </div>
</div>