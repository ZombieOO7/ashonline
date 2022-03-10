@extends('admin.layouts.default')
@php 
$months = monthList(); 
$date = dateList();
@endphp
@section('content')
@section('title', @$title)

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
		@include('admin.includes.flashMessages')
        <div class="row">
            <div class="col-lg-12">
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
                        </div>
                    </div>
					<div class="m-portlet__body">
						<div class="m-form__section m-form__section--first">
							{{ Form::open(['route' => 'generate.mock.report','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'oreder_report_form']) }}
							<div class="m-portlet__body">
								<div class="m-form__content">
									<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
										id="web_social_media_link_msg">
										<div class="m-alert__icon">
											<i class="la la-warning"></i>
										</div>
										<div class="m-alert__text">
											{{-- {{__('formname.web_setting.error_msg')}} --}}
										</div>
										<div class="m-alert__close">
											<button type="button" class="close" data-close="alert" aria-label="Close">
											</button>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group row pt-0 pb-0">
									{!! Form::label(__('formname.report.type'),
									null,array('class'=>'col-form-label col-lg-2 col-sm-12'))!!}
									<div class="col-lg-6 col-md-9 col-sm-12">
										<div class="input-group">
											{!!Form::select('report_type',@$mockReportType,null,['class'=>'form-control',
											'multiple'=>false, 'style'=>'width:100%;','data-none-selected-text' => __('formname.report.select_month') ])!!}
										</div>
										<span class="report_typeError">
											@if($errors->has('report_type'))
											<p class="errors">{{$errors->first('report_type')}}</p>
											@endif
										</span>
										<span class="m-form__help"></span>
									</div>
								</div>
								<div class="m-form__actions">
									<div class="row">
										<div class="col-lg-10 ml-lg-auto">
											{!! Form::button('Annually', ['id'=>'yearly','class' => 'btn btn-primary'] )
											!!}
											{!! Form::button('Monthly', ['id'=>'monthly','class' => 'btn btn-primary'] )
											!!}
											{!! Form::button('Daily', ['id'=>'daily','class' => 'btn btn-primary'] )
											!!}
											{!! Form::hidden('reportCategory',null,['id'=>'reportCategory']) !!}
										</div>
									</div>
								</div>
								<div class="form-group m-form__group row" id='yearInput' style="display:none;">
									{!! Form::label(__('formname.report.year').'*', null,['class'=>'col-form-label col-lg-2 col-sm-12']) !!}
									<div class="col-lg-6 col-md-9 col-sm-12">
										{!!
										Form::text('year',null,['class'=>'form-control
										m-input','id'=>'year','readonly'=>true]) !!}
										@if ($errors->has('year')) <p style="color:red;">
											{{ $errors->first('year') }}</p> @endif
									</div>
								</div>
								<div class="form-group m-form__group row" id='monthInput' style="display:none;">
									{!! Form::label(__('formname.report.month'),
									null,array('class'=>'col-form-label col-lg-2 col-sm-12'))!!}
									<div class="col-lg-6 col-md-9 col-sm-12">
										<div class="input-group">
											{!!Form::select('month',@$months,null,['class'=>'form-control
											m-bootstrap-select ','id'=>'month','multiple'=>false, 'style'=>'width:100%;','data-none-selected-text' => __('formname.report.select_month') ])!!}
										</div>
										<span class="monthsError">
											@if($errors->has('months'))
											<p class="errors">{{$errors->first('month')}}</p>
											@endif
										</span>
										<span class="m-form__help"></span>
									</div>
								</div>
								<div class="form-group m-form__group row" id='dayInput' style="display:none;">
									{!! Form::label(__('formname.report.date'),
									null,array('class'=>'col-form-label
									col-lg-2 col-sm-12'))
									!!}
									<div class="col-lg-6 col-md-9 col-sm-12">
										<div class="input-group">
											{!!Form::select('date',@$date,[],['class'=>'form-control
											m-bootstrap-select ','id'=>'date','style'=>'width:100%;','multiple'=>false ,'data-none-selected-text' => __('formname.report.select_date') ])!!}
										</div>
										<span class="daysError">
											@if($errors->has('days'))
											<p class="errors">{{$errors->first('days')}}</p>
											@endif
										</span>
										<span class="m-form__help"></span>
									</div>
								</div>
								<div id="dynamicFilters">

								</div>
								<div class="form-group m-form__group row">
									{!! Form::label(trans('formname.report.export_to').'*', null,array('class'=>'col-form-label
									col-lg-2 col-sm-12'))
									!!}
									<div class="col-lg-6 col-md-9 col-sm-12">
										<div class="input-group">
											{!!Form::select('export_to',@[''=>'Select','.csv'=>'CSV','.xlsx'=>'Excel'],[],['class'=>'form-control','id'=>'export_to' ,'data-none-selected-text' => __('formname.report.export_to') ])!!}
										</div>
										<span class="exportError">
											@if($errors->has('export_to'))
											<p class="errors">{{$errors->first('export_to')}}</p>
											@endif
										</span>
										<span class="m-form__help"></span>
									</div>
								</div>
								{!! Form::hidden('id',@$report->id ,['id'=>'id']) !!}
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<div class="row">
											<div class="col-lg-10 ml-lg-auto">
												{{-- {!! Form::button(__('formname.show'), ['id'=>'viewReport','class' => 'btn btn-success bg-success'] )
												!!} --}}
												{!! Form::submit(__('formname.export_btn'), ['class' => 'btn btn-primary'] )
												!!}
												{!! Form::button(__('formname.clear_filter'), ['id'=>'clearBtn','class' => 'btn btn-info'] )
												!!}
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
</div>
@stop
@section('inc_script')
<script>
var url = "{{ route('order_report_data') }}";
var subject_url = "{{ route('get_cat_subjects') }}"
</script>
<script src="{{ asset('backend/js/report/mock-index.js') }}" type="text/javascript"></script>
@stop