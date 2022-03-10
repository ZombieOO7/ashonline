<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsFormRequest extends FormRequest
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
        $routeName = Route::currentRouteName();
        if($routeName =='contact_us.store')
        {
            $captcha = session()->get('captcha');
            $validator = [
                // 'captcha' => 'required|same:'.$captcha,
                'captcha' => 'required',
                'full_name' => 'required|max:20',
                'email' => 'required|email',
                'phone' => 'required',
                'message' => 'required',
                'subject'=>'required'
            ];
        }else{
            $validator = [
                'full_name' => 'required|max:20',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'message' => 'required',
            ];
        }
        
        return $validator;
    }
}