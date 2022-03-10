@extends('admin.layouts.default')
@section('inc_css')
@section('content')
@section('title', @$title)
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
                                        {{@$title}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('mock-test.detail',['uuid'=>@$mockId])}}"
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
                            {{ Form::model($question, ['route' => ['question.list.store', @$question->uuid], 'method' => 'PUT','id'=>'m_form_3','class'=>'m-form m-form--fit m-form--label-align-right','enctype'=>'multipart/form-data']) }}
                        @else
                            {{ Form::open(array('route' => 'question.list.store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_3', 'files' => true, 'enctype'=>'multipart/form-data')) }}
                        @endif
                        <div class="m-portlet__body">
                            <div id="question-append">
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.q_no').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <input name="question_no" class="form-control m-input question" value="{{@$question->question_no}}">
                                        @error('question') <p class="errors">{{$errors->first('question_no')}}</p> @enderror
                                        <span class="inError"></span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.question_instruction'), null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <textarea name="instruction" id='editor1' class="form-control m-input question qckeditor" rows="9">{{@$question->instruction}}</textarea>
                                        @error('instruction') <p class="errors">{{$errors->first('instruction')}}</p> @enderror
                                        <span class="inError"></span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.mock-test.questions').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <textarea name="question" id='editor2' class="form-control m-input question qckeditor" rows="9" required="true">{{@$question->question}}</textarea>
                                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                                        <span class="inError"></span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row  @if(@$type == 4) d-none @endif" >
                                    {!! Form::label(__('formname.question.type').'*', null,array('class'=>'col-form-label col-lg-3
                                    col-sm-12')) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!! Form::select('type', @$type, @$question->type,['class' => 'form-control questionType','id'=>'qType']) !!}
                                        <span class="inError"></span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.q_topic').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!! Form::select('topic_id',@$topicList,@$question->topic_id,array('class'=>'form-control m-input')) !!}
                                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                                        <span class="inError"></span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.marks').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!! Form::text('marks',@$question->marks,array('class'=>'form-control m-input')) !!}
                                        @error('marks') <p class="errors">{{$errors->first('marks')}}</p> @enderror
                                        <span class="inError"></span>
                                    </div>
                                </div>
                                @php $answers = isset($question->answers)?$question->answers:[]; @endphp
                                @if(@$mockTest->stage_id == 1)
                                <div class="m-form__group form-group row" id='noOfOption' style="@if(@$question->type == 4) display:none; @endif">
                                    <label for="" class='col-form-label col-lg-3 col-sm-12'>{{__('formname.choose_no_option')}}</label>
                                    <div class="m-radio-inline">
                                        <label class="m-radio">
                                            <input type="radio" name="no_of_option" value="5" data-id='0_option_5' {{((isset($answers) && count($answers) == 5) || $question==null)?'checked':''}}>5
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="no_of_option" value="6" data-id='0_option_5' data-checkbox='text[0][5][is_correct]' data-answer="text[0][5][answer]" {{(isset($answers) && count($answers) == 6)?'checked':''}}>6
                                            <span></span>
                                        </label>
                                    </div>
                                    <span class="m-form__help"></span>
                                </div>
                                <div class="m-form__group form-group row" id="answerType" style="@if(@$question->type == 4) display:none; @endif">
                                    <label for="" class='col-form-label col-lg-3 col-sm-12'>{{__('formname.answer_type')}}</label>
                                    <div class="m-radio-inline">
                                        <label class="m-radio">
                                            <input type="radio" name="answer_type" value="1" class='answerType' data-index='0' id="answer_type_0" @if(@$question->answer_type == 1 || $question == null) checked @endif>{{__('formname.single_answer')}}
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="answer_type" value="2" class='answerType' data-index='0' id="answer_type_0" @if(@$question->answer_type == 2) checked @endif>{{__('formname.multiple_answer')}}
                                            <span></span>
                                        </label>
                                    </div>
                                    <span class="m-form__help"></span>
                                </div>
                                @endif
                                @php
                                    $alphabet = ord("A");
                                    $j = 1;
                                @endphp
                                <div id="question-append">
                                    @if(@$mockTest->stage_id == 1)
                                        @forelse (@$answers as $akey => $answer)
                                            <div id='0_option_{{$akey}}' class="form-group m-form__group row option_no_{{$akey}}">
                                                <input type="hidden" name="text[{{$akey}}][id]" value="{{@$answer->id}}">
                                                {!! Form::label(__('formname.option',['char'=>chr($alphabet)]).'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    @php
                                                        $name = 'text['.$akey.'][answer]';
                                                        $ansName = 'text['.$akey.'][is_correct]';
                                                    @endphp
                                                    {!! Form::textarea($name,@$answer->answer,array('id'=>'answer'.$akey,'class'=>'form-control m-input option-answers answer0 ckeditor', 'maxlength'=>'150', 'data-option'=>($akey==5)?'false':'true' ,'data-selected-ans' => 0)) !!}
                                                    <span class="inError"></span>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="m-checkbox-list" id="answer_0">
                                                        {{__('formname.correct_answer')}} :
                                                        <label class="m-checkbox closeCheckbox">
                                                            <input name="{{$ansName}}" type="checkbox" data-answerType='answer_type_0' data-questionIndex='0' class="correctAnswers qna0 correct{{$akey}}" value="1" id="answer_0" {{($answer->is_correct == 1)?'checked':''}}>
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="checkBoxError text-danger"></span>
                                                </div>
                                                <span class="error"></span>
                                            </div>
                                            @php  $alphabet++; $j++; @endphp
                                        @empty
                                            @for($i=0; $i<=5; $i++)
                                                <div id='0_option_{{$i}}' class="form-group m-form__group row option_no_{{$i}}">
                                                    {!! Form::label(__('formname.option',['char'=>chr($alphabet)]).'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                                        @php
                                                            $name = 'text['.$i.'][answer]';
                                                            $ansName = 'text['.$i.'][is_correct]';
                                                        @endphp
                                                        {!! Form::textarea($name,@$answer->answer,array('id'=>'answer'.$i,'class'=>'form-control m-input option-answers ckeditor', 'maxlength'=>'150', 'data-option'=>($i==5)?'false':'true' ,'data-selected-ans' => 0)) !!}
                                                        <span class="inError"></span>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                                        <div class="m-checkbox-list" id="answer_0">
                                                            {{__('formname.correct_answer')}} :
                                                            <label class="m-checkbox closeCheckbox">
                                                                <input name="{{$ansName}}" type="checkbox" data-answerType='answer_type_0' data-questionIndex='0' class="correctAnswers qna0 correct{{$i}}" value="1" id="answer_0" {{(@$answer->is_correct == 1)?'checked':''}}>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <span class="checkBoxError text-danger"></span>
                                                    </div>
                                                    <span class="error"></span>
                                                </div>
                                                @php $alphabet++; @endphp
                                            @endfor
                                        @endforelse
                                        @if(isset($answers) && count($answers) == 5)
                                            <div id='0_option_5' class="form-group m-form__group row option_no_5" style="display: none;">
                                                {!! Form::label(__('formname.option',['char'=>chr($alphabet)]).'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    @php
                                                        $name = 'text[5][answer]';
                                                        $ansName = 'text[5][is_correct]';
                                                    @endphp
                                                    {!! Form::text($name,null,array('id'=>'answer5','class'=>'form-control m-input option-answers ckeditor answer0', 'maxlength'=>'150', 'data-option'=>($akey==5)?'false':'true' ,'data-selected-ans' => 0)) !!}
                                                    <span class="inError"></span>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="m-checkbox-list" id="answer_0">
                                                        {{__('formname.correct_answer')}} :
                                                        <label class="m-checkbox closeCheckbox">
                                                            <input name="{{$ansName}}" type="checkbox" class="correctAnswers qna0 correct5" data-questionIndex='0' value="1" id="answer_0">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="checkBoxError text-danger"></span>
                                                </div>
                                                <span class="error"></span>
                                            </div>
                                        @endif
                                    @else
                                        @php
                                            $akey = 0;
                                            $answer = @$question->getSingleAnswer;
                                        @endphp
                                        <div id='0_option_{{$akey}}' class="form-group m-form__group row option_no_{{$akey}}">
                                            <input type="hidden" name="text[{{$akey}}][id]" value="{{@$answer->id}}">
                                            {!! Form::label(__('formname.answer').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                @php
                                                    $name = 'text['.$akey.'][answer]';
                                                    $ansName = 'text['.$akey.'][is_correct]';
                                                @endphp
                                                {!! Form::textarea($name,@$answer->answer,array('id'=>'answer'.$akey,'class'=>'form-control m-input option-answers answer0 ckeditor', 'maxlength'=>'150', 'data-option'=>($akey==5)?'false':'true' ,'data-selected-ans' => 0)) !!}
                                                <span class="inError"></span>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="m-checkbox-list" id="answer_0">
                                                        <input name="{{$ansName}}" type="hidden" data-answerType='answer_type_0' data-questionIndex='0' class="correctAnswers qna0 correct{{$akey}}" value="1" id="answer_0" {{(@$answer->is_correct == 1)?'checked':''}}>
                                                        <span></span>
                                                </div>
                                                <span class="checkBoxError text-danger"></span>
                                            </div>
                                            <span class="error"></span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.explanation'), null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <textarea name="explanation" id='explantion1' class="form-control explanationEditor">{!! @$question->explanation !!}</textarea>
                                    @error('question') <p class="errors">{{$errors->first('question_no')}}</p> @enderror
                                    <span class="inError"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.image_full'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                                    {!! Form::file('file',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_0','data-id'=>'q_image_preview_0','accept'=>'image/*')) !!}
                                    {!! Form::label('text_question_image_0',__('formname.choose_file'),array('class'=>'custom-file-label')) !!}<br>
                                    {!! Form::hidden('image_file',@$question->image) !!}
                                    {{-- <div class="row row_img create-edit-preview">
                                    <img id="q_image_preview_0" src="{{@$question->image_path}}" alt="" class='mx-200' style="display:{{isset($question->image_path)?'':'none'}};" />
                                    </div> --}}
                                    @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                                </div>
                            </div>
                            @if(@$question->image != null || @$question->resize_full_image != null)
                                <div class="form-group m-form__group row col-md-12">
                                    <label for="" class="'col-form-label col-lg-3 col-sm-12'"></label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        @if(@$question->resize_full_image != null)
                                            <textarea name="resize_full_image" id="p_full_img_path" class="imgCkeditor" cols="30" rows="10">
                                                {!! @$question->resize_full_image !!}
                                            </textarea>
                                        @else
                                            <textarea name="resize_full_image" id="p_full_img_path" class="imgCkeditor" cols="30" rows="10">
                                                <img src="{{ @$question->image_path }}" class="img-fluid mb-3" style="display:{{isset($question->image_path) && @$question->image != null ?'':'none'}};">
                                            </textarea>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.question_image'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                                    {!! Form::file('question_file',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_1','data-id'=>'q_image_preview_1','accept'=>'image/*')) !!}
                                    {!! Form::label('text_question_image_1',__('formname.choose_file'),array('class'=>'custom-file-label')) !!}<br>
                                    {!! Form::hidden('image_file',@$question->question_image) !!}
                                    {{-- <div class="row row_img create-edit-preview">
                                    <img id="q_image_preview_1" src="{{@$question->question_image_path}}" alt="" class='mx-200' style="display:{{isset($question->question_image)?'':'none'}};" />
                                    </div> --}}
                                    @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                                </div>
                            </div>
                            @if(@$question->question_image != null)
                                <div class="form-group m-form__group row col-md-12">
                                    <label for="" class="'col-form-label col-lg-3 col-sm-12'"></label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        @if(@$question->resize_question_image != null)
                                            <textarea name="resize_question_image" id="p_que_img_path" class="imgCkeditor" cols="30" rows="10">
                                                {!! @$question->resize_question_image !!}
                                            </textarea>
                                        @else
                                            <textarea name="resize_question_image" id="p_que_img_path" class="imgCkeditor" cols="30" rows="10">
                                                <img src="{{ @$question->question_image_path }}" class="img-fluid mb-3" style="display:{{isset($question->question_image_path) && $question->question_image != null ?'':'none'}};">
                                            </textarea>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.answer_image'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                                    {!! Form::file('answer_file',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_2','data-id'=>'q_image_preview_2','accept'=>'image/*')) !!}
                                    {!! Form::label('text_question_image_2',__('formname.choose_file'),array('class'=>'custom-file-label')) !!}<br>
                                    {!! Form::hidden('image_file',@$question->answer_image) !!}
                                    {{-- <div class="row row_img create-edit-preview">
                                    <img id="q_image_preview_2" src="{{@$question->answer_image_path}}" alt="" class='mx-200' style="display:{{isset($question->answer_image)?'':'none'}};" />
                                    </div> --}}
                                    @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                                </div>
                            </div>
                            @if(@$question->answer_image != null)
                            <div class="form-group m-form__group row col-md-12">
                                <label for="" class="'col-form-label col-lg-3 col-sm-12'"></label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    @if(@$question->resize_answer_image != null)
                                        <textarea name="resize_answer_image" id="p_ans_img_path" class="imgCkeditor" cols="30" rows="10">
                                            {!! @$question->resize_answer_image !!}
                                        </textarea>
                                    @else
                                        <textarea name="resize_answer_image" id="p_ans_img_path" class="imgCkeditor" cols="30" rows="10">
                                            <img src="{{ @$question->answer_image_path }}" class="img-fluid mb-3" style="display:{{isset($question->answer_image_path) && $question->answer_image != null ?'':'none'}};">
                                        </textarea>
                                    @endif
                                </div>
                            </div>
                            @endif
                            {!! Form::hidden('mockId',@$mockId) !!}
                            {!! Form::hidden('question_id',@$question_id) !!}
                            {!! Form::hidden('mock_test_subject_detail_id',@$mockTestSubjectDetailId) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success subnitBtn'] )!!}
                                            <a href="{{route('mock-test.detail',['uuid'=>@$mockId])}}" class="btn btn-secondary">Cancel</a>
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
@stop
@section('inc_script')
<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
<script>
    var actionUrl = "{{route('topic.store')}}";
    var validateTitleURL = "{{route('validate.topic.title')}}";
    var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
    var imgUpload = "{{route('question.uploadImage',['_token' => csrf_token() ])}}";
    var quesitionId = "{{@$question->id}}";
    $('.questionType').on('change', function(){
        if(this.value == 4){
            $('#answerType').hide();
            $('#noOfOption').hide();
            $(document).find('#0_option_5').show();
        }else{
            $(document).find('#0_option_5').hide();
            $('#answerType').show();
            $('#noOfOption').show();
        }
    })
</script>
<script src="{{ asset('backend/js/question_management/create-edit.js') }}" type="text/javascript"></script>
<script>
    initializeCkeditor();
    // question and answer ckeditor
</script>
@stop
