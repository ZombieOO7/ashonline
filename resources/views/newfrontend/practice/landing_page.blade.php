@extends('newfrontend.layouts.default')
@section('title', __('frontend.practice'))
@section('content')
@php
    $routeArray = [
        [
            'title' => __('frontend.practice'),
            'route' => route('practice'),
        ],
    ];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
@php
$parentData = parentData();
$parent = @$parentData[0];
$isParent = @$parentData[1];
@endphp
    <section class="mock_papers">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3 mdl_tilte">{{@$homePracticeSection->title}}</h3>
                    <p class="df_pp w-960">{!! @$homePracticeSection->content !!}</p>
                </div>
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-xl-11">
                            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                                @if($isParent== true)
                                    @forelse(@$parent->childs as $key => $child)
                                        <li class="nav-item">
                                            <a class="nav-link e-mck-btn e-mck-btn-child @if($studentId==$child->id)active @endif" href="{{route('practice-home',['studentId'=>@$child->uuid])}}">
                                                <span class="pbwa_ic pbwa_ic01" style="background: url('{{@$child->image_thumb}}') !important;background-size: 50px !important;border-radius: 25px;"></span>
                                                {{@$child->full_name}}
                                            </a>
                                        </li>
                                    @empty
                                    @endforelse
                                @endif
                            </ul>
                            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                                @forelse($subjects as $key => $subject)
                                    <li class="nav-item">
                                        <a class="nav-link e-mck-btn e-mck-btn-v2 @if($key==0)active @endif" id="{{@$subject->slug}}-tab" data-toggle="pill"
                                            href="#{{@$subject->slug}}" data-url='{{route('weekly-assessments',['slug'=>@$subject->slug,'studentId'=>@$uuid])}}' role="tab" aria-controls="{{@$subject->slug}}" aria-selected="true">
                                            <span class="pbwa_ic pbwa_ic01"></span>
                                            {{@$subject->title}}
                                        </a>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                            <div class="col-md-12 mt-3">
                                <ul class="clr_info_lst">
                                    <li><span class="ans_crcl"></span>Current Week</li>
                                    <li><span class="ans_unnsrd"></span>Last Two Week</li>
                                    <li><span class="ans_incrcl"></span>Expired</li>
                                </ul>
                            </div>
                            <div class="tab-content mt-4 mb-4" id="pills-tabContent">
                                @forelse($subjects as $key => $subject)
                                    <div class="tab-pane fade show @if($key==0)active @endif" id="{{@$subject->slug}}" role="tabpanel"
                                        aria-labelledby="{{@$subject->slug}}-tab">
                                        <div class="rspnsv_table rspnsv_table_allinfo">
                                            <table
                                                class="table-bordered table-striped table-condensed cf v-align-bottom sm_txt_tbl">
                                                <thead class="cf">
                                                    <tr>
                                                        <th>{{__('frontend.papers_lbl')}}</th>
                                                        <th>{{__('frontend.issue_date')}}</th>
                                                        <th>{{__('frontend.attempt_by')}}</th>
                                                        <th>{{__('frontend.expiry_date')}}</th>
                                                        {{-- <th>{{__('frontend.practice_testAttempt_1')}}</th> --}}
                                                        <th>{{__('frontend.total_attempt_1')}}</th>
                                                        <th>{{__('frontend.out_of_attempt_1')}}</th>
                                                        <th>{{__('frontend.percentage_attempt_1')}}</th>
                                                        <th>{{__('frontend.total_attempt_1')}}</th>
                                                        <th>{{__('frontend.out_of_attempt_1')}}</th>
                                                        <th>{{__('frontend.percentage_attempt_1')}}</th>
                                                        <th>{{__('frontend.status')}}</th>
                                                        <th>{{__('frontend.action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($subject->threeWeeklyAssessment(@$studentId)??[] as $key => $weekAssessment)
                                                        <tr class="{{$weekAssessment->class}}">
                                                            @php
                                                                $studentTest = @$weekAssessment->studentAssessment($studentId);
                                                                $studentTestResult = @$studentTest->twoPracticeTestResult;
                                                                $firstResult = @$studentTestResult[0];
                                                                $secondResult = @$studentTestResult[1];
                                                                // $thirdResult = @$studentTestResult[2];
                                                            @endphp
                                                            <td data-title="Papers">{{@$weekAssessment->title}}</td>
                                                            <td data-title="Date">{{@$weekAssessment->start_date_month}}</td>
                                                            <td data-title="Date">{{@$weekAssessment->end_date_month}}</td>
                                                            <td data-title="Date">{{@$weekAssessment->expiry_date}}</td>
                                                            <td data-title="TotalAttempt 1">{{@$firstResult->total_marks ?? '-'}}</td>
                                                            <td data-title="Out ofAttempt 1">{{@$firstResult->obtained_marks ?? '-'}}</td>
                                                            <td data-title="PercentageAttempt 1">{{@$firstResult->overall_result_per ?? '-'}}</td>
                                                            <td data-title="TotalAttempt 2">{{@$secondResult->total_marks ?? '-'}}</td>
                                                            <td data-title="Out ofAttempt 2">{{@$secondResult->obtained_marks ?? '-'}}</td>
                                                            <td data-title="PercentageAttempt 2">{{@$secondResult->overall_result_per ?? '-'}}</td>
                                                            <td data-title="Status">
                                                                {{$weekAssessment->assessment_status}}
                                                            </td>
                                                            <td data-title="Action">
                                                                @if($firstResult == NULL || $secondResult == NULL)
                                                                    @if($weekAssessment->action_flag==true)
                                                                        <a href="{{route('assessments-detail',['testAssessmentId'=>@$weekAssessment->uuid])}}" class="btn btn-md btn-light text-white">{{__('frontend.start')}}</a>
                                                                    @endif
                                                                @endif
                                                                @if($firstResult != NULL)
                                                                    <a href="{{route('review-test-result',['uuid'=>@$studentTest->uuid])}}" class="tbl_btn @if($studentTestResult == null) unread_tr @endif">{{__('frontend.review_lbl')}}</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="15" class="">{{__('formname.records_not_found')}}</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            <div class="viw_all_scn text-center">
                                <a href='javascript:;' data-href="{{route('weekly-assessments',['uuid'=>$uuid])}}" class="btn btn_join viewAll">{{__('frontend.view_all')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="prctbytpc_sc mt-80">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3 mdl_tilte">{{@$homeTopicSection->title}} <span class="fn28"></span></h3>
                    <p class="df_pp w-960">{!! @$homeTopicSection->content !!}</p>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="wt_bx_wt_sdw">
                        <div class="mltc_head d-flex align-items-center">
                            <img src="{{asset('newfrontend/images/pctcbytpc_ic01.png')}}" alt="">
                            <h4>{{@$homeTopicSection->subject_title_1}}</h4>
                        </div>
                        <div class="mltc_info">
                            <p>{{@$homeTopicSection->subject_title_1_content}}<span>{{__('frontend.ash_question_bank')}}</span></p>
                            <a href="{{route('topic-list',['slug'=>'maths'])}}" class="btn btn_join">{{__('frontend.start')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="wt_bx_wt_sdw">
                        <div class="mltc_head d-flex align-items-center">
                            <img src="{{asset('newfrontend/images/pctcbytpc_ic01.png')}}" alt="">
                            <h4>{{@$homeTopicSection->subject_title_2}}</h4>
                        </div>
                        <div class="mltc_info">
                            <p>{{@$homeTopicSection->subject_title_2_content}}<span>{{__('frontend.past_paper_question')}}</span></p>
                            <a href="{{route('past-paper-list',['subject'=>'maths','grade'=>'eleven_plus'])}}" class="btn btn_join">{{__('frontend.start')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="wt_bx_wt_sdw">
                        <div class="mltc_head mltc_head_orng d-flex align-items-center">
                            <img src="{{asset('newfrontend/images/pctcbytpc_ic02.png')}}" alt="">
                            <h4>{{@$homeTopicSection->subject_title_3}}</h4>
                        </div>
                        <div class="mltc_info">
                            <p>{{@$homeTopicSection->subject_title_3_content}}<span>{{__('frontend.practice_english_lbl')}}</span></p>
                            <a href="{{route('topic-list',['slug'=>'english'])}}" class="btn btn_join">{{__('frontend.start')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="wt_bx_wt_sdw">
                        <div class="mltc_head mltc_head_bl d-flex align-items-center">
                            <img src="{{asset('newfrontend/images/pctcbytpc_ic03.png')}}" alt="">
                            <h4>{{@$homeTopicSection->subject_title_4}}</h4>
                        </div>
                        <div class="mltc_info">
                            <p>{{@$homeTopicSection->subject_title_4_content}}<span>{{__('frontend.ash_question_bank')}}</span></p>
                            <a href="{{route('topic-list',['slug'=>'vr'])}}" class="btn btn_join">{{__('frontend.start')}}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="prctbyppr_sc">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3 mdl_tilte">{{@$homePastPaperSection->title}}</h3>
                    <span class="df_pp w-960">{!! @$homePastPaperSection->content !!}</span>
                </div>
                <div class="col-xl-2"></div>
                <div class="col-xl-4 col-md-6">
                    <div class="wt_bx_wt_sdw">
                        <div class="mltc_head d-flex align-items-center">
                            <img src="{{asset('newfrontend/images/pctcbytpc_ic01.png')}}" alt="">
                            <h4>{{@$homePastPaperSection->subject_title_1}}</h4>
                        </div>
                        <div class="mltc_info">
                            {!! @$homePastPaperSection->subject_title_1_content !!}
                            <a href="{{route('past-paper-list',['subject'=>'maths','grade'=>'eleven_plus'])}}" class="btn btn_join">View Papers</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="wt_bx_wt_sdw">
                        <div class="mltc_head mltc_head_orng d-flex align-items-center">
                            <img src="{{asset('newfrontend/images/pctcbytpc_ic01.png')}}" alt="">
                            <h4>{{@$homePastPaperSection->subject_title_2}}</h4>
                        </div>
                        <div class="mltc_info">
                            {!! @$homePastPaperSection->subject_title_2_content !!}
                            <a href="{{route('past-paper-list',['subject'=>'english','grade'=>'eleven_plus'])}}" class="btn btn_join">View Papers</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
@stop
@section('pageJs')
<script>
    (function($){
          $('.js-load-video-medium').joldLoadVideo({youtubeThumbSize: 'maxresdefault'});
    })(jQuery);
    var base_url = "{{url('/')}}";
    $(function() {
        $(document).find('.fixedStar_readonly').raty({
            readOnly:  true,
            path    :  base_url+'/public/frontend/images',
            starOff : 'star-off.svg',
            starOn  : 'star-on.svg',
            start: $(document).find(this).attr('data-score')
        });
    });

    $(document).on('click','.viewAll',function(){
        var url = $(document).find(".e-mck-btn-v2.active").data('url');
        window.location.replace(url);
    })
</script>
@endsection