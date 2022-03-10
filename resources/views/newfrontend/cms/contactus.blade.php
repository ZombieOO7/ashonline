@extends('newfrontend.layouts.default')
@section('title',__('frontend.contactus'))
@section('content')
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',__('frontend.contactus'),route('home')))
<!--inner content-->
<section class="contact_sc">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-12 in_ttl">
                        <h3 class="df_h3">{{ @$cms->title }}</h3>
                        <p class="df_pp">{!! @$cms->content !!}</p>
                    </div>
                    <div class="col-md-12">
                        {{ Form::open(array('route' => 'contact_us.store','method'=>'POST','class'=>'def_form','id'=>'contact_form','autocomplete' => 'off')) }}
                            {{-- @include('frontend.includes.flashmessages') --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <input type="text" class="form-control" placeholder="Your Name"> --}}
                                        {!!Form::text('full_name',null,['class'=>'form-control','id'=>'full_name','placeholder'=>__('frontend.contact_us.full_name'),'maxlength'=>50]) !!}
                                        @if ($errors->has('full_name'))
                                        <p class="error">
                                            {{ $errors->first('full_name') }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <input type="text" class="form-control" placeholder="Mobile Number"> --}}
                                        {!!Form::text('phone',null,['class'=>'form-control','id'=>'phone','placeholder'=>__('frontend.contact_us.phone'),'maxlength'=>'16']) !!}
                                        @if ($errors->has('phone'))
                                        <p class="error">
                                            {{ $errors->first('phone') }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <input type="text" class="form-control" placeholder="Email Address"> --}}
                                        {!!Form::email('email',null,['class'=>'form-control','placeholder'=>__('frontend.contact_us.email'),'maxlength'=>config('constant.input_email_max_length')]) !!}
                                        @if ($errors->has('email'))
                                        <p class="error">
                                            {{ $errors->first('email') }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <select class="selectpicker def_select" title="Select Subject">
                                            <option>Subject1</option>
                                            <option>Subject2</option>
                                            <option>Subject3</option>
                                        </select> --}}
                                        {!! Form::select('subject', $subjectList??[], null,['class' => 'selectpicker def_select','id'=>'subject' ]) !!}
                                        <span class="subjectError"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{-- <input type="text" class="form-control" placeholder="Your Message"> --}}
                                        {!!Form::textarea('message',null,['class'=>'form-control','placeholder'=>__('frontend.contact_us.your_msg_here'),'maxlength'=>config('constant.input_desc_max_length')]) !!}

                                    </div>
                                </div>
                                @php
                                $captcha =  \Str::random(6);
                                session()->put('captcha', $captcha);
                                @endphp
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <div class="capch_dv">
                                                <label>{{@$captcha}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                                {!!Form::text('captcha',"",['class'=>'form-control','id'=>'captcha','placeholder'=>__('frontend.contact_us.enter_captcha'),'maxlength'=>6]) !!}
                                                <span class="captchaError"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        {{-- <button type="submit" class="btn submit_btn">Submit</button> --}}
                                        {!! Form::submit(__('formname.submit'), ['class' => 'btn btncheckout sbmtwtpdng'] )!!}
                                    </div>
                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="wtsp_bx">
                                        <div class="input-group">
                                            <h6>Reach out to us via Whatsapp</h6>
                                            <div class="input-group-prepend">
                                                <a href="#"><span>WHATSAPP</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}


                            </div>
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--close inner content-->
@endsection
@section('pageJs')

<script>
    var $captcha='{{@$captcha}}';
    var captchaurl = '{{route("refreshCapatcha")}}';
    var CONSTANT_VARS = $.extend({}, {!!json_encode(config('constant'), JSON_FORCE_OBJECT) !!});
</script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contactus/contact-form.js') }}" ></script>
@endsection