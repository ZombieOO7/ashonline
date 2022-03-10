<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PaymentSettingFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if($request->active_tab == 'stripe_payment')
        {
            $validator = [
                'payment_type'=>'required',
                'stripe_key'=>'required',
                'stripe_secret'=>'required',
                'stripe_currency'=>'required',
                'stripe_mode'=>'required',
            ];
        }
        if($request->active_tab == 'paypal_payment')
        {
            $validator = [
                'paypal_client_id' => 'required',
                'paypal_sandbox_api_username' => 'required',
                'paypal_sandbox_api_password' => 'required',
                'paypal_sandbox_api_secret' => 'required',
                // 'paypal_sandbox_api_certificate' => 'required',
                'paypal_currency'=>'required',
                'paypal_mode' => 'required',
            ];
        }
        return $validator;
    }
}
