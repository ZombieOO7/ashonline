<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}
<script src="{{asset('frontend/js/popper.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('frontend/js/moment.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.raty.js')}}"></script>
<script src="{{asset('frontend/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('frontend/js/main.js')}}"></script>
<script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('frontend/plugin/notific8/jquery.notific8.min.js') }}"></script>
<script src="{{asset('frontend/js/custom/notification.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
@php
    $routeName = Route::currentRouteName();
@endphp
<script>
    var rateImagePath = '{{asset("newfrontend/images")}}';
    sessionStorage.setItem('beenhere', '0');    
    setTimeout(function() {
        $(document).find('.alert-success').fadeOut('slow');
    }, 3000); // <-- time in milliseconds

    setTimeout(function() {
        $(document).find('.alert-warning').fadeOut('slow');
    }, 3000); // <-- time in milliseconds

    setTimeout(function() {
        $(document).find('.alert-info').fadeOut('slow');
    }, 3000); // <-- time in milliseconds

    setTimeout(function() {
        $(document).find('.alert-danger').fadeOut('slow');
    }, 3000); // <-- time in milliseconds
    
    $(document).ready(function ($) {
      
      $(document).find('.page-loader').hide();
    });
    $(document)
    .ajaxStart(function () {
        $('.page-loader').show();   //ajax request went so show the loading image
    })
    .ajaxStop(function () {
        $('.page-loader').hide();   //got response so hide the loading image
    });
    var base_url = '{{url('/')}}';
    $(function() {
      $(document).find('.fixedStar').raty({
        readOnly:  true,
        path    :  base_url+'/public/frontend/images',
        starOff : 'star-off.svg',
        starOn  : 'star-on.svg',
        start: $(document).find(this).attr('data-score')
      });
    });


    
      // Newsletter subscribtion
      $('#subscriber_email').on('keypress', function(e) {
        if(e.which == 13) {
          $('.newsletter-subscribe').trigger('click');
          return false;
        }
      });
      $(document).find('.newsletter-subscribe').on('click',function() {
        // return false;
        $.ajax({
            url: $(this).attr('data-url'),
            method: "post",
            // global: false,
            data: { email : $(document).find('#subscriber_email').val(),_token: "{{ csrf_token() }}" },
            success: function (result) {
                if (result.msg) {
                  swal({
                      // title: '',
                      text: result.msg,
                      icon: result.icon,
                  }).then(() => {
                      window.location.reload();
                  });
                  // $(document).find('.subscriber_msg').html('<span style="color:green;">'+result.success+'</span>');
                } else {
                  swal({
                      // title: 'Error',
                      text: result.error,
                      icon: 'error',
                  }).then(() => {
                      window.location.reload();
                  });
                }
            }
        });
    });
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

    var loginUrl = "{{ route('user.login.post') }}";
    var forgotPassUrl = "{{route('user.password.email')}}";
    var profileUrl = "{{route('parent-profile')}}";
    var studentUrl = "{{route('student-profile')}}";
    var homeRoute = "{{route('firstpage')}}";
    var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
    var routeName = "{{@$routeName}}";
    if(routeName == 'mock-exam' || routeName == 'mock-exam-review'){
        allowClick = false;
    }
    $(document).find('.epaper').on('click', function(){
        if(allowClick == true){
            var newUrl = $(this).attr('data-href');
            window.location.replace(newUrl);
        }
    })
    checkUserlogin = "{{route('check-user-login')}}";
</script>
<script src="{{asset('newfrontend/js/login.js')}}"></script>