@extends('admin.layouts.default')
@section('inc_css')
<link href="{{asset('css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
@endsection
@section('content')
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
                                <a href="{{route('paper_category_index')}}"
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
                        @include('admin.includes.flashMessages')
                       
                        @if(isset($paperCategory) || !empty($paperCategory))
                        {{ Form::model($paperCategory, ['route' => ['paper_category_store', $paperCategory->id], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                        @else
                        {{ Form::open(['route' => 'paper_category_store','method'=>'post','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
                        @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.paper_category.type').'*', null,['class'=>'col-form-label col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('type', @$types, @$paperCategory->type,
                                    ['class' =>
                                    'form-control' ]) !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.paper_category.title').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('title',@$paperCategory->title,['class'=>'form-control
                                    m-input err_msg','maxlength'=>20]) !!}
                                    @if ($errors->has('title')) <p style="color:red;">
                                        {{ $errors->first('title') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.paper_category.color_code') .'*',
                                null,['class'=>'col-form-label
                                col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('color_code',@$paperCategory->color_code,['class'=>'form-control
                                    m-input err_msg colorpicker','readonly','pattern'=>"^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$"]) !!}
                                    @if ($errors->has('color_code')) <p style="color:red;">
                                        {{ $errors->first('color_code') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.paper_category.content').'', null,['class'=>'col-form-label
                            col-lg-3
                            col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        {!!
                                        Form::textarea('content',@$paperCategory->content,['class'=>'form-control
                                        m-input','id'=>'content']) !!}
                                    </div>
                                    <span class="contentError">
                                        @if ($errors->has('content')) <p style="color:red;">
                                            {{ $errors->first('content') }}</p> @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.paper_category.our_products').'', null,['class'=>'bold_txt col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.paper_category.products_content').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        {!!
                                        Form::textarea('product_content',@$paperCategory->product_content,['class'=>'form-control
                                        m-input','id'=>'productContent']) !!}
                                    </div>
                                    <span class="productContentError">
                                        @if ($errors->has('product_content')) <p style="color:red;">
                                            {{ $errors->first('product_content') }}</p> @endif
                                    </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-9 note-scn">
                                    {!! Form::label(__('formname.note').':', null,['class'=>'bold_txt']) !!}
                                    <span class="m-form__help">{{ __('formname.note_message') }}</span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-lg-3"></div>
                                {!! Form::label(__('formname.paper_category.product_title'), null,['class'=>'bold_txt col-form-label
                                col-lg-3 col-sm-12 text-left ']) !!}
                                {!! Form::label(__('formname.paper_category.product_description'), null,['class'=>'bold_txt col-form-label
                                col-lg-3 col-sm-12 text-left']) !!}
                            </div>
                            @for($i=0; $i<=2; $i++)
                            <div class="form-group m-form__group row all_product">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-3 col-md-9 col-sm-12">
                                {!! Form::text('products['.$i.'][title]',@$paperCategory->keyProducts[$i]->title,['class'=>'form-control
                                m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                    @if ($errors->has('products.'.$i.'.title')) <p style="color:red;">
                                    {{ __('formname.error_message') }}</p> @endif
                                </div>
                                <div class="col-lg-3 col-md-9 col-sm-12">
                                    {!! Form::textarea('products['.$i.'][description]',@$paperCategory->keyProducts[$i]->description,['class'=>'form-control
                                    m-input err_msg','rows'=>'2','maxlength' => 300]) !!}
                                    @if ($errors->has('products.'.$i.'.description')) <p style="color:red;">
                                        {{ __('formname.error_message') }}</p> @endif
                                </div>
                            </div>
                            @endfor

                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.paper_category.key_benefits').'', null,['class'=>'bold_txt col-form-label
                                col-lg-3
                                col-sm-12']) !!}                                
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-lg-3"></div>
                                {!! Form::label(__('formname.paper_category.product_title'), null,['class'=>'bold_txt col-form-label
                                col-lg-3 text-left col-sm-12']) !!}
                                {!! Form::label(__('formname.paper_category.product_description'), null,['class'=>'bold_txt col-form-label
                                col-lg-3  col-sm-12 text-left']) !!}
                            </div>
                            @for($i=0; $i<=3; $i++)
                            <div class="form-group m-form__group row all-benifits">
                                <div class="col-lg-3 col-sm-12 benifits_img"></div>
                                <div class="col-lg-3 col-md-9 col-sm-12">
                                    {!! Form::text('benefits['.$i.'][title]',@$paperCategory->keyBenefits[$i]->title,['class'=>'form-control
                                    m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                    
                                    @if ($errors->has('benefits.'.$i.'.title')) <p style="color:red;">
                                        {{ __('formname.error_message') }}</p> @endif
                                    </div>
                                <div class="col-lg-3 col-md-9 col-sm-12">
                                    {!! Form::textarea('benefits['.$i.'][description]',@$paperCategory->keyBenefits[$i]->description,['class'=>'form-control
                                    m-input err_msg','rows'=>'2','maxlength' => 300]) !!}
                                    <span class="err_msg"></span>
                                    @if ($errors->has('benefits.'.$i.'.description')) <p style="color:red;">
                                        {{ __('formname.error_message') }}</p> @endif
                                </div>
                            </div>
                            @endfor
                            
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.status'), null,['class'=>'col-form-label col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], @$paperCategory->status,
                                    ['class' =>
                                    'form-control' ]) !!}
                                </div>
                            </div>
                            {!! Form::hidden('id',@$paperCategory->id ,['id'=>'id']) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
                                            !!}
                                            <a href="{{Route('paper_category_index')}}"
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
{{-- <script src="{{asset('js/ckeditor.js')}}"></script> --}}
<script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
<script src="{{ asset('backend/js/paper-category/create.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-colorpicker.min.js')}}"></script>
@stop