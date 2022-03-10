<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class PaperFormRequest extends FormRequest
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
            'content' =>'required',
            'price' => 'required',
            'title' => ['required' ,'max:20'],
            'category_id' => 'required',
            'exam_type_id' => 'required',
            'subject_id' => 'required',
            'age_id' => 'required',
            'status' => 'required',
        ];

        return $validator;
    }
}
