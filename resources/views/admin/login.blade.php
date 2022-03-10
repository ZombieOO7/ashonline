<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>{{__('formname.login')}} | {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ @getWebSettings()->meta_description != null ? @getWebSettings()->meta_description  : "Welcome to AshACE Papers" }}">
    <meta name="keywords" content="{{ @getWebSettings()->meta_keywords != null ? @getWebSettings()->meta_keywords : 'AshACE Papers' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
    WebFont.load({
        google: {
            "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });

    function trim(el) {
        el.value = el.value.
        replace(/(^\s*)|(\s*$)/gi, ""). // removes leading and trailing spaces
        replace(/[ ]{2,}/gi, " "). // replaces multiple spaces with one space
        replace(/\n +/, "\n"); // Removes spaces after newlines
        return;
    }
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <link href="{{ asset('backend/dist/default/assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend/dist/default/assets/demo/default/base/style.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend/css/common.css') }}" rel="stylesheet"
    type="text/css" />

    <link rel="shortcut icon" type="image/png" href="{{ URL::asset('frontend/images/favicon.png') }}" />

</head>
<!-- end::Head -->
<!-- begin::Body -->

<body
    class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page lgnpg_prnt">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2"
            id="m_login" style="background-image: url({{ asset('images/bg-3.jpg') }});">
            <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo aa">
                        <a href="{{ URL('/') }}">
                            <img src="{{ asset('frontend/images/wt_logo.png') }}" alt="logo.png" title="logo.png" >

                        </a>
                    </div>
                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title" style="color:#fff !important;">{{ __('Sign In To Admin Panel') }}</h3>
                        </div>
                        @include('admin.includes.flashMessages')
                        
                        <form method="post" action="{{ route('admin.login.post') }}" aria-label="{{ __('Login') }}"
                            class="login-form m-login__form m-form" id="m_form_1">
                            @csrf
                            <div class="form-group m-form__group">
                         <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} m-input"type="email" placeholder={{trans("formname.email")}} name="email" id="email"
                                    maxlength="{{config('constant.rules.email_length')}}" value="<?php if (isset($_COOKIE["username"])) {echo $_COOKIE["username"];}?>" autofocus onchange="return trim(this)" readonly
                                    onfocus="this.removeAttribute('readonly');" />

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group m-form__group">
                                <input
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} m-input m-login__form-input--last"
                                    type="password" maxlength="{{config('constant.rules.password_max_length')}}" minlength="{{config('constant.rules.password_min_length')}}" placeholder={{trans('formname.password')}} name="password" value="<?php if (isset($_COOKIE["password"])) {echo $_COOKIE["password"];}?>"
                                    onchange="return trim(this)" readonly onfocus="this.removeAttribute('readonly');" />

                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            @if ($message = Session::get('error'))
                            <div class='form-control-feedback'>
                                <span style='color:red'>{{ $message }}</span>
                            </div>
                            @endif
                            <div class="row m-login__form-sub">
                                <div class="col m--align-left m-login__form-left">
                                    <label class="m-checkbox">
                                    <input type="checkbox" value="true" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <font style="color:#fff !important;">Remember me</font>
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col m--align-right m-login__form-right">
                                    <a href="{{ url('admin/password/reset') }}" id="m_login_forget_password" class="m-link" style="color:#fff !important;">{{ __('Forgot Password ?') }}</a>
                                    </div>
                            </div>

                            <div class="m-login__form-action">
                                <button type="submit" id="m_login_signin_submit"
                                    class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary sgninn_btn">{{ __('Sign In') }}</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end:: Page -->
    <!--begin::Base Scripts -->
    <script src="{{ asset('backend/dist/default/assets/vendors/base/vendors.bundle.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('backend/dist/default/assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript">
    </script>
    <script>
        var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
        console.log(rule);
    </script>
    <script src="{{ asset('backend/js/login_page_form_validation.js') }}" type="text/javascript"></script>
    <!--end::Base Scripts -->
</body>
<!-- end::Body -->

</html>