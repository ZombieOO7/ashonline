@extends('newfrontend.layouts.default')
@section('title',__('frontend.parentmock.purchase'))
@section('content')

    <div class="container mrgn_bt_40">
        <div class="row">
            <div class="row col-md-12 prfl_ttl">
                <div class="col-md-3">
                    <h3>Result</h3>
                </div>
                <div class="col-md-9 mt-5">
                    <div class="float-right">
                        @if(Auth::guard('parent')->user())
                            <a class="txt-dec-none" href="{{route('purchased-mock')}}"><button type="button" class="btn submit_btn">Go to My Mocks</button></a>
                        @endif
                        @if(Auth::guard('student')->user())
                            <a class="txt-dec-none" href="{{route('student-mocks')}}"><button type="button" class="btn submit_btn">Go to My Mocks</button></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mn_qs_bx">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-left">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>Child Id</label>
                                        <p>{{@$student->ChildIdText}}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="float-right">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>Attempt</label>
                                        <p>{{@$studentTest->attempt_count}}</p>
                                    </li>
                                    <li>
                                        <label>Exam Name</label>
                                        <p>{{@$mockTest->title}}</p>
                                    </li>
                                    <li>
                                        <label>Exam ID</label>
                                        <p>{{@$mockTest->id}}</p>
                                    </li>
                                    <li>
                                        <label>Date</label>
                                        <p>{{@$studentTest->created_at_user_readable}}</p>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <ul class="ex_bt_dtls ex_bt_dtls_v2">
                                <li>
                                <span class="ul_in_info ex_i_01">
                                    <h6>{{@$studentTest->questions}}</h6>
                                    <label>Questions</label>
                                </span>
                                </li>
                                <li>
                                <span class="ul_in_info ex_i_02">
                                    <h6>{{@$studentTest->attempted}}</h6>
                                    <label>Attempted</label>
                                </span>
                                </li>
                                <li>
                                <span class="ul_in_info ex_i_04">
                                    <h6>{{@$studentTest->correctly_answered}}</h6>
                                    <label>Correctly Answered</label>
                                </span>
                                </li>
                                <li>
                                <span class="ul_in_info ex_i_05">
                                    <h6>{{@$studentTest->unanswered}}</h6>
                                    <label>Unanswered</label>
                                </span>
                                </li>

                                <li class="float-right">
                                <span class="ul_in_info_v1">
                                    <label>Marks</label>
                                    <h6>{{@$studentTest->obtained_marks}} out of
                                        {{@$studentTest->total_marks}}</h6>
                                </span>
                                </li>
                                <li class="float-right">
                                <span class="ul_in_info_v1">
                                    <label>Overall Result</label>
                                    <h6>{{@$studentTest->overall_result}}%</h6>
                                </span>
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                            <div class="rtng_b_box">
                                <img src="{{asset('images/mlt_str.png')}}" alt="">
                                <h4><span>Your Ranking</span></h4>
                                <h4><b>{{@$studentTest->rank}}</b><span> out of {{@$totalStudentAttemptTest}}</span></h4>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mrks_box">
                                <h3>Answers</h3>
                                <p>Want to check the answers for the questions you didn’t attempt and the wrong answered
                                    ones?</p>
                                <div class="row col-md-12">
                                    <div class="col-md-4">
                                        <a class='txt-dec-none' href="{{route('view-questions-result',[@$studentTest->uuid])}}"><button type="button"
                                                class="btn submit_btn">View All Questions</button></a>
                                    </div>
                                    <div class="col-md-4">
                                        <a class='txt-dec-none' href="{{route('view-incorrect-questions-result',[@$studentTest->uuid])}}"><button type="button"
                                                class="btn submit_btn ml-3">View Incorrect Questions</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>


@stop
@section('pageJs')
@stop
