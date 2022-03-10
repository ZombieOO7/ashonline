@extends('admin.layouts.default')
@section('inc_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css"
    rel="stylesheet">
@endsection
@section('content')
@php
if(isset($subject)){
$title=__('formname.subject.detail');
}
else{
$title=__('formname.subject.detail');
}
@endphp

@section('title', @$title)

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
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
                                <a href="{{route('subject_index')}}"
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
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.subject.paper_category').' : ', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                    {{@$subject->paper_category_id}}
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.subject.title').' : ', null,['class'=>'col-form-label
                                    col-lg-3
                                    col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@$subject->title}}
                                    </div>
                                </div>
                            <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.subject.content').' : ', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="col-form-label">
                                            {!!@$subject->content!!}
                                        </div>
                                    <span class="contentError">
                                        @if ($errors->has('content')) <p style="color:red;">
                                            {{ $errors->first('content') }}</p> @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            
                            @if(isset($subject))
                            @php $subjectststus = $subject->status;@endphp
                            @else
                            @php $subjectststus = null;@endphp
                            @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.status').' : ', null,['class'=>'col-form-label col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="col-form-label">
                                        {{@($subjectststus==1)?'Active':'InActive'}}
                                    </div>
                                </div>
                            </div>
                            {!! Form::hidden('id',isset($subject)?$subject->id:'' ,['id'=>'id']) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            <a href="{{Route('subject_index')}}"
                                                class="btn btn-success">{{__('formname.back')}}</a>
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
<script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
<script>
//deal with copying the ckeditor text into the actual textarea
CKEDITOR.on('instanceReady', function() {
    $.each(CKEDITOR.instances, function(instance) {
        CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
        CKEDITOR.instances[instance].document.on("paste", CK_jQ);
        CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
        CKEDITOR.instances[instance].document.on("blur", CK_jQ);
        CKEDITOR.instances[instance].document.on("change", CK_jQ);
    });
});

function CK_jQ() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}

CKEDITOR.replace('editor1');
</script>
<script src="{{ asset('backend/js/paper-category/create.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js">
</script>
<script>
$('.colorpicker').colorpicker();
</script>
@stop