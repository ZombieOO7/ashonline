<link href="{{asset('css/featherlight.min.css')}}" type="text/css" rel="stylesheet" />
<link href="{{asset('css/watermarker.css')}}" type="text/css" rel="stylesheet" />
<script src="{{asset('js/jquery-latest.js')}}"></script>
<script src="{{asset('js/featherlight.min.js')}}" type="text/javascript" charset="utf-8"></script>
<!--begin::Base Scripts -->
<script src="{{ asset('backend/dist/default/assets/vendors/base/vendors.bundle.js') }}" type="text/javascript">
</script>
<script src="{{ asset('backend/dist/default/assets/demo/default/base/scripts.bundle.js') }}"
    type="text/javascript"></script>
<!--end::Base Scripts -->
<!--begin::Page Vendors -->
<!--end::Page Vendors -->
<!--begin::Page Snippets -->
<script src="{{ asset('backend/dist/default/assets/app/js/dashboard.js') }}" type="text/javascript"></script>
<!--end::Page Snippets -->

<script src="{{ asset('backend/dist/default/assets/vendors/custom/datatables/datatables.bundle.js') }}"
    type="text/javascript"></script>
<script src="{{asset('js/jquery.raty.js')}}"></script>
<script src="{{asset('js/watermarker.js')}}"></script>
<script src="{{asset('js/jquery.watermark.min.js')}}"></script>
<script>
    var CONSTANT_VARS = $.extend({}, {!!json_encode(config('constant'), JSON_FORCE_OBJECT) !!});
    var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
//Ajax Loader
$(document).ready(function() {
});
</script>
<script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('backend/js/common.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/tablecommon.js') }}" type="text/javascript"></script>
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}" />
<script src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript" src="{{ str_replace('public/', '', URL('resources/lang/js/en/message.js')) }}"></script>
<script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
@yield('inc_script')
@component('vendor.sweetalert.view')
@endcomponent
