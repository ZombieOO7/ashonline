<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PracticeExamFormRequest extends FormRequest
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
            'title' => ['required', 'max:' . config('constant.rules.name_length')],
            'description' => ['required', 'max:' . config('constant.rules.content_length')],
            // 'exam_board_id' => 'required',
            'subject_id' => 'required',
            'school_year' => 'required',
            'status' => 'required',
        ];
        return $validator;
    }
}
