@extends('newfrontend.layouts.default')
@section('title', 'Past Paper')
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
		'route' => '#',
	],
];
@endphp
    <!--inner content-->
    <div class="main">
        <div class="prc_tp_bnr">
            <div class="row">
                <div class="col-lg-2 pr_b_l_img"></div>
                <div class="col-lg-4 pr_b_cl_prnt d-flex align-items-center">
                    <div class="mx-475">
                        {!! @$homePastPaperSection->title !!}
                        {!! @$homePastPaperSection->content !!}
                    </div>
                </div>
                <div class="col-lg-4 pr_b_cr_prnt d-flex align-items-center">
                    <div class="mx-475 text-center">
                        <h4>
                            {!! @$homePastPaperSection->note !!}
                            <img src="{{asset('newfrontend/images/hnd_img.jpg')}}">
                        </h4>
                        @forelse ($threePastPapers??[] as $key => $pastPaper)
                        <a href="{{route('past.paper.download',['paperId'=> @$pastPaper->uuid])}}" class="btn btn_join btn_join_v2 mb-3 mr-2"><span class="btnic pdf_ic"></span>
                            {{@$pastPaper->name}}
                            <img src="{{asset('newfrontend/images/arrow_ic.svg')}}" class="ml-1">
                        </a>
                        <a href="{{route('past.paper.detail',['uuid'=>@$pastPaper->uuid])}}" class="btn btn_join btn_join_v2 mb-3"><span class="btnic eye_ic"></span>Answers</a>
                        @empty
                        @endforelse
                    </div>

                </div>
                <div class="col-lg-2 pr_b_r_img"></div>
            </div>
        </div>
        @include('newfrontend.includes.breadcrumbs',$routeArray)
        <div class="mt-3"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-5">
                    <div class="rrspnsvtbl_v2">
                        <table class="table table-bordered blue_head_tbl">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Independent School Past Exam Papers</th>
                                    <th>Question Paper</th>
                                    <th>Detailed Answers</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($allPastPapers as $key => $paper)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{@$paper->name}}</td>
                                        <td>
                                            <a href="{{route('past.paper.download',['paperId'=> @$paper->uuid])}}"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a>
                                        </td>
                                        <td>
                                            <a href="{{route('past.paper.detail',['uuid'=>@$paper->uuid])}}"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="4"> No Papers Found.</td>
                                @endforelse
                            </tbody>
                        </table>
                        <table class="table table-bordered blue_head_tbl" id="past_paper">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan='4' class="text-white"><span class="fa fa-pen"></span> {{__('frontend.premium_paper_note')}}</th>
                                </tr>
                            </thead>
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
    var url = "{{route('past-paper.datatable.list',['subject'=>@$subject->slug])}}";
</script>
<script src="{{ asset('backend/dist/default/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{asset('backend/js/common.js')}}"></script>
<script src="{{asset('newfrontend/js/past-paper/index.js')}}"></script>
@endsection