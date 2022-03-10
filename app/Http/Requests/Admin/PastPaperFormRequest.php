<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PastPaperFormRequest extends FormRequest
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
            'name' => ['required', 'max:' . config('constant.rules.name_length')],
            'year' => 'required',
            'school_year' => 'required',
            'month' => 'required',
            // 'grade_id' => 'required',
            'subject_id' => 'required',
            'instruction' => ['required', 'max:' . config('constant.rules.content_length')],
            'status'=>'required',
            'pdf_file' =>[Rule::requiredIf(function () use ($request) {
                                if($request->stored_file == null) {
                                    return true;
                                } else {
                                    return false;
                                }
                            })
                        ],
        ];
        return $validator;
    }
}
