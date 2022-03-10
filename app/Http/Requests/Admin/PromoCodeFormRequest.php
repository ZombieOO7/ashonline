<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromoCodeFormRequest extends FormRequest
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
            'code'=> ['required','max:'.config('constant.input_title_max_length') ],
            'amount_1'=>'nullable|integer|min:1|'.Rule::requiredIf(function () use ($request) {
                if ((isset($request->amount_2) && $request->amount_2 != '') || (isset($request->discount_1) && $request->discount_1 != '') ||(isset($request->code) && $request->code != '')) {
                    return true;
                } else {
                    return false;
                }
            }),
            'discount_1'=>'nullable|integer|min:1|'.Rule::requiredIf(function () use ($request) {
                if (((isset($request->discount_2) && $request->discount_2 != '') || (isset($request->amount_1) && $request->amount_1 != '')) ||(isset($request->code) && $request->code != '')) {
                    return true;
                } else {
                    return false;
                }
            }),
            'discount_2'=>'nullable|integer|max:100|'.Rule::requiredIf(function () use ($request) {
                if (isset($request->amount_2) && $request->amount_2 != '') {
                    return true;
                } else {
                    return false;
                }
            }),

            'amount_2'=>'nullable|integer|'.Rule::requiredIf(function () use ($request) {
                if (isset($request->discount_2) && $request->discount_2 != '') {
                    return true;
                } else {
                    return false;
                }
            }),
        ];
        if ($request->has('id') && $request->id != null) {
            $validator['code'][] = 'unique:promo_codes,code,' . $request->id.',id,deleted_at,NULL';
        } else {
            $validator['code'][] = 'unique:promo_codes,code,NULL,id,deleted_at,NULL';
        }
        return $validator;
    }
}
