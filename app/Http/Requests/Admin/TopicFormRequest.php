<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TopicFormRequest extends FormRequest
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
            'active' =>'required',
        ];
        if ($request->has('id') && $request->id != null) {
            $validator['title'][] = 'unique:topics,title,' . $request->id.',id,deleted_at,NULL';;
        } else {
            $validator['title'][] = 'unique:topics,title,NULL,id,deleted_at,NULL';
        }
        return $validator;
    }
}
