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
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"
                    id="main_portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-wrapper">
                            <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{ucwords($methodType)}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{Route('schools.index')}}"
                                    class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{trans('users.back')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                            @if(isset($schools) && !empty($schools))
                                {{ Form::model($schools, ['route' =>['admin.schools.update', $schools->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right', 'files' => true, 'enctype' => "multipart/form-data"]) }}
                            @else
                                {{ Form::open(array('route' => ['schools.store'],'method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1', 'files' => true, 'enctype' => "multipart/form-data")) }}
                        @endif
                        {!! Form::hidden('uuid',(isset($schools) ? @$schools->uuid : '') ,['id'=>'uuid']) !!}
                            {!! Form::hidden('id',(isset($schools) ? @$schools->id : '')) !!}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.school_name') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('school_name',@$schools->school_name,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                                    @error('school_name') <p class="errors">{{$errors->first('school_name')}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.exam_board').'*', null,array('class'=>'col-form-label col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('categories', @$boardList, @$schools->categories,
                                    ['class' => 'form-control' ]) !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.is_multiple'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 mt-3">
                                    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                        <input type="checkbox" name="is_multiple" value="1" class="m-checkable trade_checkbox checkbox {{ (@$schools->is_multiple==1)?'checked':'' }}"{{ (@$schools->is_multiple==1)?'checked':'' }}>
                                    <span></span>
                                    </label>
                                </div>
                            </div>
                            </label>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(trans('users.status'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        {!! Form::select('active', ['1' => 'Active', '0' => 'Inactive'], @$schools->active, ['class' => 'form-control' ]) !!}
                                    </div>
                            </div>

                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(trans('users.submit'), ['class' => 'btn btn-success'] )!!}
                                            <a href="{{Route('schools.index')}}"
                                                class="btn btn-secondary">{{trans('users.cancel')}}</a>
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

<script src="{{ asset('backend/js/schools/create.js') }}" type="text/javascript"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdJhdpVyx8K7Uqf9g62DGZjNIazWaxZ3M&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

@stop
