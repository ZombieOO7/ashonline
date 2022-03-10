@extends('admin.layouts.default')
@section('inc_css')
@section('content')

@section('title', $methodType)


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
                @include('admin.includes.flashMessages')
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" 
                id="main_portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-wrapper">
                        <div class="m-portlet__head-caption">
                            <h3 class="m-portlet__head-text"> {{$methodType}}:</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{route('schools.index')}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                            <span>
                                <i class="la la-arrow-left"></i>
                                <span>{{ __('general.back') }}</span>
                            </span>
                        </a>
                    </div>
                </div>
                
                <div class="m-portlet__body width_big users_details_scn">
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 mrgn_bt_20">
                            <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{trans('users.school_name')}}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$Schools->school_name}}</div>
                            </div>
                            <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{trans('users.exam_board')}}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$Schools->examBoard->title }}</div>
                            </div>
                        </div>
                        
                    </div>
                    <div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
@stop