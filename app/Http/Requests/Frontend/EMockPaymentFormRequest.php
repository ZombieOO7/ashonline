<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EMockPaymentFormRequest extends FormRequest
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
        if($request->address_type == 'new_address') {
            $validator = [
                'email' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'city' => 'required',
                'country' => 'required',
                'state' => 'required',
                'address1' => 'required',
                'postal_code' => 'required',
            ];
        }else{
            $validator = [

            ];
        }
        return $validator;
    }
}
