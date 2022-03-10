@extends('newfrontend.layouts.default')
@section('title', __('frontend.practice'))
@section('content')
@php
    $routeArray = [
    [
		'title' => __('frontend.practice'),
		'route' => route('practice'),
	],
    [
		'title' => __('frontend.practice_by_topic'),
		'route' => route('topic-list',['subject'=>'maths']),
	],
    [
		'title' => @$subjectData->title,
		'route' => route('topic-list',['subject'=>@$subjectData->slug]),
	],
	[
		'title' => @$practiceExam->title,
		'route' => '#',
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <!--inner content-->
    <section class="mock_papers">
        <div class="container">
			<form id="m_form">
				<div class="row">
					<div class="col-md-12 ttlsm_sp">
						<h3 class="df_h3 mdl_tilte">{{ @$practiceExam->title }}
							{{-- {{ __('frontend.papers_lbl') }} - {{ @$topic->title }}</h3> --}}
						<p class="df_pp p_wt_dvdr">{{ @$totalQuestions }} {{__('frontend.questions')}}
							<span>|</span>{{ @$totalMarks }} {{__('frontend.marks')}}</p>
					</div>
					<div class="col-md-12 wktas_tp_sc mb-2">
						<h4>{{ __('frontend.informations') }}</h4>
						<ul class="bnr_in_list">
							{!! @$practiceExam->description !!}
						</ul>
					</div>
					<div class="col-md-12 mb-0 mt-0">
						<div class="checkbox agreeckbx mr-3 d-inline-rsp">
							<input type="checkbox" name="agree" class="dt-checkboxes" id="agreeCheck">
							<label for="agreeCheck">{{ __('frontend.instruction_label') }}</label>
						</div>
						{{-- <a id='startExam' href="#" class="add_to_cart btn_flwr btn_srt mb-0 mt-0">{{ __('frontend.start') }}</a> --}}
						<a id='startExam' href="{{ route('attempt-topic-test', ['uuid' => @$practiceExam->uuid ]) }}" class="add_to_cart btn_flwr btn_srt mb-0 mt-0">{{ __('frontend.start') }}</a>
					</div>
					<div class="col-md-12">
						<span class="agreeError"></span>
					</div>
					<div class="mt-5"></div>
				</div>
			</form>
        </div>
    </section>
@stop
@section('pageJs')
<script>
	var examTotalTimeSeconds = 0;
</script>
<script src="{{asset('frontend/practice/js/exam.js')}}"></script>
@endsection