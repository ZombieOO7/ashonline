@extends('admin.layouts.default')
@php 
$months = monthList(); 
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
							{{ Form::open(['route' => 'generate_report','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'oreder_report_form']) }}
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
								<div class="form-group m-form__group row">
									{!! Form::label(__('formname.report.year').'*', null,['class'=>'col-form-label
									col-lg-2
									col-sm-12']) !!}
									<div class="col-lg-6 col-md-9 col-sm-12">
										{!!
											Form::text('year',@$report->year,['class'=>'form-control m-input','id'=>'year','readonly'=>true]) !!}
										@if ($errors->has('year')) <p style="color:red;">
											{{ $errors->first('year') }}</p> @endif
									</div>
								</div>
								<div class="form-group m-form__group row">
									{!! Form::label(trans('formname.report.month').'*', null,array('class'=>'col-form-label
									col-lg-2 col-sm-12'))
									!!}
									<div class="col-lg-6 col-md-9 col-sm-12">
										<div class="input-group">
											{!!Form::select('months[]',@$months,[],['class'=>'form-control m-bootstrap-select ','id'=>'months','multiple'=>true ,'data-none-selected-text' => __('formname.report.select_month') ])!!}
										</div>
										<span class="monthsError">
											@if($errors->has('months'))
											<p class="errors">{{$errors->first('months')}}</p>
											@endif
										</span>
										<span class="m-form__help"></span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									{!! Form::label(trans('formname.report.category'), null,array('class'=>'col-form-label
									col-lg-2 col-sm-12'))
									!!}
									<div class="col-lg-6 col-md-9 col-sm-12">
										<div class="input-group">
											{!!Form::select('categoryIds[]',@$paperCategories,[],['class'=>'form-control m-bootstrap-select ','id'=>'categoryIds','multiple'=>true ,'data-none-selected-text' => __('formname.report.select_categories') ])!!}
											@if ($errors->has('categoryIds.*')) 
												<p style="color:red;">
												{{ $errors->first('categoryIds.*') }}
												</p> 
											@endif
										</div>
										<span class="categoriesError">
											@if($errors->has('categories'))
											<p class="errors">{{$errors->first('categories')}}</p>
											@endif
										</span>
										<span class="m-form__help"></span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									{!! Form::label(trans('formname.report.subject'), null,array('class'=>'col-form-label
									col-lg-2 col-sm-12'))
									!!}
									<div class="col-lg-6 col-md-9 col-sm-12">
										<div class="input-group">
											{!!Form::select('subjectIds[]',@$subjects,[],['class'=>'form-control m-bootstrap-select','id'=>'subjectIds','multiple'=>true ,'data-none-selected-text' => __('formname.report.select_subject') ])!!}
										</div>
										<span class="subjectsError">
											@if($errors->has('subjectIds'))
											<p class="errors">{{$errors->first('subjectIds')}}</p>
											@endif
										</span>
										<span class="m-form__help"></span>
									</div>
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
												{!! Form::submit(__('formname.export_btn'), ['class' => 'btn btn-primary'] )
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
<script src="{{ asset('backend/js/report/index.js') }}" type="text/javascript"></script>
@stop