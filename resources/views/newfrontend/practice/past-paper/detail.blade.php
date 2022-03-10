@extends('newfrontend.layouts.default')
@section('title', __('frontend.practice'))
@section('content')
@php
    $user = Auth::guard('student')->user();
    $routeArray = [
    [
		'title' => __('frontend.practice'),
		'route' => route('practice'),
	],
    [
		'title' => 'Past Paper',
		'route' => route('past-paper-list',['subject'=>@$subject->slug,'grade'=>@$grade->slug]),
	],
    [
		'title' => @$pastPaper->name,
		'route' => '#',
	],
];
@endphp
<!--inner content-->
<div class="main">
    <div class="pq_tp_bnner">
        <div class="row">
            <div class="col-lg-8 pq_lf_sc align-items-center d-flex">
                <h1><span>{{@$pastPaper->subject->title}}</span>{{@$pastPaper->name}}</h1>
            </div>
            <div class="col-lg-4 pq_rt_sc align-items-center d-flex justify-content-center">
                <img src="{{asset('practice/images/pq_arrow.svg')}}" class="img-fluid">
            </div>
        </div>
    </div>
    @include('newfrontend.includes.breadcrumbs',$routeArray)
    <div class="mt-3"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-5 sdbr_box sdbr_box_v2">
                <div class="sdbx_bx_wt_sdw">
                    <div class="prfl_ttl">
                        <h3>
                            {{@$pastPaper->name ?? 'Topic List'}}
                            <a class="btn btn-dttgl" data-toggle="collapse" href="#SidebarMenu" role="button"
                                aria-expanded="false" aria-controls="SidebarMenu"><span
                                    class="ash-menu"></span></a>
                            <div class="clearfix"></div>
                        </h3>
                    </div>
                    <div class="collapse" id="SidebarMenu">
                        <div class="card card-body">
                            <ul class="crd_list">
                                @forelse(@$topicList??[] as $topic)
                                    <li><a href="{{route('topic.question',['slug'=>@$topic['slug']])}}">{{ucfirst(@$topic['title'])}}</a></li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <table id="pastPaperQuestion">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end inner content-->
@stop
@section('pageJs')
<script>
    var url = "{{route('past-paper.question.datatable',['uuid'=>@$pastPaper->uuid])}}";
</script>
<script src="{{ asset('backend/dist/default/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{asset('backend/js/common.js')}}"></script>
<script src="{{asset('newfrontend/js/past-paper/index.js')}}"></script>
@endsection