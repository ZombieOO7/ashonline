@extends('newfrontend.layouts.default')
@section('title','Mock Exam')
@section('pageCss')
    {{-- <meta http-equiv="refresh" content="0; url={{route('student-mocks')}}"> --}}
@endsection
@section('content')
<div class="container mrgn_bt_40">
    <div class="row">
        {{-- <div class="col-md-12 mrgn_tp_50 frtp_ttl">
            <h4>Instructions To Conduct Exam</h4>
            <ul class="inf_ar_list">
                <li>{!! @$mockTest->header !!}</li>
            </ul>
        </div> --}}
        {{-- <div class="col-md-12">
            <hr class="mrgn_bt_0">
        </div> --}}
        <div class="col-md-12 prfl_ttl">
            <h3>{{ @$mockTest->title }}</h3>
        </div>
        <div class="col-md-12">
            <div class="mn_qs_bx">
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-left">
                            <h3 class="qs_h3">{{@$currentSubject->name}}</h3>
                        </div>
                        <div class="float-right">
                            <ul class="ex_tp_dtls">
                                <li>
                                    <h4>Total Subject : {{ @$total_subjects }}</h4>
                                </li>
                                <li>
                                    <label>Parent Email</label>
                                    <p>{{ @$student->parents->email }}</p>
                                </li>
                                <li>
                                    <label>IP Address</label>
                                    <p>{{ @$ip }}</p>
                                </li>
                                {{-- <li>
                                    <span class="alrt_inf">Sed ut perspiciatis unde omnis iste<br>natus error sit
                                        voluptatem</span>
                                </li> --}}
                            </ul>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <ul class="ex_bt_dtls">
                            <li>
                                <span class="ul_in_info ex_i_01">
                                    <h6>{{ @$totalQuestions }}</h6>
                                    <label>Questions</label>
                                </span>
                            </li>
                            <li>
                                <span class="ul_in_info ex_i_02">
                                    <h6 class="is_attmpt-cls">{{@$attempted}}</h6>
                                    <label>Attempted</label>
                                </span>
                            </li>
                            <li class="float-right">
                                <span class="ul_in_info ex_i_03">
                                    <h6 id="timer">{{ @$time_left }}</h6>
                                    <label>Time Left</label>
                                </span>
                            </li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <form class="qstn_form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="in_qstn_box ajx-dv">
                                        @if(isset($firstQuestion->questionData->questionPdfs->question_pdf))
                                            <embed src="{{@$firstQuestion->questionData->questionPdfs->question_pdf}}" type="application/pdf" width="100%" height="400px" />
                                        @endif
                                        @if(isset($firstQuestion->questionData->questionImages->question_image))
                                            <img class="img-fluid" src="{{@$firstQuestion->questionData->questionImages->question_image}}" width="250px" height="250px" >
                                        @endif
                                        <b>
                                            <p>{{ @$firstQuestion->questionData->question_title }}</p>
                                        </b>
                                        <h3><span>Q <b class="qus-no">{{$qno??1}}</b>.</span> {{ @$firstQuestion->questionList->question }}</h3>
                                        @if(isset($firstQuestion->questionList->image_path) && ($firstQuestion->questionList->image_path != null))
                                            <img class="img-fluid" src="{{@$firstQuestion->questionList->image_path}}" width="250px" height="250px" >
                                        @endif
                                        <div class="inin_qstn_box mrgn_bt_30 mrgn_tp_40">
                                            @php
                                            $alphabet = ord("a");
                                            @endphp
                                            <ul class="qsa_optns @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2) unread_tr @endif" style="@if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)pointer-events: none;@endif">
                                                @if($firstQuestion->questionData->question_type == 1)
                                                @forelse ($answers as $ans)
                                                <li>
                                                    <div class="optn_bbx">
                                                        <input type="radio" class="ans-rdo"
                                                            data-subject-id="{{ @$subject_id }}"
                                                            data-mock-test-id="{{ @$mockTest->id }}"
                                                            data-current_question_id="{{ @$firstQuestion->id }}"
                                                            name="asnwer" value="{{ @$ans->id }}"
                                                            id="asnwer_{{chr($alphabet)}}" @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)disabled @endif>
                                                        <label><span>{{chr($alphabet)}}.</span>
                                                            {{ @$ans->answer }}</label>
                                                        <input type="hidden" name="time_taken" value="" id='timeTaken'>
                                                    </div>
                                                </li>
                                                @php $alphabet++; @endphp
                                                @empty
                                                @endforelse
                                                @endif
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="action_lst">
                                        <div class="row pl-5 pb-2 text-default">
                                            <span class="h5 lastQuestionLabel" style="display: @if($nextQuestionId != '' || $nextQuestionId != null) none; @endif">This is last question of this subject paper</span>
                                        </div>
                                        <li class="prv-qus-li">
                                            <button type="button" class="btn prvs_btn nxt_qus"
                                             data-subject-id="{{ @$subject_id }}"
                                             data-current_question_id="{{ @$firstQuestion->id}}"
                                             data-type="prev"
                                             data-prev-question-id="{{ @$prevQuestionId }}"
                                             data-mock-test-id="{{ @$mockTest->id }}"
                                             data-next-question-id="{{ @$nextQuestionId }}"
                                             {{($prevQuestionId =='' || $prevQuestionId==null)?'disabled':''}}>Previous Question</button>
                                        </li>
                                        <li class="nxt-qus-li">
                                            <button type="button" class="btn nxt_btn nxt_qus"
                                                data-subject-id="{{ @$subject_id }}" data-type="next"
                                                data-current_question_id="{{ @$firstQuestion->id }}"
                                                data-prev-question-id="{{ @$prevQuestionId }}"
                                                data-mock-test-id="{{ @$mockTest->id }}"
                                                data-next-question-id="{{ @$nextQuestionId }}"
                                                {{($nextQuestionId =='' || $nextQuestionId==null)?'disabled':''}}>Next Question</button>
                                        </li>
                                        <input type="hidden" name="mark_for_review" class="dt-checkboxes" value="0" id="agreeCheck">
                                        <li class="float-right cpmlt-mck">
                                            @if(@$nextSubjectId == null)
                                            <button type="button" class="btn cmplt_btn"
                                                    data-subject-id="{{ @$subject_id }}" data-type="next"
                                                    data-current_question_id="{{ @$firstQuestion->id }}"
                                                    data-prev-question-id="{{ @$prevQuestionId }}"
                                                    data-mock-test-id="{{ @$mockTest->id }}"
                                                    data-next-question-id="{{ @$nextQuestionId }}"
                                                    data-mock-test-title="{{ @$mockTest->title }}"
                                                    data-mock-test-image="{{ @$mockTest->image_path}}"
                                                    data-url="{{ route('mock-result',[@$mockTest->uuid]) }}"
                                                    {{($nextQuestionId =='' || $nextQuestionId==null)?'':'disabled'}}>Submit Paper
                                            </button>
                                            @else
                                                <button type="button" class="drk_blue_btn nxtSubQue" disabled data-toggle="modal" data-target='#StartNextSectionModal' >Next Paper
                                                </button>
                                            @endif
                                        </li>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="inf_bx_wpdng pad_0">
                                <h4 class="mrgn_bt_15">Note :</h4>
                                {!! @$mockTest->summury!!}
                            </div>
                    </div>
                </div>
                <div class="d-none">
                    @if(@$firstAudio != '')
                        <audio id="firstAudio" class="audioInput" controls autoplay preload style='display:none;'>
                            <source src="{{@$firstAudio->audio_path}}" type="audio/mpeg">
                        </audio>
                    @endif
                    @if($secondAudio != '')
                        <audio id="secondAudio" class="audioInput" controls preload style='display:none;'>
                            <source src="{{@$secondAudio->audio_path}}" type="audio/mpeg">
                        </audio>
                    @endif
                    @if($thirdAudio != '')
                        <audio id="thirdAudio" class="audioInput" controls preload style='display:none;'>
                            <source src="{{@$thirdAudio->audio_path}}" type="audio/mpeg">
                        </audio>
                    @endif
                    @if($forthAudio != '')
                        <audio id="forthAudio" class="audioInput" controls preload style='display:none;'>
                            <source src="{{@$forthAudio->audio_path}}" type="audio/mpeg">
                        </audio>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade def_modal lgn_modal" data-backdrop="static" data-keyboard="false" id="CompleteMockExamModal" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <h3>Complete Mock Exam</h3>
                        <p class="mrgn_bt_40">Are you sure you want to complete the mock exam?</p>
                        <div class="mc_pp_bx">
                            <div class="row">
                                <div class="col-md-12 mc_d_b">
                                    <div class="d-md-flex align-items-center">
                                        <a href="javascript:void(0);" class="mck-tst-img-url"><img
                                                src="images/mock_img_tbl.png"
                                                class="mx-wd-95 img-fluid mck-tst-img"></a>
                                        <a href="javascript:void(0);" class="mck-tst-title-url">
                                            <p class="mdl_txt mck-tst-title"> GL Mock Exam 1</p>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-12 inline_action mrgn_tp_15">
                                    <a href="javascript:;" type="button" class="btn submit_btn cmplt_mck"
                                        data-mock-test-id="{{ @$mockTest->id }}"
                                        data-mock-test-title="{{ @$mockTest->title }}"
                                        data-mock-test-image="{{ @$mockTest->image_path }}"
                                        data-url="{{ route('mock-result',[@$mockTest->uuid]) }}">Submit Now</a>
                                    {{-- <a href="{{ route('mock-exam-review',[@$mockTest->uuid]) }}"
                                        class="btn submit_btn btn_rvw" style="display: none;">Review Now</a> --}}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade def_modal lgn_modal" data-backdrop="static" data-keyboard="false" id="MockExamCompleteModal" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Mock Exam Time Out</h3>
                        <p class="mrgn_bt_40">You'r Mock Exam Time Finished</p>
                        <div class="mc_pp_bx">
                            <div class="row">
                                <div class="col-md-12 mc_d_b">
                                    <div class="d-md-flex align-items-center">
                                        <a href="{{ route('mock-detail',[@$mockTest->uuid]) }}"
                                            class="mck-tst-img-url"><img src="{{@$mockTest->image_path}}"
                                                class="mx-wd-95 img-fluid mck-tst-img"></a>
                                        <a href="{{ route('mock-detail',[@$mockTest->uuid]) }}"
                                            class="mck-tst-title-url">
                                            <p class="mdl_txt mck-tst-title"> {!! @$mockTest->title !!}</p>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-12 inline_action mrgn_tp_15">
                                    <button type="button" class="btn cmplt_btn cmplt_mck submit_btn"
                                    data-mock-test-id="{{ @$mockTest->id }}"
                                    data-mock-test-title="{{ @$mockTest->title }}"
                                    data-mock-test-image="{{ @$mockTest->image_path }}"
                                    data-url="{{ route('mock-result',[@$mockTest->uuid]) }}">Submit Now</button>
                                    {{-- <a href="{{ route('mock-exam-review',[@$mockTest->uuid]) }}"
                                        class="btn submit_btn btn_rvw">Review Now</a> --}}
                                    {{-- <a href="{{ route('mock-exam-review',[@$mockTest->uuid]) }}"
                                        class="btn submit_btn btn_rvw">Review</a> --}}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade def_modal lgn_modal" id="StartNextSectionModal" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <h3>Next Paper</h3>
                        <p class="mrgn_bt_40">Do you want to attempt next paper ?</p>
                        <div class="mc_pp_bx">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mc_p_dd_b mc_brdr_nn">
                                        <div class="row">
                                            <div class="col-md-6 mc_lfd">
                                                <label>Paper Name</label>
                                                <h3 class="secTopicName">{{@$nextSubject->name}}</h3>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <div class="mc_rtd">
                                                    <h3 class="secTime">{{@$nextSubjectTime}} Minutes</h3>
                                                    <label>Time to Complete</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <a type="button" id='nextSection' href="{{route('mock-exam-2',['uuid'=>@$mockTest->uuid,'subjectId'=>@$nextSubjectId])}}" class="btn submit_btn"> Continue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @stop
    @section('pageJs')
    <script>
        var nextSubjectId = '{{@$nextSubjectId}}';
        $(document).bind("contextmenu",function(e){
            return false;
        });
    </script>
    <script type="text/javascript">
        var ajaxNextQuestionUrl = "{{ route('ajax-next-question') }}";
        var saveQuestionAnsURL = "{{ route('ajax-store-question-ans') }}";
        var examTotalTimeSeconds = "{{ @$examTotalTimeSeconds }}";
        var studentMocksURL = "{{ route('student-mocks') }}";
        var studentTestId= "{{$studentTest->id}}";
        var mockTestId= "{{@$mockTest->id}}";
        var studentTestResultId ='{{$studentTestResult->id}}';
        var questionListIds = '{{@$questionListIds}}';
        var firstAudioPlayTime = 0;
        var secondAudioPlayTime = parseInt('{{@$secondAudioPlayTime}}');
        var thirdAudioPlayTime = parseInt('{{@$thirdAudioPlayTime}}');
        var forthAudioPlayTime = parseInt('{{@$forthAudioPlayTime}}');
        var examReviewUrl = "{{route('mock-exam-review',[@$mockTest->uuid])}}";
        var ajaxSaveStudentTestUrl = "{{ route('complete-mock') }}";
        var resultUrl = "{{ route('mock-result',[@$mockTest->uuid]) }}";
        var timeArray = @php echo json_encode(@$timeArray) @endphp;
        var inBetweenTime = "{{@$inBetweenTime}}";
        var current_subject_id = "{{@$subject_id}}";
        var updateTestStatus = '{{route("update-test-status")}}';
        var subjectIds = [];
        subjectIds.push(current_subject_id);
        var nextPaperUrl = "{{route('mock-exam-2',['uuid'=>@$mockTest->uuid,'subjectId'=>@$nextSubjectId])}}";
    </script>
    <script src="{{asset('newfrontend/js/student/mock_exam.js')}}"></script>
    <script>
        $(document).find('#header').click(false);
        $(document).find('.subscibe_sc').click(false);
        $(document).find('.footer').click(false);
        $(document).on('click','#epapersMenu', function(e){
            e.preventDefault();
        });
        $(document).ready(function() {
            swal("Please do not refresh or go back data may be lost", {
                icon: 'info',
                closeOnClickOutside: false,
            });
            window.history.pushState(null, "", window.location.href);
            window.onpopstate = function() {
                window.history.pushState(null, "", window.location.href);
            };
            $(window).keydown(function(event){
                if(event.keyCode == 116) {
                    event.preventDefault();
                    return false;
                }
            });
            // window.onbeforeunload = function() {
            //     return "Are you sure you want to leave? it will lost your data";
            // }
        });
        $(document).ready(function(){
            if($('#firstAudio').length >0){
                setTimeout(function(){
                document.getElementById("firstAudio").play();
                }, 3000);
            }
            if($('#secondAudio').length >0){
                setTimeout(function(){
                document.getElementById("secondAudio").play();
                }, secondAudioPlayTime);
            }
            if($('#thirdAudio').length >0){
                setTimeout(function(){
                document.getElementById("thirdAudio").play();
                }, thirdAudioPlayTime);
            }
            if($('#forthAudio').length >0){
                setTimeout(function(){
                document.getElementById("forthAudio").play();
                }, forthAudioPlayTime);
            }
          })
    </script>
    @stop
