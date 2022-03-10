<?php

namespace App\Http\Requests\Admin;

use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;

class ResourceRequest extends FormRequest
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
    public function rules()
    {
        switch ($this->method()) {
            case 'GET': {
                    return [];
                }
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'title' => 'required|max:'.config('constant.input_title_max_length'),
                        // 'resource_category_id' => 'required',
                        'question' => 'required|sometimes|mimes:pdf',
                        'answer' => 'required|sometimes|mimes:pdf',
                        'featured' => 'required|sometimes|mimes:jpg,jpeg,png',
                        'content' => 'required|sometimes',
                        'meta_title' => 'required|sometimes|max:'.config('constant.input_title_max_length'),
                        'meta_keyword' => 'required|sometimes|max:'.config('constant.input_title_max_length'),
                        'meta_description' => 'required|sometimes|max:300',
                    ];
                }
            case 'PUT': {
                    return [
                        'title' => 'required|max:'.config('constant.input_title_max_length'),
                        // 'resource_category_id' => 'required',
                        'question' => 'required|sometimes|mimes:pdf',
                        'answer' => 'required|sometimes|mimes:pdf',
                        'featured' => 'required|sometimes|mimes:jpg,jpeg,png',
                        'content' => 'required|sometimes',
                        'meta_title' => 'required|sometimes|max:'.config('constant.input_title_max_length'),
                        'meta_keyword' => 'required|sometimes|max:'.config('constant.input_title_max_length'),
                        'meta_description' => 'required|sometimes|max:'.config('constant.input_desc_max_length'),
                    ];
                }
            default:
                break;
        }
    }
}
