<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParentFormRequest extends FormRequest
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
            'full_name'=> ['required','max:' . config('constant.rules.name_length')],
            // 'middle_name'=> ['required','max:' . config('constant.rules.name_length')],
            // 'last_name'=> ['required','max:' . config('constant.rules.name_length')],
            'email'=> ['required','max:' . config('constant.rules.email_length')],
            // 'dob' => 'required',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'state' => 'required',
            'country_id' => 'required',
            // 'zip_code' => 'required',
            'mobile' => ['required'],
            // 'council' =>'required',

        ];
        if ($request->has('id') && $request->id != null) {
            $validator['email'][] = 'unique:parents,email,' . $request->id.',id,deleted_at,NULL';
            $validator['phone'][] = 'unique:parents,mobile,' . $request->id.',id,deleted_at,NULL';
            
        } else {
            $validator['email'][] = 'unique:parents,email,NULL,id,deleted_at,NULL';
            $validator['password'] = 'required';
            $validator['phone'][] = 'unique:parents,mobile,NULL,id,deleted_at,NULL';

        }
        return $validator;
    }
}
