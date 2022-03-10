<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class StageFormRequest extends FormRequest
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
            'title' => ['required' ,'max:20'],
            'status' =>'required',
        ];
        if ($request->has('id') && $request->id != null) {
            $validator['title'][] = 'unique:stages,title,' . $request->id;
        } else {
            $validator['title'][] = 'unique:stages,title';
        }
        return $validator;
    }
}
