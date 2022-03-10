<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckUniqueName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PermissionFormRequest extends FormRequest
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
            'name' => ['required', new CheckUniqueName],
        ];
        if ($request->has('id') && $request->id != null) {
            $validator['name'][] = 'unique:permissions,name,' . $request->id;
        } else {
            $validator['name'][] = 'unique:permissions,name';
        }
        return $validator;
    }
}