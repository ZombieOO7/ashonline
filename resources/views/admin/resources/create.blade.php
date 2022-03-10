@extends('admin.layouts.default')
@section('inc_css')

@endsection
@php
$resType = ($type == 'blog') ? 'Blog' : $type2;
$title = __('admin/resorces.create_title', ['type' => $resType]);
if(isset($resource))
    $title = __('admin/resorces.edit_title', ['type' => $resType]);
@endphp
@section('title', $title)

@section('content')

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
                                        {{ $title }}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('resources.index', $type)}}"
                                    class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{ __('formname.back')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        @if(isset($resource) || !empty($resource))
                            {{ Form::model($resource, ['route' => ['resources.update', @$resource->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right resource_help', 'files' => true]) }}
                        @else
                            {{ Form::open(array('route' => 'resources.store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right resource_help','id'=>'m_form_1', 'files' => true)) }}
                        @endif
                        <div class="m-portlet__body">
                            {{-- @include('admin.includes.flashMessages') --}}

                            {!! Form::hidden('uuid',(isset($resource) ? @$resource->uuid : '') ,['id'=>'uuid']) !!}
                            {!! Form::hidden('id',(isset($resource) ? @$resource->id : '')) !!}
                            {!! Form::hidden('type', $type) !!}

                            <div class="form-group m-form__group row">
                                {!! Form::label(__('admin/resorces.title').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('title', @$resource->title ,array('class'=>'form-control m-input', 'maxlength'=> config('constant.input_title_max_length'))) !!}
                                    @error('title') <p class="errors">{{ $errors->first('title') }} </p> @enderror
                                </div>
                            </div>
                            {{-- <div class="form-group m-form__group row">
                                {!! Form::label(__('admin/resorces.category').'*', null ,['class'=>'col-form-label col-lg-3 col-sm-12'],false) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('resource_category_id', resourceCategory(), @$resource->resource_category_id, ['id' => 'resource_category_id','class' =>'form-control']) !!}
                                    @error('resource_category_id') <p class="errors">{{ $errors->first('resource_category_id') }} </p> @enderror
                                </div>
                            </div> --}}

                            <div class="form-group m-form__group row">
                                {!! Form::label(__('admin/resorces.question').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group err_msg">
                                        {!! Form::file('question', ['class'=>'custom-file-input' ,'id'=>'question', 'accept' => 'application/pdf,application/vnd.ms-excel']) !!}
                                        {!! Form::label((isset($resource) ? @$resource->question_original_name : 'Choose file'), null,['class'=>'custom-file-label']) !!}
                                        <input type="hidden" name="question_stored_name" id="question_stored_name" value="{{@$resource->question_stored_name}}">
                                        </br>
                                        <span class="m-form__help">{{ __('admin/resorces.file_format') }}</span>
                                    </div>
                                    @error('question') <p class="errors">{{ $errors->first('question') }} </p> @enderror
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                {!! Form::label(__('admin/resorces.answer').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group err_msg">
                                        {!! Form::file('answer', ['class'=>'custom-file-input' ,'id'=>'answer', 'accept' => 'application/pdf,application/vnd.ms-excel']) !!}
                                        {!! Form::label((isset($resource) ? @$resource->answer_original_name : 'Choose file'), null,['class'=>'custom-file-label']) !!}
                                        <input type="hidden" name="answer_stored_name" id="answer_stored_name" value="{{@$resource->answer_stored_name}}">
                                        </br>
                                        <span class="m-form__help">{{ __('admin/resorces.file_format') }}</span>
                                    </div>
                                    @error('answer') <p class="errors">{{ $errors->first('answer') }} </p> @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group m-form__group row">
                                {!! Form::label('Status', null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('active', ['1' => 'Active', '0' => 'Inactive'], (isset($resource)) ? ($resource->active) : null, ['class' => 'form-control' ]) !!}
                                </div>
                            </div> --}}

                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] ) !!}
                                            <a href="{{route('resources.index', $type)}}" class="btn btn-secondary">{{__('formname.cancel')}}</a>
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
<script src="{{ asset('backend/js/resources/create.js') }}" type="text/javascript"></script>
@stop
