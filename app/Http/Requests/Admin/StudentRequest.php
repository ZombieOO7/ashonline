<?php

namespace App\Http\Requests\Admin;

use App\Models\Student;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;


class StudentRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST': {
                    return [
                        'parent_id' =>[function ($attribute, $value, $fail) use($request){
                            $child = Student::whereParentId($request->parent_id)->where('deleted_at',NULL)->count();
                            if ($child >= 2) {
                                $fail('Maximum 2 child allowed to this parent!');
                            }
                        }],
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'middle_name' => 'required',
                        'dob'=> 'required',
                        'school_year' =>'required',
                        // 'exam_board_id' => 'required',
                        'school_id' => 'required',
                        'email' => 'required|unique:students,email,NULL,id,deleted_at,NULL',
                    ];
                }
            case 'PUT': {
                    return [
                        'parent_id' =>[function ($attribute, $value, $fail) use($request){
                            $child = Student::whereParentId($request->parent_id)->where('deleted_at',NULL)->count();
                            if ($child >= 3) {
                                $fail('Maximum 2 child allowed to this parent!');
                            }
                        }],
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'middle_name' => 'required',
                        'dob'=> 'required',
                        'school_year' =>'required',
                        // 'exam_board_id' => 'required',
                        'school_id' => 'required',
                        'email' => 'required|unique:students,email,' . $request->id.',id,deleted_at,NULL',
                    ];
                }
            default:
                break;
        }
    }
    public function messages()
    {
        return [
            'county.required' =>'The Country Field is required',
            'email.required'=>'The Username Field is required',
            'email.unique' => 'The Username is already taken',
            'email.max' => 'The Username should be not grater than 100 character',
            'parent_id.max'=>'The Parent has already child 2 added',
        ];
    }
}
