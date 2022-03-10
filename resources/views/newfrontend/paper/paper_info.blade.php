@extends('newfrontend.layouts.default')
@section('title', 'Mock Exam')
@section('pageCss')
    {{-- <meta http-equiv="refresh" content="0; url={{route('student-mocks')}}"> --}}
@endsection
@section('content')
@php
    $user = Auth::guard('student')->user();
    $routeArray = [
    [
		'title' => __('frontend.my_profile'),
		'route' => route('student-profile'),
	],
    [
		'title' => 'My Mocks',
		'route' => route('student-mocks'),
	],
    [
		'title' => @$mockTestPaper->mockTest->title,
		'route' => route('mock-info',@$mockTestPaper->mockTest->uuid),
	],
    [
		'title' => @$mockTestPaper->name,
		'route' => route('mock-paper-info',@$mockTestPaper->uuid),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
@php
    $routeName = Route::currentRouteName();
@endphp
    <div class="container mrgn_bt_40">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="brdr_bbx">
                    <div class="d_bl_bbx purched_details">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <p class="mdl_txt">{{__('formname.paper_name')}} : {{@$mockTestPaper->name}}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mdl_txt">{{__('formname.paper_time')}} : {{@$mockTestPaper->time}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="inf_bx_wpdng">
                        @if($routeName =='mock-paper-info')
                            <h4>{{__('formname.paper_description')}}</h4>
                            <div class="unset-list">
                                {!! @$mockTestPaper->description !!}
                            </div>
                        @else
                            <h4>{{__('formname.close_instruction')}}</h4>
                            {!! @$mockTestPaper->complete_instruction !!}
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            @if($routeName =='mock-paper-info')
                <div class="col-md-12">
                    <form action="{{ route('mock-paper-section')}}" method="POST" id='m_form_1'>
                        @csrf
                        <input type="hidden" name="uuid" value="{{@$mockTestPaper->uuid}}">
                        <div class="brdr_bbx brdr_bbx_v2">
                            <h4>Please provide your coﬁrmation for the below points to start your mock exam :</h4>
                            <ul class="chcklist">
                                <li>
                                    <div class="checkbox agreeckbx">
                                        <input type="checkbox" class="dt-checkboxes" id="ckb_1" name="agree">
                                        <label for="ckb_1">I have read all the above Instructions</label>
                                    </div>
                                </li>
                                <span class="agreeError"></span>
                            </ul>
                            <button type="submit" class="drk_blue_btn">Start Now</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="col-md-12">
                    <div class="brdr_bbx brdr_bbx_v2">
                        @if($mockTest->stage_id == 1)
                            <a role="button" class="drk_blue_btn" href="{{route('view-paper-result',['uuid'=>@$studentTestPaper->uuid])}}">View Result</a>
                        @endif
                        <a role="button" class="drk_blue_btn" href="{{route('student-mocks')}}">{{__('formname.go_to_mock')}}</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop
@section('pageJs')
<script>
    $('#m_form_1').validate({
        rules:{
            agree:{
                required:true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == 'agree'){
                error.insertAfter('.agreeError');
            }
        }
    })
    $(document).ready(function() {
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
        $(window).keydown(function(event){
            if(event.keyCode == 116) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>
@stop