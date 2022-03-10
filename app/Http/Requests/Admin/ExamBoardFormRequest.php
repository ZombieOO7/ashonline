<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ExamBoardFormRequest extends FormRequest
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
            'title' => ['required' ,'max:255'],
            'content' => 'required',
            'status' =>'required',
        ];
        if ($request->has('id') && $request->id != null) {
            $validator['title'][] = 'unique:exam_boards,title,' . $request->id;
        } else {
            $validator['title'][] = 'unique:exam_boards,title';
        }
        return $validator;
    }
}
