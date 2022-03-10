<?php

namespace App\Http\Requests\Admin;

use App\Models\TestAssessment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class TestAssessmentFormRequest extends FormRequest
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
        $validator = [
            'title' => ['required', 'max:' . config('constant.rules.name_length')],
            'description' => ['required', 'max:' . config('constant.rules.content_length')],
            'school_year' => 'required',
            'status' => 'required',
            /* 'week' => [function ($attribute, $value, $fail) use($request,$routeName){
                $count = TestAssessment::whereDate('start_date',date('Y-m-d',strtotime($request->start_date)))
                            ->where(function($query)use($request,$routeName){
                                if($request->id != null && $routeName != 'test-assessment.copy-exam'){
                                    $query->where('id','!=',$request->id);
                                }
                            })
                            ->whereDate('end_date',date('Y-m-d',strtotime($request->end_date)))
                            ->whereHas('testAssessmentSubjectInfo',function($query) use($request){
                                $query->where('subject_id',$request->section[0]['subject_id']);
                            })
                            ->where('grade_id',$request->grade_id)
                            ->count();
                if ($count > 0) {
                    $fail('selected week is already taken in other assessment!');
                }
            }], */
            'week' => 'required',
        ];
        return $validator;
    }
}
