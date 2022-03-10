<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AdminFormRequest extends FormRequest
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
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'email' => ['required'],
            'role.*' => 'required',
        ];
        if ($request->has('id') && $request->id != null) {
            $validator['email'][] = 'unique:admins,email,' . $request->id;
        } else {
            $validator['email'][] = 'unique:admins,email';
            $validator['password'] = 'required';
        }
        return $validator;
    }
}