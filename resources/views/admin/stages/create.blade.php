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
                                <a href="{{route('stage_index')}}"
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
                        {{ Form::model($stage, ['route' => ['stage_store', @$stage->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                        @else
                        {{ Form::open(['route' => 'stage_store','method'=>'post','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
                        @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.stage.title').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('title',@$stage->title,['class'=>'form-control
                                    m-input err_msg']) !!}
                                    @if ($errors->has('title')) 
                                        <p style="color:red;">{{ $errors->first('title') }}</p> 
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
                                            <a href="{{Route('stage_index')}}"
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
    $(document).find('.selectpicker').selectpicker({  
        placeholder: "{{__('formname.select_paper_cat')}}",
        allowClear: true
    }) 
    // $(document).find("#paper_category").select2();
</script>
<script>
var rule = $.extend({}, {!!json_encode(config('constant.examtypes'), JSON_FORCE_OBJECT) !!});
console.log(rule);
</script>
<script src="{{ asset('backend/js/examtypes/create.js') }}" type="text/javascript"></script>
@stop