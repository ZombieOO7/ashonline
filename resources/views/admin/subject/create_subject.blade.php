@extends('admin.layouts.default')
@section('content')
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
                        @if(isset($subject) || !empty($subject))
                        {{ Form::model($subject, ['route' => ['subject_store', @$subject->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                        @else
                        {{ Form::open(['route' => 'subject_store','method'=>'post','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
                        @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.subjects.title').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('title',@$subject->title,['class'=>'form-control
                                    m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                    @if ($errors->has('title')) 
                                        <p style="color:red;" class="valError">{{ $errors->first('title') }}</p> 
                                    @endif
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.subjects.content').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        {!!
                                        Form::textarea('content',@$subject->content,['class'=>'form-control
                                        m-input err_msg','id'=>'editor1']) !!}
                                    </div>
                                    <span class="contentError">
                                        @if ($errors->has('content')) <p style="color:red;">
                                            {{ $errors->first('content') }}</p> @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            {!! Form::hidden('id',@$subject->id,['id'=>'id']) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
                                            !!}
                                            <a href="{{Route('subject_index')}}"
                                                class="btn btn-secondary">{{__('formname.cancel')}}</a>
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
<script>
//deal with copying the ckeditor text into the actual textarea

</script>
<script>
    $(document).find("#paper_category").select2();
</script>
<script src="{{ asset('backend/js/subject/create.js') }}" type="text/javascript"></script>
@stop