<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponFormRequest extends FormRequest
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
        $validator = [
            'code' => [Rule::requiredIf(function () use ($request) {
                    if($request->type == 'apply') {
                        return true;
                    } else {
                        return false;
                    }
                })
            ]
        ];
    
        return $validator;
    }

    public function messages() 
    {
        return [
            'code.required' => 'Please enter a coupon code.',
        ];
    }
}
