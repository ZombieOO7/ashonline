<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestPaperFormRequest extends FormRequest
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
            'title' => ['required'],
            'content' => 'required',
            'price' => 'required',
            'edition' => ['required'],
            'category_id' => 'required',
            'exam_type_id' => 'required',
            'subject_id' => 'required',
//            'name' =>Rule::requiredIf(function () use ($request) {
//                if ((isset($request->stored_img_name) && $request->stored_img_name == '') || $request->stored_img_name == null) {
//                    return true;
//                } else {
//                    return false;
//                }
//            }) ,
            'pdf_name' => Rule::requiredIf(function () use ($request) {
                if (isset($request->stored_pdf_name) && $request->stored_pdf_name == '') {
                    return true;
                } else {
                    return false;
                }
            }),
            'exam_type_id' => 'nullable|' . Rule::requiredIf(function () use ($request) {
                    if ($request->has('exam_type_id'))
                        return true;
                    return false;
                }),
            'subject_id' => 'nullable|' . Rule::requiredIf(function () use ($request) {
                    if ($request->has('subject_id'))
                        return true;
                    return false;
                }),
            'age_id' => 'nullable|' . Rule::requiredIf(function () use ($request) {
                    if ($request->has('age_id'))
                        return true;
                    return false;
                }),
            'stage_id' => 'nullable|' . Rule::requiredIf(function () use ($request) {
                    if ($request->has('stage_id'))
                        return true;
                    return false;
                }),
            // 'name' => ['required','dimensions:width=279,height=245'],
        ];
        return $validator;
    }

    public function messages()
    {
        return [
            'name.dimensions' => 'Image dimension must be 245 x 279.',
        ];
    }
}
