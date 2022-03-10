<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;


class SchoolsRequest extends FormRequest
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
            case 'GET': {
                    return [];
                }
            case 'POST': {
                    return [
                        'school_name' => 'required|max:50',
                        // 'exam_board' => 'required',
                        'categories'=> 'required',
                        
                        
                    ];
                    
                }
            case 'PUT': {
                    return [
                        'school_name' => 'required|max:50',
                        // 'exam_board' => 'required',
                        'categories'=> 'required',
                    ];
                }
            default:
                break;
        }
    }
}
