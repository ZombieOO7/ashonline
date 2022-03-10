@extends('newfrontend.layouts.default')
@section('title', 'Mock Exam')
@section('pageCss')
    {{-- <meta http-equiv="refresh" content="0; url={{route('student-mocks')}}"> --}}
@endsection
@section('content')
    <div class="container mrgn_bt_40">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="brdr_bbx">
                    <div class="d_bl_bbx purched_details">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <p class="mdl_txt">{{__('formname.section_name')}} : {{@$section->name}}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="mdl_txt">{{__('formname.section_time')}} : {{@$section->time}}</p>
                            </div>
                            <div class="col-md-3">
                                <span class="ul_in_info ex_i_03">
                                    <h6 id="timer" class="text-white">{{ @$section->instruction_read_time}}</h6>
                                    <label class="text-white">Time Left</label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="inf_bx_wpdng">
                        <h4>{{__('formname.section_instruction')}}</h4>
                        <div class="unset-list">
                            {!! @$section->description !!}
                        </div>
                    </div>
                    <div class="inf_bx_wpdng">
                        <img id="blah" src="{{@$section->image_path}}" alt="" max-width="200" height="200" style="{{ isset($section->image) ? 'display:block;display: block;width: 200px;height: 200px;' : 'display:none;' }}"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('pageJs')
<script>
    var examUrl = "{{$routeUrl}}";
    var examTotalTimeSeconds = parseInt('{{@$examTotalTimeSeconds}}');
    var count = examTotalTimeSeconds;
    var counter = setInterval(timer, 1000);
    function timer() {
        count--;
        if (count < 0) return clearInterval(counter);
        document.getElementById('timer').innerHTML = formatTime(count);
    }

    $(document).find('#header').click(false);
    $(document).find('.subscibe_sc').click(false);
    $(document).find('.footer').click(false);
    $(document).on('click','#epapersMenu', function(e){
        e.preventDefault();
    });
    // $(document).ready(function() {
    //     swal("Please do not refresh or go back data may be lost", {
    //         icon: 'info',
    //         closeOnClickOutside: false,
    //     });
    //     window.history.pushState(null, "", window.location.href);
    //     window.onpopstate = function() {
    //         window.history.pushState(null, "", window.location.href);
    //     };
    //     $(window).keydown(function(event){
    //         if(event.keyCode == 116) {
    //             event.preventDefault();
    //             return false;
    //         }
    //     });
    //     // window.onbeforeunload = function() {
    //     //     return "Are you sure you want to leave? it will lost your data";
    //     // }
    // });

    function formatTime(seconds) {
        var h = Math.floor(seconds / 3600),
            m = Math.floor(seconds / 60) % 60,
            s = seconds % 60;
        if (h < 10) h = "0" + h;
        if (m < 10) m = "0" + m;
        if (s < 10) s = "0" + s;
        if (h == '00' && m == '00' && s == '00') {
            window.location.href = examUrl;
        }
        return h + ":" + m + ":" + s;
    }
</script>
@stop