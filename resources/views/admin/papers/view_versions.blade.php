@extends('admin.layouts.default')
@section('inc_css')
@section('content')
@section('title', 'Versions')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                @include('admin.includes.flashMessages')
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"
                    id="main_portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-wrapper">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{ @$paper->title }}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('paper_index')}}"
                                    class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{ __("formname.back") }}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                        <div class="form-group m-form__group row row_div">
                            @forelse($paperVersions as $version)
                            <div class="col-lg-3">
                                <label class="col-form-label">
                                    <b>{{__('formname.test_papers.version')}} {{@$version->version}} : </b>
                                    {{ @$version->original_name != null ? @$version->original_name : @$paper->original_name}}
                                </label>
                                <img src="{{ asset('images/pdf.jpeg') }}" style="height: 150px !important;" alt="">
                                <a href="{{route('download_pdf',@$version->uuid)}}" class="download_pdf">
                                    <i class="la la-download"></i>
                                </a>
                            </div>
                            @empty
                            <div class="col-lg-3">
                                <label class="col-form-label">
                                    <b>{{__('formname.test_papers.version')}} : 1</b>
                                    {{ @$paper->original_name }}
                                </label>
                                <img src="{{ asset('images/pdf.jpeg') }}" style="height: 150px !important;" alt="">
                                <a href="{{route('download_pdf',@$paper->uuid)}}" class="download_pdf">
                                    <i class="la la-download"></i>
                                </a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('inc_script')
<script>

</script>
@stop