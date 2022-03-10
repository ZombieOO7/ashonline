@extends('admin.layouts.default')
@section('inc_css')
@section('content')
@section('title', $methodType)
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
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
                                        {{ @$methodType }}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{Route('question.index')}}"
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
                        @if(isset($question) || !empty($question))
                            {{ Form::model($question, ['route' => ['question.store', @$question->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','enctype'=>'multipart/form-data']) }}
                        @else
                            {{ Form::open(array('route' => 'question.store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1', 'files' => true, 'enctype'=>'multipart/form-data')) }}
                        @endif
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.question.subject_id').'*', null,array('class'=>'col-form-label col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('subject_id', $subject, isset($question) ? $question->subject_id : " ",
                                    ['class' => 'form-control', 'id' => 'subject_id' , 'placeholder' => 'Select subject', 'data-question-id' => isset($question) ? $question->id : " " ]) !!}
                                <span class="inError"></span>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.question.question_type').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('question_type', @$questionType, isset($question) ? $question->question_type : " ",
                                    ['class' => 'form-control', 'id' => 'question_type', 'data-url' => route('question.select'), 'data-question-id' => isset($question) ? $question->id : " ", 'data-subject-id' => isset($question) ? $question->subject_id : " " ]) !!}
                                    <span class="inError"></span>
                                </div>

                            </div>

                            <div class="form-group m-form__group row" id='typeData'>
                                {!! Form::label(__('formname.question.type').'*', null,array('class'=>'col-form-label col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('type', @$type, @$question->type,
                                    ['class' => 'form-control', 'id' => 'type', 'data-url' => route('question.select'), 'data-question-id' => isset($question) ? $question->id : " ", 'data-subject-id' => isset($question) ? $question->subject_id : " " ]) !!}
                                <span class="inError"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.question.topic') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('topic_id',@$topics,@$question->topic->id,['class'=>'form-control','id'=>'topicId','maxlength'=>'50']) !!}
                                    @error('title') <p class="errors">{{$errors->first('title')}}</p> @enderror
                                    <span class="inError"></span>
                                </div>
                            </div>
                            <input type="hidden" class="questionedit" id='questionId' value="{{ @$question->id }}">
                            <div id="question-append">
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.status'), null,array('class'=>'col-form-label col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('active', ['1' => 'Active', '0' => 'Inactive'], @$question->active,['class' => 'form-control' ]) !!}
                                <span class="inError"></span>
                                </div>

                            </div>

                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success subnitBtn'] )!!}
                                            <a href="{{Route('question.index')}}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Topic</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(array('route' => 'topic.store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_2', 'files' => true, 'enctype'=>'multipart/form-data')) }}
            <div class="modal-body">
                    <div class="form-group m-form__group row">
                        {!! Form::label(__('formname.question.topic') .'*', null,array('class'=>'col-form-label col-lg-4 col-sm-12'))!!}
                        <div class="col-lg-8 col-md-9 col-sm-12">
                            {!! Form::text('title',null,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                            @error('title') <p class="errors">{{$errors->first('title')}}</p> @enderror
                            <span class="inError"></span>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary saveTopic">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
@section('inc_script')
<script>
    var actionUrl = "{{route('topic.store')}}";
    var validateTitleURL = "{{route('validate.topic.title')}}";
    var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
</script>
<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
<script src="{{ asset('backend/js/question_management/create-edit.js') }}" type="text/javascript"></script>
@stop
