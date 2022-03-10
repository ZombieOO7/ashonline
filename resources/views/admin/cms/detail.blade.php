@extends('admin.layouts.default')
@section('inc_css')
@section('content')
@section('title', @$title)

<div class="m-grid__item m-grid__item--fluid m-wrapper">
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
                            {{-- <div class="m-portlet__head-tools">
                                <a href="{{route('cms_index')}}"
                                    class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{__('formname.back')}}</span>
                                    </span>
                                </a>
                            </div> --}}
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        @if(isset($cms) || !empty($cms))
                        {{ Form::model($cms, ['route' => ['cms_store', $cms->id], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right']) }}
                        @else
                        {{ Form::open(array('route' => 'cms_store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1')) }}
                        @endif
                        <div class="m-portlet__body">
                            <div class="m-form__content">
                                <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
                                    id="m_form_1_msg">
                                    <div class="m-alert__icon">
                                        <i class="la la-warning"></i>
                                    </div>
                                    <div class="m-alert__text">
                                        {{__('formname.error_msg')}}
                                    </div>
                                    <div class="m-alert__close">
                                        <button type="button" class="close" data-close="alert" aria-label="Close">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.title').'*', null,array('class'=>'col-form-label
                                col-lg-3
                                col-sm-12','maxlength' => config('constant.input_title_max_length'))) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!!
                                    Form::text('title',isset($cms)?$cms->title:'',array('class'=>'form-control
                                    m-input','maxlength' => 45)) !!}
                                    @if ($errors->has('title')) <p style="color:red;">
                                        {{ $errors->first('title') }}</p> @endif
                                </div>
                            </div>
                            @if(@$cms->page_slug == 'exam-guidance')
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.short_description'), null,array('class'=>'col-form-label
                                col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        {!!
                                        Form::textarea('short_description',isset($cms)?$cms->short_description:'',array('class'=>'form-control
                                        m-input','id'=>'editor2')) !!}
                                    </div>
                                    <span class="shrtDescError">
                                        @if ($errors->has('short_description')) <p style="color:red;">
                                            {{ $errors->first('short_description') }}</p> @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.content').'*', null,array('class'=>'col-form-label
                                col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        {!!
                                        Form::textarea('content',isset($cms)?$cms->content:'',array('class'=>'form-control
                                        m-input','id'=>'editor1')) !!}
                                    </div>
                                    <span class="contentError">
                                        @if ($errors->has('content')) <p style="color:red;">
                                            {{ $errors->first('content') }}</p> @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            {{-- @if(isset($cms))
                            @php $cmsststus = $cms->status;@endphp
                            @else
                            @php $cmsststus = null;@endphp
                            @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.status'), null,array('class'=>'col-form-label col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], $cmsststus,
                                    ['class' =>
                                    'form-control' ]) !!}
                                </div>
                            </div> --}}
                            {!! Form::hidden('id',isset($cms)?$cms->id:'' ,['id'=>'id']) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(trans('formname.submit'), ['class' => 'btn btn-success'] )
                                            !!}
                                            <a href="{{Route('cms_pages',['slug'=>@$cms->page_slug])}}"
                                                class="btn btn-secondary">{{trans('formname.cancel')}}</a>
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
<script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
<script src="{{ asset('backend/js/cms/create.js') }}" type="text/javascript"></script>
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
    CKEDITOR.replace('editor2');

    var cmsSlug = "{{ @$cms->page_slug }}";
    if ( cmsSlug == "contact-us" ) {
        CKEDITOR.config.removePlugins = 'image';    
    }
    
</script>
@stop