<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SubscriptionFormRequest extends FormRequest
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
            // 'title' => ['required','max:'.config('constant.name_length')],
            'price' => ['required','max:'.config('constant.rules.price_length')],
            // 'status' =>'required',
        ];
        if ($request->has('id') && $request->id != null) {
            // $validator['title'][] = 'unique:subscriptions,title,'.$request->id.',id,deleted_at,NULL';
        } else {
            // $validator['title'][] = 'unique:subscriptions,title,NULL,id,deleted_at,NULL';
        }
        return $validator;
    }
}
