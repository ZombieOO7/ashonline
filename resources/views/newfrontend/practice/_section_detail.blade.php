@extends('newfrontend.layouts.default')
@section('title', __('frontend.practice'))
@section('content')
<div class="main_brdcrmb">
	<div class="container">
		<div class="row">
			<div class="col-md-12 frtp_ttl">
		    	<nav class="bradcrumb_pr" aria-label="breadcrumb">
					<ol class="breadcrumb breadcrumb_v2">
						@include('newfrontend.practice.bradcrumb')
					</ol>
				</nav>				
			</div>
		</div>
	</div>
</div>
    <!--inner content-->
    {{-- <section class="mock_papers">
        <div class="container">
			<form id="m_form">
				<div class="row">
					<div class="col-md-12 ttlsm_sp">
						<h3 class="df_h3 mdl_tilte">{{ @$section->name }}
							{{ __('frontend.papers_lbl') }}</h3>
						<p class="df_pp p_wt_dvdr">{{ @$section->total_question }} Questions
							<span>|</span>{{ @$section->time }}</p>
					</div>
					<div class="col-md-12 wktas_tp_sc mb-2">
						<h4>{{ __('frontend.informations') }}</h4>
						<ul class="bnr_in_list">
							{!! @$testAssessment->description !!}
						</ul>
					</div>
					<div class="col-md-12 mb-0 mt-0">
						<div class="checkbox agreeckbx mr-3 d-inline-rsp">
							<input type="checkbox" name="agree" class="dt-checkboxes" id="agreeCheck">
							<label for="agreeCheck">{{ __('frontend.instruction_label') }}</label>
						</div>
						<a id='startExam' href="{{ route('attempt-test-assessment', ['uuid' => @$testAssessment->uuid]) }}" class="add_to_cart btn_flwr btn_srt mb-0 mt-0">{{ __('frontend.start') }}</a>
					</div>
					<div class="col-md-12">
						<span class="agreeError"></span>
					</div>
					<div class="mt-5"></div>
				</div>
			</form>
        </div>
    </section> --}}
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
    var examTotalTimeSeconds = parseInt('{{@$section->instruction_read_seconds}}');
</script>
<script src="{{asset('frontend/practice/js/exam.js')}}"></script>
@endsection