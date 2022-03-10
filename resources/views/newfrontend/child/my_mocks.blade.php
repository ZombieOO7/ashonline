@extends('newfrontend.layouts.default')
@section('title',__('frontend.parentmock.purchase'))
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
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <!--inner content-->
    <div class="container mrgn_bt_40">
        <div class="row">
            @include('newfrontend.child.leftbar')
            <div class="col-md-9">
                <div class="form_box">
                    <h3>{{__('frontend.parentmock.purchase')}}</h3>
                    <div class="pdng_box rmv_pgn_box">
                        <ul class="nav nav-pills mb-3 top_blue_pannel" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-purchased-tab" data-toggle="pill"
                                   href="#pills-purchased" role="tab" aria-controls="pills-purchased"
                                   aria-selected="true">{{__('frontend.parentmock.available')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-completed-tab" data-toggle="pill" href="#pills-completed"
                                   role="tab" aria-controls="pills-completed"
                                   aria-selected="false">{{__('frontend.parentmock.completed')}}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-purchased" role="tabpanel"
                                 aria-labelledby="pills-purchased-tab">

                                <div class="pdng_box pdng_tp_0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="rspnsv_table rspnsv_table_scrlb">
                                                <table class="table-bordered table-striped table-condensed cf moc_tbl">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th class="img_hd">{{__('formname.images')}}</th>
                                                            <th>{{__('formname.exam_name')}}</th>
                                                            <th>{{__('formname.exam_board')}}</th>
                                                            <th>{{__('formname.year')}}</th>
                                                            <th>{{__('formname.date')}}</th>
                                                            <th>{{__('formname.exam_duration')}}</th>
                                                            <th width="20%">{{__('formname.action')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($myMocks as $item)
                                                        <tr>
                                                            <td data-title="Images">
                                                                <a href="{{ route('mock-detail', @$item->mockTest->uuid ) }}">
                                                                    <img src="{{@$item->mockTest->image_path}}" class="mx-wd-95 img-fluid"></a></td>


                                                            <td data-title="Exam Name">{{@$item->mockTest->title}}</td>
                                                            <td data-title="Exam type">{{@$item->mockTest->examBoard->title}}</td>
                                                            <td data-title="Year">
                                                                {{@$item->mockTest->grade->title}}</td>
                                                            <td data-title="Date">{{@$item->mockTest->proper_start_date_and_end_date}}</td>
                                                            <td data-title="Duration">{{@$item->mockTest->total_paper_time}}
                                                            </td>
                                                            <td data-title="" colspan="7">
                                                                <a role="button" class="btn btn_join submit_btn @if(@$inprgExam > 0) disabled @endif" href="{{route('mock-info',[@$item->mockTest->uuid])}}">
                                                                    {{-- {{(@$item->studentTest)}} --}}
                                                                    @if(@$item->studentTest)
                                                                        In Progress
                                                                    @else
                                                                        Start
                                                                    @endif
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7"><h4 class="blue_txt"></h4>
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-12">
                                                                        <div class="text-left">
                                                                            <p class="mdl_txt">{{__('formname.no_mock_available')}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-completed" role="tabpanel"
                                 aria-labelledby="pills-completed-tab">
                                <div class="pdng_box pdng_tp_0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="rspnsv_table rspnsv_table_scrlb">
                                                <table class="table-bordered table-striped table-condensed cf moc_tbl">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th class="img_hd">{{__('formname.images')}}</th>
                                                            <th>{{__('formname.exam_name')}}</th>
                                                            <th width="20%">{{__('formname.date')}}</th>
                                                            <th width="20%">{{__('formname.action')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($completedMocks as $item)
                                                        @if($item->mockTest != null)
                                                            <tr>
                                                                <td data-title="Images">
                                                                    <a href="{{ route('mock-detail',['uuid'=>@$item->mockTest->uuid] ) }}">
                                                                        <img
                                                                            src="{{ @$item->mockTest->image_path}}"
                                                                            class="mx-wd-95 img-fluid"></a>
                                                                </td>
                                                                <td data-title="Exam Name">{{@$item->mockTest->title}}</td>
                                                                <td data-title="Date">{{@$item->proper_updated_at}}</td>
                                                                @if(@$item->studentTestCompleted->count() == @$item->mockTest->papers->count())
                                                                <td>
                                                                    <a href="{{route('mock-paper-result',[@$item->uuid])}}" class="btn btn_join pt-1 pb-1 pl-2 pr-2">View Result</a>
                                                                </td>
                                                                @endif
                                                        @endif
                                                    @empty
                                                        <tr>
                                                            <td><h4 class="blue_txt"></h4>
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-12">
                                                                        <div class="text-left">
                                                                            <p class="mdl_txt">{{__('formname.no_mock_available')}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!--close inner content-->
    <!--Activate Mock Modal -->
    <div class="modal fade def_modal lgn_modal" id="activeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3>{{__('frontend.parentmock.active_mock')}}</h3>
                    <p class="mrgn_bt_40">{{__('frontend.parentmock.warning')}}</p>
                    <button type="submit" class="btn submit_btn d_inline">{{__('frontend.parentmock.confirm')}}</button>
                    <button type="button" class="btn gr_btn d_inline" data-dismiss="modal">{{__('frontend.parentmock.cancel')}}</button>
                </div>

            </div>
        </div>
    </div>
    <!--Start Evaluation Modal -->
    <div class="modal fade def_modal lgn_modal" id="EvaluateMockModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3>Evaluate Mock Exam</h3>
                    <p class="mrgn_bt_40">Are you sure you want to evaluate the mock exam?</p>
                    <button type="submit" class="btn submit_btn d_inline">Start Evaluation</button>
                    <button type="submit" class="btn gr_btn d_inline" data-dismiss="modal">Cancel</button>
                </div>

            </div>
        </div>
    </div>
    </div>
@stop
@section('pageJs')
    <script>
        studentId = "{{@$user->id}}";
        url = "{{route('check-exam')}}";
    </script>
    <script src="{{asset('newfrontend/js/student/my_mock.js')}}"></script>
@stop
