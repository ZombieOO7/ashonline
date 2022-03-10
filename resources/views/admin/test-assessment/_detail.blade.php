@extends('admin.layouts.default')
@section('content')
@section('title', @$title)
<link rel="stylesheet" href="{{asset('css/pdf.css')}}">
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"
                    id="main_portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-wrapper">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{@$title}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('test-assessment.index')}}"
                                    class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{__('formname.back')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        @if(isset($testAssessment) || !empty($testAssessment))
                        {{ Form::model(@$testAssessment, ['route' => ['test-assessment.store', @$testAssessment->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit','files' => true,'autocomplete' => "off"]) }}
                        @else
                        {{ Form::open(['route' => 'test-assessment.store','method'=>'post','class'=>'m-form m-form--fit','id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
                        @endif
                            <div class="col-md-12 row">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.test-assessment.title').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {{@$testAssessment->title}}
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.test-assessment.image') .' :', null,['class'=>'font-weight-bold col-form-label
                                            col-lg-4 col-sm-12'])
                                            !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                @if(@$testAssessment->image)
                                                    <img id="blah" src="{{@$testAssessment->image->image_path }}" alt="" height="200px;" width="200px;"
                                                    style="display:block;" />
                                                @else
                                                <img id="blah" src="" alt="" height="200px;" width="200px;"
                                                    style="display:none;" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.test-assessment.description').' :', null,['class'=>'font-weight-bold col-form-label col-lg-6 col-sm-12']) !!}
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-form-label">
                                                <div class="input-group">
                                                    {!! @$testAssessment->description !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.test-assessment.school_year').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {{ @config('constant.school_year')[@$testAssessment->school_year] }}
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.test-assessment.start_date').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {!! @$testAssessment->proper_start_date_text !!}
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.test-assessment.end_date').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {!! @$testAssessment->proper_end_date_text !!}
                                            </div>
                                        </div>
                                        @if(@$testAssessment->examBoard->slug == 'super_selective')
                                            <div class="form-group m-form__group row superSelective">
                                                {!! Form::label(__('formname.test-assessment.stage_id').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                    {{(@$testAssessment->stage_id == 1)?'Stage 1':'Stage 2'}}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div id="subjectTestDetails" class="col-md-12">
                                    @isset($testAssessment->testAssessmentSubjectDetail)
                                        @forelse ($testAssessment->testAssessmentSubjectDetail as $key => $testAssessmentSubjectDetail)
                                        <div class="">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-3 col-sm-12 col-form-label">
                                                    <h5> {{__('formname.test-assessment.subject_name')}} :</h5>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-form-label">
                                                    <b>{{@$testAssessmentSubjectDetail->subject->title}}</b>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-form-label">
                                                    <h5>{{__('formname.test-assessment.time')}} :</h5>
                                                </div>
                                                <div class="col-lg-3 col-form-label">
                                                    <b>{{ @$testAssessmentSubjectDetail->time }}</b>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-form-label">
                                                    <h5>{{ __('formname.test-assessment.question')}} : </h5>
                                                </div>
                                                <div class="col-lg-3 col-form-label">
                                                    <b>{{ @$testAssessmentSubjectDetail->questions }} </b>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-form-label">
                                                    <h5>{{ __('formname.test-assessment.report_question')}} : </h5>
                                                </div>
                                                <div class="col-lg-3 col-form-label">
                                                    <b>{{ @$testAssessmentSubjectDetail->report_question }} </b>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $questionsList = $testAssessmentSubjectDetail->questionList3??[];
                                            $paperKey = 0;
                                            $sqkey = $key;
                                        @endphp
                                        <div class="col-md-12">
                                            @if(@$testAssessmentSubjectDetail->passage != null)
                                                <div class="pdfApp border" data-index="{{@$testAssessmentSubjectDetail->id}}" data-src="{{@$testAssessmentSubjectDetail->passage_path}}">
                                                    <div id="viewport-container{{@$testAssessmentSubjectDetail->id}}" class="viewport-container" data-index="{{@$testAssessmentSubjectDetail->id}}"><div role="main" class="viewport" id="viewport{{@$testAssessmentSubjectDetail->id}}" data-index="{{@$testAssessmentSubjectDetail->id}}"></div></div>
                                                </div>
                                            @endif
                                            @forelse(@$questionsList as $qkey => $questionObject)
                                            @php
                                                $questionData = $questionObject;
                                                $question = $questionData;
                                            @endphp
                                                <div class="form-group m-form__group row col-md-12">
                                                    <div class="optn_box mrgn_bt_15 w-100">
                                                        <div class="optn_head text-white">
                                                            <div class="col-md-10 d-inline">
                                                                Question {{@$question->question_no}}  »  {{@$question->subject->title}}  »  {{@$question->topic->title}} 
                                                            </div>
                                                            <div class="col-md-2 d-inline"> Point: {{@$question->marks}} pt </div>
                                                        </div>
                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                            <strong>{{@$question->instruction}}</strong>
                                                        </div>
                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                            <strong>{{@$question->question}}</strong>
                                                        </div>
                                                        <div class="row">
                                                            @if($question->image != null)
                                                                @if($question->resize_full_image != null)
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.image_full')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                                                                                {!! @$question->resize_full_image !!}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.image_full')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                                                                                <img class="img-fluid" src="{{@$question->image_path}}">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @if($question->question_image != null)
                                                                @if($question->resize_question_image != null)
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.question_image')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->question_image_path}}">
                                                                                {!! @$question->resize_question_image !!}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.question_image')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->question_image_path}}">
                                                                                <img class="img-fluid" src="{{@$question->question_image_path}}">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @if($question->answer_image != null)
                                                                @if($question->resize_answer_image != null)
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.question_image')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->answer_image_path}}">
                                                                                {!! @$question->resize_answer_image !!}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.answer_image')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->answer_image_path}}">
                                                                                <img class="img-fluid" src="{{@$question->answer_image_path}}">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                            @if(@$questionData->question_type == 1 && @$questionData->type == 4)
                                                                @php
                                                                    $alphabet = ord("A");
                                                                    $correctAnswer = null;
                                                                @endphp
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        @forelse(@$question->answers??[] as $akey => $answer)
                                                                            @if($akey < 3)
                                                                                @if($answer->is_correct == 1)
                                                                                    <strong>{{chr($alphabet)}}. {!! @$answer->answer !!} </strong>
                                                                                @else
                                                                                    <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!}
                                                                                @endif
                                                                                <br>
                                                                                @php
                                                                                    $alphabet++;
                                                                                @endphp
                                                                            @endif
                                                                        @empty
                                                                        @endforelse
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        @forelse(@$question->answers??[] as $akey => $answer)
                                                                            @if($akey > 2)
                                                                                @if($answer->is_correct == 1)
                                                                                    <strong>{{chr($alphabet)}}. {!! @$answer->answer !!} </strong>
                                                                                @else
                                                                                    <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!}
                                                                                @endif
                                                                                <br>
                                                                                @php
                                                                                    $alphabet++;
                                                                                @endphp
                                                                            @endif
                                                                        @empty
                                                                        @endforelse
                                                                    </div>
                                                                </div>
                                                            @elseif(@$questionData->question_type == 1)
                                                                @php
                                                                    $alphabet = ord("A");
                                                                    $correctAnswer = null;
                                                                @endphp
                                                                @forelse(@$question->answers??[] as $akey => $answer)
                                                                    @if($answer->is_correct == 1)
                                                                        <strong>{{chr($alphabet)}}. {!! @$answer->answer !!} </strong>
                                                                    @else
                                                                        <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!}
                                                                    @endif
                                                                    <br>
                                                                    @php
                                                                        $alphabet++;
                                                                    @endphp
                                                                @empty
                                                                @endforelse
                                                            @else
                                                                <strong>Answer : </strong>
                                                                {!! @$question->getSingleAnswer->answer !!}
                                                            @endif
                                                        </div>
                                                        @if(@$question->explanation != null)
                                                            <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                <span class="font-weight-bold"> Explanation </span>
                                                                <br>
                                                                {!! @$question->explanation !!}
                                                            </div>
                                                        @endif
                                                        <div class="optn_infrmtn_v1 p-4">
                                                            <a role="button" href="{{route('edit-assessment-list-question',['uuid'=>@$question->uuid,'mockId'=>@$testAssessment->uuid])}}" class="btn m-btn--square  btn-outline-primary mr-3" title="{{__('formname.edit')}}">{{__('formname.edit')}}</a>
                                                            <button type="button" data-module_name="question" data-module="Question" data-id="{{@$question->uuid}}" data-mock_test_id="{{@$testAssessment->uuid}}" data-msg="You want to delete this question" data-url="{{route('delete-assessment-list-question',['uuid'=>$question->uuid])}}" class="btn m-btn--square btn-outline-danger deleteQuestion" title="{{__('formname.delete')}}">{{__('formname.delete')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        @empty
                                        @endforelse
                                        <div class="col-md-12 pl-5 pr-5 mt-4 mb-4">
                                            <a href="{{route('assessment.add-question',['uuid'=>@$testAssessmentSubjectDetail->id,'mockId'=>@$testAssessment->uuid])}}" class="btn btn-primary">
                                                <span class="fa fa-plus"></span>
                                                Add Question
                                            </a>
                                        </div>
                                    @endisset
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('formname.test-assessment.question_list')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="questionList">
                {!! Form::hidden("questionSubjectId",null,['id'=>'']) !!}
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="question_table">
                    <thead>
                        <tr>
                            <th></th>
                            {{-- <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="trade_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th> --}}
                            <th>{{__('formname.question.question')}}</th>
                            <th>{{__('formname.test-assessment.type')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.question.question')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.test-assessment.type')}}"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="getIds">Save</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('inc_script')
<script src="{{asset('js/pdf.min.js')}}"></script>
<script src="{{asset('js/pdf.worker.js')}}"></script>
<script src="{{asset('js/pdf-creator.js')}}"></script>
{{-- <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script> --}}
<script>
var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
var formname = $.extend({}, {!!json_encode(__('formname'), JSON_FORCE_OBJECT) !!});
var id = '{{@$testAssessment->id}}';
var subjectUrl = '{{route("test-assessment.subject-detail")}}';
var getQuestionList = '{{route("test-assessment.question-list")}}';
$(function(){
    $("audio").on("play", function() {
        $("audio").not(this).each(function(index, audio) {
            audio.pause();
        });
    });
});
initializePdf();
</script>
<script src="{{ asset('backend/js/test-assessment/create.js') }}" type="text/javascript"></script>
@stop
