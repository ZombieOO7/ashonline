@extends('admin.layouts.default')
@section('inc_css')
<style>
	.m2--hide{
		display: none;
	}
</style>
@section('content')
@php
if(isset($permission)){
$title=__('formname.permission_update');
}
else{
$title=__('formname.web_setting.name');
}
$CONSTANT = config('constant')['websetting'];
$ACTIVETAB = $CONSTANT['active_tab'];
$activeTab = (old('active_tab')!= null)?old('active_tab'):@$activeTab;
if ($activeTab != null){
}else{
	$activeTab = $ACTIVETAB[2];
}
// dd($activeTab);
@endphp
@section('pageCss')

@endsection
@section('title', $title)

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
                                        {{$title}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="m-portlet__body">
						<div class="m-wizard__form-step m-wizard__form-step--current" id="web_setting_form_step">
							<div class="row">
								<div class="col-xl-12">
									<ul class="nav nav-tabs m-tabs-line--2x m-tabs-line m-tabs-line--danger" role="tablist">
										<li class="nav-item m-tabs__item">
											<a class="nav-link m-tabs__link {{($activeTab==$ACTIVETAB[2])?'active':''}}" data-toggle="tab" href="#promo_code_tab" role="tab"><i class="fa fa-bullhorn"></i>{{__('formname.web_setting.promo_code')}}</a>
										</li>

										<li class="nav-item m-tabs__item">
											<a class="nav-link m-tabs__link {{($activeTab==$ACTIVETAB[3])?'active':''}}" data-toggle="tab" href="#meta_keyword_tab" role="tab"><i class="fa fa-tag"></i>{{__('formname.web_setting.meta_tags')}}</a>
										</li>
										<li class="nav-item m-tabs__item">
											<a class="nav-link m-tabs__link {{($activeTab==$ACTIVETAB[5])?'active':''}}" data-toggle="tab" href="#rating_mail_tab" role="tab"><i class="fa fa-envelope"></i>{{__('formname.web_setting.rating_mail')}}</a>
										</li>
										<li class="nav-item m-tabs__item">
											<a class="nav-link m-tabs__link {{($activeTab==$ACTIVETAB[6])?'active':''}} " data-toggle="tab" href="#notification_tab" role="tab"><i class="fa fa-bell"></i>{{__('formname.web_setting.notification')}}</a>
										</li>
										<li class="nav-item m-tabs__item">
											<a class="nav-link m-tabs__link {{($activeTab==$ACTIVETAB[7])?'active':''}} " data-toggle="tab" href="#stripe_payment_tab" role="tab"><i class="fab fa-cc-stripe"></i>{{__('formname.web_setting.payment')}}</a>
										</li>
										<li class="nav-item m-tabs__item">
											<a class="nav-link m-tabs__link {{($activeTab==$ACTIVETAB[8])?'active':''}} " data-toggle="tab" href="#paypal_payment_tab" role="tab"><i class="fab fa-paypal"></i>{{__('formname.web_setting.paypal')}}</a>
										</li>
									</ul>
									<div class="tab-content m--margin-top-40">
										<div class="tab-pane {{($activeTab==$ACTIVETAB[4])?'active':''}}" id="social_media_tab" role="tabpanel">
											
											<div class="m-form__section m-form__section--first">
												
												@if(isset($setting) || !empty($setting))
												{{ Form::model($setting, ['route' => ['general_setting_store',$setting->id], 'method' => 'PUT','id'=>'socila_media_link_form','class'=>'m-form m-form--fit m-form--label-align-right']) }}
												@else
												{{ Form::open(['route' => 'general_setting_store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'socila_media_link_form']) }}
												@endif
												<div class="m-portlet__body">
													<div class="m-form__content">
														<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
															id="web_social_media_link_msg">
															<div class="m-alert__icon">
																<i class="la la-warning"></i>
															</div>
															<div class="m-alert__text">
																{{__('formname.web_setting.error_msg')}}.
															</div>
															<div class="m-alert__close">
																<button type="button" class="close" data-close="alert" aria-label="Close">
																</button>
															</div>
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.google_url').'', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('google_url',($setting)?@$setting->google_url:'',['class'=>'form-control
															m-input']) !!}
															@if ($errors->has('google_url')) <p style="color:red;">
																{{ $errors->first('google_url') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.facebook_url').'', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('facebook_url',@$setting->facebook_url,['class'=>'form-control
															m-input']) !!}
															@if ($errors->has('facebook_url')) <p style="color:red;">
																{{ $errors->first('facebook_url') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.twitter_url').'', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('twitter_url',@$setting->twitter_url,['class'=>'form-control
															m-input']) !!}
															@if ($errors->has('twitter_url')) <p style="color:red;">
																{{ $errors->first('twitter_url') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.youtube_url').'', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('youtube_url',@$setting->youtube_url,['class'=>'form-control
															m-input']) !!}
															@if ($errors->has('youtube_url')) <p style="color:red;">
																{{ $errors->first('youtube_url') }}</p> @endif
														</div>
													</div>
													{!! Form::hidden('id',@$setting->id ,['id'=>'id']) !!}
													{!! Form::hidden('active_tab',$ACTIVETAB[4],['id'=>'active_tab']) !!}
													<div class="m-portlet__foot m-portlet__foot--fit">
														<div class="m-form__actions m-form__actions">
															<br>
															<div class="row">
																<div class="col-lg-9 ml-lg-auto">
																	{!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
																	!!}
																	<a href="{{Route('web_setting_index')}}"
																		class="btn btn-secondary">{{__('formname.cancel')}}</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											{!! Form::close() !!}
											</div>
										</div>
										<div class="tab-pane {{($activeTab==$ACTIVETAB[3])?'active':''}}" id="meta_keyword_tab" role="tabpanel">
											
											<div class="m-form__section m-form__section--first">
												
												@if(isset($setting) || !empty($setting))
												{{ Form::model($setting, ['route' => ['general_setting_store',$setting->id], 'method' => 'PUT','id'=>'socila_media_link_form','class'=>'m-form m-form--fit m-form--label-align-right']) }}
												@else
												{{ Form::open(['route' => 'general_setting_store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'socila_media_link_form']) }}
												@endif
												<div class="m-portlet__body">
													<div class="m-form__content">
														<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
															id="web_social_media_link_msg">
															<div class="m-alert__icon">
																<i class="la la-warning"></i>
															</div>
															<div class="m-alert__text">
																{{__('formname.web_setting.error_msg')}}.
															</div>
															<div class="m-alert__close">
																<button type="button" class="close" data-close="alert" aria-label="Close">
																</button>
															</div>
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.meta_keywords').'', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('meta_keywords',($setting)?@$setting->meta_keywords:'',['class'=>'form-control
															m-input']) !!}
															@if ($errors->has('meta_keywords')) <p style="color:red;">
																{{ $errors->first('meta_keywords') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.meta_description').'', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!! Form::textarea('meta_description', @$setting->meta_description, ['class'=>'form-control']) !!}
															@if ($errors->has('meta_description')) <p style="color:red;">
																{{ $errors->first('meta_description') }}</p> @endif
														</div>
													</div>
													{!! Form::hidden('id',@$setting->id ,['id'=>'id']) !!}
													{!! Form::hidden('active_tab',$ACTIVETAB[3],['id'=>'active_tab']) !!}
													<div class="m-portlet__foot m-portlet__foot--fit">
														<div class="m-form__actions m-form__actions">
															<br>
															<div class="row">
																<div class="col-lg-9 ml-lg-auto">
																	{!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
																	!!}
																	<a href="{{ route('admin_dashboard') }}"
																		class="btn btn-secondary">{{__('formname.cancel')}}</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											{!! Form::close() !!}
											</div>
										</div>
										<div class="tab-pane {{($activeTab==$ACTIVETAB[2])?'active':''}}" id="promo_code_tab" role="tabpanel">
											
											<div class="m-form__section m-form__section--first">
												
												@if(isset($setting) || !empty($setting))
												{{ Form::model($setting, ['route' => ['general_setting_store',$setting->id], 'method' => 'PUT','id'=>'promo_code_setting_form','class'=>'m-form m-form--fit m-form--label-align-right']) }}
												@else
												{{ Form::open(['route' => 'general_setting_store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'promo_code_setting_form']) }}
												@endif
												<div class="m-portlet__body">
													<div class="m-form__content">
														<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
															id="web_social_media_link_msg">
															<div class="m-alert__icon">
																<i class="la la-warning"></i>
															</div>
															<div class="m-alert__text">
																{{__('formname.web_setting.error_msg')}}.
															</div>
															<div class="m-alert__close">
																<button type="button" class="close" data-close="alert" aria-label="Close">
																</button>
															</div>
														</div>
													</div>

													
													<div class="form-group m-form__group row">
														{!! Form::label('Current Status'.'', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
														<div class="col-lg-3 col-md-9 col-sm-12">
															{!! Form::text('status',@$setting->code_status==1 ? 'Active' : 'Inactive',['class'=>'form-control m-input','disabled' => true]) !!}
														</div>
													</div>
													<input type="hidden" value="{{ @$setting->code_status==1 ? 1 : 0}}" name="code_status" id="hidden_code_status"/>
													<div class="form-group m-form__group row">
														{!! Form::label('Active/Inactive'.'', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-3 col-md-9 col-sm-12">
															<a class="cd-stts" href="javascript:;" data-status="{{ @$setting->code_status==1 ? 1 : 0}}" title="{{ @$setting->code_status==1 ? 'Active' : 'Inactive' }}">
																<i class="{{ @$setting->code_status == 1 ? 'fas fa-toggle-on' : 'fas fa-toggle-off' }}" id="tggl-clss" style="font-size: 25px;"></i>
															</a>
														</div>
													</div>
													{!! Form::hidden('id',@$setting->id ,['id'=>'id']) !!}
													{!! Form::hidden('active_tab',$ACTIVETAB[2],['id'=>'active_tab']) !!}
													<div class="m-portlet__foot m-portlet__foot--fit">
														<div class="m-form__actions m-form__actions">
															<br>
															<div class="row">
																<div class="col-lg-9 ml-lg-auto">
																	{!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
																	!!}
																	<a href="{{ route('admin_dashboard') }}"
																		class="btn btn-secondary">{{__('formname.cancel')}}</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											{!! Form::close() !!}
											</div>
										</div>
										<div class="tab-pane {{($activeTab==$ACTIVETAB[5])?'active':''}}" id="rating_mail_tab" role="tabpanel">
											
											<div class="m-form__section m-form__section--first">
												
												@if(isset($setting) || !empty($setting))
												{{ Form::model($setting, ['route' => ['general_setting_store',$setting->id], 'method' => 'PUT','id'=>'rating_mail_form','class'=>'m-form m-form--fit m-form--label-align-right']) }}
												@else
												{{ Form::open(['route' => 'general_setting_store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'rating_mail_form']) }}
												@endif
												<div class="m-portlet__body">
													<div class="m-form__content">
														<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
															id="web_social_media_link_msg">
															<div class="m-alert__icon">
																<i class="la la-warning"></i>
															</div>
															<div class="m-alert__text">
																{{__('formname.web_setting.error_msg')}}.
															</div>
															<div class="m-alert__close">
																<button type="button" class="close" data-close="alert" aria-label="Close">
																</button>
															</div>
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.rating_mail_label').'', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-3 col-md-9 col-sm-12">
															{!!
																Form::text('rating_mail',($setting)?@$setting->rating_mail:'',['class'=>'form-control
															m-input pdng-right','maxlength'=>3,'id' => 'rating_mail','autocomplete' => 'off']) !!}
															{!! Form::label(__('formname.web_setting.days').'', null,['class'=>'text-left abslt-icn']) !!}
															@if ($errors->has('rating_mail')) <p style="color:red;">
																{{ $errors->first('rating_mail') }}</p> @endif
														</div>
													</div>
													{!! Form::hidden('id',@$setting->id ,['id'=>'id']) !!}
													{!! Form::hidden('active_tab',$ACTIVETAB[5],['id'=>'active_tab']) !!}
													<div class="m-portlet__foot m-portlet__foot--fit">
														<div class="m-form__actions m-form__actions">
															<br>
															<div class="row">
																<div class="col-lg-9 ml-lg-auto">
																	{!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
																	!!}
																	<a href="{{ route('admin_dashboard') }}"
																		class="btn btn-secondary">{{__('formname.cancel')}}</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											{!! Form::close() !!}
											</div>
										</div>
										<div class="tab-pane {{($activeTab==$ACTIVETAB[6])?'active':''}}" id="notification_tab" role="tabpanel">
											<div class="m-form__section m-form__section--first">
												@if(isset($setting) || !empty($setting))
												{{ Form::model($setting, ['route' => ['general_setting_store',$setting->id], 'method' => 'PUT','id'=>'notification_form','class'=>'m-form m-form--fit m-form--label-align-right','autocomplete' => 'off']) }}
												@else
												{{ Form::open(['route' => 'general_setting_store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'notification_form','autocomplete' => 'off']) }}
												@endif
												<div class="m-portlet__body">
													<div class="m-form__content">
														<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
															id="web_social_media_link_msg">
															<div class="m-alert__icon">
																<i class="la la-warning"></i>
															</div>
															<div class="m-alert__text">
																{{__('formname.web_setting.error_msg')}}.
															</div>
															<div class="m-alert__close">
																<button type="button" class="close" data-close="alert" aria-label="Close">
																</button>
															</div>
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.notification_content').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('notification_content',($setting)?@$setting->notification_content:'',['class'=>'form-control
															m-input','maxlength'=> 30]) !!}
															@if ($errors->has('notification_content')) <p style="color:red;">
																{{ $errors->first('notification_content') }}</p> @endif
														</div>
													</div>
													{!! Form::hidden('id',@$setting->id ,['id'=>'id']) !!}
													{!! Form::hidden('active_tab',$ACTIVETAB[6],['id'=>'active_tab']) !!}
													<div class="m-portlet__foot m-portlet__foot--fit">
														<div class="m-form__actions m-form__actions">
															<br>
															<div class="row">
																<div class="col-lg-9 ml-lg-auto">
																	{!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
																	!!}
																	<a href="{{ route('admin_dashboard') }}"
																		class="btn btn-secondary">{{__('formname.cancel')}}</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											{!! Form::close() !!}
											</div>
										</div>
										<div class="tab-pane {{($activeTab==$ACTIVETAB[7])?'active':''}}" id="stripe_payment_tab" role="tabpanel">
											<div class="m-form__section m-form__section--first">
												@if(isset($paymentSetting) || !empty($paymentSetting))
												{{ Form::model($paymentSetting, ['route' => ['payment_setting_store',$paymentSetting->id], 'method' => 'PUT','id'=>'payment_setting_form','class'=>'m-form m-form--fit m-form--label-align-right','autocomplete' => 'off']) }}
												@else
												{{ Form::open(['route' => 'payment_setting_store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'payment_setting_form','autocomplete' => 'off']) }}
												@endif
												<div class="m-portlet__body">
													<div class="m-form__content">
														<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
															id="web_social_media_link_msg">
															<div class="m-alert__icon">
																<i class="la la-warning"></i>
															</div>
															<div class="m-alert__text">
																{{__('formname.web_setting.error_msg')}}.
															</div>
															<div class="m-alert__close">
																<button type="button" class="close" data-close="alert" aria-label="Close">
																</button>
															</div>
														</div>
													</div>
													<div class="form-group m-form__group row ">
														{!! Form::label(__('').'', null,['class'=>'col-lg-3']) !!}
														<div class="col-lg-9">
															<div class="grn_note_info">
																{!! Form::label(__('formname.note').':', null,['class'=>'bold_txt']) !!}
																<span class="">{{ __('formname.web_setting.note_message') }}</span>
															</div>
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.stripe_key').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('stripe_key',@$paymentSetting->stripe_key,['class'=>'form-control
															m-input','maxlength'=> 50]) !!}
															@if ($errors->has('stripe_key')) <p style="color:red;">
																{{ $errors->first('stripe_key') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.stripe_secret').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('stripe_secret',@$paymentSetting->stripe_secret,['class'=>'form-control
															m-input','maxlength'=> 50]) !!}
															@if ($errors->has('stripe_secret')) <p style="color:red;">
																{{ $errors->first('stripe_secret') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.stripe_currency').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('stripe_currency',@$paymentSetting->stripe_currency,['class'=>'form-control
															m-input','maxlength'=> 50]) !!}
															@if ($errors->has('stripe_currency')) <p style="color:red;">
																{{ $errors->first('stripe_currency') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.stripe_mode').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('stripe_mode',@$paymentSetting->stripe_mode,['class'=>'form-control
															m-input','maxlength'=> 50]) !!}
															@if ($errors->has('stripe_mode')) <p style="color:red;">
																{{ $errors->first('stripe_mode') }}</p> @endif
														</div>
													</div>
													{!! Form::hidden('id',@$paymentSetting->id ,['id'=>'id']) !!}
													{!! Form::hidden('payment_type',$paymentSetting->payment_type??'1' ,['id'=>'payment_type']) !!}
													{!! Form::hidden('active_tab',$ACTIVETAB[7],['id'=>'active_tab']) !!}
													<div class="m-portlet__foot m-portlet__foot--fit">
														<div class="m-form__actions m-form__actions">
															<br>
															<div class="row">
																<div class="col-lg-9 ml-lg-auto">
																	{!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
																	!!}
																	<a href="{{ route('admin_dashboard') }}"
																		class="btn btn-secondary">{{__('formname.cancel')}}</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											{!! Form::close() !!}
											</div>
										</div>
										<div class="tab-pane {{($activeTab==$ACTIVETAB[8])?'active':''}}" id="paypal_payment_tab" role="tabpanel">
											<div class="m-form__section m-form__section--first">
												
												@if(isset($paymentSetting) || !empty($paymentSetting))
												{{ Form::model($paymentSetting, ['route' => ['payment_setting_store',$paymentSetting->id], 'method' => 'PUT','id'=>'paypal_setting_form','class'=>'m-form m-form--fit m-form--label-align-right','autocomplete' => 'off']) }}
												@else
												{{ Form::open(['route' => 'payment_setting_store','method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'paypal_setting_form','autocomplete' => 'off']) }}
												@endif
												<div class="m-portlet__body">
													<div class="m-form__content">
														<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
															id="web_social_media_link_msg">
															<div class="m-alert__icon">
																<i class="la la-warning"></i>
															</div>
															<div class="m-alert__text">
																{{__('formname.web_setting.error_msg')}}.
															</div>
															<div class="m-alert__close">
																<button type="button" class="close" data-close="alert" aria-label="Close">
																</button>
															</div>
														</div>
													</div>
													<div class="form-group m-form__group row ">
														{!! Form::label(__('').'', null,['class'=>'col-lg-3']) !!}
														<div class="col-lg-9">
															<div class="grn_note_info">
																{!! Form::label(__('formname.note').':', null,['class'=>'bold_txt']) !!}
																<span class="">{{ __('formname.web_setting.note_message') }}</span>
															</div>
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.paypal_client_id').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('paypal_client_id',@$paymentSetting->paypal_client_id,['class'=>'form-control
															m-input','maxlength'=> 100]) !!}
															@if ($errors->has('paypal_client_id')) <p style="color:red;">
																{{ $errors->first('paypal_client_id') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.paypal_sandbox_api_username').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('paypal_sandbox_api_username',@$paymentSetting->paypal_sandbox_api_username,['class'=>'form-control
															m-input','maxlength'=> 50]) !!}
															@if ($errors->has('paypal_sandbox_api_username')) <p style="color:red;">
																{{ $errors->first('paypal_sandbox_api_username') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.paypal_sandbox_api_password').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('paypal_sandbox_api_password',@$paymentSetting->paypal_sandbox_api_password,['class'=>'form-control
															m-input','maxlength'=> 50]) !!}
															@if ($errors->has('paypal_sandbox_api_password')) <p style="color:red;">
																{{ $errors->first('paypal_sandbox_api_password') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.paypal_sandbox_api_secret').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('paypal_sandbox_api_secret',@$paymentSetting->paypal_sandbox_api_secret,['class'=>'form-control
															m-input','maxlength'=> 150]) !!}
															@if ($errors->has('paypal_sandbox_api_secret')) <p style="color:red;">
																{{ $errors->first('paypal_sandbox_api_secret') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.paypal_currency').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('paypal_currency',@$paymentSetting->paypal_currency,['class'=>'form-control
															m-input','maxlength'=> 30]) !!}
															@if ($errors->has('paypal_currency')) <p style="color:red;">
																{{ $errors->first('paypal_currency') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.paypal_sandbox_api_certificate').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('paypal_sandbox_api_certificate',@$paymentSetting->paypal_sandbox_api_certificate,['class'=>'form-control
															m-input','maxlength'=> 50]) !!}
															@if ($errors->has('paypal_sandbox_api_certificate')) <p style="color:red;">
																{{ $errors->first('paypal_sandbox_api_certificate') }}</p> @endif
														</div>
													</div>
													<div class="form-group m-form__group row">
														{!! Form::label(__('formname.web_setting.paypal_mode').'*', null,['class'=>'col-form-label
														col-lg-3
														col-sm-12']) !!}
														<div class="col-lg-6 col-md-9 col-sm-12">
															{!!
																Form::text('paypal_mode',@$paymentSetting->paypal_mode,['class'=>'form-control
															m-input','maxlength'=> 30]) !!}
															@if ($errors->has('paypal_mode')) <p style="color:red;">
																{{ $errors->first('paypal_mode') }}</p> @endif
														</div>
													</div>
													{!! Form::hidden('id',@$paymentSetting->id ,['id'=>'id']) !!}
													{!! Form::hidden('payment_type',$paymentSetting->payment_type??'1' ,['id'=>'payment_type']) !!}
													{!! Form::hidden('active_tab',$ACTIVETAB[8],['id'=>'active_tab']) !!}
													<div class="m-portlet__foot m-portlet__foot--fit">
														<div class="m-form__actions m-form__actions">
															<br>
															<div class="row">
																<div class="col-lg-9 ml-lg-auto">
																	{!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
																	!!}
																	<a href="{{ route('admin_dashboard') }}"
																		class="btn btn-secondary">{{__('formname.cancel')}}</a>
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
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('inc_script')
<script>
var rule = $.extend({}, {!!json_encode(config('constant'), JSON_FORCE_OBJECT) !!});
	$(document).find('.cd-stts').on('click',function(){
		if($(this).attr('data-status') == 1) {
			$("#tggl-clss").removeClass('fas fa-toggle-on');
			$("#tggl-clss").addClass('fas fa-toggle-off');
			$(this).attr('data-status',0);
			$(document).find('#hidden_code_status').val(0);
		} else {
			$("#tggl-clss").removeClass('fas fa-toggle-off');
			$("#tggl-clss").addClass('fas fa-toggle-on');
			$(this).attr('data-status',1);
			$(document).find('#hidden_code_status').val(1);
		}
	});
	// ALLOW CVV TO ONLY NUMBERS
	$(document).find('#rating_mail').keypress(function (event) {
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});
</script>
<script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
<script src="{{ asset('backend/js/websetting/create.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/payment-setting/create.js') }}" type="text/javascript"></script>
@stop