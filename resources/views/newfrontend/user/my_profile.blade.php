@extends('newfrontend.layouts.default')
@section('title',__('frontend.my_profile'))
@section('content')
@php
    $date = date('d-m-Y');
    $routeArray = [
    [
		'title' => __('frontend.my_profile'),
		'route' => route('parent-profile'),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <div class="container mrgn_bt_40">
        <div class="row">
            @include('newfrontend.user.leftbar')
            <div class="col-md-9">
                <div class="form_box">
                    <h3>{{__('frontend.account_info')}}</h3>
                       <span class="last_login"> <p>{{__('frontend.last_login')}} : <span>{{@$user->last_login}}</span></p></span>
                        @if(@$user->subscription_status != '1' && @$user->subscription_end_date != null && strtotime(@$user->proper_subscription_end_date) > strtotime($date))
                           <span class="last_login"> <p>{{__('frontend.subscription_deactive_lbl')}} : <span>{{@$user->proper_subscription_end_date}}</span></p></span>
                        @elseif(@$user->subscription_end_date != null && strtotime(@$user->proper_subscription_end_date) > strtotime($date))
                           <span class="last_login"> <p>{{__('frontend.subscription_end_lbl')}} : <span>{{@$user->proper_subscription_end_date}}</span></p></span>
                        @elseif(@$user->subscription_status == null && $user->trial_end_date > $date)
                            <span class="last_login"> <p>{{__('frontend.trial_period_lbl')}} : <span>{{@$user->trial_end_date}}</span></p></span>
                        @else
                            <span class="last_login"> <p> Your subscription expired or deactivated</p></span>
                        @endif
                    <div class="pdng_box">
                        {{ Form::open(['route' => ['profile-update'], 'method' => 'POST','id'=>'profile_update','class'=>'def_form max80','autocomplete' => "off",'enctype'=> 'multipart/form-data','autocomplete'=>'off']) }}
                        <input type="hidden" name="id" value="{{ @$user->id }}"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="pro-img ch-pic">
                                        <img class="profile-pic" src="{{ @$user->image_thumb }}" id="blah"/>
                                        <input class="file-upload-nw" name="image" type="file"
                                               accept="image/{{__("formname.required_sign")}}"/>
                                        <a href="javascript:void(0);" class="change-pic">{{__('frontend.update_profile_pic')}}</a>
                                    </div>
                                    @if ($errors->has('image'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('image') }}
                                        </p>
                                    @endif
                                </div>

                            </div>
                            <i class="far fa-info-square"></i>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="full_name" class="col-form-label">
                                        {{__('frontend.full_name')}}
                                        <i class="fas fa-info-circle"></i>
                                    </label>
                                    <input type="text" name="full_name" class="form-control"
                                           placeholder="{{__('frontend.full_name')}}{{__("formname.required_sign")}}"
                                           value="{{ @$user->full_name }}">
                                    @if ($errors->has('full_name'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('full_name') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email" class="col-form-label">{{__('frontend.email_address')}}
                                        <i class="fas fa-info-circle"></i></label>
                                    <input type="text" name="email" class="form-control"
                                           placeholder="{{__('frontend.email_address')}}"
                                           value="{{ @$user->email }}">
                                    @if ($errors->has('email'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('email') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mobile" class="col-form-label">{{__('frontend.phone_number')}}
                                        <i class="fas fa-info-circle"></i></label>
                                    <input type="text" name="mobile" class="form-control" placeholder="{{__('frontend.phone_number')}}"
                                           value="{{ @$user->mobile }}">
                                    @if ($errors->has('mobile'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('mobile') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country" class="col-form-label">{{__('frontend.country')}}
                                        <i class="fas fa-info-circle"></i></label>
                                        {!! Form::select('country_id', @$countryList, @$user->country_id, ['title'=>"{{__('frontend.country')}}",'class'
                                        =>'selectpicker def_select','id'=>'countryId' ]) !!}
                                    @if ($errors->has('country_id'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('country_id') }}
                                        </p>
                                    @endif
                                    <span class="countryError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="county" class="col-form-label">{{__('frontend.post_code')}}</label>
                                    <input type="text" id='postcode' class="form-control" placeholder="{{__('frontend.post_code')}}"
                                           value="{{@$user->zip_code}}" name='zip_code' @if(@$user->getCountry->name != 'United Kingdom') readonly @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="col-form-label">{{__('frontend.address_1')}}
                                        <i class="fas fa-info-circle"></i></label>
                                    <input type="text" class="form-control" placeholder="{{__('frontend.address_1')}}*" name="address"
                                           value="{{ @$user->address }}" id='address'
                                           maxlength="{{config('constant.rules.text_length')}}">
                                    <span class="addressError">
                                        @if ($errors->has('address'))
                                           <p class="errors" style="color:red;">
                                               {{ $errors->first('address') }}
                                           </p>
                                       @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="full_name" class="col-form-label">{{__('frontend.address_2')}}</label>
                                    <input type="text" class="form-control" placeholder="{{__('frontend.address_2')}}"
                                        id='address2' value="{{ @$user->address2 }}" name='address2'>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city"
                                           class="col-form-label">{{__('frontend.city')}}
                                        <i class="fas fa-info-circle"></i></label>
                                    <input type="text" name="city" class="form-control"
                                           placeholder="{{__('frontend.city')}}" id='city' 
                                           value="{{ @$user->city }}">
                                    @if ($errors->has('city'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('city') }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="county" class="col-form-label">{{__('frontend.county')}}
                                        <i class="fas fa-info-circle"></i></label>
                                    {!! Form::select('county_id', countyList(), (@$user->country->name == 'United Kingdom')?$user->council:'Other', ['title'=>"County",'class'
                                    =>'selectpicker def_select','id'=>'county','disabled'=>(@$user->country->name == 'United Kingdom')? false:true ]) !!}
                                    <input type="hidden" class="form-control" placeholder="County/Council" value="{{(@$user->country->name == 'United Kingdom')?$user->council:'Other'}}" id='countyVal' name='council'>
                                    <span class="countyError"></span>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3 mb-3">
                                <h3>Please enter your card detail</h3>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{__('frontend.card_number')}}" class="col-form-label">{{__('frontend.card_number')}}
                                        <i class="fas fa-info-circle"></i>
                                    </label>
                                    {!! Form::text('card_number', @$user->card_number , ['class' =>'form-control', 'placeholder' => __('frontend.card_number'), 'maxlength' => config('constant.rules.card_no_max_length'), 'minlength' => config('constant.rules.card_no_min_length')]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{__('frontend.name_on_card')}}" class="col-form-label">{{__('frontend.name_on_card')}}
                                        <i class="fas fa-info-circle"></i>
                                    </label>
                                    {!! Form::text('name_on_card', @$user->name_on_card, ['class' =>'form-control','placeholder' => __('frontend.name_on_card'),'maxlength' => config('constant.rules.text_length')]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiry_on" class="col-form-label">{{__('frontend.expiry_on')}}
                                        <i class="fas fa-info-circle"></i>
                                    </label>
                                    {!! Form::text('expiry_date', @$user->expiry_date, ['class' =>'form-control','id'=>'expiry_date','onkeypress'=>'return false;']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cvv" class="col-form-label">{{__('frontend.cvv')}}
                                        <i class="fas fa-info-circle"></i>
                                    </label>
                                    {!! Form::text('cvv', @$user->cvv,['class' =>'form-control', 'placeholder' => __('frontend.cvv'),'maxlength'=>config('constant.rules.cvv_length'), 'minlength'=>config('constant.rules.cvv_length')]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{__('frontend.subscription_status')}}" class="col-form-label">{{__('frontend.subscription_status')}}
                                        <i class="fas fa-info-circle"></i></label>
                                        {!! Form::select('subscription_status', @$subscriptionStatusList, @$user->subscription_status, ['title'=>"{{__('frontend.subscription_status')}}",'class'
                                        =>'selectpicker def_select','id'=>'subscriptionStatus' ]) !!}
                                    @if ($errors->has('subscription_status'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('country_id') }}
                                        </p>
                                    @endif
                                    <span class="countryError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6 changepassword_clps">
                                <div class="collapse" id="ChangePassword">
                                    <div class="card card-body">
                                        <div class="form-group">
                                            <input type="password" id='password' class="form-control" name="new_password" placeholder="{{__('frontend.new_password')}}" maxlength="12" autocomplete="new-password">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                   placeholder="{{__('frontend.conf_new_password')}}" maxlength="12" autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <span class="inf_txt">{{__('frontend.profile_note')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 sgnup_action btm_action mrgn_bt_0">
                                <div class="form-group">
                                    <button type="submit" class="btn btn_join">{{__('frontend.save_update')}}</button>
                                    <br>
                                    <a class="btn_clps" data-toggle="collapse" id='changePass' href="javascript:;"
                                       data-target="#ChangePassword" role="button" aria-expanded="false"
                                       aria-controls="ChangePassword">{{__('frontend.change_password')}}</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('pageJs')
    <script>
        $addressKey = "{{env('ADDRESS_API_KEY')}}";
        $('#expiry_date').datetimepicker({
            format: 'MM/YYYY',
            minDate: moment(),
        });
    </script>
    <script src="{{asset('newfrontend/js/getAddress.js')}}"></script>
    <script type="text/javascript">
        var oldPasswordURL = "{{ route('check-old-password') }}";
    </script>
    <script src="{{asset('newfrontend/js/profile.js')}}"></script>
@stop
