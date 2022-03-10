<?php

namespace App\Http\Requests\Frontend;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChildProfileUpdateFormRequest extends FormRequest
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
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        $validator = [
            'first_name' => ['required', 'max:' . config('constant.rules.name_length')],
            'last_name' => ['required', 'max:' . config('constant.rules.name_length')],
            'middle_name' => ['required', 'max:' . config('constant.rules.name_length')],
            // 'email'=> ['required','max:' . config('constant.rules.email_length')],
            'school_year' => 'required',
            'exam_board_id' => 'required',
            'school_name' => 'required',
            'image' => ['mimes:jpeg,jpg,png'],
            'parent_id' =>[function ($attribute, $value, $fail) use($request){
                $child = Student::whereParentId($request->parent_id)->count();
                if ($child >= 3) {
                    $fail('This parent has already child 2 child!');
                }
            }],
            'email'=> 'required|unique:students,email,' . $request->id,
        ];
        return $validator;
    }

    public function messages()
    {
        return [
            'email.required' => 'The username field is required.',
            'email.unique' => 'The username has already exists. '
        ];
    }
}
