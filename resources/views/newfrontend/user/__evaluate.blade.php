@extends('newfrontend.layouts.default')
@section('title', 'Mock Exam')
@section('pageCss')
    {{-- <meta http-equiv="refresh" content="0; url={{route('student-mocks')}}"> --}}
@endsection
@section('content')
@php
    $routeName = Route::currentRouteName();
@endphp
    <div class="container mrgn_bt_40">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="brdr_bbx">
                    <div class="d_bl_bbx purched_details">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <p class="mdl_txt">{{__('formname.exam_name')}} : {{@$mockTestPaper->mockTest->title}}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mdl_txt">{{__('formname.paper_name')}} : {{@$mockTestPaper->name}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="inf_bx_wpdng">
                        <h4>{{__('formname.paper_description')}}</h4>
                        {!! @$cms->content !!}
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-12">
                <form id='m_form_1'>
                    <div class="brdr_bbx brdr_bbx_v2">
                        <h4>Please provide your coﬁrmation for the before start paper evaluation.</h4>
                        <ul class="chcklist">
                            <li>
                                <div class="checkbox agreeckbx">
                                    <input type="checkbox" class="dt-checkboxes" id="ckb_1" name="agree">
                                    <label for="ckb_1">I have read all the above Instructions</label>
                                </div>
                            </li>
                            <span class="agreeError"></span>
                        </ul>
                        <button type="submit" class="drk_blue_btn">Start Evaluate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('pageJs')
<script>
    var redirectUrl= "{{route('evaluation',['paper'=>@$uuid])}}";
    $(document).ready(function(){
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
        $('#m_form_1').on('submit',function(e){
            e.preventDefault();
            if($('#m_form_1').valid()){
                debugger;
                window.location.replace(redirectUrl);
            }
        })
    })
</script>
@stop