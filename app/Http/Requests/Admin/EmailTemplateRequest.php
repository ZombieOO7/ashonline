<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class EmailTemplateRequest extends FormRequest
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
        // dd($request->all());
        $validator = [
            'title' => ['required', 'max:100'],
            'subject' => 'required|max:200',
        ];
        if ($request->has('id') && $request->id != null) {
            $validator['title'][] = 'unique:email_templates,title,' . $request->id;
        } else {
            $validator['title'][] = 'unique:email_templates,title';
        }
        return $validator;
    }
    public function messages()
    {
        return [
            'title.unique' => 'The title has been taken already',
        ];
    }
}
