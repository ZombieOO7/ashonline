<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class MockTestFormRequest extends FormRequest
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
            'description' => ['required'],
            'exam_board_id' => 'required',
            'stage_id' => [Rule::requiredIf(function () use ($request) {
                                if($request->exam_board_id == 3) {
                                    return true;
                                } else {
                                    return false;
                                }
                            })
                        ],
            'start_date' => 'required',
            'end_date' => 'required',
            'grade_id' => 'required',
            'price' => ['required','max:' . config('constant.rules.price_length')],
            'status' => 'required',
        ];
        if($request->has('test_detail')){
            foreach($request->test_detail as $key => $testDetail)
            {
                // $validator['test_detail.'.$key.'.time'] = 'required';
                // $validator['test_detail.'.$key.'.questions'] = 'required';
            }
        }else{
            // $validator['test_detail.0.time'] = 'required';
            // $validator['test_detail.0.questions'] = 'required';
        }
        return $validator;
    }

    public function messages()
    {
        return [
                'exam_board_id.required' => 'The exam board is required',
                'grade_id.required' => 'The grade is required',
        ];
    }
}
