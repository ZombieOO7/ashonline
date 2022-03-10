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
                                <a href="{{route('past-paper.show',['uuid'=>@$pastPaper->uuid])}}"
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
                            {{ Form::model($question, ['route' => ['past-paper.question.store', @$question->uuid], 'method' => 'PUT','id'=>'m_form_3','class'=>'m-form m-form--fit m-form--label-align-right','enctype'=>'multipart/form-data']) }}
                        @else
                            {{ Form::open(array('route' => 'past-paper.question.store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_3', 'files' => true, 'enctype'=>'multipart/form-data')) }}
                        @endif
                        <input type="hidden" name="uuid" value="{{@$question->uuid}}">
                        <input type="hidden" name="past_paper_id" value="{{@$pastPaperId}}">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.question_no',['no'=>'']).'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-sm-12">
                                    <div class="input-group err_msg">
                                        {!! Form::text("question_no", @$question->question_no, ['class'=>'form-control']) !!}
                                    </div>
                                    @if ($errors->has("question_no"))
                                        <p style="color:red;">
                                            {{ $errors->first("question_no") }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.solved_question_time').'*', null,['class'=>'col-form-label col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-sm-12">
                                    {!! Form::text("solved_question_time",@$question->solved_question_time,['class' => 'form-control' ]) !!}
                                    @if ($errors->has("solved_question_time"))
                                        <p style="color:red;">
                                            {{ $errors->first("solved_question_time") }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.subject').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('subject_id',@$subjectList??[],@$question->subject_id,['class'=>'form-control
                                    m-input err_msg']) !!}
                                    @if ($errors->has('subject_id')) 
                                        <p style="color:red;">{{ $errors->first('subject_id') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-3 text-right mt-2">
                                    <label for="" class="">{{__('formname.question_topic')}}</label>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    {!! Form::select("topic_ids[]",@$topicList??[],@$question->topic_ids,['id'=>'topic', 'class' => 'form-control selectpicker', 'multiple'=>true]) !!}
                                    <span class='topicError'></span>
                                    @if ($errors->has("topic"))
                                        <p style="color:red;">
                                            {{ $errors->first("topic") }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.question_image_lbl').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-sm-12">
                                    <div class="input-group err_msg">
                                        {!! Form::file("question_file", ['class'=>'custom-file-input' ,'id'=>'questioImage' ]) !!}
                                        {!! Form::label('Choose file', null,['class'=>'custom-file-label']) !!}
                                        <input type="hidden" name="stored_question_image" id="stored_question_image"
                                            value="{{@$question->question_image}}">
                                    </div>
                                    @if ($errors->has("question_image"))
                                        <p style="color:red;">
                                            {{ $errors->first("question_image") }}
                                        </p>
                                    @endif
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
                                {!! Form::label(__('formname.answer_image_lbl').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-sm-12">
                                    <div class="input-group err_msg">
                                        {!! Form::file("answer_file", ['class'=>'custom-file-input' ,'id'=>'answerImage' ]) !!}
                                        {!! Form::label('Choose file', null,['class'=>'custom-file-label']) !!}
                                        <input type="hidden" name="stored_answer_image" id="stored_answer_image"
                                            value="{{@$question->answer_image}}">
                                    </div>
                                    @if ($errors->has("answer_image"))
                                        <p style="color:red;">
                                            {{ $errors->first("answer_image") }}
                                        </p>
                                    @endif
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
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <br>
                                <div class="row">
                                    <div class="col-lg-9 ml-lg-auto">
                                        {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success subnitBtn'] )!!}
                                        <a href="{{route('past-paper.show',['uuid'=>@$pastPaper->uuid])}}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
function CK_jQ() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}
function ckeditorKeyPress(event){
    if (event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39) {
    }else{ 
        event.cancel();
        event.stop();
    }
}
$(document).find('.imgCkeditor').each(function(e){
    var buttons = "Maximize,ShowBlocks,oembed,MediaEmbed,Save,DocProps,Print,Templates,document,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField,Anchor,CreatePlaceholder,Image,Flash,button1,button2,button3,About"
    CKEDITOR.replace( this.id,{
        extraPlugins:'image2',
        useCapture: true,
        className:'form-control',
        height : 350,
        removeButtons: buttons,
        autoParagraph: false,
        ignoreEmptyParagraph: true,
        removeDialogTabs : 'image:advanced;image:Link',
        on: {
                focus: function (instance) {
                    // $("#" + instance.editor.id + "_top").show();
                    $("#" + instance.editor.id + "_top").hide();
                },
                blur: function (instance) {
                    $("#" + instance.editor.id + "_top").hide();
                },
                keyup: CK_jQ,
                paste: CK_jQ,
                change: CK_jQ,
                key: ckeditorKeyPress
        },
    });
    CKEDITOR.config.startupFocus = false;
    CKEDITOR.config.resize_enabled = true;
    CKEDITOR.config.autoParagraph = false;
    CKEDITOR.config.extraPlugins = 'autogrow,ckeditor_wiris';
    CKEDITOR.config.autoGrow_minHeight = 50;
    CKEDITOR.config.autoGrow_maxHeight = 300;
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.on("instanceReady", function (ev) {
        $.each(CKEDITOR.instances, function (instance) {
            $("#" + CKEDITOR.instances[instance].id + "_top").hide();
            $("#" + CKEDITOR.instances[instance].id + "_bottom").hide();
        });
    });
});
</script>
@endsection