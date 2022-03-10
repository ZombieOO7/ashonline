<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ExamTypeFormRequest extends FormRequest
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
            // 'status' =>'required',
            'paper_category_id'=>'required',
        ];
        if ($request->has('id') && $request->id != null) {
            $validator['title'][] = 'unique:exam_types,title,' . $request->id.',id,deleted_at,NULL';
        } else {
            $validator['title'][] = 'unique:exam_types,title,NULL,id,deleted_at,NULL';
        }
        return $validator;
    }
}
