@extends('admin.layouts.default')
@section('inc_css')

@section('content')

@section('title', @$title)
@php
    if(isset($cms)){
        $imagePath = ($cms->image != null && file_exists(storage_path().'/'.'app/public/uploads/'.$cms->image)) ? url('storage/app/public/uploads/'. $cms->image) : asset('images/mock_img_tbl.png');
        $logoPath = ($cms->logo != null && file_exists(storage_path().'/'.'app/public/uploads/'.$cms->logo)) ? url('storage/app/public/uploads/'. $cms->logo) : asset('images/mock_img_tbl.png');
    }else{
        $imagePath = null;
        $logoPath = null;
    }
@endphp
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
                                <a href="{{route($route)}}"
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
                        @if(isset($cms) || !empty($cms))
                            {{ Form::model($cms, ['route' => ['cms_store', $cms->id], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true]) }}
                        @else
                            {{ Form::open(array('route' => 'cms_store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','files' => true)) }}
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
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!!
                                    Form::text('title',isset($cms)?$cms->title:'',array('class'=>'form-control
                                    m-input')) !!}
                                    @if ($errors->has('title')) <p style="color:red;">
                                        {{ $errors->first('title') }}</p> @endif
                                </div>
                            </div>
                            @if($type==3)
                                <div class="form-group m-form__group row">
                                    {!! Form::label(trans('formname.mock-test.school_id').'*', null,array('class'=>'col-form-label
                                    col-lg-3 col-sm-12')) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!!
                                        Form::select('school_id',@$schoolList,@$cms->school_id,array('class'=>'form-control
                                        m-input','id'=>'school_id')) !!}
                                        @if ($errors->has('school_id')) <p style="color:red;">
                                            {{ $errors->first('school_id') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(trans('formname.mock_test_id'), null,array('class'=>'col-form-label
                                    col-lg-3 col-sm-12')) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!!
                                        Form::select('mock_test_id[]',@$mockTests,@$mockTestIds,array('class'=>'form-control
                                        m-input selectpicker m-bootstrap-select m_selectpicker','id'=>'mock_test_id','multiple'=>true)) !!}
                                        @if ($errors->has('mock_test_id')) <p style="color:red;">
                                            {{ $errors->first('mock_test_id') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(trans('formname.cms.paper'), null,array('class'=>'col-form-label
                                    col-lg-3 col-sm-12')) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!!
                                        Form::select('paper_id[]',@$papers,@$paperIds,array('class'=>'form-control
                                        m-input selectpicker m-bootstrap-select m_selectpicker','id'=>'paper_id','multiple'=>true)) !!}
                                        @if ($errors->has('paper_id')) <p style="color:red;">
                                            {{ $errors->first('paper_id') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.cms.logo').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 img_msg_scn">
                                        <div class="input-group err_msg">
                                            {!! Form::file('logo_file', ['class'=>'custom-file-input' ,'id'=>'logoInp',
                                            'accept' => 'image/*']) !!}
                                            {!! Form::label('Choose file', null,['class'=>'custom-file-label']) !!}
                                            <input type="hidden" name="logo_name" id="logoInp"
                                                   value="{{@$cms->logo_name}}">
                                            </br>
                                            @if ($errors->has('image')) <p style="color:red;">
                                                {{ $errors->first('image') }}</p> @endif
                                        </div>
                                        @if ($errors->has('logoInp'))
                                            <p style="color:red;">
                                                {{ $errors->first('logoInp') }}
                                            </p>
                                        @endif<br>
                                        <img id="logoImg" src="{{$logoPath}}" alt="" width="200px" ;
                                             height="200px" ;
                                             style="{{ isset($cms->logo) ? 'display:block;' : 'display:none;' }}"/>

                                    </div>
                                </div>

                            @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.short_description').'*', null,array('class'=>'col-form-label
                                col-lg-3 col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        {!!
                                        Form::textarea('short_description',isset($cms)?$cms->short_description:'',array('class'=>'form-control
                                        m-input','id'=>'editor')) !!}
                                    </div>
                                    <span class="shrtDescError"></span>
                                    @if ($errors->has('short_description')) <p style="color:red;">
                                        {{ $errors->first('short_description') }}</p> @endif
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.content').'*', null,array('class'=>'col-form-label
                                col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        {!!
                                        Form::textarea('content',@$cms->content,array('class'=>'form-control
                                        m-input','id'=>'editor1')) !!}
                                    </div>
                                    <span class="contentError">
                                        @if ($errors->has('content')) <p style="color:red;">
                                            {{ $errors->first('content') }}</p> @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.exam_style').'*', null,array('class'=>'col-form-label
                                col-lg-3 col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        {!!
                                        Form::textarea('exam_style',isset($cms)?$cms->exam_style:'',array('class'=>'form-control
                                        m-input','id'=>'editor2')) !!}
                                    </div>
                                    <span class="examStyleError"></span>
                                    @if ($errors->has('exam_style')) <p style="color:red;">
                                        {{ $errors->first('exam_style') }}</p> @endif
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.meta_keyword'), null,array('class'=>'col-form-label
                                col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!!
                                    Form::text('meta_keyword',@$cms->meta_keyword,array('class'=>'form-control
                                    m-input')) !!}
                                    @if ($errors->has('meta_keyword')) <p style="color:red;">
                                        {{ $errors->first('meta_keyword') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.meta_description'),
                                null,array('class'=>'col-form-label
                                col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!!
                                    Form::textarea('meta_description',@$cms->meta_description,array('class'=>'form-control
                                    m-input')) !!}
                                    @if ($errors->has('meta_description')) <p style="color:red;">
                                        {{ $errors->first('meta_description') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.image').'*', null,['class'=>'col-form-label
                            col-lg-3
                               col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 img_msg_scn">
                                    <div class="input-group err_msg">
                                        <button type="button" class="btn btn-primary" id="getDatatable"
                                                data-toggle="modal"
                                                data-target="#exampleModal">
                                            Upload Image
                                        </button>
                                        <span class="imageError"></span>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <ul class="nav nav-tabs">
                                                            <nav>
                                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                    <a class="nav-item nav-link active"
                                                                       id="nav-home-tab"
                                                                       data-toggle="tab" href="#nav-home" role="tab"
                                                                       aria-controls="nav-home" aria-selected="true">Upload
                                                                        Image</a>
                                                                    <a class="nav-item nav-link" id="nav-profile-tab"
                                                                       data-toggle="tab" href="#nav-profile" role="tab"
                                                                       aria-controls="nav-profile"
                                                                       aria-selected="false">Media
                                                                        Library</a>
                                                                </div>
                                                            </nav>
                                                        </ul>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="tab-content" id="nav-tabContent">
                                                            <div class="tab-pane fade show active" id="nav-home"
                                                                 role="tabpanel" aria-labelledby="nav-home-tab">
                                                                <div class="form-group m-form__group row">
                                                                    {!! Form::label(__('formname.image').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                                    <div
                                                                        class="col-lg-6 col-md-9 col-sm-12 img_msg_scn">
                                                                        <div class="input-group err_msg">
                                                                            {!! Form::file('name', ['class'=>'custom-file-input' ,'id'=>'imgInp',
                                                                            'accept' => 'image/*']) !!}
                                                                            {!! Form::label('Choose file', null,['class'=>'custom-file-label']) !!}
                                                                            <input type="hidden" name="stored_img_name"
                                                                                   id="imgInp"
                                                                                   value="{{@$cms->image}}">
                                                                            </br>
                                                                            @if ($errors->has('image')) <p
                                                                                style="color:red;">
                                                                                {{ $errors->first('image') }}</p> @endif
                                                                        </div>
                                                                        @if ($errors->has('imgInp'))
                                                                            <p style="color:red;">
                                                                                {{ $errors->first('imgInp') }}
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                                                 aria-labelledby="nav-profile-tab">

                                                                <table
                                                                    class="table table-striped- table-bordered table-hover for_wdth"
                                                                    id="image_module_table"
                                                                    data-type=""
                                                                    data-url="{{ route('cms.images_datatable') }}">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>
                                                                        </th>
                                                                        <th>{{__('formname.image_name.path')}}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tfoot>
                                                                    </tfoot>
                                                                </table>
                                                                <button type="button" class="btn btn-primary"
                                                                        id="SaveImageMedia"
                                                                        data-module_name="Image">{{__('formname.save')}}</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                                data-dismiss="modal">
                                                            Close
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="ImageShowColumns" class="mt-3" max-width="100%" ;
                                         height="auto">
                                        {!! Form::hidden('image_id',@$cms->image_id ,['id'=>'image_id']) !!}
                                        <img id="blah" src="{{$imagePath}}" alt="" max-width="200" height="200" style="{{ isset($cms->image) ? 'display:block;' : 'display:none;' }}"/>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.status'), null,array('class'=>'col-form-label col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], @$cms->status,
                                    ['class' => 'form-control' ]) !!}
                                </div>
                            </div>
                            {!! Form::hidden('logo_image_id',@$cms->logo_image_id ,['id'=>'logo_image_id']) !!}
                            {!! Form::hidden('id',isset($cms)?$cms->id:'' ,['id'=>'id']) !!}
                            {!! Form::hidden('type',@$type) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(trans('formname.submit'), ['class' => 'btn btn-success'] )
                                            !!}
                                            <a href="{{Route($route,['type'=>@$type])}}"
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
    <script src="{{ asset('backend/js/Image/imageModel.js') }}" type="text/javascript"></script>

    <script>
        var mockUrl = '{{route("get-school-mock")}}';
        var getDatatables = '{{route("cms.images_datatable")}}';
        var getImageId = '{{route("cms.GetSelectedImage")}}';
        var id = '{{@$cms->id}}';
        var common_id = id;
    </script>

@stop
