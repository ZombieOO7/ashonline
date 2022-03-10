@extends('admin.layouts.default')
@section('inc_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@section('title', @$title)
<style>
.bootstrap-select > .dropdown-toggle.bs-placeholder.btn-light {
    border: 1px solid #c3c3c3 !important;
}
.bootstrap-select > .dropdown-toggle.btn-light, .bootstrap-select > .dropdown-toggle.btn-secondary{
    border: 1px solid #c3c3c3 !important;
}
.bootstrap-select .dropdown-menu {
    max-height: 200px !important;
    min-width: -moz-available !important;
    width: 300px !important;
    min-width: 410px !important;
    max-width: 410px !important;
}
</style>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
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
                                <a href="{{route('parent_index')}}"
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
                        @if(isset($parent) || !empty($parent))
                        {{ Form::model($parent, ['route' => ['parent_store', @$parent->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit','autocomplete' => "off"]) }}
                        @else
                        {{ Form::open(['route' => 'parent_store','method'=>'post','class'=>'m-form m-form--fit','id'=>'m_form_1','autocomplete' => "off"]) }}
                        @endif
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.full_name').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::text('full_name',($parent)?@$parent->full_name:old('full_name'),['class'=>'form-control
                                m-input','id'=>'full_name','maxlength' => 100]) !!}
                                @if ($errors->has('full_name'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('full_name') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.email').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::email('email',($parent)?@$parent->email:old('email'),['class'=>'form-control
                                m-input','id'=>'email','maxlength' => 50]) !!}
                                @if ($errors->has('email'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.password').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <input type="text" value="{{ @$parent ? '' : @$autoPassword }}" name="password" class="form-control m-input" maxlength="16" minlength="6" {{isset($parent)?'disabled':''}}/>
                                @if ($errors->has('password'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.phone').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <input type="text" name="mobile" value="{{ @$parent ? @$parent->mobile : old('mobile')}}" class="form-control m-input" id="mobile" maxlength="14" minlength="10"/>
                                @if ($errors->has('mobile'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('mobile') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.is_tution_parent').'*', null,['class'=>'col-form-label col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <select name="is_tuition_parent" id="is_tuition_parent" class="form-control">
                                    <option value="0" {{ @$parent->is_tuition_parent == 0 ? 'selected' : ''}}>{{__('No')}}</option>
                                    <option value="1" {{ @$parent->is_tuition_parent == 1 ? 'selected' : ''}}>{{__('Yes')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.country').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::select('country_id', @$countryList, @$parent->country_id, ['title'=>"Country",'class'
                                    =>'selectpicker form-control m-input def_select w-100','id'=>'countryId' ]) !!}
                                @if ($errors->has('country'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('country') }}
                                    </p>
                                @endif
                                <span class="countryError"></span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.zip_code'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <input type="text" id='postcode' name="zip_code" value="{{ @$parent ? @$parent->zip_code : old('zip_code')}}" class="form-control" @if(@$parent->getCountry->name != 'United Kingdom') readonly @endif maxlength="14"/>
                                @if ($errors->has('zip_code'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('zip_code') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.address').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <input type="text" name="address" value="{{ @$parent ? @$parent->address : old('address')}}" class="form-control m-input" id="address" maxlength="150"/>
                                @if ($errors->has('address'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('address') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.address2'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <input type="text" name="address2" value="{{ @$parent ? @$parent->address2 : old('address2')}}" class="form-control m-input" id="address2" maxlength="150"/>
                                @if ($errors->has('address2'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('address2') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.city').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <input type="text" name="city" value="{{ @$parent ? @$parent->city : old('city')}}" class="form-control m-input" id="city" maxlength="50"/>
                                @if ($errors->has('city'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('city') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.parent.council').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {{-- <input type="text" name="council" value="{{ @$parent ? @$parent->council : old('council')}}" class="form-control m-input" id='county' maxlength="50"/> --}}
                                {!! Form::select('county_id', countyList(), (@$user->country->name == 'United Kingdom')?$user->council:'Other', ['title'=>"County",'class'
                                =>'selectpicker def_select  w-100','id'=>'county','disabled'=>(@$user->country->name == 'United Kingdom')? false:true ]) !!}
                                <input type="hidden" class="form-control" placeholder="County/Council" value="{{(@$user->country->name == 'United Kingdom')?$user->council:'Other'}}" id='countyVal' name='council'>
                                <span class="countyError"></span>
                                @if ($errors->has('council'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('council') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.is_verify').'*', null,['class'=>'col-form-label col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <select name="is_verify" id="status" class="form-control">
                                    <option value="1" {{ @$parent->is_verify == 1 ? 'selected' : ''}}>Yes</option>
                                    <option value="0" {{ @$parent->is_verify == 0 ? 'selected' : ''}}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.status').'*', null,['class'=>'col-form-label col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ @$parent->status == 1 ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{ @$parent->status == config('constant.status_inactive_value') ? 'selected' : ''}}>Inactive</option>
                                    <option value="2" {{ @$parent->status == config('constant.status_deactivate_value')  ? 'selected' : ''}} disabled>Deactivate</option>
                                </select>
                            </div>
                        </div>
                        {!! Form::hidden('id',@$parent->id ,['id'=>'id']) !!}
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <br>
                                <div class="row">
                                    <div class="col-lg-9 ml-lg-auto">
                                        {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
                                        !!}
                                        <a href="{{Route('parent_index')}}"
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
<script>
    var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="{{asset('newfrontend/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('backend/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/parents/create.js') }}" type="text/javascript"></script>
<script>
    $addressKey = "{{env('ADDRESS_API_KEY')}}";
</script>
<script src="{{asset('newfrontend/js/getAddress.js')}}"></script>
@stop
