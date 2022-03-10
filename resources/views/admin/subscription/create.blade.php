@extends('admin.layouts.default')
@section('content')
@section('title', @$title)

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
                                        {{@$title}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('subscription.index')}}"
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
                        @if(isset($subscription) || !empty($subscription))
                        {{ Form::model($subscription, ['route' => ['subscription.store', @$subscription->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                        @else
                        {{ Form::open(['route' => 'subscription.store','method'=>'post','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
                        @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.subscription.title').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('title',@$subscription->title,['class'=>'form-control
                                    m-input err_msg','maxlength'=>config('constant.title_length'),'placeholder'=>__('formname.subscription.title')]) !!}
                                    @if ($errors->has('title'))
                                        <p style="color:red;">{{ $errors->first('title') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.currency').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('currency',@$subscription->currency,['class'=>'form-control
                                    m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.currency')]) !!}
                                    @if ($errors->has('currency'))
                                        <p style="color:red;">{{ $errors->first('currency') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.price').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('price',@$subscription->price,['class'=>'form-control
                                    m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.price')]) !!}
                                    @if ($errors->has('price'))
                                        <p style="color:red;">{{ $errors->first('price') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.daily_charge').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('daily_charge',@$subscription->daily_charge,['class'=>'form-control
                                    m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.daily_charge'),]) !!}
                                    @if ($errors->has('daily_charge'))
                                        <p style="color:red;">{{ $errors->first('daily_charge') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.payment_date').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('payment_date',@$subscription->payment_date,['class'=>'form-control
                                    m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.payment_date'),]) !!}
                                    @if ($errors->has('payment_date'))
                                        <p style="color:red;">{{ $errors->first('payment_date') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.status').'*', null,['class'=>'col-form-label col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('status', @$statusList, @$subscription->status,
                                    ['class' =>
                                    'form-control' ]) !!}
                                </div>
                            </div>
                            {!! Form::hidden('id',@$subscription->id ,['id'=>'id']) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
                                            !!}
                                            <a href="{{Route('subscription.index')}}"
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
<script src="{{ asset('backend/js/subscription/create.js') }}" type="text/javascript"></script>
@stop