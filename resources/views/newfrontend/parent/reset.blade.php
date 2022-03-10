@extends('newfrontend.layouts.default')
@section('title','Parent’s Reset Password')
@section('content')
<section class="signup_sc">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-12 sm_in_ttl text-center">
                    <h3 class="df_h3">Parent’s Reset Password</h3>
                    {{-- <p class="df_pp">Please create your account with us</p> --}}
                    </div>
                    <div class="col-md-12">
                    {{ Form::open(['route' => 'parent.password.reset','method'=>'post','class'=>'def_form','id'=>'parent_register','autocomplete' => "off"]) }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Email Address*" value="{{old('email')}}" name='email' maxlength="{{config('constant.rule.text_length')}}">
                                    @if ($errors->has('email'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('email') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id='password' type="password" class="form-control" placeholder="Password*"  name="password"  maxlength="{{config('constant.rules.password_max_length')}}" minlength="{{config('constant.rules.password_min_length')}}">
                                    @if ($errors->has('password'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('password') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Conﬁrm Password*" name="password_confirmation"  maxlength="{{config('constant.rules.password_max_length')}}" minlength="{{config('constant.rules.password_min_length')}}">
                                    @if ($errors->has('password_confirmation'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('password_confirmation') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 text-center sgnup_action btm_action">
                                <div class="form-group">
                                <button type="submit" class="btn btn_join">Submit </button>
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
  <script src="{{asset('newfrontend/js/register.js')}}"></script>
  @endsection
@stop