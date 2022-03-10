@extends('newfrontend.layouts.default')
@section('title', __('frontend.parentmock.purchase'))
@section('content')
    @section('pageCss')
        <link rel="stylesheet" href="{{asset('css/pdf.css')}}">
        <style>
            .selectedAns {
                border: 1px solid #000 !important;
                background-color: #212121 !important;
                color: #fff !important;
            }

        </style>
    @endsection
    <!--inner content-->
    <div class="container mrgn_bt_40 main-dv">
        <div class="row">
            {{-- <div class="col-md-12 prfl_ttl">
                <h3>Validate Answers</h3>
            </div> --}}
            <div class="col-md-12">
                <div class="mn_qs_bx">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <div class="float-left">
                                <h3 class="qs_h3">{{@$firstQuestion->section->name}}</h3>
                            </div>
                            <div class="float-right">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <h4>Total Sections : {{ @$mockTestPaper->no_of_section}}</h4>
                                    </li>
                                    <li>
                                        <label>{{ @$mockTest->title }}</label>
                                        <p>{{@$mockTestPaper->name}}</p>
                                    </li>

                                </ul>
                            </div> --}}

                        </div>
                        <div class="col-md-12">
                            <div class="float-left">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>{{__('formname.mock-test.title')}}</label>
                                        <p>{{@$mockTest->title}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('formname.paper_name')}}</label>
                                        <p>{{@$mockTestPaper->name}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('formname.subject')}}</label>
                                        <p>{{@$firstQuestion->section->subject->title}}</p>
                                    </li>
                                    <li>
                                        <label>{{__('formname.section_name')}}</label>
                                        <p class="sectionTitle">{{@$firstQuestion->section->name}}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="float-right">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>{{__('formname.child_name')}}</label>
                                        <p>{{ @$student->full_name }}</p>
                                    </li>
                                    <li>
                                        <label>Total Sections</label>
                                        <p>{{ @$mockTestPaper->no_of_section}}</p>
                                    </li>
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
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                        <div class="col-md-12 ">
                            <form class="qstn_form">
                                <div class="row">
                                    <div class="col-md-12">
                                        @php
                                            $section = @$firstQuestion->section;
                                        @endphp
                                        <div id="examData">
                                            @if(isset($section->passage) && $section->passage_path !=null)
                                                <div class="pdfApp border" data-index="00" data-src="{{@$section->passage_path}}">
                                                    <div id="viewport-container00" class="viewport-container" data-index="00"><div role="main" class="viewport" id="viewport00" data-index="00"></div></div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="in_qstn_box">
                                            <div class="quest-title">
                                                <h3 class="mb-0">
                                                    <div class="mb-3">
                                                        <span class="q_no">Q {{ @$firstQuestion->question->question_no }}.</span>
                                                        {!! @$firstQuestion->question->instruction !!}
                                                        {!! @$firstQuestion->question->question !!}
                                                    </div>
                                                    @if((@$firstQuestion->question->image != null))
                                                        <div class="viwDetail">
                                                            <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">{{__('formname.view_question')}}</a>
                                                        </div>
                                                    @endif
                                                </h3>
                                                @if((@$firstQuestion->question->image != null))
                                                    <div class='col-md-12 row collapse ml-5' id="collapseExample">
                                                        @if($firstQuestion->question->resize_full_image)
                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$firstQuestion->question->image_path}}">
                                                                {!! @$firstQuestion->question->resize_full_image !!}
                                                            </span>
                                                        @else
                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$firstQuestion->question->image_path}}">
                                                                <img class="img-fluid mb-3" src="{{@$firstQuestion->question->image_path}}">
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            @if (@$firstQuestion->question->question_type == 1)
                                                <span class="answerList">
                                                    @php
                                                        $alphabet = ord("A");
                                                    @endphp
                                                    <ul class="qsa_optns pl-4">
                                                    @forelse (@$firstQuestion->question->answers as $ans)
                                                        <li>
                                                            @if(@$ans->is_correct == '1')
                                                                <h6 class="text-success">
                                                                    {{chr($alphabet)}}. {!! @$ans->answer !!}
                                                                    <span class="fa fa-check"></span>
                                                                </h6>
                                                            @else
                                                                <h6>
                                                                    {{chr($alphabet)}}. {!! @$ans->answer !!}
                                                                </h6>
                                                            @endif
                                                        </li>
                                                        @php $alphabet++; @endphp
                                                    @empty
                                                    @endforelse
                                                    </ul>
                                                </span>
                                            @else
                                                <span class="answerList">
                                                    <div class="quest-title ml-5">
                                                        <strong>Correct Answer : </strong>
                                                        <h6 class="text-success">
                                                            {!! @$answers[0]->answer !!}
                                                            <span class="fa fa-check"></span>
                                                        </h6>
                                                    </div>
                                                </span>
                                            @endif
                                            <div class="ml-4 row">
                                                <label for="" class="col-form-label col-lg-3 col-sm-12"></label>
                                                <div class="col-lg-12 col-md-12 col-sm-12 ml-2">
                                                    @if((@$firstQuestion->question->answer_image != null))
                                                        @if(@$firstQuestion->question->resize_answer_image)
                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$firstQuestion->question->answer_image_path}}">
                                                                {!! @$firstQuestion->question->resize_answer_image !!}
                                                            </span>
                                                        @else
                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$firstQuestion->question->answer_image_path}}">
                                                                <img id="q_image_preview_1" src="{{@$firstQuestion->question->answer_image_path}}" class="img-fluid" style="display:{{isset($firstQuestion->question->answer_image_path) && @$firstQuestion->question->answer_image != null ?'':'none'}};" />
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            @if(@$firstQuestion->question->explanation != null)
                                                <div class="row ml-5 mt-5">
                                                    <h5>Explanation</h5>
                                                    {!! @$firstQuestion->question->explanation !!}
                                                </div>
                                            @endif
                                            <div class="row ml-2 mt-5">
                                                <span class="h4 lastQuestionLabel text-danger" style="display: @if($nextQuestionId != '' || $nextQuestionId != null) none; @endif">{{__('formname.last_paper_question_note')}}</span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h6 class="mrk_ttl">Mark Question Here</h6>
                                </div>
                                <div class="col-md-12">
                                    <ul class="ex_bt_dtls">
                                        <li>
                                            <span class="ul_in_info ex_i_06">
                                                <h6>
                                                    <span class="">
                                                        Total Scored so far
                                                    </span>
                                                    <b class="marks_obtained">
                                                    {{ @$firstQuestion->testResult->studentTestPaper->obtained_marks ?? 00 }}
                                                    </b>
                                                    <span class="">
                                                        Out Of
                                                    </span>
                                                    <b class="">
                                                        &nbsp;{{ @$firstQuestion->testResult->studentTestPaper->total_marks ?? 100 }} 
                                                    </b> Marks
                                                </h6>
                                            </span>
                                        </li>

                                        <div class="clearfix"></div>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <ul class="qsa_optns qsa_optns_v2 row">
                                        <li class="col-md-12 mt-3">
                                            <div class="optn_bbx">
                                                <input type="radio" @if (@$firstQuestion->is_correct == 2) checked @endif name="asnwer" id="asnwer_a" value="0">
                                                <label id='2' class="@if (@$firstQuestion->is_correct == 2) selectedAns @endif"><span>A.</span> Incorrect = 0%</label>
                                            </div>
                                        </li>
                                        <li class="col-md-12">
                                            <div class="optn_bbx">
                                                <input type="radio" @if (@$firstQuestion->is_correct == 3) checked @endif name="asnwer" id="asnwer_a" value="1">
                                                <label id='3' class="@if (@$firstQuestion->is_correct == 3) selectedAns @endif"><span>B.</span> Fairly Correct = 25%</label>
                                            </div>
                                        </li>
                                        <li class="col-md-12">
                                            <div class="optn_bbx">
                                                <input type="radio" @if (@$firstQuestion->is_correct == 4) checked @endif name="asnwer" id="asnwer_a" value="2">
                                                <label id='4' class="@if (@$firstQuestion->is_correct == 4) selectedAns @endif"><span>C.</span> Half Correct = 50%</label>
                                            </div>
                                        </li>
                                        <li class="col-md-12">
                                            <div class="optn_bbx">
                                                <input type="radio" @if (@$firstQuestion->is_correct == 5) checked @endif name="asnwer" id="asnwer_a" value="3">
                                                <label id='5' class="@if (@$firstQuestion->is_correct == 5) selectedAns @endif"><span>D.</span> Mostly Correct = 75%</label>
                                            </div>
                                        </li>
                                        <li class="col-md-12">
                                            <div class="optn_bbx">
                                                <input type="radio" @if (@$firstQuestion->is_correct == 1) checked @endif name="asnwer" id="asnwer_a" value="4">
                                                <label id='1' class="@if (@$firstQuestion->is_correct == 1) selectedAns @endif"><span>E.</span> Fully Correct = 100%</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <ul class="action_lst">

                                        <li class="prev-btn-li">
                                            <button type="button" class="btn prvs_btn" disabled
                                            data-current_index='0' data-next_index = '1' data-prev_index = ''>Previous Question</button>
                                        </li>

                                        <li class="next-btn-li">

                                            <button type="button" class="btn nxt_btn nxt_qus" id="btn"
                                                data-subject_id="{{ @$subject_id }}" data-btn_type="next-sub-question"
                                                data-current_question_id="{{ @$firstQuestion->id }}"
                                                data-current_index = '0'
                                                data-next_index = '1'
                                                data-prev_index = ''
                                                data-current_sub_question_id="{{ @$firstQuestion->id }}"
                                                data-prev_sub_question_id="{{ @$prevQuestionId }}"
                                                data-next_sub_question_id="{{ @$nextQuestionId }}"
                                                data-prev_question_id="{{ @$prevQuestionId }}"
                                                data-mock_test_id="{{ @$mockTestPaper->id }}"
                                                data-next_question_id="{{ @$nextQuestionId }}"
                                                {{ @$nextQuestionId == '' || @$nextQuestionId == null ? 'disabled' : '' }}
                                                data-current_question_number='{{ @$questionNo }}'
                                                data-next_question_number='{{ @$nextQuestionNo }}'
                                                data-prev_question_number=''>Next Question</button>

                                        </li>

                                        <li class="float-right cmplt-mock">
                                            <button type="button" class="btn cmplt_btn" data-subject_id="{{ @$subject_id }}" data-mock_test_id="{{ @$mockTest->id }}">Complete Evaluation</button>
                                        </li>
                                        <div class="clearfix"></div>
                                    </ul>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12 pt-5">
                            <div class="col-md-12">
                                <ul class="clr_info_lst">
                                    {{-- <li><span class="ans_crcl"></span>Attempted</li> --}}
                                    <li><span class="ans_unnsrd"></span>Reviewed</li>
                                </ul>
                            </div>
                            <div class="questsn_side_menu">
                                <div class="qustn_title">
                                    <h3 class="qs_h3 blue_clr_txt">Questions:</h3>
                                </div>
                                <div class="question_list_scn" id="previewQuestionList">
                                    @forelse($previewQuestionList??[] as $qKey => $sectionQuestionList)
                                        @if(isset($previewQuestionList) && count($previewQuestionList) > 1)
                                        <div class="font-weight-bold mb-3">{{@$sectionQuestionList['section']}}</div>
                                        @endif
                                        <ul>
                                            @forelse(@$sectionQuestionList['data']??[] as $qKey => $previewQuestion)
                                            @php
                                                $class2 = '';
                                                if(@$previewQuestion['mark_as_review'] == 1){
                                                    $class = 'yellow_review_actv';
                                                }elseif(@$previewQuestion['is_attempted']== 1){
                                                    // $class = 'active_green';
                                                    $class = '';
                                                }else{
                                                    $class = '';
                                                }
                                                if(@$previewQuestion['question_id'] == @$firstQuestion->id){
                                                    $class2 = 'font-weight-bold';
                                                    $questionIndex = $qKey; 
                                                }
                                            @endphp
                                            <li class="quest_lst_n {{$class.' '.$class2}}" data-index="{{$qKey}}">
                                                <span class="q_counter_num {{$class2}}">{{@$previewQuestion['q_no']}}</span>
                                                {{@shortContent($previewQuestion['question'],120)}}
                                            </li>
                                            @empty
                                            @endforelse
                                        </ul>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--close inner content-->
    </div>
    <div class="modal fade def_modal lgn_modal" data-backdrop="static" data-keyboard="false" id="CompleteMockExamModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3>{{__('frontend.complete_eval_lbl')}}</h3>
                    <div class="mc_pp_bx">
                        <div class="row">
                            <div class="col-md-12 mc_d_b">
                                <div class="d-md-flex align-items-center">
                                    <img src="{{@$mockTest->image_path}}" class="mx-wd-95 img-fluid mck-tst-img">
                                    <div class="row">
                                        <div class="mdl_txt mck-tst-title mdl_txt mck-tst-title col-md-12"><span class='font-weight-bold text-dark'> {{__('formname.mock_test_id')}}</span> : {!! @$mockTest->title !!} </div>
                                        <div class="mdl_txt mck-tst-title mdl_txt mck-tst-title col-md-12"><span class='font-weight-bold text-dark'> {{__('formname.paper')}}</span> : {{ @$mockTestPaper->name }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 inline_action mrgn_tp_15">
                                <div class="mb-4">{{__('frontend.confirm_paper_evaluate')}}</div>
                                <a href='javascript:;' class="drk_blue_btn section_review_btn" data-dismiss="modal" aria-label="Close">{{__('formname.review_lbl')}}</a>
                                <a href="javascript:;" type="button" class="btn submit_btn cmplt_mck">{{__('formname.submit')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('pageJs')
    <script src="{{asset('js/pdf.min.js')}}"></script>
    <script src="{{asset('js/pdf.worker.js')}}"></script>
    <script src="{{asset('js/pdf-creator.js')}}"></script>
    <script type="text/javascript">
        initializePdf();
        var ajaxNextQuestionUrl = "{{ route('seval-ajax-next-question') }}";
        var markQuestionUrl = "{{ route('seval-mark-question-answer') }}";
        var completeMockUrl = "{{ route('seval-complete-mock-marking') }}"
        var student_id = "{{ @$student_id }}";
        var student_test_result_id = "{{ @$firstQuestion->student_test_result_id }}";
        var questionUrl = "{{route('evaluate.go.to.question')}}";
        var redirectUrl = null;
        $('.quest-title').find('.showImg').on('click',function(){
            $('.quest-title').find('.questionFullImg').show();
        })
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
    </script>
    <script src="{{asset('newfrontend/js/student/evaluate_mock.js')}}"></script>
@stop
