<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class PaperCategoryFormRequest extends FormRequest
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
            'type' => 'required',
            'title' => ['required'],
            'color_code' => 'required|max:10',
            'status' =>'required',
            'product_content'=>'required',
            'benefits.*.title'=>'required',
            'benefits.*.description'=>'required',
            'products.*.title'=>'required',
            'products.*.description'=>'required',
        ];

        if ($request->has('id') && $request->id != null) {
            $validator['title'][] = 'unique:paper_categories,title,' . $request->id;
        } else {
            $validator['title'][] = 'unique:paper_categories,title';
        }
        return $validator;
    }
}
