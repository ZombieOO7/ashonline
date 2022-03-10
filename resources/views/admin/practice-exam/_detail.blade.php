@extends('admin.layouts.default')
@section('content')
@section('title', @$title)

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
                                <a href="{{route('practice-exam.index')}}"
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
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.test-assessment.title').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                    {{@$testAssessment->title}}
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.test-assessment.image') .' :', null,['class'=>'font-weight-bold col-form-label
                                col-lg-3 col-sm-12'])
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
                                {!! Form::label(__('formname.test-assessment.exam_board_id').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                    {{ @$testAssessment->examBoard->title}}
                                </div>
                            </div>
                            @if($testAssessment->school !=null)
                            <div class="form-group m-form__group row superSelective">
                                {!! Form::label(__('formname.test-assessment.school_id').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                    {{ @$testAssessment->school ?$testAssessment->school->school_name :'' }}
                                </div>
                            </div>
                            @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.test-assessment.grade_id').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                    {{ @$testAssessment->grade->title }}
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
                            <div id="subjectTestDetails">
                                @isset($testAssessment->testAssessmentSubjectDetail)
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6 col-sm-12 col-form-label">
                                        <h4> {{__('formname.test-assessment.subject_detail')}} </h4>
                                    </div>
                                </div>
                                    @forelse ($testAssessment->testAssessmentSubjectDetail as $key => $testAssessmentSubjectDetail)
                                    @php
                                        $subjectQuestions = $testAssessmentSubjectDetail->subjectQuestions->pluck('question_id');
                                        $subjectQuestionIds = implode(',',$subjectQuestions->toArray());
                                    @endphp
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
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-10 col-form-label">
                                            <h5> Question List :</h5>
                                                <table class="table table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            {{-- <th style="width:20%;">{{__('formname.test-assessment.no')}}</th> --}}
                                                            <th style="width:60%;">Question Title</th>
                                                            <th style="width:20%;">{{__('formname.test-assessment.question_type')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse(@$testAssessmentSubjectDetail->subjectQuestions as $subjectQuestion)
                                                            @php $i=1; @endphp
                                                            @forelse(@$subjectQuestion->questions as $questionData)
                                                            <tr>
                                                                {{-- <td style="width:20%;">{{$i}}</td> --}}
                                                                <td style="width:60%;">
                                                                    <b>{{@$questionData->question_title}}</b>
                                                                    @forelse(@$questionData->questionsList as $key => $question)
                                                                        @php
                                                                            $key++;
                                                                        @endphp
                                                                            <p><b>Q-{{$key}} </b> {{@$question->question}}</p>
                                                                    @empty
                                                                    @endforelse
                                                                </td>
                                                                <td style="width:20%;">{{@config('constant.question_type')[$questionData->type]}}</td>
                                                            </tr>
                                                            @php $i++; @endphp
                                                            @empty
                                                            @endforelse
                                                        @empty
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class='col-lg-5 col-sm-12'>
                                        </div>
                                        <div class='col-lg-3 col-sm-12'>
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse
                                @endisset
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.test-assessment.description').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                    <div class="input-group">
                                        {!! @$testAssessment->description !!}
                                    </div>
                                    <span class="descriptionError">
                                        @if ($errors->has('description')) <p style="color:red;">
                                            {{ $errors->first('description') }}</p> @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            @if($testAssessment->header !=null)
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.test-assessment.header').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                    <div class="input-group">
                                        {!! @$testAssessment->header !!}
                                    </div>
                                    <span class="headerError">
                                        @if ($errors->has('header')) <p style="color:red;">
                                            {{ $errors->first('header') }}</p> @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            @endif
                            @if($testAssessment->summury !=null)
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.test-assessment.summury').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                    <div class="input-group">
                                        {!! @$testAssessment->summury !!}
                                    </div>
                                    <span class="summuryError">
                                        @if ($errors->has('summury')) <p style="color:red;">
                                            {{ $errors->first('summury') }}</p> @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            @endif
                            @if(isset($testAssessment->assessmentAudio))
                                @if(isset($testAssessment->assessmentAudio[0]->audio))
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.test-assessment.interval').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@config('constant.intervalList')[1]}}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.test-assessment.audio_file').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{-- @if(isset($testAssessment->assessmentAudio[0]->audio_path) && $testAssessment->assessmentAudio[0]->audio_path != null) --}}
                                            <audio id="begningIntervalAudio" class="audioInput" controls>
                                                <source src="{{@$testAssessment->assessmentAudio[0]->audio_path}}" type="audio/mpeg">
                                            </audio>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                                @endif
                                @if(isset($testAssessment->assessmentAudio[1]->audio))
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.test-assessment.interval').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@config('constant.intervalList')[2]}}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.test-assessment.audio_file').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{-- @if(isset($testAssessment->assessmentAudio[1]->audio_path) && $testAssessment->assessmentAudio[1]->audio_path != null) --}}
                                            <audio id="begningIntervalAudio" class="audioInput" controls>
                                                <source src="{{@$testAssessment->assessmentAudio[1]->audio_path}}" type="audio/mpeg">
                                            </audio>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                                @endif
                                @if(isset($testAssessment->assessmentAudio[2]->audio))
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.test-assessment.interval').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@config('constant.intervalList')[3]}}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.test-assessment.audio_file').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{-- @if(isset($testAssessment->assessmentAudio[2]->audio_path) && $testAssessment->assessmentAudio[2]->audio_path != null) --}}
                                            <audio id="begningIntervalAudio" class="audioInput" controls>
                                                <source src="{{@$testAssessment->assessmentAudio[2]->audio_path}}" type="audio/mpeg">
                                            </audio>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                                @endif
                                @if(isset($testAssessment->assessmentAudio[3]->audio))
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.test-assessment.interval').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@config('constant.intervalList')[4]}}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.test-assessment.audio_file').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{-- @if(isset($testAssessment->mockAudio[3]->audio_path) && $testAssessment->mockAudio[3]->audio_path != null) --}}
                                            <audio id="begningIntervalAudio" class="audioInput" controls>
                                                <source src="{{@$testAssessment->mockAudio[3]->audio_path}}" type="audio/mpeg">
                                            </audio>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                                @endif
                            @endif
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
<script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
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
</script>
<script src="{{ asset('backend/js/test-assessment/create.js') }}" type="text/javascript"></script>
@stop
