@extends('newfrontend.layouts.default')
@section('title', __('frontend.exam'))
@section('content')
    <div class="container mrgn_bt_40">
        <div class="row">
            <div class="col-md-12 prfl_ttl">
                <h3 class="mt-3">{{ @$practiceExam->title }}</h3>
            </div>
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mn_qs_bx">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="ex_bt_dtls">
                                        <li>
                                            <span class="ul_in_info ex_i_01">
                                                <h6>
                                                    <span>{{__('frontend.questions')}}</span> 
                                                    <span class='questionNo' data-questionNo="1">1</span> 
                                                    <span>of</span>{{ @$studentTestResult->questions }}
                                                </h6>
                                            </span>
                                        </li>
                                        <div class="clearfix"></div>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <form class="qstn_form">
                                        <div class="row questionContent">
                                            <div class="col-md-12">
                                                <div class="in_qstn_box">
                                                    <div class="inin_qstn_box">
                                                        @if(@$question->instruction != null)
                                                            {!! @$question->instruction !!}
                                                        @endif
                                                        {!!@$question->question !!}
                                                        @if(($question->image != null))
                                                            <div>
                                                                @if($question->resize_full_image)
                                                                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                                                                        {!! @$question->resize_full_image !!}
                                                                    </span>
                                                                @else
                                                                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                                                                        <img class="img-fluid mb-3" src="{{@$question->image_path}}">
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @php
                                                            $alphabet = ord("A");
                                                        @endphp
                                                        <input type="hidden" name='question_list_id' value="{{@$question->id}}" id='questionListId'>
                                                        <input type="hidden" name='practice_test_question_answer_id' value="{{@$testQuestionAnswer->id}}" id='testQuestionAnswerId'>
                                                        @if(@$question->type == 4)
                                                            @php
                                                                $inputType = 'checkbox';
                                                                $answers = @$question->answers??[];
                                                            @endphp
                                                            <div class="col-md-12 row">
                                                                <div class="col-md-6">
                                                                    <ul class="qsa_optns">
                                                                        @forelse ($answers as $akey => $ans)
                                                                            @if($akey < 3)
                                                                                <li>
                                                                                    <div class="optn_bbx">
                                                                                        <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer" id="answer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                                        data-correctAnswerId="{{@$question->correctAnswer->id}}" @if(in_array(@$ans->id,@$testQuestionAnswer->selected_answers)) checked @endif>
                                                                                        <label class="optn_lble">
                                                                                            @if($inputType == 'checkbox')
                                                                                                <span class="checkbx_square fa fa-check-square"></span>
                                                                                            @else
                                                                                                <span class="checkbx_rund"></span>
                                                                                            @endif
                                                                                            <span>{{chr($alphabet)}}.</span>
                                                                                            {!! @$ans->answer !!}
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                                @php $alphabet++; @endphp
                                                                            @endif
                                                                        @empty
                                                                        @endforelse
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <ul class="qsa_optns">
                                                                        @forelse ($answers as $akey => $ans)
                                                                            @if($akey > 2)
                                                                                <li>
                                                                                    <div class="optn_bbx">
                                                                                        <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer" id="answer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                                        data-correctAnswerId="{{@$question->correctAnswer->id}}" @if(in_array(@$ans->id,@$testQuestionAnswer->selected_answers)) checked @endif>
                                                                                        <label class="optn_lble">
                                                                                            @if($inputType == 'checkbox')
                                                                                                <span class="checkbx_square fa fa-check-square"></span>
                                                                                            @else
                                                                                                <span class="checkbx_rund"></span>
                                                                                            @endif
                                                                                            <span>{{chr($alphabet)}}.</span>
                                                                                            {!! @$ans->answer !!}
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                                @php $alphabet++; @endphp
                                                                            @endif
                                                                        @empty
                                                                        @endforelse
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @else
                                                            @php
                                                                if(@$question->answer_type == 2){
                                                                    $inputType = 'checkbox';
                                                                }else{
                                                                    $inputType = 'radio';
                                                                }
                                                            @endphp
                                                            <ul class="qsa_optns">
                                                            @forelse ($question->answers??[] as $ans)
                                                                <li>
                                                                    <div class="optn_bbx">
                                                                        <input class="answer" type="{{$inputType}}" value="{{@$ans->id}}" name="answer[]" id="answer_{{chr($alphabet)}}" data-testQuestionAnswerId="{{@$testQuestionAnswer->id}}" data-answerId="{{@$ans->id}}" 
                                                                        data-correctAnswerId="{{@$question->correctAnswer->id}}" @if(in_array(@$ans->id,@$testQuestionAnswer->selected_answers)) checked @endif>
                                                                        <label class="optn_lble">
                                                                            @if($inputType == 'checkbox')
                                                                                <span class="checkbx_square fa fa-check-square"></span>
                                                                            @else
                                                                                <span class="checkbx_rund"></span>
                                                                            @endif
                                                                            <span>{{chr(@$alphabet)}}.</span>
                                                                            {!! @$ans->answer !!}
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                @php $alphabet++; @endphp
                                                            @empty
                                                            @endforelse
                                                            </ul>
                                                        @endif
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <ul class="action_lst">
                                                    <li>
                                                        <button type="button" class="btn prvs_btn previousQuestion" disabled data-index="null">{{__('frontend.previous_question')}}</button>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="btn nxt_btn nextQuestion" @if($nextQuestionId == null) disabled @endif 
                                                        data-id="{{@$testQuestionAnswer->id}}" data-index="1" data-questionId="{{@$nextQuestionId}}">{{__('frontend.next_question')}}</button>
                                                    </li>
                                                    <li class="float-right">
                                                        <button type="button" class="btn cmplt_btn completeBtn" data-index="null" data-id="{{@$testQuestionAnswer->id}}" @if($nextQuestionId != null) disabled @endif>{{__('frontend.submit')}}</button>
                                                    </li>
                                                    <div class="clearfix"></div>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12 text-right mt-4 mb-3">
                                <button type="button" data-toggle="modal" data-target='reportProblemModal' class="btn prvs_btn rprt_btn"><img src="{{asset('practice/images/flag_ic.png')}}" alt="">{{__('frontend.report_problem')}}</button>
                            </div>
                            <div class="inf_bx_wpdng col-md-12">
                                <h4 class="mrgn_bt_15">Note :</h4>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                                    tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam,
                                    quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
                                    consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie
                                    consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto
                                    odio</p>
                            </div>
                        </div> --}}


                    </div>

                </div>

            </div>
            <div class="col-xl-3" id="previewQuestionList">
                <ul class="qsrslt_lst">
                    @forelse($previewQuestionList as $qKey => $previewQuestion)
                        @php
                            $class2 = '';
                            if($previewQuestion['mark_as_review'] == 1){
                                $class = 'yellow_review_actv';
                            }elseif($previewQuestion['is_attempted']== 1){
                                $class = 'active_green';
                            }else{
                                $class = '';
                            }
                            if($previewQuestion['question_id'] == @$question->id){
                                $class2 = 'font-weight-bold';
                            }
                        @endphp
                        <li class="goToQuestion cursor-pointer {{$class.' '.$class2}}" 
                            data-index="{{$qKey}}" data-questionNo="{{$qKey+1}}" 
                            data-id="{{@$testQuestionAnswer->id}}" data-questionId="{{$previewQuestion['id']}}">
                            <span class="{{$class2}}">{{@$qKey+1}}</span>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="modal fade def_modal lgn_modal" id="CompleteMockExamModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3>{{__('frontend.complete_paper')}}</h3>
                    <p class="mrgn_bt_40">{{__('frontend.sure_complete_paper')}}</p>
                    <div class="mc_pp_bx">
                        <div class="row">
                            <div class="col-md-12 mc_d_b">
                                <div class="d-md-flex align-items-center">
                                    <h3 class="mt-3">{{@$practiceExam->title}}</h3>
                                </div>
                            </div>
                            <div class="col-md-12 inline_action mrgn_tp_15">
                                <a role="button" class="btn submit_btn submitPaper" href="{{route('topic.submit-paper',['resultId'=>@$studentTestResult->uuid])}}">{{__('frontend.submit')}}</a>
                                {{-- <a role="button" class="btn submit_btn reviewPaper btn_rvw" href="{{route('topic.review-paper',['resultId'=>@$studentTestResult->uuid])}}">{{__('frontend.review_now')}}</a> --}}
                            </div>
                        </div>
    
                    </div>
                </div>
    
            </div>
        </div>
    </div>
    <div class="modal fade def_modal lgn_modal" id="reportProblemModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3>{{__('frontend.report_problem')}}</h3>
                    <form class="def_form" id='reportProblem' aria-label="{{ __('frontend.login') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="description" class="form-control" placeholder="Enter Problem" id="problem" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" class="btn submit_btn submitReport">{{__('frontend.submit')}}
                                        <div class="lds-ring" style="display:none;">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
    
            </div>
        </div>
    </div>
@stop
@section('pageJs')
    <script>
        var storeAnswerUrl = "{{route('topic.store-answer')}}";
        var goToQuestionUrl = "{{route('topic.go-to-question')}}";
        var nextQuestionUrl = "{{route('topic.next-question')}}";
        var previousQuestionUrl = "{{route('topic.previous-question')}}";
        // disable page refresh and and back button
        var reportProblemUrl = '{{route("report-problem")}}';
        var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
        var getReportProblemUrl = '{{route("get-topic-report-problem")}}';
        $(document).on('click','.rprt_btn',function(){
            $(".main_loader").css("display", "block");
            var questionId = $(document).find('#questionListId').val();
            var testQuestionAnswerId = $(document).find('#testQuestionAnswerId').val();
            $.ajax({
                url:getReportProblemUrl,
                method:'POST',
                data:{
                    practice_test_question_answer_id:testQuestionAnswerId,
                    question_list_id:questionId,
                    project_type:3,
                },
            success:function(response){
                $(".main_loader").css("display", "none");
                $('#reportProblemModal').modal('show');
                if(response.status=='success'){
                    $(document).find('#problem').val(response.data.description);
                }else{
                    $(document).find('#problem').val('');
                }
            },
            error: function () {
            }
        });
    })
    $(document).on('click','.submitReport',function(){
        if($(document).find('#reportProblem').valid()){
            $('.lds-ring').show();
            var questionId = $(document).find('#questionListId').val();
            var description = $(document).find('#problem').val();
            var testQuestionAnswerId = $(document).find('#testQuestionAnswerId').val();
            $.ajax({
                url:reportProblemUrl,
                method:'POST',
                data:{
                    practice_test_question_answer_id:testQuestionAnswerId,
                    question_list_id:questionId,
                    description:description,
                    project_type:3,
                },
                success:function(response){
                    $('.lds-ring').hide();
                    toastr.success(response.msg);
                    $('#reportProblemModal').modal('hide');
                },
                error: function () {
                }
            })
        }
    })
    </script>
    <script src="{{asset('frontend/practice/js/topic_exam.js')}}"></script>
@stop