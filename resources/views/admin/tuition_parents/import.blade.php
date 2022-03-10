@extends('admin.layouts.default')
<?php /*Load css to header section*/ ?>
@push('inc_css')

@endpush

@section('content')
@section('title', 'Upload File')

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
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-wrapper">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{__('formname.import_file')}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('tuition_parent_index')}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{__('formname.back')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" action="{{route('tuition_parent_importFile')}}" id="m_form_1" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="m-portlet__body">
                                <div class="m-form__content">
                                    <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_1_msg">
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
                                    <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.import_file')}} *</label>
                                     <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="file" class="custom-file-input" name="import_file"  id="customFile">
                                            @if($errors->has('import_file'))<p class="errors">{{$errors->first('import_file')}}</p>@endif
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <div class="alert m-alert m-alert--default" role="alert">
                                                Download <a target="__blank" href="{{ URL('/public/uploads/sample-tuition_parents.xls') }}">Sample</a> file
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            <input type="submit" name="import" value="Import" class="btn btn-success" />
                                            <a href="{{route('tuition_parent_index')}}" class="btn btn-secondary">{{__('formname.cancel')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
</div>

@stop

<?php /*Load script to footer section*/ ?>
@push('inc_script')
@endpush

<?php /*Load jquery to footer section*/ ?>
@section('inc_script')
<script>
    $(document).ready(function(){
        $("#m_form_1").validate({
            rules: {
                import_file: {
                    required: true,
                    extension: "csv|xls|xlxs"
                }
            },
            messages: {
                import_file: {
                    required: 'Import file filed is required.',
                    extension: 'Use only csv,xls,xlsx file to export promo codes.'
                },
            },
            invalidHandler:function(e,r){$("#m_form_1_msg").removeClass("m--hide").show(),
            mUtil.scrollTop()},
        });
    });
</script>
@stop