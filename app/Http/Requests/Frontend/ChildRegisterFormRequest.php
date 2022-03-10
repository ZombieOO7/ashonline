<?php

namespace App\Http\Requests\Frontend;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;


class ChildRegisterFormRequest extends FormRequest
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
    public function rules(Request $request){
        $validator = [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'dob'=> 'required',
            'school_year' =>'required',
            'exam_board_id' => 'required',
            'username'=> ['required','max:' . config('constant.rules.email_length')],
            // 'exam_style_id' => 'required',
            'school_name' => 'required',
            'parent_id' =>[function ($attribute, $value, $fail) use($request){
                $child = Student::whereParentId($request->parent_id)->count();
                if ($child >= 2) {
                    $fail('This parent has already child 2 child!');
                }
            }],
        ];
        if ($request->has('id') && $request->id != null) {
            $validator['username'][] = 'unique:students,email,' . $request->id.',id,deleted_at,NULL';
        } else {
            $validator['username'][] = 'unique:students,email,NULL,id,deleted_at,NULL';
        }
        return $validator;
    }
    public function messages()
    {
        return [
            'county.required' =>'The Country Field is required',
            'exam_board_id.required' => 'The Exam Board Field is required',
            'dob.required' => 'The Date of Birth Field is required',
            'parent_id.max'=>'The Parent has already child 2 child',
        ];
    }
}
