@extends('admin.layouts.default')
@section('inc_css')
@section('content')

@section('title', __('formname.student_detail'))


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
                            <h3 class="m-portlet__head-text">{{__('formname.student_detail')}}:</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{route('student.index')}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
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
                                <label class="col-lg-3 col-sm-12"><b>{{ __('users.fullname') }}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$student->fullname}}</div>
                            </div>
                            <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{ __('users.dob') }}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$student->dob_text}}</div>
                            </div>
                            {{-- <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{ __('users.gender') }}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ (isset($student->gender)&& ($student->gender==1))?'Male':'Female'}}</div>
                            </div> --}}
                            <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{ __('users.school_year') }}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$student->school_year}}</div>
                            </div>
                            <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{ __('users.exam_board') }}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$examBoardName}}</div>
                            </div>
                            {{-- <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{ __('users.email') }}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$student->email}}</div>
                            </div>
                            <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{ __('users.address') }}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$student->address}}</div>
                            </div>
                            <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{ __('users.city') }}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$student->city}}</div>
                            </div>
                            <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{ __('users.zip_code') }}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$student->zip_code}}</div>
                            </div>
                            <div class="row">
                                <label class="col-lg-3 col-sm-12"><b>{{ __('users.mobile') }}</b></label>
                                <div class="col-lg-9 col-md-9 col-sm-12 break_word">{{ @$student->mobile}}</div>
                            </div> --}}
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

@section('inc_script')
@stop
