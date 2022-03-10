<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParentProfileUpdateFormRequest extends FormRequest
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
            'email'=> ['required','max:' . config('constant.rules.email_length')],
            'mobile' =>'required',
            // 'region' => 'required',
            'country_id' => 'required',
            'city' => 'required',
            'council' => 'required',
            'address' => 'required',
            'image' => ['mimes:jpeg,jpg,png'],
        ];
        if ($request->has('id') && $request->id != null) {
            $validator['email'][] = 'unique:parents,email,' . $request->id.',id,deleted_at,NULL';
        } else {
            $validator['email'][] = 'unique:parents,email,NULL,id,deleted_at,NULL';
            $validator['password'] = 'required';
        }
        if($request->password != null){
            $validator['password'] = 'required|min:6|max:16|confirmed';
            $validator['password_confirmation'] = 'required|min:6|max:16';
        }
        return $validator;
    }
}
