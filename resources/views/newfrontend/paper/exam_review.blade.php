@extends('newfrontend.layouts.default')
@section('title','Exam Review')
@section('content')
<style>
    .action_lst li .btn.cmplt_btn2{
        background-color: #003394 !important;
    }
</style>
<div class="container mrgn_bt_40">
    <div class="row">
        <div class="col-md-12 prfl_ttl">
            <h3>{{ @$mockTest->title }}</h3>
        </div>
        <div class="col-md-12">
            <div class="mn_qs_bx">
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-left">
                            <h3 class="qs_h3 sectionName">{{@$section->name}}</h3>
                        </div>
                        <div class="float-right">
                            <ul class="ex_tp_dtls">
                                <li>
                                    <h4>Total Sections : {{ count($sections) }}</h4>
                                </li>
                                <li>
                                    <label>Parent Email</label>
                                    <p>{{ @$student->parents->email }}</p>
                                </li>
                                <li>
                                    <label>IP Address</label>
                                    <p class='ip_cls'>{{ @$ip }}</p>
                                </li>
                                <li>
                                    {{-- <span class="alrt_inf">Sed ut perspiciatis unde omnis iste<br>natus error sit
                                        voluptatem</span> --}}
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <ul class="ex_bt_dtls">
                            <li>
                                <span class="ul_in_info ex_i_01">
                                    <h6>{{ @$studentTestQuestionAnswer }}</h6>
                                    <label>Questions for Review</label>
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
                        @if($studentTestQuestionAnswer == 0)
                            <form class="qstn_form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="in_qstn_box ajx-dv">
                                            <h3>There is no questions for review</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="action_lst">
                                            <li class="float-right">
                                                <a href="javascript:;" role="button" class="btn cmplt_btn"
                                                    data-mock-test-id="{{ @$mockTest->id }}"
                                                    data-mock-test-title="{{ @$mockTest->title }}"
                                                    data-mock-test-image="{{ @$mockTest->image_path }}"
                                                    data-url="{{ route('paper-result',[@$studentTestPaper->uuid]) }}">
                                                    Submit Paper
                                                </a>
                                            </li>
                                            <div class="clearfix"></div>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        @else
                        <div class="col-md-12" id="examData">
                            <form class="qstn_form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row flex-column-reverse flex-md-row">
                                            <div class="col-md-7">
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
                                                    <h3><span>Q <b class="qus-no">{{@$firstQuestion->questionList->question_no??1}}</b>.</span> {{ @$firstQuestion->questionList->question }}</h3>
                                                    @if($firstQuestion->questionList->image_id != null)
                                                        <img class="img-fluid" src="{{@$firstQuestion->questionList->image_path}}" width="250px" height="250px" >
                                                    @endif
                                                    <div class="inin_qstn_box mrgn_bt_30 mrgn_tp_40">
                                                        @php
                                                        $alphabet = ord("A");
                                                        @endphp
                                                        <ul class="qsa_optns @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2) unread_tr @endif" style="@if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)pointer-events: none;@endif">
                                                            @if($firstQuestion->questionData->question_type == 1)
                                                            @php
                                                                $answers = @$firstQuestion->questionList->answers??[];
                                                                if($firstQuestion->questionList->answer_type == 2){
                                                                    $inputType = 'checkbox';
                                                                }else{
                                                                    $inputType = 'radio';
                                                                }
                                                            @endphp
                                                            @forelse ($answers as $ans)
                                                            <li>
                                                                <div class="optn_bbx">
                                                                    <input type="{{$inputType}}" class="ans-rdo"
                                                                        data-section_id="{{ @$sectionId }}"
                                                                        data-current_question_id="0"
                                                                        name="asnwer" value="{{ @$ans->id }}"
                                                                        @if(in_array($ans->id,$firstQuestion->selected_answers)) checked @endif
                                                                        id="asnwer_{{chr($alphabet)}}" @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)disabled @endif>
                                                                    <label class="optn_lble"><span class="checkbx_rund"></span><span>{{chr($alphabet)}}.</span>
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
                                            <div class="col-md-5">
                                                <div class="questsn_side_menu">
                                                    <div class="qustn_title">
                                                        <h3 class="qs_h3 blue_clr_txt">Questions:</h3>
                                                    </div>
                                                    <div class="question_list_scn">
                                                        <ul>
                                                            @forelse($previewQuestionList as $qKey => $previewQuestion)
                                                            @php
                                                                $class2 = '';
                                                                if($previewQuestion['is_attempted']== 1){
                                                                    $class = 'active_green';
                                                                }else{
                                                                    $class = '';
                                                                }
                                                                if($previewQuestion['question_id'] == @$firstQuestion->id){
                                                                    $class2 = 'font-weight-bold';
                                                                }
                                                            @endphp
                                                            <li class="quest_lst_n {{$class.' '.$class2}}" data-index="{{$qKey}}"><span class="q_counter_num {{$class2}}">{{@$previewQuestion['q_no']}}</span>{{@shortContent($previewQuestion['question'],45)}}</li>
                                                            @empty
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="action_lst">
                                            <div class="row pl-5 pb-2 text-default">
                                                <span class="h5 lastQuestionLabel" style="display: @if($nextQuestionId != '' || $nextQuestionId != null) none; @endif">This is last question of review paper</span>
                                            </div>
                                            <li class="prv-qus-li">
                                                <button type="button" class="btn prvs_btn nxt_qus"
                                                 data-section_id="{{ @$sectionId }}"
                                                 data-subject_id="{{ @$subjectId }}"
                                                 data-current_question_id="0" 
                                                 data-type="prev"
                                                 data-prev-question-id="{{ @$prevQuestionId }}" 
                                                 data-mock-test-id="{{ @$mockTest->id }}" 
                                                 data-next-question-id="{{ @$nextQuestionId }}"
                                                 {{($prevQuestionId =='' || $prevQuestionId==null)?'disabled':''}}>Previous Question</button>
                                            </li>
                                            <li class="nxt-qus-li">
                                                <button type="button" class="btn nxt_btn nxt_qus"
                                                    data-section_id="{{ @$sectionId }}" 
                                                    data-subject_id="{{ @$subjectId }}"
                                                    data-type="next"
                                                    data-current_question_id="0"
                                                    data-prev-question-id="{{ @$prevQuestionId }}"
                                                    data-mock-test-id="{{ @$mockTest->id }}"
                                                    data-next-question-id="{{ @$nextQuestionId }}"
                                                    {{($nextQuestionId =='' || $nextQuestionId==null)?'disabled':''}}>Next
                                                    Question</button>
                                            </li>
                                            <li class="float-right cpmlt-qus-li">
                                                <button type="button" class="btn cmplt_btn"
                                                    data-subject-id="{{ @$subject_id }}"
                                                    data-type="next"
                                                    data-current_question_id="0"
                                                    data-mock-test-id="{{ @$mockTest->id }}"
                                                    data-mock-test-title="{{ @$mockTest->title }}"
                                                    data-mock-test-image="{{ @$mockTest->image_path }}"
                                                    data-url="{{ route('paper-result',[@$studentTestPaper->uuid]) }}">
                                                    Submit Paper
                                                </button>
                                            </li>
                                            <div class="clearfix"></div>
                                        </ul>
                                    </div>
                                </div>
                                <input type="hidden" name="time_taken" value="{{@$studentTest->duration}}" id='timeTaken'>
                                <input type="hidden" name="mark_for_review" class="dt-checkboxes" value="1" id="agreeCheck">
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade def_modal lgn_modal" id="CompleteMockExamModal" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3>Completion Successful</h3>
                <p class="mrgn_bt_40">Your mock exam has been completed Successfully. Please proceed to check your
                    result</p>
                <div class="mc_pp_bx">
                    <div class="row">
                        <div class="col-md-12 mc_d_b">
                            <div class="d-md-flex align-items-center">
                                <a href="javascript:void(0);" class="mck-tst-img-url"><img src="images/mock_img_tbl.png"
                                        class="mx-wd-95 img-fluid mck-tst-img"></a>
                                <a href="javascript:void(0);" class="mck-tst-title-url">
                                    <p class="mdl_txt mck-tst-title"> GL Mock Exam 1</p>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-12 inline_action mrgn_tp_15">
                            <a href="#" class="btn submit_btn cmplt_mck"
                                data-mock-test-id="{{ @$mockTest->id }}"
                                data-mock-test-title="{{ @$mockTest->title }}"
                                data-mock-test-image="{{ @$mockTest->image_path }}"
                                data-url="{{ route('paper-result',[@$studentTestPaper->uuid]) }}">
                                View Result</a>
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
    $(document).find('#header').click(false);
    $(document).find('.subscibe_sc').click(false);
    $(document).find('.footer').click(false);
    $(document).on('click','#epapersMenu', function(e){
        e.preventDefault();
    });
    $(document).ready(function() {
        // swal("Please do not refresh or go back data may be lost", {
        //     icon: 'info',
        //     closeOnClickOutside: false,
        // });
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    });
    $(document).bind("contextmenu",function(e){
        return false;
    });
</script>
<script type="text/javascript">
 var ajaxReviewNextQuestionUrl = "{{ route('ajax-review-next-question') }}";
  var ajaxSaveStudentTestUrl = "{{ route('complete-mock') }}";
  var studentTestId= "{{$studentTest->id}}";
  var studentTestResultId ='{{$studentTestResult->id}}';
  var saveQuestionAnsURL = "{{ route('ajax-store-question-ans') }}";
  var examTotalTimeSeconds = 0;
  var ajaxNextQuestionUrl = null;
  var paperId = "{{$studentTestPaper->id}}";
  var examTotalTimeSeconds = "{{ @$examTotalTimeSeconds }}";
  var section_taken_time = 0;
  var resultUrl = "{{ route('paper-result',[@$studentTestPaper->uuid]) }}";
  var nextSubjectId = null;
  var updateTestStatus = '{{route("update-test-status")}}';
  var mockTestId= "{{@$mockTest->id}}";
  var questionUrl = "{{route('review.go.to.question')}}";
  var nextSectionId = null;
  var sectionId =null;
  $(document).ready(function() {
        // swal("Please do not refresh or go back data may be lost", {
        //     icon: 'info',
        //     closeOnClickOutside: false,
        // });
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
</script>
<script src="{{asset('newfrontend/js/student/mock_exam.js')}}"></script>
<script src="{{asset('newfrontend/js/student/mock_exam_review.js')}}"></script>
@stop
