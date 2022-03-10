@extends('newfrontend.layouts.default')
@section('title','Parent’s Sign Up')
@section('content')
<section class="signup_sc">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-12 sm_in_ttl text-center">
                        <h3 class="df_h3">Parent’s Sign Up</h3>
                        <p class="df_pp">Please create your account with us</p>
                    </div>
                    <div class="col-md-12">
                    @if(isset($parent) || !empty($parent))
                        {{ Form::model($parent, ['route' => ['parent.profile.update', @$parent->uuid], 'method' => 'PUT','id'=>'parent_register','class'=>'def_form']) }}
                    @else
                        {{ Form::open(['route' => 'parent.register.post','method'=>'post','class'=>'def_form','id'=>'parent_register']) }}
                    @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="full_name" class="col-form-label">
                                        Full Name
                                        <i class="fas fa-info-circle"></i>
                                        {{--                                        {{__("formname.required_sign")}}--}}
                                    </label>
                                    <input type="text" class="form-control" placeholder="Full Name" value="{{old('full_name')}}" name='full_name' maxlength="{{config('constant.rules.text_length')}}">
                                    @if ($errors->has('full_name'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('full_name') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email Address
                                        <i class="fas fa-info-circle"></i></label>
                                    <input type="text" class="form-control" placeholder="Email Address" value="{{old('email')}}" name='email' maxlength="{{config('constant.rule.text_length')}}">
                                    @if ($errors->has('email'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('email') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mobile" class="col-form-label">Phone Number
                                        <i class="fas fa-info-circle"></i></label>
                                    <input type="text" class="form-control" placeholder="Phone Number" value="{{old('mobile')}}" name='mobile'>
                                    @if ($errors->has('mobile'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('mobile') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="col-form-label">
                                        Password   <i class="fas fa-info-circle"></i>
                                    </label>
                                    <input id='password' type="password" class="form-control" placeholder="Password"  name="password"  maxlength="{{config('constant.rules.password_max_length')}}" minlength="{{config('constant.rules.password_min_length')}}">
                                    @if ($errors->has('password'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('password') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="col-form-label">
                                        Conﬁrm Password   <i class="fas fa-info-circle"></i>
                                    </label>
                                    <input type="password" class="form-control" placeholder="Conﬁrm Password" name="password_confirmation"  maxlength="{{config('constant.rules.password_max_length')}}" minlength="{{config('constant.rules.password_min_length')}}">
                                    @if ($errors->has('password_confirmation'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('password_confirmation') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="address" class="col-form-label">Country
                                        <i class="fas fa-info-circle"></i></label>
                                    {!! Form::select('country_id', @$countryList, null, ['title'=>"Country",'class'
                                    =>'selectpicker def_select','id'=>'countryId' ]) !!}
                                    {{-- <input type="text" class="form-control" placeholder="Country*" name="country" value="{{old('country')}}" maxlength="{{config('constant.rules.text_length')}}"> --}}
                                    <span class="countryError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="full_name" class="col-form-label">Post Code(Only for the UK)</label>
                                <div class="form-group">
                                <input type="text" id='postcode' class="form-control" placeholder="Post Code(Only for the UK)" value="{{old('zip_code')}}" name='zip_code' readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="col-form-label">Address 1
                                        <i class="fas fa-info-circle"></i></label>
                                    <input type="text" id='address' class="form-control" placeholder="Address 1" name="address" value="{{old('address')}}" maxlength="{{config('constant.rules.text_length')}}">
                                    <span class="addressError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="country" class="col-form-label">Address 2</label>
                                <input type="text" id='address2' class="form-control" placeholder="Address 2" value="{{old('address_2')}}" name='address2'>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country" class="col-form-label">City
                                        <i class="fas fa-info-circle"></i></label>
                                    <input type="text" class="form-control" id='city' placeholder="City" value="{{old('city')}}" name='city'>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country" class="col-form-label">County/Council
                                        <i class="fas fa-info-circle"></i></label>
                                {!! Form::select('county_id', countyList(), null, ['title'=>"County",'class'
                                =>'selectpicker def_select','id'=>'county','disabled'=>true ]) !!}
                                <input type="hidden" class="form-control" placeholder="County/Council" value="{{old('county')}}" id='countyVal' name='council'>
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
                                    {!! Form::text('card_number', null, ['class' =>'form-control', 'placeholder' => __('frontend.card_number'), 'maxlength' => config('constant.rules.card_no_max_length'), 'minlength' => config('constant.rules.card_no_min_length')]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{__('frontend.name_on_card')}}" class="col-form-label">{{__('frontend.name_on_card')}}
                                        <i class="fas fa-info-circle"></i>
                                    </label>
                                    {!! Form::text('name_on_card', null, ['class' =>'form-control','placeholder' => __('frontend.name_on_card'),'maxlength' => config('constant.rules.text_length')]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiry_on" class="col-form-label">{{__('frontend.expiry_on')}}
                                        <i class="fas fa-info-circle"></i>
                                    </label>
                                    {!! Form::text('expiry_date', null, ['class' =>'form-control','id'=>'expiry_date','onkeypress'=>'return false;']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cvv" class="col-form-label">{{__('frontend.cvv')}}
                                        <i class="fas fa-info-circle"></i>
                                    </label>
                                    {!! Form::password('cvv', ['class' =>'form-control', 'placeholder' => __('frontend.cvv'),'maxlength'=>config('constant.rules.cvv_length'), 'minlength'=>config('constant.rules.cvv_length')]) !!}
                                </div>
                            </div>
                            <div class="col-md-12 text-center sgnup_action btm_action">
                                <div class="form-group">
                                <button type="submit" class="btn btn_join">Sign Up</button>
                                <p class="mrgn_tp_30">Already having an account? <a href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal">Login</a></p>
                                </div>
                            </div>

                        </div>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
  @section('pageJs')
  <script>
      var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
  </script>


<!-- Include plugin file -->
<script>
    $addressKey = "{{env('ADDRESS_API_KEY')}}";
</script>
<script src="{{asset('newfrontend/js/jquery.getAddress-4.0.0.min.js')}}"></script>
<script src="{{asset('newfrontend/js/jquery.getAddress-3.0.4.min.js')}}"></script>
<script src="{{asset('newfrontend/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('newfrontend/js/getAddress.js')}}"></script>
<script src="{{asset('newfrontend/js/register.js')}}"></script>
@endsection
@stop
