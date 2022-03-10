@extends('newfrontend.layouts.default')
@section('title', __('frontend.view_question'))
@section('content')
    <div class="container mrgn_bt_40">
        <div class="row">
            <div class="col-md-12 frtp_ttl">
                <nav class="bradcrumb_pr" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @include('newfrontend.practice.bradcrumb')
                        <li class="breadcrumb-item active" aria-current="page">{{ __('frontend.result') }}</li>
                    </ol>
                </nav>
            </div>

            <div class="col-md-12 prfl_ttl">
                <h3 class="mt-3">{{ __('frontend.result') }}</h3>
            </div>
            <div class="col-md-12">
                <div class="mn_qs_bx">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-left">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>{{__('formname.child_id')}}</label>
                                        <p>{{ @$student->child_id_text }}</p>
                                    </li>
                                    <li>
                                        <label>{{ __('frontend.name') }}</label>
                                        <p>{{ @$student->full_name }}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="float-right">
                                <ul class="ex_tp_dtls">
                                    <li>
                                        <label>{{ __('frontend.attempt') }}</label>
                                        <p>{{@$totalAttemptCount}}</p>
                                    </li>
                                    <li>
                                        <label>{{ __('frontend.assessment_name') }}</label>
                                        <p>{{ @$testAssessment->title }}</p>
                                    </li>
                                    <li>
                                        <label>{{ __('frontend.date') }}</label>
                                        <p>{{ @$result->proper_date }}</p>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <ul class="ex_bt_dtls ex_bt_dtls_v2">
                                <li>
                                    <span class="ul_in_info ex_i_01">
                                        <h6>{{ @$result->questions }}</h6>
                                        <label>{{ __('frontend.questions') }}</label>
                                    </span>
                                </li>
                                <li>
                                    <span class="ul_in_info ex_i_02">
                                        <h6>{{ @$result->attempted }}</h6>
                                        <label>{{ __('frontend.attempted') }}</label>
                                    </span>
                                </li>
                                <li>
                                    <span class="ul_in_info ex_i_04">
                                        <h6>{{ @$result->correctly_answered }}</h6>
                                        <label>{{ __('frontend.correctly_answered') }}</label>
                                    </span>
                                </li>
                                <li>
                                    <span class="ul_in_info ex_i_05">
                                        <h6>{{ @$result->unanswered }}</h6>
                                        <label>{{ __('frontend.unanswered') }}</label>
                                    </span>
                                </li>

                                <li class="float-right">
                                    <span class="ul_in_info_v1">
                                        <label>{{ __('frontend.marks') }}</label>
                                        <h6>{{ __('frontend.out_of_marks', ['obtained_marks' => @$result->obtained_marks, 'total_mark' => @$result->total_marks]) }}
                                        </h6>
                                    </span>
                                </li>
                                <li class="float-right">
                                    <span class="ul_in_info_v1">
                                        <label>{{ __('frontend.overall_result') }}</label>
                                        <h6>{{ __(@$result->overall_result) }}</h6>
                                    </span>
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                            <div class="rtng_b_box">
                                <img src="images/mlt_str.png" alt="">
                                <h4><span>{{ __('frontend.your_rank') }}</span></h4>
                                <h4><b>{{ @$result->rank }}</b><span> out of {{ @$totalTest }}</span></h4>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mrks_box mrks_box_v2">
                                <h3>{{ __('frontend.question_analysis') }}</h3>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                                    tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim </p>
                                <ul class="mrk_list">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse($testQuestionAnswers as $key => $questionAnswer)
                                        @php
                                            $class = '';
                                            if ($questionAnswer->is_attempted == 1) {
                                                if ($questionAnswer->is_correct == 0) {
                                                    $class = 'incorrectly';
                                                }
                                            } else {
                                                $class = 'unanswered';
                                            }
                                        @endphp
                                        <li class="{{ $class }} mr-1">
                                            <a class="text-white questionDiv nav-link pt-0 pb-0 @if($key==0)active @endif" id="question{{@$questionAnswer->id}}-tab" data-toggle="tab"
                                                href="#question{{@$questionAnswer->id}}" role="tab" aria-controls="question{{@$questionAnswer->id}}" aria-selected="true">
                                                Q{{$i}}
                                            </a>
                                        </li>
                                        @php
                                            $i++;
                                        @endphp
                                    @empty
                                    @endforelse
                                </ul>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <ul class="clr_info_lst">
                                <li><span class="ans_crcl"></span>{{ __('frontend.answered_correctly') }}</li>
                                <li><span class="ans_incrcl"></span>{{ __('frontend.answered_incorrectly') }}</li>
                                <li><span class="ans_unnsrd"></span>{{ __('frontend.unanswered') }}</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="mrks_box mrks_box100">
                                <h3>{{ __('formname.answers') }}</h3>
                                <p class="mrgn_bt_30">{{ __('formname.check_answer_label') }}</p>
                                <div class="col-md-12 row mb-2" id="examData">
                                    @if(isset($question->questionData->questionPdfs) && $question->questionData->questionPdfs->question_pdf !=null)
                                        <div class="pdfApp border" data-index="00" data-src="{{@$question->questionData->questionPdfs->question_pdf}}">
                                            <div id="viewport-container00" class="viewport-container" data-index="00"><div role="main" class="viewport" id="viewport00" data-index="00"></div></div>
                                        </div>
                                    @endif
                                </div>
                                {{-- <div class="col-md-12 row mb-2">
                                    <a href="{{route('show-guidance')}}">
                                        <button type="button" class="btn submit_btn">{{__('formname.show_guidance')}}</button>
                                    </a>
                                </div> --}}
                                {{-- <div class="rspnsv_table result_table">
                                    <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd "
                                        cellspacing="10">
                                        <thead>
                                            <tr>
                                                <th>{{ __('formname.q_no') }}</th>
                                                <th>{{ __('formname.questions') }}</th>
                                                <th class="thc_3">{{ __('formname.q_topic') }}</th>
                                                <th class="thc_4">{{ __('formname.your_ans') }}</th>
                                                <th class="thc_5">{{ __('formname.correct_answer') }}</th>
                                                <th class="thc_6">{{ __('formname.result') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php $count = 1; @endphp
                                            @forelse (@$testQuestionAnswers as $key => $studentTestQuestionAnswer)
                                                @php
                                                    $correctImage = 'ys_ic.png';
                                                    if ($studentTestQuestionAnswer->is_correct == 1) {
                                                        $correctImage = 'ys_ic.png';
                                                    } else {
                                                        $questionColor = '';
                                                        $correctImage = 'wrng_ic.png';
                                                    }
                                                @endphp

                                                <tr>
                                                    <td data-title="Q No." class="text-center">{{ $count }}</td>
                                                    <td data-title="Questions">
                                                        {{ @$studentTestQuestionAnswer->questionList->question }}</td>
                                                    <td data-title="Topic">
                                                        {{ @$studentTestQuestionAnswer->question->topic->title }}</td>
                                                    <td data-title="Your Answer">
                                                        {{ @$studentTestQuestionAnswer->answer->answer }}</td>
                                                    <td data-title="Correct Answer">
                                                        {{ @$studentTestQuestionAnswer->questionList->correctAnswer->answer }}
                                                    </td>
                                                    <td data-title="Result"><img src="{{ asset('images/' . @$correctImage) }}">
                                                    </td>
                                                </tr>
                                                @php $count++; @endphp
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">{{ __('formname.question_not_found') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form class="qstn_form">
                                <div class="row tab-content" id="pills-tabContent">
                                    @php
                                        $j = 1;
                                    @endphp
                                    @forelse($testQuestionAnswers as $key=> $question)
                                    <div class="col-md-12 tab-pane fade show @if($key==0) active @endif" id="question{{@$question->id}}" role="tabpanel"
                                        aria-labelledby="question{{@$question->id}}-tab">
                                        <div class="in_qstn_box" >
                                            @if(@$question->questionList->instruction != null)
                                                <h3>{!! @$question->questionList->instruction !!}</h3>
                                            @endif
                                            <h3><span>Q{{ @$question->questionList->question_no }}.</span>{!! @$question->questionList->question !!}</h3>
                                            @if(isset($question->image) && ($question->image != null))
                                                <img class="img-fluid mb-3" src="{{@$question->image_path}}" width="auto" height="300px" >
                                            @endif
                                            <div class="inin_qstn_box mt-3">
                                                @if(@$question->questionData->question_type == 1)
                                                @php
                                                    $alphabet = ord("A");
                                                @endphp
                                                <ul class="qsa_optns">
                                                    @forelse(@$question->questionList->answers as $answer)
                                                    @php
                                                    $class='';
                                                    // if(@$answer->is_correct == 1){
                                                        // $class='correctAns';
                                                    if(in_array($answer->id,$question->selected_answers) && @$answer->is_correct == 1){
                                                        // $class='inCorrectAns';
                                                        $class='correctAns';
                                                    }elseif(in_array($answer->id,$question->selected_answers)){
                                                        $class='inCorrectAns';
                                                    }else{
                                                        $class='unread_tr';
                                                    }
                                                    @endphp
                                                    <li>
                                                        <div class="optn_bbx">
                                                            <input type="radio" disabled name="asnwer" id="asnwer_{{chr($alphabet)}}" @if(in_array($answer->id,$question->selected_answers)) checked @endif>
                                                            <label class='{{$class}}'><span>{{chr($alphabet)}}</span> {{ @$answer->answer }}</label>
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
                                    @php
                                        $j++;
                                    @endphp
                                    @empty
                                    @endforelse
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pageJs')
<script>
    /*profile-upload*/
    $(document).ready(function() {
        $('.optn_bbx input[type="radio"]').change(function(){
            if ($(this).is(':checked')) {
                $(".action_lst li button").removeAttr("disabled");
            } else {
                $(".action_lst li button").attr( "disabled", "disabled" );
            }
        });
    });
    $(document).on('click','.questionDiv',function(){
        var targetDiv = $('#pills-tabContent');
        targetDiv.find('.active').removeClass('active');
        var target = $(this).attr('href');
        $(target).addClass('show');
        $(target).addClass('active');
        if (target.length) {
            $('html,body').animate({
                scrollTop: targetDiv.offset().top - 100
            }, 1000);
            // return false;
        }
    });
</script>
@endsection
