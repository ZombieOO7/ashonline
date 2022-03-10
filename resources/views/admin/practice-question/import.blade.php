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
        @include('admin.includes.flashMessages')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-wrapper">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{__('formname.question.import_file')}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('assessment.question.index')}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{__('formname.back')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" action="{{route('assessment.question.importFile')}}" id="m_form_1" enctype="multipart/form-data">
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
                                    <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.question.import_file')}} *</label>
                                     <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="file" class="custom-file-input" name="import_file"  id="customFile">
                                            @if($errors->has('import_file'))<p class="errors">{{$errors->first('import_file')}}</p>@endif
                                            <label class="custom-file-label" for="customFile">{{__('formname.choose_file')}}</label>
                                        </div>
                                        <br>
                                        {{-- <div class="input-group">
                                            <div class="alert m-alert m-alert--default" role="alert">
                                                Download <a target="__blank" href="{{ URL('/public/uploads/question.xlsx') }}">Stage - 1 MCQ Sample</a> file
                                            </div>
                                        </div> --}}
                                        <div class="input-group">
                                            <div class="alert m-alert m-alert--default" role="alert">
                                                Download <a target="__blank" href="{{ URL('/public/uploads/mcq-sample.xls') }}"> Sample</a> file
                                            </div>
                                        </div>
                                        {{-- <div class="input-group">
                                            <div class="alert m-alert m-alert--default" role="alert">
                                                Download <a target="__blank" href="{{ URL('/public/uploads/Stage_1_Comprehensive_Questions.xlsx') }}">Stage - 1 Comprehension Sample</a> file
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="alert m-alert m-alert--default" role="alert">
                                                Download <a target="__blank" href="{{ URL('/public/uploads/Stage_1_Cloze_Questions.xlsx') }}">Stage - 1 Cloze Sample</a> file
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="alert m-alert m-alert--default" role="alert">
                                                Download <a target="__blank" href="{{ URL('/public/uploads/Stage_2_Comprehensive_Questions.xlsx') }}">Stage - 2 Comprehension Sample</a> file
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="alert m-alert m-alert--default" role="alert">
                                                Download <a target="__blank" href="{{ URL('/public/uploads/Stage_2_Cloze_Questions.xlsx') }}">Stage - 2 Cloze Sample</a> file
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                {{-- <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.question.passage')}} </label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="file" class="custom-file-input" name="passage[]"  id="customFile" multiple='true' accept='application/pdf'>
                                            @if($errors->has('passage'))<p class="errors">{{$errors->first('passage')}}</p>@endif
                                            <label class="custom-file-label" for="customFile">{{__('formname.choose_file')}}</label>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.images')}} </label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="file" class="custom-file-input" name="images[]"  id="customFile" multiple='true' accept='image/*'>
                                            @if($errors->has('images'))<p class="errors">{{$errors->first('images')}}</p>@endif
                                            <label class="custom-file-label" for="customFile">{{__('formname.choose_file')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            <input type="submit" name="import" value="Import" class="btn btn-success" />
                                            <a href="{{route('question.index')}}" class="btn btn-secondary">{{__('formname.cancel')}}</a>
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
                    extension: "csv,xls,xlsx"
                }
            },
            messages: {
                import_file: {
                    required: 'Import file field is required.',
                    extension: 'Use only CSV or Excel file to import Questions.'
                },
            },
            invalidHandler:function(e,r){$("#m_form_1_msg").removeClass("m--hide").show(),
            mUtil.scrollTop()},
        });
    });
</script>
@stop