@php
    $cartFlag = 'false';
    $user = null;
    if(Auth::guard('parent')->user() != null){
        $user = Auth::guard('parent')->user();
        $cartFlag = 'true';
    }elseif(Auth::guard('student')->user() != null){
        $msg = __('frontend.child_cart_warning');
        $user = Auth::guard('student')->user();
        $cartFlag = 'false';
    }else{
        $msg = __('frontend.cart_login');
    }
    $routeName = Route::currentRouteName();
@endphp
<script>
	var path ='{{asset("newfrontend/images")}}';
</script>
<script src="{{asset('newfrontend/js/jquery.min.js')}}"></script>
<!-- Add after your form -->
<script src="{{asset('newfrontend/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('newfrontend/js/popper.min.js')}}"></script>
<script src="{{asset('newfrontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('newfrontend/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('newfrontend/js/moment.min.js')}}"></script>
<script src="{{asset('newfrontend/js/jquery.jold.js-load-video.js')}}"></script>
<script src="{{asset('newfrontend/js/jquery.raty.js')}}"></script>
<script src="{{ asset('newfrontend/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{asset('newfrontend/js/main.js')}}"></script>
{{-- <script src="{{asset('newfrontend/js/jquery.validate.min.js')}}"></script> --}}
<script src="{{asset('newfrontend/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('newfrontend/js/additional-methods.min.js')}}"></script>
<script src="{{asset('newfrontend/js/toastr.min.js')}}"></script>
<script src="{{asset('newfrontend/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('newfrontend/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('newfrontend/js/jquery.print.js')}}"></script>
<link href="{{asset('css/featherlight.min.css')}}" type="text/css" rel="stylesheet" />
<script src="{{asset('js/featherlight.min.js')}}" type="text/javascript" charset="utf-8"></script>
{{-- <script src="{{asset('js/watermark.min.js')}}"></script> --}}
<script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
<script>
	var base_url = '{{url('/')}}';
	var loginUrl = "{{ route('user.login.post') }}";
    var homeRoute = "{{route('firstpage')}}";
    var forgotPassUrl = "{{route('user.password.email')}}";
    var profileUrl = "{{route('parent-profile')}}";
    var studentUrl = "{{route('student-mocks')}}";
  	var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
    var cartURL = "{{ route('emock-cart') }}";
    var flag = false;
    cartFlag = "{{@$cartFlag}}";
    var warningMsg = "{{@$msg}}";
    var routeName = "{{@$routeName}}";
    checkUserlogin = "{{route('check-user-login')}}";
    // toastr notification options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    @if ($message = Session::get('message'))
        toastr.success("{{ $message }}");
    @endif
    @if ($message = Session::get('success'))
        toastr.success("{{ $message }}");
    @endif
    @if ($message = Session::get('error'))
        toastr.error("{{ $message }}");
    @endif
    @if ($message = Session::get('warning'))
        toastr.warning("{{ $message }}");
    @endif
    @if ($message = Session::get('info'))
        toastr.info("{{ $message }}");
    @endif
</script>
<script src="{{asset('newfrontend/js/common.js')}}"></script>
<script src="{{asset('newfrontend/js/sweetalert.min.js')}}"></script>
<script src="{{asset('newfrontend/js/login.js')}}"></script>
<script>
</script>
<script src="{{asset('newfrontend/js/mock/detail.js')}}"></script>
