@extends('admin.layouts.default')
@section('inc_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
@endsection
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
                                <a href="{{route('promo_code_index')}}"
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
                        @if(isset($stage) || !empty($stage))
                        {{ Form::model($stage, ['route' => ['promo_code_store', @$stage->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','autocomplete' => "off"]) }}
                        @else
                        {{ Form::open(['route' => 'promo_code_store','method'=>'post','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','autocomplete' => "off"]) }}
                        @endif
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.promo_codes.amount_1').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!!
                                    Form::text('amount_1',($stage)?@$stage->amount_1:'',['class'=>'form-control
                                m-input','id'=>'amount_1','maxlength' => 10]) !!}
                                @if ($errors->has('amount_1')) <p style="color:red;">
                                    {{ $errors->first('amount_1') }}</p> @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.promo_codes.discount_1').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!!
                                    Form::text('discount_1',($stage)?@$stage->discount_1:'',['class'=>'form-control
                                m-input' ,'id'=>'discount_1','maxlength' => 3]) !!}
                                @if ($errors->has('discount_1')) <p style="color:red;">
                                    {{ $errors->first('discount_1') }}</p> @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.promo_codes.amount_2').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!!
                                    Form::text('amount_2',($stage)?@$stage->amount_2:'',['class'=>'form-control
                                m-input' ,'id'=>'amount_2','maxlength' => 10]) !!}
                                @if ($errors->has('amount_2')) <p style="color:red;">
                                    {{ $errors->first('amount_2') }}</p> @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.promo_codes.discount_2').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!!
                                    Form::text('discount_2',($stage)?@$stage->discount_2:'',['class'=>'form-control
                                m-input' ,'id'=>'discount_2','maxlength' => 3]) !!}
                                @if ($errors->has('discount_2')) <p style="color:red;">
                                    {{ $errors->first('discount_2') }}</p> @endif
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.promo_codes.code').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::text('code',@$stage->code,['class'=>'form-control
                                m-input err_msg','maxlength'=> config('constant.input_title_max_length')]) !!}
                                @if ($errors->has('code')) 
                                    <p style="color:red;">{{ $errors->first('code') }}</p> 
                                @endif
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.promo_codes.start_date').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::text('start_date',@$stage->start_date ? date('m/d/Y',strtotime(@$stage->start_date)) : '',['class'=>'form-control
                                m-input err_msg','id' => 'start_date','readonly' => true]) !!}
                                @if ($errors->has('start_date')) 
                                    <p style="color:red;">{{ $errors->first('start_date') }}</p> 
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.promo_codes.end_date').'*', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::text('end_date',@$stage->end_date ? date('m/d/Y',strtotime(@$stage->end_date)) : '',['class'=>'form-control
                                m-input err_msg','id' => 'end_date','readonly' => true]) !!}
                                @if ($errors->has('start_date')) 
                                    <p style="color:red;">{{ $errors->first('end_date') }}</p> 
                                @endif
                            </div>
                        </div>

                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.status').'*', null,['class'=>'col-form-label col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], @$stage->status,
                                    ['class' =>
                                    'form-control' ]) !!}
                                </div>
                            </div>
                            {!! Form::hidden('id',@$stage->id ,['id'=>'id']) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
                                            !!}
                                            <a href="{{Route('promo_code_index')}}"
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('backend/js/promo_codes/create.js') }}" type="text/javascript"></script>
@stop