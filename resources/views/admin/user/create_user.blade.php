@extends('admin.layouts.default')
@section('inc_css')

@section('content')
@php
if(isset($user)){
$title=trans('formname.user_update');
}
else{
$title=trans('formname.user_create');
}
@endphp

@section('title', $title)

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
                                        {{$title}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('user_index')}}"
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
                        @if(isset($user) || !empty($user))
                        {{ Form::model($user, ['route' => ['user_store', $user->id], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right']) }}
                        @else
                        {{ Form::open(array('route' => 'user_store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1')) }}
                        @endif
                        <div class="m-portlet__body">
                            <div class="m-form__content">
                                <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
                                    id="m_form_1_msg">
                                    <div class="m-alert__icon">
                                        <i class="la la-warning"></i>
                                    </div>
                                    <div class="m-alert__text">
                                        {{__('formname.error_msg')}}.
                                    </div>
                                    <div class="m-alert__close">
                                        <button type="button" class="close" data-close="alert" aria-label="Close">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.first_name').'*', null,array('class'=>'col-form-label
                                col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!!
                                    Form::text('first_name',isset($user)?$user->first_name:'',array('class'=>'form-control
                                    m-input')) !!}
                                    @if ($errors->has('first_name')) <p style="color:red;">
                                        {{ $errors->first('first_name') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.last_name') .'*', null,array('class'=>'col-form-label
                                col-lg-3 col-sm-12'))
                                !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!!
                                    Form::text('last_name',isset($user)?$user->last_name:'',array('class'=>'form-control
                                    m-input')) !!}
                                    @if ($errors->has('last_name')) <p style="color:red;">
                                        {{ $errors->first('last_name') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.email'). '*', null,array('class'=>'col-form-label
                                col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!!
                                    Form::email('email',isset($user)?$user->email:'',array('class'=>'form-control
                                    m-input')) !!}
                                    <span>
                                        @if ($errors->has('email')) <p style="color:red;">
                                            {{ $errors->first('email') }}</p> @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.password').'*', null,array('class'=>'col-form-label
                                col-lg-3 col-sm-12'))
                                !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        {!! Form::password('password',['class' =>
                                        'form-control
                                        m-input','id'=>'password','type' =>
                                        'password']) !!}
                                    </div>
                                    <span class="passwordError">
                                        @if($errors->has('password'))
                                        <p class="errors">{{$errors->first('password')}}</p>
                                        @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.confirm_password').'*',
                                null,array('class'=>'col-form-label
                                col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        {!! Form::password('conform_password',['class' => 'form-control
                                        m-input','id'=>'conform_password','type' => 'password']) !!}
                                    </div>
                                    <span class="conformPasswordError">
                                        @if($errors->has('conform_password'))
                                        <p class="errors">{{$errors->first('conform_password')}}</p>
                                        @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            @if(isset($user))
                            @php $userststus = $user->status;@endphp
                            @else
                            @php $userststus = null;@endphp
                            @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.status'), null,array('class'=>'col-form-label col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], $userststus,
                                    ['class' =>
                                    'form-control' ]) !!}
                                </div>
                            </div>
                            {!! Form::hidden('id',isset($user)?$user->id:'' ,['id'=>'id']) !!}
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('formname.user_role').'*', null,array('class'=>'col-form-label
                                col-lg-3 col-sm-12'))
                                !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        @php
                                        $roleList = Config::get('role');
                                        $filtered = Illuminate\Support\Arr::except($roleList, ['1']);
                                        @endphp
                                        @if(isset($user))
                                        @php $userRole = $user->roles->pluck('id');@endphp
                                        @else
                                        @php $userRole ="select";@endphp
                                        @endif
                                        {!!
                                        Form::select('role[]',$filtered,$userRole,['class'=>'selectpicker
                                        form-control
                                        m-bootstrap-select m_selectpicker','id'=>'role','multiple'=>true,'data-none-selected-text' => __('formname.select_role') ])!!}
                                        @if ($errors->has('role.*')) <p style="color:red;">
                                            {{ $errors->first('role.*') }}</p> @endif
                                    </div>
                                    <span class="roleError">
                                        @if($errors->has('role.*'))
                                        <p class="errors">{{$errors->first('role.*')}}</p>
                                        @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(trans('formname.submit'), ['class' => 'btn btn-success'] )
                                            !!}
                                            <a href="{{Route('user_index')}}"
                                                class="btn btn-secondary">{{trans('formname.cancel')}}</a>
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
<script src="{{ asset('backend/js/user/create.js') }}" type="text/javascript"></script>
@stop