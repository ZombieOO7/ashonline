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
                                <a href="{{route('email_template_index')}}"
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
                        @if(isset($emailTemplate) || !empty($emailTemplate))
                        {{ Form::model($emailTemplate, ['route' => ['email_template_store', @$emailTemplate->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                        @else
                        {{ Form::open(['route' => 'email_template_store','method'=>'post','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
                        @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.email_template.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('title',@$emailTemplate->title,['class'=>'form-control m-input err_msg','maxlength'=>config('constant.input_title_max_length')]) !!}
                                    @if ($errors->has('title')) 
                                        <p style="color:red;">{{ $errors->first('title') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.email_template.subject').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('subject',@$emailTemplate->subject,['class'=>'form-control m-input','maxlength'=>config('constant.input_title_max_length')]) !!}
                                    @if ($errors->has('subject')) <p style="color:red;">
                                        {{ $errors->first('subject') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.email_template.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class='controls' id="variables">
                                        @if(@$emailTemplate->slug == 'contact-us' || @$emailTemplate->slug == 'review-feedback')
                                        <a href="javascript:void(0);">{{__('formname.email_template.user_full_name')}}</a>
                                        <a href="javascript:void(0);">{{__('formname.email_template.email')}}</a>
                                        @endif
                                        @if(@$emailTemplate->slug == 'parent-registration' || @$emailTemplate->slug == 'forgot-password')
                                            <a href="javascript:void(0);">{{__('formname.email_template.user_full_name')}}</a>
                                            <a href="javascript:void(0);">{{__('formname.email_template.email')}}</a>
                                            <a href="javascript:void(0);">{{__('formname.email_template.link')}}</a>
                                        @endif
                                        @if(@$emailTemplate->slug == 'child-login-detail')
                                            <a href="javascript:void(0);">{{__('formname.email_template.username')}}</a>
                                            <a href="javascript:void(0);">{{__('formname.email_template.password')}}</a>
                                            <a href="javascript:void(0);">{{__('formname.email_template.childid')}}</a>
                                        @endif
                                        @if(@$emailTemplate->slug == 'contact-us')
                                        <a href="javascript:void(0);">{{__('formname.email_template.phone')}}</a>
                                        <a href="javascript:void(0);">{{__('formname.email_template.subject_link')}}</a>
                                        <a href="javascript:void(0);">{{__('formname.email_template.message')}}</a>
                                        @endif
                                        @if(@$emailTemplate->slug == 'invoice')
                                        <a href="javascript:void(0);">{{__('formname.email_template.user_full_name')}}</a>
                                        @endif
                                        {{-- @if(@$emailTemplate->slug == 'order-email-to-user' || @$emailTemplate->slug == 'order-email-to-admin')
                                        <a href="javascript:void(0);">{{__('formname.email_template.address')}}</a>
                                        @endif --}}
                                    </div>
                                    <div class="input-group">
                                        {!! Form::textarea('body',@$emailTemplate->body,['class'=>'form-control m-input','id'=>'editor1','maxlength'=>config('constant.input_desc_max_length')]) !!}
                                    </div>
                                    <span class="contentError">
                                        @if ($errors->has('body'))
                                        <p style="color:red;">
                                            {{ $errors->first('body') }}
                                        </p>
                                        @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.status').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], @$emailTemplate->status,
                                    ['class' =>
                                    'form-control' ]) !!}
                                </div>
                            </div>
                            {!! Form::hidden('id',@$emailTemplate->id ,['id'=>'id']) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] ) !!}
                                            <a href="{{Route('email_template_index')}}"
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
<script src="{{ asset('backend/js/email-template/create.js') }}" type="text/javascript"></script>
@stop