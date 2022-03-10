@extends('newfrontend.layouts.default')
@section('title','My Profile')
@section('content')
<div class="container mrgn_bt_40">
    <div class="row">
      @include('newfrontend.user.leftbar')
      <div class="col-md-9">
        <div class="form_box">
        <h3>{{@$title}}</h3>
          <div class="pdng_box">
             {{ Form::open(['route' => ['update-address'], 'method' => 'POST','id'=>'address_update','class'=>'def_form max80','autocomplete' => "off",'enctype'=> 'multipart/form-data']) }}
             <input type="hidden" name="id" value="{{ @$address->id }}"/>
              <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="address" class="form-control ignore" placeholder="{{ __('frontend.address_1').'*' }}" value="{{ isset($address->address) ? $address->address : old('address') }}" maxlength="80">
                        @if ($errors->has('address'))
                            <p class="error">
                                {{ $errors->first('address') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="address2" class="form-control ignore" value="{{ isset($address->address2) ? $address->address2 : old('address2') }}" placeholder="{{ __('frontend.address_2') }}" maxlength="80">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="city" class="form-control ignore" placeholder="{{ __('frontend.city').'*' }}"
                               maxlength="35" value="{{ isset($address->city) ? $address->city : old('city') }}">
                        @if ($errors->has('city'))
                            <p class="error">
                                {{ $errors->first('city') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="postal_code" class="form-control ignore"
                               placeholder="{{ __('frontend.postcode').'*' }}" value="{{ isset($address->postal_code) ? $address->postal_code : old('postal_code') }}"
                               maxlength="10">
                        @if ($errors->has('postal_code'))
                            <p class="error">
                                {{ $errors->first('postal_code') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="state" class="form-control ignore"
                               placeholder="{{ __('frontend.state_country').'*' }}" value="{{ isset($address->state) ? $address->state : old('state') }}"
                               maxlength="35">
                        @if ($errors->has('state'))
                            <p class="error">
                                {{ $errors->first('state') }}
                            </p>
                        @endif
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="country" class="form-control ignore" placeholder="{{ __('frontend.uk').'*' }}"
                               value="{{ isset($address->country) ? $address->country : old('country') }}" maxlength="35">
                        @if ($errors->has('country'))
                            <p class="error">
                                {{ $errors->first('country') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="col-md-12 ">
                    <div class="form-group">
                        <div class="checkbox agreeckbx">
                            <input type="checkbox" class="dt-checkboxes" id="defaultAgreeCheck" name="save_as_default" value="1" {{(@$address->default==0)?'':'checked'}}>
                            <label for="defaultAgreeCheck">Save & Set As Default</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <button type="submit" class="btn btn_join">Save Updates</button><br>
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
<script type="text/javascript">
  var oldPasswordURL = "{{ route('check-old-password') }}";
</script>
<script src="{{asset('newfrontend/js/parent/address.js')}}"></script>
@stop
