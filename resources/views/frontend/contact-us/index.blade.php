@extends('frontend.layouts.default')
@section('title',@$pageDetail->title)
@section('pageCss')
    <style>
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',@$pageDetail->title,route('home')))
<div class="container">
    <div class="row">
        <div class="col-md-12 mrgn_bt_30 mrgn_tp_40">
            <div class="row">
                <div class="col-lg-12">
                    {{-- <h1 class="small_title">{{__('formname.contact_us')}}</h1> --}}
                    <h1 class="small_title">{{@$pageDetail->title}}</h1>
                </div>
                <div class="col-lg-12">
                    <div class="contact_section">
                        {{ Form::open(array('route' => 'contact_us.store','method'=>'POST','class'=>'def_form','id'=>'contact_form','autocomplete' => 'off')) }}
                        <div class="row">
                            <div class="col-lg-6 pdng_right">
                                {!!@$pageDetail->page_content!!}
                                @include('frontend.includes.flashmessages')                                  
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!!Form::email('email',null,['class'=>'form-control','placeholder'=>__('frontend.contact_us.email'),'maxlength'=>config('constant.input_email_max_length')]) !!}
                                            @if ($errors->has('email'))
                                            <p class="error">
                                                {{ $errors->first('email') }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!!Form::text('phone',null,['class'=>'form-control','id'=>'phone','placeholder'=>__('frontend.contact_us.phone'),'maxlength'=>'16']) !!}
                                            @if ($errors->has('phone'))
                                            <p class="error">
                                                {{ $errors->first('phone') }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!!Form::text('full_name',null,['class'=>'form-control','id'=>'full_name','placeholder'=>__('frontend.contact_us.full_name'),'maxlength'=>50]) !!}
                                            @if ($errors->has('full_name'))
                                            <p class="error">
                                                {{ $errors->first('full_name') }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="df-select scnd-slct">
                                                {!! Form::select('subject', $subjectList, null,['class' => 'selectpicker','id'=>'subject' ]) !!}
                                                <span class="subjectError"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!!Form::textarea('message',null,['class'=>'form-control','placeholder'=>__('frontend.contact_us.your_msg_here'),'maxlength'=>config('constant.input_desc_max_length')]) !!}
                                        </div>
                                    </div>
                                    @php
                                        $captcha = session()->get('captcha');
                                    @endphp
                                    <div class="col-md-12 mrgn_tp_15 mrgn_bt_20">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                        <div class="captcha_scn">
                                                        {!!Form::text('captcha',"",['class'=>'form-control','id'=>'captcha','placeholder'=>__('frontend.contact_us.enter_captcha'),'maxlength'=>6]) !!}
                                                        </div>
                                                    @if ($errors->has('captcha'))
                                                        <p class="error">
                                                            {{ $errors->first('captcha') }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-md-12 cptcha_img">
                                                    <div id="captchaImg">
                                                        <img src="{{url(config('constant.frontend_contact_us.captcha_png'))}}" alt="captcha image">
                                                    </div>
                                                <a href="javascript:void(0);" class="btn btn-primary" onclick="refreshCaptcha()" role="button"><span class="fa fa-user" aria-hidden="true"></span>{{__('formname.refresh')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mrgn_bt_40">
                                        {!! Form::submit(__('formname.submit'), ['class' => 'btn btncheckout sbmtwtpdng'] )!!}
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