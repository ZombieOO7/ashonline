@extends('admin.layouts.default')
@section('content')
@section('title', 'Image Management')
@section('inc_style')
    <style type="text/css">

        input[type=file] {

            display: inline;

        }
        .image_form__help{
            background-color: red;
        }

        #image_preview {
            max-height: 10px;
            max-width: 10px;
            background-size: 100px;

        }

        #image_preview img {
            padding: 5px;

        }

    </style>
@endsection
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->

    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
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
                        <a href="{{route('images.index')}}"
                           class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{__('formname.back')}}</span>
                                    </span>
                        </a>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="container" id="datashow">


                <form action="{{ route('images.store') }}" method="post" id="m_form_image"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group m-form__group row">
                        {!! Form::label(trans('formname.image_name.image').'*', null,array('class'=>'col-form-label
                        col-lg-3
                        col-sm-12')) !!}
                        <div class="col-lg-6 col-md-9 col-sm-12">

                            <input type="file" id="uploadFile" name="uploadFile"><br><br>
                            <span class="image_form__help">{{ __('admin/resorces.image_file_format') }}</span>
                            @if ($errors->has('uploadFile'))
                                <p class='errors' style="color:red;">{{ $errors->first('uploadFile') }}</p>
                            @endif
                            <div id="image_preview" class="m-3"></div>
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input type="submit" class="btn btn-success" id="submitData" name='submitImage'
                               value="Save Image"/>
                    </div>
                </form>
                <br/>

            </div>

        </div>
        <br></div>
</div>

@stop

@section('inc_script')
    <script type="text/javascript">

        $("#uploadFile").change(function () {
            $('#image_preview').html("");
            var total_file = document.getElementById("uploadFile").files.length;
            for (var i = 0; i < total_file; i++) {
                $('#image_preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "'>");

            }

        });
        // $('form').ajaxForm(function () {
        //     alert("Uploaded SuccessFully");
        //
        // });

    </script>
    <script src="{{ asset('backend/js/Image/index.js') }}" type="text/javascript"></script>

@stop
