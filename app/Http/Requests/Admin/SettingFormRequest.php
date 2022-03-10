<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SettingFormRequest extends FormRequest
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
        // dd($request->all());

        if($request->active_tab == 'general_tab'){
            $validator = [
                'logo' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'favicon' => 'nullable|mimes:svg,png,ico|max:2048',
            ];
        }
        if($request->active_tab == 'social_media_tab'){
            $validator = [
                'facebook_url' => 'nullable|max:150',
                'youtube_url' => 'nullable|max:150',
                'twitter_url' => 'nullable|max:150',
                'google_url' =>  'nullable|max:150',
            ];
        }
        if($request->active_tab == 'meta_tab')
        {
            $validator = [
                'meta_keywords'=>'nullable|max:150',
                'meta_description'=>'nullable|max:300',
            ];
        }
        if($request->active_tab == 'promo_code')
        {
            $validator = [
                'amount_1'=>'nullable|integer|min:1|'.Rule::requiredIf(function () use ($request) {
                    if ((isset($request->amount_2) && $request->amount_2 != '') || (isset($request->discount_1) && $request->discount_1 != '') ||(isset($request->code) && $request->code != '')) {
                        return true;
                    } else {
                        return false;
                    }
                }),
                'code'=>Rule::requiredIf(function () use ($request) {
                    if ((isset($request->amount_1) && $request->amount_1 != '')) {
                        return true;
                    } else {
                        return false;
                    }
                }),
                'discount_1'=>'nullable|integer|min:1|'.Rule::requiredIf(function () use ($request) {
                    if (((isset($request->discount_2) && $request->discount_2 != '') || (isset($request->amount_1) && $request->amount_1 != '')) ||(isset($request->code) && $request->code != '')) {
                        return true;
                    } else {
                        return false;
                    }
                }),
                'discount_2'=>'nullable|integer|max:100|'.Rule::requiredIf(function () use ($request) {
                    if (isset($request->amount_2) && $request->amount_2 != '') {
                        return true;
                    } else {
                        return false;
                    }
                }),

                'amount_2'=>'nullable|integer|'.Rule::requiredIf(function () use ($request) {
                    if (isset($request->discount_2) && $request->discount_2 != '') {
                        return true;
                    } else {
                        return false;
                    }
                }),
            ];
        }
        if($request->active_tab == 'rating_mail')
        {
            $validator = [
                'rating_mail'=>'required|min:0|integer',
            ];
        }
        if($request->active_tab == 'notification')
        {
            $validator = [
                'notification_content'=>'required|max:100',
            ];
        }

        return $validator;
    }
}
