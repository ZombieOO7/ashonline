@extends('admin.layouts.default')
@section('inc_css')

@endsection
@php
    $resType = ($type == 'blog' || $type == 'emock-blog') ? 'Blog' : 'Resource';
    $title = __('admin/resorces.create_title', ['type' => @$resType]);
    if(isset($resource))
        $title = __('admin/resorces.edit_title', ['type' => @$resType]);
@endphp
@section('title', @$title)

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
                                            {{ @$title }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <a href="{{route('resources.index', @$type)}}"
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
                                {{ Form::model($resource, ['route' => ['resources.update', @$resource->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right', 'files' => true]) }}
                            @else
                                {{ Form::open(array('route' => 'resources.store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1', 'files' => true)) }}
                            @endif
                            <div class="m-portlet__body">
                                {{-- @include('admin.includes.flashMessages') --}}
                                {!! Form::hidden('uuid',(isset($resource) ? @$resource->uuid : '') ,['id'=>'uuid']) !!}
                                {!! Form::hidden('id',(isset($resource) ? @$resource->id : '')) !!}
                                {!! Form::hidden('type', $type) !!}

                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('admin/resorces.title').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!! Form::text('title', @$resource->title ,array('class'=>'form-control m-input', 'maxlength'=>config('constant.input_title_max_length'))) !!}
                                        @error('title') <p class="errors">{{ $errors->first('title') }} </p> @enderror
                                    </div>
                                </div>
                                @if($type == 'blog' || $type == 'guidance')
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('admin/resorces.category').'*', null ,['class'=>'col-form-label col-lg-3 col-sm-12'],false) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::select('category_id', paperCategory(), @$resource->category_id, ['id' => 'category_id','class' =>'form-control selectpicker']) !!}
                                            @error('category_id') <p
                                                class="errors">{{ $errors->first('category_id') }} </p> @enderror
                                        </div>
                                    </div>
                                @endif
                                @if($type == 'emock-blog')
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.grade_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::select('grade_id', @$gradeList, @$resource->grade_id,
                                            ['class' =>'form-control' ]) !!}
                                            @if ($errors->has('grade_id'))
                                                <p class='errors'
                                                   style="color:red;">{{ $errors->first('grade_id') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if($type == 'emock-blog')
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('admin/resorces.link').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('link', @$resource->link ,array('class'=>'form-control m-input', 'maxlength'=>config('constant.rules.content_length'))) !!}
                                            @if ($errors->has('link'))
                                                <p class='errors' style="color:red;">{{ $errors->first('link') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                {{--                            Image Old Code--}}
                                {{--                            <div class="form-group m-form__group row">--}}
                                {{--                                {!! Form::label(__('admin/resorces.featured').'', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}--}}
                                {{--                                <div class="col-lg-6 col-md-9 col-sm-12 img_msg_scn">--}}
                                {{--                                    <div class="input-group err_msg">--}}
                                {{--                                        {!! Form::file('featured', ['class'=>'custom-file-input' ,'id'=>'featured', 'accept' => 'image/*']) !!}--}}
                                {{--                                        {!! Form::label((isset($resource) ? @$resource->featured_original_name : 'Choose file'), null,['class'=>'custom-file-label']) !!}--}}
                                {{--                                        <input type="hidden" name="featured_stored_name" id="featured_stored_name" value="{{@$resource->featured_stored_name}}">--}}
                                {{--                                        </br>--}}
                                {{--                                        <span class="m-form__help">{{ __('admin/resorces.featured_file_format') }}</span>--}}
                                {{--                                    </div>--}}
                                {{--                                    @error('featured') <p class="errors">{{ $errors->first('featured') }} </p> @enderror--}}
                                {{--                                    <img id="blah" src="{{@$resource->featured_img }}" alt="" height="200px;" width="200px;" style="{{ isset($resource->featured_img) ? 'display:block;' : 'display:none;' }}"/>--}}
                                {{--                                </div>--}}
                                {{--                            </div>--}}

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
                                            <span class="imgError"></span>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <ul class="nav nav-tabs">
                                                                <nav>
                                                                    <div class="nav nav-tabs" id="nav-tab"
                                                                         role="tablist">
                                                                        <a class="nav-item nav-link active"
                                                                           id="nav-home-tab"
                                                                           data-toggle="tab" href="#nav-home" role="tab"
                                                                           aria-controls="nav-home"
                                                                           aria-selected="true">Upload
                                                                            Image</a>
                                                                        <a class="nav-item nav-link"
                                                                           id="nav-profile-tab"
                                                                           data-toggle="tab" href="#nav-profile"
                                                                           role="tab"
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
                                                                        {!! Form::label(__('admin/resorces.featured').'', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                                        <div
                                                                            class="col-lg-6 col-md-9 col-sm-12 img_msg_scn">
                                                                            <div class="input-group err_msg">
                                                                                {!! Form::file('featured', ['class'=>'custom-file-input' ,'id'=>'featured', 'accept' => 'image/*']) !!}
                                                                                {!! Form::label((isset($resource) ? @$resource->featured_original_name : 'Choose file'), null,['class'=>'custom-file-label']) !!}
                                                                                <input type="hidden"
                                                                                       name="featured_stored_name"
                                                                                       id="featured_stored_name"
                                                                                       value="{{@$resource->featured_stored_name}}">
                                                                                </br>
                                                                                <span
                                                                                    class="m-form__help">{{ __('admin/resorces.featured_file_format') }}</span>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="tab-pane fade" id="nav-profile"
                                                                     role="tabpanel"
                                                                     aria-labelledby="nav-profile-tab">

                                                                    <table
                                                                        class="table table-striped- table-bordered table-hover for_wdth"
                                                                        id="image_module_table"
                                                                        data-type=""
                                                                        data-url="{{ route('resource.images_datatable') }}">
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
                                            {!! Form::hidden('image_id',@$resource->image_id ,['id'=>'image_id']) !!}
                                            <img id="blah"
                                                 src="{{isset($resource->featured_stored_name) ? url('storage/app/public/uploads/'.@$resource->featured_stored_name) : ''}}"
                                                 alt=""
                                                 max-width="200" ;
                                                 height="200" ;
                                                 style="{{ isset($resource) ? 'display:block;' : 'display:none;' }}"/>

                                        </div>
                                    </div>
                                </div>


                                <div class="form-group m-form__group row">
                                    {!! Form::label(trans('admin/resorces.content').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!! Form::textarea('content', @$resource->content, ['id' => 'editor1', 'rows' => 4, 'cols' => 54,]) !!}
                                        <span class="contentError">
                                        @error('content') <p class="errors">{{$errors->first('content')}}</p> @enderror
                                    </span>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    {!! Form::label(trans('admin/resorces.meta_title').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!! Form::text('meta_title',@$resource->meta_title,array('class'=>'form-control m-input','maxlength'=>config('constant.input_title_max_length'))) !!}
                                        @error('meta_title') <p
                                            class="errors">{{$errors->first('meta_title')}}</p> @enderror
                                    </div>
                                </div>
                                 <div class="form-group m-form__group row">
                                    {!! Form::label(trans('admin/resorces.meta_keyword').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!! Form::text('meta_keyword',@$resource->meta_keyword,array('class'=>'form-control m-input','maxlength'=>config('constant.input_title_max_length'))) !!}
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(trans('admin/resorces.meta_description').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 txtarea">
                                        {!! Form::textarea('meta_description', @$resource->meta_description,array('class'=>'form-control', 'maxlength'=>config('constant.input_desc_max_length')), ['rows' => 3, 'cols' => 30,]) !!}
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.status').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], (isset($resource)) ? ($resource->status) : null, ['class' => 'form-control' ]) !!}
                                    </div>
                                </div>

                                <div class="m-portlet__foot m-portlet__foot--fit">
                                    <div class="m-form__actions m-form__actions">
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-9 ml-lg-auto">
                                                {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] ) !!}
                                                <a href="{{route('resources.index', $type)}}"
                                                   class="btn btn-secondary">{{__('formname.cancel')}}</a>
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
    <script>
        var getDatatables = '{{route("resource.images_datatable")}}';
        var getImageId = '{{route("resource.GetSelectedImage")}}';
        var id = '{{@$resource->id}}';
        var common_id = id;
    </script>
    <script src="https://cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>
    <script src="{{ asset('backend/js/resources/create_guidance.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/js/Image/imageModel.js') }}" type="text/javascript"></script>

@stop
