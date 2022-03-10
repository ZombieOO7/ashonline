@extends('newfrontend.layouts.default')
@section('title', __('frontend.result'))
    <style>
        .selectedAns {
            border: 1px solid #000 !important;
            background-color: #212121 !important;
            color: #fff !important;
        }

        .correctAns {
            border: 1px solid #4CAF50 !important;
            background-color: #4CAF50 !important;
            color: #fff !important;
        }

        .inCorrectAns {
            border: 1px solid #F44336 !important;
            background-color: #F44336 !important;
            color: #fff !important;
        }

    </style>
@section('content')
    <div class="container mrgn_bt_40">
        <div class="row">
            <div class="col-md-12 mt-5 mb-5">
                <ul class="ex_bt_dtls ex_bt_dtls_v2 ex_bt_dtls_v5 row align-items-center">
                    <li class="col-md">
                        <h6 class="mt-2">01.</h6>
                    </li>
                    <li class="col-md">
                        <h6 class="mt-2">10 Mar 2021, 04:25</h6>
                    </li>
                    <li class="col-md">
                        <div class="progress rslt_progress mt-2 minprgrss">
                            <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="prgss_nmbrs">40 / 100</div>
                        </div>
                    </li>
                    <li class="col-md">
                        <button type="submit" class="btn btn_join">Close Result</button>
                    </li>
                </ul>
            </div>
            <div class="col-md-12 prfl_ttl">
                <h3 class="mt-3">{{__('frontend.result')}}</h3>
            </div>
            <div class="col-md-12">
                <div class="mn_qs_bx">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-left">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>{{__('frontend.name')}}</label>
                                        <p>{{ @$student->full_name }}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="float-right">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>Attempt</label>
                                        <p>01</p>
                                    </li>
                                    <li>
                                        <label>Paper Name</label>
                                        <p>Merchant Taylors – Maths Specimen Paper 2</p>
                                    </li>
                                    <li>
                                        <label>Date</label>
                                        <p>10th March 2021</p>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <ul class="ex_bt_dtls ex_bt_dtls_v2">
                                <li>
                                    <span class="ul_in_info ex_i_01">
                                        <h6>10</h6>
                                        <label>Questions</label>
                                    </span>
                                </li>
                                <li>
                                    <span class="ul_in_info ex_i_02">
                                        <h6>8</h6>
                                        <label>Attempted</label>
                                    </span>
                                </li>
                                <li>
                                    <span class="ul_in_info ex_i_04">
                                        <h6>5</h6>
                                        <label>Correctly Answered</label>
                                    </span>
                                </li>
                                <li>
                                    <span class="ul_in_info ex_i_05">
                                        <h6>2</h6>
                                        <label>Unanswered</label>
                                    </span>
                                </li>

                                <li class="float-right">
                                    <span class="ul_in_info_v1">
                                        <label>Marks</label>
                                        <h6>30 out of 100</h6>
                                    </span>
                                </li>
                                <li class="float-right">
                                    <span class="ul_in_info_v1">
                                        <label>Overall Result</label>
                                        <h6>30%</h6>
                                    </span>
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                            <div class="rtng_b_box">
                                <img src="images/mlt_str.png" alt="">
                                <h4><span>Your Ranking</span></h4>
                                <h4><b>06</b><span> out of 1023</span></h4>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mrks_box mrks_box_v2">
                                <h3>Question Analysis</h3>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                                    tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim </p>
                                <ul class="mrk_list">
                                    <li>Q1</li>
                                    <li>Q2</li>
                                    <li class="incorrectly">Q3</li>
                                    <li class="incorrectly">Q4</li>
                                    <li class="unanswered">Q5</li>
                                    <li class="incorrectly">Q6</li>
                                    <li>Q7</li>
                                    <li class="unanswered">Q8</li>
                                    <li>Q9</li>
                                    <li>Q10</li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <ul class="clr_info_lst">
                                <li><span class="ans_crcl"></span>Answered Correctly</li>
                                <li><span class="ans_incrcl"></span>Answered Incorrectly</li>
                                <li><span class="ans_unnsrd"></span>Unanswered</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="mrks_box">
                                <h3>Answers</h3>
                                <p>Want to check the answers for the questions you didn’t attempt and the wrong answered
                                    ones?</p>
                                <button type="submit" class="btn submit_btn show_btn">View Questions</button>
                            </div>
                        </div>
                        <div class="col-md-12 view_qstn">
                            <form class="qstn_form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="in_qstn_box">
                                            <h3><span>Q 1.</span> Circle the most appropriate unit of measure for the
                                                following:</h3>
                                            <div class="inin_qstn_box">
                                                <h4>The length of an airplane</h4>
                                                <ul class="qsa_optns">
                                                    <li>
                                                        <div class="optn_bbx">
                                                            <input type="radio" name="asnwer" id="asnwer_a">
                                                            <label><span>a.</span> pints</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="optn_bbx">
                                                            <input type="radio" name="asnwer" id="asnwer_a" checked>
                                                            <label><span>b.</span> fluid ounces</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="optn_bbx">
                                                            <input type="radio" name="asnwer" id="asnwer_a">
                                                            <label><span>c.</span> gallons</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="optn_bbx">
                                                            <input type="radio" name="asnwer" id="asnwer_a">
                                                            <label><span>d.</span> millilitres</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
    </div>
@stop
@php
$isStudent = 'no';
if (Auth::guard('parent')->user()) {
    $isStudent = 'no';
} else {
    $isStudent = 'yes';
}
$isExam = 'no';
if (session()->has('isExam')) {
    $isExam = session()->get('isExam');
}
@endphp
@section('pageJs')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".questions .in_qstn_box").each(function(e) {
                if (e != 0)
                    $(this).hide();
            });

            $("#next").click(function() {
                if ($(".questions .in_qstn_box:visible").next().length != 0)
                    $(".questions .in_qstn_box:visible").next().show().prev().hide();
                else {
                    $(".questions .in_qstn_box:visible").hide();
                    $(".questions .in_qstn_box:first").show();
                }
                var qNo = $('.questions .in_qstn_box:visible').attr('data-questionNo');
                $('.questionLabel').text(qNo);
                return false;
            });

            $("#prev").click(function() {
                if ($(".questions .in_qstn_box:visible").prev().length != 0)
                    $(".questions .in_qstn_box:visible").prev().show().next().hide();
                else {
                    $(".questions .in_qstn_box:visible").hide();
                    $(".questions .in_qstn_box:last").show();
                }
                var qNo = $('.questions .in_qstn_box:visible').attr('data-questionNo');
                $('.questionLabel').text(qNo);
                return false;
            });
        });
        var isExam = '{{ @$isExam }}';
        $(document).bind("contextmenu", function(e) {
            return false;
        });

        function disableF5(e) {
            if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault();
        };
        $(document).ready(function() {
            if (isExam == 'yes') {

                $(document).on("keydown", disableF5);
                swal("Please do not refresh or go back data may be lost", {
                    icon: 'info',
                    closeOnClickOutside: false,
                });
                window.history.pushState(null, "", window.location.href);
                window.onpopstate = function() {
                    window.history.pushState(null, "", window.location.href);
                };

                function disableF5(e) {
                    if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault();
                };
                $(document).ready(function() {
                    $(document).on("keydown", disableF5);
                });
            }
        });
        /*profile-upload*/
        $(document).ready(function() {
            $('.optn_bbx input[type="radio"]').change(function() {
                if ($(this).is(':checked')) {
                    $(".action_lst li button").removeAttr("disabled");
                } else {
                    $(".action_lst li button").attr("disabled", "disabled");
                }
            });
        });

    </script>
@stop
