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
		'title' => Auth::guard('student')->check()==true?'My Mocks':'Purchased Mocks',
		'route' => Auth::guard('student')->check()==true?route('student-mocks'):route('purchased-mocks'),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <div class="container mrgn_bt_40">
        <div class="row">
            <div class="col-md-12 prfl_ttl">
                @if(@$studentTest->mockTest->school_id != null)
                <h3>{{@$studentTest->mockTest->school->school_name}}</h3>
                @endif
            </div>
            <div class="col-md-12">
                <div class="brdr_bbx">
                    <div class="d_bl_bbx purched_details">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="d-md-flex align-items-center">
                                    <a href="#"><img src="{{@$studentTest->mockTest->image_path }}" class="img-fluid" style="width:150px;height:150px;"></a>
                                    <a href="#">
                                        <p class="mdl_txt"> {{@$studentTest->mockTest->title}}</p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="mdl_txt">{{@$studentTest->mockTest->proper_start_date_and_end_date}}</p>
                            </div>
                            <div class="col-md-2">
                                <p class="mdl_txt">{{@$studentTest->mockTest->examBoard->title}}</p>
                            </div>
                            <div class="col-md-2">
                                <p class="mdl_txt">{{@$studentTest->mockTest->total_paper_time}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="inf_bx_wpdng">
                        <h4>{{__('formname.mock_instruction')}}</h4>
                        <div class="unset-list">
                            {!! @$studentTest->mockTest->description !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="inf_bx_wpdng">
                        <div class="rspnsv_table rspnsv_table_scrlb">
                            <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd">
                                <thead class="cf">
                                    <tr>
                                        <th>Paper Name</th>
                                        <th>Date</th>
                                        @if(@$studentTest->mockTest->stage_id == 1)
                                            <th>Rank</th>
                                        @endif
                                        <th>Score</th>
                                        <th>Score(%)</th>
                                        @if(@$studentTest->mockTest->stage_id == 1)
                                            <th>Time Taken</th>
                                        @endif
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($studentTest->completedStudentTestPapers as $paper)
                                        <tr class="cf">
                                            <td><span class="p-4">{{@$paper->paper->name}}</span></td>
                                            <td>{{@$paper->created_at}}</td>
                                            @if(@$studentTest->mockTest->stage_id == 1)
                                                <td>
                                                    {{(@$paper->is_greater_then_end_date== true)?@$paper->rank:'- - -'}}
                                                </td>
                                            @endif
                                            <td>{{@$paper->obtained_marks}}</td>
                                            <td>{{@$paper->overall_result}}</td>
                                            @if(@$studentTest->mockTest->stage_id == 1)
                                                <td>{{@$paper->proper_time_taken}}</td>
                                            @endif
                                            <td>
                                                @if(@$studentTest->mockTest->stage_id == 2 && @$paper->status ==3)
                                                    <span class="p-4">
                                                        <a class="drk_blue_btn blue_btn ev_btn text-white" href="{{route('evaluation-info',['paper'=>@$paper->uuid])}}">Evaluate Paper
                                                        </a>
                                                    </span>
                                                @else
                                                    <span class="p-4">
                                                        <a role="button" class="drk_blue_btn text-white" href="{{ route('view-paper-result',['uuid'=>@$paper->uuid]) }}">Result</a>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Start Evaluation Modal Standard -->
    <div class="modal fade def_modal lgn_modal" id="SEvaluateMockModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3>Evaluate Mock Exam</h3>
                    <p class="mrgn_bt_40">Are you sure you want to evaluate the mock exam?</p>
                    <a href="" id="s_start_eval" class="btn submit_btn d_inline">Start Evaluation</a>
                    <button type="submit" class="btn gr_btn d_inline" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('pageJs')
<script>
    $('.ev_btn').on('click', function () {
        var url = $(this).attr('data-url');
        var dataTarget = $(this).attr('data-target');
        if (dataTarget == "#SEvaluateMockModal") {
            var oldUrl = $('#s_start_eval').attr("href"); // Get current url
            var newUrl = oldUrl.replace("", url); // Create new url
            $('#s_start_eval').attr("href", newUrl); // Set herf value
        } else {
            $('#m_start_eval').attr("href", url);
        }
    });
</script>
@stop