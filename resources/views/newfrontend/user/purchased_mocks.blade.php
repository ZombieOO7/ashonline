@extends('newfrontend.layouts.default')
@section('title',__('frontend.parentmock.purchase'))
@section('content')
@php
    $date = date('Y-m-d');
    $currentDate = strtotime($date);
    $routeArray = [
    [
		'title' => __('frontend.my_profile'),
		'route' => route('parent-profile'),
	],
    [
		'title' => __('frontend.purchased_mock'),
		'route' => route('purchased-mock'),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <!--inner content-->
    <div class="container mrgn_bt_40">
        <div class="row">
            @include('newfrontend.user.leftbar')
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
                            <div class="tab-pane fade active show" id="pills-purchased" role="tabpanel" aria-labelledby="pills-purchased-tab">
                                <div class="def_p mb-0 pd30">{!! @$cms->content !!} </div>
                                <div class="pdng_box pdng_tp_0">
                                    <div class="row">
                                        <div class="col-md-12 p-0">
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
                                                    @forelse($items as $item)
                                                        <tr class="tr_ttlt">
                                                            <td data-title="" colspan="6">
                                                                <h5>{{__('frontend.parentmock.created_at')}} : {{@$item->order->proper_order_date}}</h5>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td data-title="Images">
                                                                <a href="{{ route('mock-detail', ['uuid'=>@$item->mockTest->uuid] ) }}">
                                                                    <img src="{{@$item->mockTest->image_path }}" style="height: 100px; width:100px;" class="img-fluid"></a>
                                                            </td>
                                                            <td data-title="Exam Name">
                                                                <div>{{@$item->mockTest->title}}</div>
                                                                <a href="{{route('mock-detail', ['uuid'=>@$item->mockTest->uuid] ) }}" class="text-primary">
                                                                    {{__('formname.view_detail')}}
                                                                </a>
                                                            </td>
                                                            <td data-title="Exam type">{{@$item->mockTest->examBoard->title}}</td>
                                                            <td data-title="Year">
                                                                 {{@$item->mockTest->grade->title}}</td>
                                                            <td data-title="Date">{{@$item->mockTest->proper_start_date_and_end_date}}</td>
                                                            <td data-title="Time">{{@$item->mockTest->total_paper_time}}</td>
                                                            @if(strtotime(@$item->mockTest->end_date) >= $currentDate)
                                                                <td data-title="" colspan="6">
                                                                    <div class="button_link_scn">
                                                                        @php
                                                                            $class = '';
                                                                            $printFlag = true;
                                                                            $purchasedMock = App\Models\PurchasedMockTest::where(['parent_id'=>Auth::guard('parent')->id(),'mock_test_id'=>$item->mock_test_id,'status'=>1])->first();
                                                                            $studentTest = App\Models\StudentTest::where(['mock_test_id'=>$item->mock_test_id,'student_id'=>@$purchasedMock->student_id])->first();
                                                                            if($studentTest == null && $purchasedMock == null){
                                                                                $label = __('formname.assign_mock');
                                                                            }else if($studentTest != null){
                                                                                $class = 'disabled';
                                                                                $printFlag = false;
                                                                                $label = __('formname.assign_mock');
                                                                            }else{
                                                                                $label = __('formname.assign_mock');
                                                                                if(Auth::guard('parent')->user()->child_count > 1){
                                                                                    $label = __('formname.reassign_mock');
                                                                                    $printFlag = true;
                                                                                }else{
                                                                                    $printFlag = false;
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        <button class="drk_blue_btn activeModal printPdf p-2 mr-0" {{$class}} data-mock_test_id='{{@$item->mockTest->id}}' data-id="{{@$item->mockTest->id}}" @if(@$item->mockTest->stage_id == 2) disabled @endif>{{$label}}</button>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        @if(@$item->mockTest->stage_id == 2)
                                                            <tr class="tr_ttlt tr_ttlt_wtbrdr">
                                                                <td colspan="7">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7">
                                                                    @if(@$printFlag == true)
                                                                        <div class="checkbox agreeckbx ml-2 mb-2">
                                                                            <input type="checkbox" class="dt-checkboxes agreeToPrint" data-id="{{@$item->mockTest->id}}" id="ckb_{{@$item->mockTest->id}}" name="agree{{@$item->mockTest->id}}">
                                                                            <label for="ckb_{{@$item->mockTest->id}}">Please make sure you print the answer sheet and then assign the mock to child</label>
                                                                        </div>
                                                                    @endif
                                                                    <div class="row ml-2">
                                                                        @forelse(@$item->mockTest->papers as $paper)
                                                                            <div class="p-2 mr-0">
                                                                                <a class="drk_blue_btn text-white" href="{{route('mock-paper.answer-sheet',['uuid'=>@$paper->uuid])}}" id="{{@$item->mock_test_id}}" class="btn p-0">{{$paper->name.' Answer sheet'}}</a>
                                                                            </div>
                                                                        @empty
                                                                        @endforelse
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @empty
                                                        <tr class="tr_ttlt">
                                                            <td class="" data-title="" colspan="6">
                                                                <p class="mdl_txt">{{__('formname.no_mock_available')}}</p>
                                                            </td>
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
                            <div class="tab-pane fade" id="pills-completed" role="tabpanel" aria-labelledby="pills-completed-tab">
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
                                                            {{-- <th width="20%">{{__('formname.action')}}</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($completedMocks as $item)
                                                        <tr class="tr_ttlt">
                                                            <td data-title="" colspan="6">
                                                                <h5>Completed By : {{@$item->child->full_name}}</h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td data-title="Images">
                                                                <a href="{{ route('mock-detail', ['uuid'=>@$item->mockTest->uuid] ) }}">
                                                                    <img src="{{@$item->mockTest->image_path }}" style="height: 100px; width:100px;" class="img-fluid">
                                                                </a>
                                                            </td>
                                                            <td data-title="Exam Name">
                                                                <div>{{@$item->mockTest->title}}</div>
                                                                <a href="{{ route('mock-detail', ['uuid'=>@$item->mockTest->uuid] ) }}" class="text-primary">
                                                                    {{__('formname.view_detail')}}
                                                                </a>
                                                            </td>
                                                            <td data-title="Exam type">{{@$item->mockTest->examBoard->title}}</td>
                                                            <td data-title="Year">{{@$item->mockTest->grade->title}}</td>
                                                            <td data-title="Date">{{@$item->mockTest->proper_start_date_and_end_date}}</td>
                                                            <td data-title="Time">{{@$item->mockTest->total_paper_time}}</td>
                                                        </tr>
                                                        <tr class="tr_ttlt">
                                                            @php
                                                                if(@$item->studentTestCompleted->count() == @$item->mockTest->papers->count()){
                                                                    $label = 'View Result';
                                                                }else{
                                                                    if(@$item->mockTest->stage_id =='2')
                                                                        $label = 'Evaluate Mock';
                                                                    else
                                                                        $label = 'View Result';
                                                                }
                                                            @endphp
                                                            <td colspan="{{(in_array(@$item->mockTest->id,$parentRatingArr))?3:2}}">
                                                                <a style="color: white" href="{{route('mock-paper-result',[@$item->uuid])}}" class="drk_blue_btn blue_btn ev_btn ntn">{{@$label}}</a>
                                                            </td>
                                                            @if(in_array(@$item->mockTest->id,$parentRatingArr))
                                                                <td></td>
                                                            @else
                                                                <td colspan="2">
                                                                    <button class="drk_blue_btn mt-2 p-2" data-toggle="collapse" href="#ShareFeedback_tab{{@$item->mockTest->id}}"
                                                                            id="sharefeedback" role="button" aria-expanded="false" aria-controls="ShareFeedback_tab">Share Feedback
                                                                    </button>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        <tr class="tr_ttlt">
                                                            <td colspan="7">
                                                                <div class="col-md-12 fdbck_collaps">
                                                                    <div class="collapse" id="ShareFeedback_tab{{@$item->mockTest->id}}">
                                                                        <div class="card card-body">
                                                                            <form class="def_form in_cllps_dv"
                                                                                  method="POST"
                                                                                  action="{{route('preview-n-rate') }}">
                                                                                @csrf
                                                                                <p>Leave your review and rate us on
                                                                                    basis of your experience with us</p>
                                                                                <div class="row mrgn_tp_30">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div
                                                                                                class="fixedStar mx_w_str editable_star bg_star"
                                                                                                data-score="1"></div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <textarea
                                                                                                class="form-control grtxtr"
                                                                                                id="" rows="4"
                                                                                                name='msg'
                                                                                                placeholder="Write your message here"></textarea>
                                                                                            <input type="hidden"
                                                                                                   name="mock_test_id"
                                                                                                   value="{{@$item->mockTest->id}}">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <input type="submit"
                                                                                                   class="btn submit_btn btn_blue"
                                                                                                   data-toggle="modal"
                                                                                                   data-target="#success_modal"
                                                                                                   value="Submit">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
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
                                                    @if(!empty($evaluatedMocks))
                                                        @foreach($evaluatedMocks as $item)
                                                            <tr class="tr_ttlt">
                                                                <td data-title="" colspan="6">
                                                                    <h5>{{__('frontend.parentmock.created_at')}}
                                                                        : {{@$item->order->proper_order_date}}</h5></td>
                                                            </tr>
                                                            <tr>
                                                                <a href="{{ route('mock-detail', ['uuid'=>@$item->mockTest->uuid] ) }}">
                                                                    <td data-title="Images">
                                                                        <img src="{{@$item->mockTest->imagepath }}">
                                                                    </td>
                                                                </a>
                                                                <a href="{{ route('mock-detail', ['uuid'=>@$item->mockTest->uuid] ) }}">
                                                                    <td data-title="Exam Name">{{@$item->mockTest->title}}</td>
                                                                </a>
                                                                <td data-title="Exam type">{{@$item->mockTest->examBoard->title}}</td>
                                                                <td data-title="Year">
                                                                    Year {{@$item->mockTest->grade->grade_id}}</td>
                                                                <td data-title="Date">{{@$item->mockTest->proper_start_date_and_end_date}}</td>
                                                                <td data-title="Time">{{@$item->mockTest->mockTestSubjectTime->proper_time}}</td>
                                                                <td data-title="Price">{{@$item->mockTest->price_text}}</td>
                                                            </tr>
                                                            <tr class="tr_ttlt tr_ttlt_wtbrdr">
                                                                <td colspan="4">
                                                                    <a href="#" class="btn btn_join btn_vw_rslt">View
                                                                        Result</a>
                                                                </td>
                                                                <td colspan="3" class="text-right">
                                                                    <a href="#" class="btn btn_dwnld shr_ic">Share via Mail</a>
                                                                    <span class="tb_dvdr">|</span>
                                                                    <a href="#" class="btn btn_dwnld">Download</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
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

    <!--Activate Mock Modal -->
    <div class="modal fade def_modal lgn_modal" id="activeMockModal" tabindex="-1" role="dialog" aria-hidden="true">
        {{ Form::open(['id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3>{{__('frontend.parentmock.active_mock')}}</h3>
                    <p class="mrgn_bt_40">{{__('frontend.parentmock.warning')}}</p>
                    {!! Form::hidden('parent_id', Auth::guard('parent')->id(),['id'=>'parentId']) !!}
                    <div class="">
                        @php
                            $parent = Auth::guard('parent')->user();
                        @endphp
                        <p class=""><strong>Select Child</strong></p>
                        @forelse($parent->childs as $child)
                            <a href="javascript:;" class="e-mck-btn selectChildId" data-student_id={{@$child->id}}>{{@$child->full_name}}</a>
                        @empty
                        @endforelse
                        <br/>
                        <span class="childError"></span>
                        {!! Form::hidden('student_id', null,['id'=>'studentId']) !!}
                    </div>
                <div class="mrgn_bt_40"></div>
                {!! Form::hidden('mock_test_id', null,['id'=>'mockTestId']) !!}
                    <button type="submit" class="btn submit_btn assignMock d_inline">
                        {{__('frontend.parentmock.confirm')}}
                        <div class="lds-ring" style="display:none;">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </button>
                    <button type="button" class="btn gr_btn d_inline" data-dismiss="modal">{{__('frontend.parentmock.cancel')}}</button>
                </div>

            </div>
        </div>
        {!! Form::close() !!}
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


    <div class="modal fade def_modal lgn_modal" id="success_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3>Successfully Submitted</h3>
                    <p class="mrgn_bt_40">Thank you for sharing your feedback with us. It has been successfully
                        submitted.</p>
                    <button type="submit" class="btn submit_btn" data-dismiss="modal">Okay</button>
                </div>

            </div>
        </div>
    </div>

    @php
        @endphp
@stop
@section('pageJs')
    <script>
        var activeMockUrl = '{{route("activate.mock")}}';
    </script>
    <script src="{{asset('newfrontend/js/parent/mock.js')}}"></script>
@stop
