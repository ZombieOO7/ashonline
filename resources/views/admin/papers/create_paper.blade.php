@extends('admin.layouts.default')
@section('inc_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css"
          rel="stylesheet">

    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css">

@endsection
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
                            <div class="m-portlet__head-tools">
                                <a href="{{route('paper_index')}}"
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
                        @if(isset($paper) || !empty($paper))
                            {{ Form::model($paper, ['route' => ['paper_store', @$paper->id], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                        @else
                            {{ Form::open(['route' => 'paper_store','method'=>'post','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
                        @endif
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::text('title',@$paper->title,['class'=>'form-control
                                m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                @if ($errors->has('title')) <p style="color:red;">
                                    {{ $errors->first('title') }}</p> @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label('category_id',__('formname.test_papers.category')." <sup
                                class='rqvr'>*</sup>" ,['class'=>'col-form-label col-lg-3
                            col-sm-12'],false) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::select('category_id', @$paperCategories, @$paper->category_id,
                                ['id' => 'category_id','class' =>'form-control','placeholder' => __('formname.select')])
                                !!}
                            </div>
                        </div>
                        <div id="categoryTypeColumns" class="mt-3">

                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.test_papers.edition').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::text('edition',@$paper->edition,['class'=>'form-control
                                m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                @if ($errors->has('edition')) <p style="color:red;">
                                    {{ $errors->first('edition') }}</p> @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.test_papers.price').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::text('price',@$paper->price,['class'=>'form-control
                                m-input err_msg','maxlength' => 10,'id'=>'price']) !!}
                                @if ($errors->has('price')) <p style="color:red;">
                                    {{ $errors->first('price') }}</p> @endif
                            </div>
                        </div>

                        {{--                    Upload Image Start --}}
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.image').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12 img_msg_scn">
                                <div class="input-group err_msg">
                                    <button type="button" class="btn btn-primary" id="getDatatable" data-toggle="modal"
                                            data-target="#exampleModal">
                                        Upload Image
                                    </button>
                                </div>
                                    <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <ul class="nav nav-tabs mb-0">
                                                    <nav>
                                                        <div class="nav nav-tabs mb-0" id="nav-tab" role="tablist">
                                                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Upload Image</a>
                                                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Media Library</a>
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
                                                            {!! Form::label(__('formname.mock-test.image') .'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                                {!!Form::file('test_image',['id'=>'imgInput','class'=>'form-control m-input','accept' => 'image/*'])!!}
                                                                <input type="hidden" name="stored_img_name" id="stored_img_id" value="{{@$user->profile_pic}}">
                                                                @if ($errors->has('test_image')) <p class='errors' style="color:red;">
                                                                    {{ $errors->first('test_image') }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                        {{-- <div class="m-scrollable m-scroller ps ps--active-y" data-scrollbar-shown="true" data-scrollable="true" data-height="400" style="height: 400px; overflow: hidden;"> --}}
                                                            <table class="table table-striped- table-bordered table-hover for_wdth" id="image_module_table" data-type="" data-url="{{ route('mock-test.images_datatable') }}">
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
                                                        {{-- </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" id="SaveImageMedia" data-module_name="Image">{{__('formname.save')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="ImageShowColumns" class="mt-3" max-width="200" height="400">
                                    {!! Form::hidden('image_id',@$mockTest->image_id ,['id'=>'image_id']) !!}

                                    <img id="blah" src="{{isset($paper->name) ? url('storage/app/public/uploads/'.@$paper->name) : ''}}" alt="" max-width="200" height="200" style="{{ isset($paper->name) ? 'display:block;width:200px;height:200px;' : 'display:none;' }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row img_msg_scn">
                            {!! Form::label(__('formname.test_papers.pdf').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <div class="input-group err_msg">
                                    {!! Form::file('pdf_name', ['class'=>'custom-file-input' ,'id'=>'pdfId' ]) !!}
                                    {!! Form::label('Choose file', null,['class'=>'custom-file-label']) !!}
                                    <input type="hidden" name="stored_pdf_name" id="stored_pdf_id"
                                           value="{{@$paper->pdf_name}}">
                                    <span
                                        class="m-form__help">{{ __('formname.pdf_format') }}</br>{{ __('formname.test_papers.pdf_version') }}</span>
                                </div>
                                @if ($errors->has('pdf_name'))
                                    <p style="color:red;">
                                        {{ $errors->first('pdf_name') }}
                                    </p>
                                @endif
                                @if(isset($paper))

                                    <img src="{{ asset('images/pdf.jpeg') }}" alt=""><a
                                        href="{{route('download_pdf',@$paper->version->uuid)}}" class="download_pdf"><i
                                            class="la la-download"></i></a>
                                @endif
                            </div>

                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.test_papers.content').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <div class="input-group">
                                    {!!
                                    Form::textarea('content',@$paper->content,['class'=>'form-control
                                    m-input','id'=>'editor1']) !!}
                                </div>
                                <span class="contentError">
                                    @if ($errors->has('content')) <p style="color:red;">
                                        {{ $errors->first('content') }}</p> @endif
                                </span>
                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.status').'*', null,['class'=>'col-form-label col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], @$paper->status,
                                ['class' =>
                                'form-control','placeholder' => 'Select' ]) !!}
                            </div>
                        </div>

                        <!-- KEYWORDS -->
                        <div class="form-group m-form__group row">
                            {!! Form::label('Keywords', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::text('keywords','',['class'=>'form-control m-input err_msg tm-input tm-input-info']) !!}
                                @if ($errors->has('keywords'))
                                    <p style="color:red;">
                                        {{ $errors->first('keywords') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {!! Form::hidden('id',@$paper->id ,['id'=>'id']) !!}
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <br>
                                <div class="row">
                                    <div class="col-lg-9 ml-lg-auto">
                                        {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
                                        !!}
                                        <a href="{{ route('paper_index')}}"
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
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
    <script>

        var fieldurl = '{{route("getColumns")}}';
        var paperId = '{{@$paper->id}}';
        var cartegoryId = '{{@$paper->category_id}}';
        var getImageId = '{{route("GetSelectedImage")}}';
        var getDatatables = '{{route("images_datatable")}}';
        var common_id = paperId;
    </script>

    <script>
        //deal with copying the ckeditor text into the actual textarea
        CKEDITOR.on('instanceReady', function () {
            $.each(CKEDITOR.instances, function (instance) {
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
        var keywords = $.extend({}, {!!json_encode(isset($keywords) ? $keywords: "", JSON_FORCE_OBJECT)!!});
        $(".tm-input").tagsManager({
            prefilled: keywords,
        });
    </script>
    <script src="{{ asset('backend/js/papers/create.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/js/Image/imageModel.js') }}" type="text/javascript"></script>
@stop
