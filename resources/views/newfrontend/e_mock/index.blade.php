@extends('newfrontend.layouts.default')
@section('title',__('frontend.emock.title'))
@section('content')
@php
    $routeArray = [
        [
            'title' => __('frontend.emock.title'),
            'route' => route('e-mock'),
        ],
    ];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    @php
        $isParent = isParent();
    @endphp
    <section class="top_link_scn mt-4">

        @if(Auth::guard('parent')->user() == null || Auth::guard('parent')->user()['is_tuition_parent'] == 0)

            <div class="container text-center text-md-center">
                @forelse(@$examBoardEveryOne??[] as $key => $board)
                    <a href="{{ route('emock-exam',['slug'=>@$board->slug]) }}"
                       class="e-mck-btn">{{ @$board->title }}</a>
                @empty
                @endforelse
            </div>
        @elseif(Auth::guard('parent')->user()['is_tuition_parent'] == 1)
            <div class="container text-center text-md-center">
                @forelse(@$examBoardBoth??[] as $key => $boards)
                    <a href="{{ route('emock-exam',['slug'=>@$boards->slug]) }}"
                       class="e-mck-btn">{{ @$boards->title }}</a>
                @empty
                @endforelse
            </div>
        @endif

 </section>
    {{-- @if(Auth::guard('parent')->user() == null)
        <section class="main_banner">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 bnr-md-3"><img src="{{ asset('newfrontend/images/banner_1.png') }}"
                                                        alt="left image"
                                                        title="left image" class="img-fluid"></div>
                    <div class="col-md-3 bnr-md-3 bnrordr3 text-md-right"><img
                            src="{{ asset('newfrontend/images/banner_2.png') }}" alt="left image" title="left image"
                            class="img-fluid"></div>
                    <div class="col-md-6 bnr-md-6 text-center bnr-content align-self-center">
                        {!!@$emockSliderSection->slider_1_title!!}
                        {!!@$emockSliderSection->slider_1_description!!}
                        <a href="{{route('emock-categories')}}" class="btn btn-primary lets_try_btn">Let’s Try</a>
                    </div>
                </div>
            </div>
        </section>
    @else --}}
        <section class="main_banner banner_sc_v1 banner_sc_v2">
            <div id="BannerIndicators" class="carousel slide" data-ride="carousel" data-interval="100000">
                <ol class="carousel-indicators">
                    <li data-target="#BannerIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#BannerIndicators" data-slide-to="1"></li>
                    <li data-target="#BannerIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{asset('newfrontend/images/emc_bnr_1.jpg')}}" alt="" class="img-fluid bn_img">
                        <div class="row">
                            <div class="col-md-4 bnr-md-4"></div>
                            <div class="col-md-7 bnr-md-7 bnr_content_v2 bnr-content d-flex align-items-center">
                                <div class="cnnt_bbx">
                                    {!!@$emockSliderSection->slider_1_title!!}
                                    <p class="bnr_s_p">
                                        <ul class="bnr_inflist bnr_inflist_v2">
                                            {!!@$emockSliderSection->slider_1_description!!}
                                        </ul>
                                    </p>
                                    <a href="{{route('emock-categories')}}" class="btn btn-primary lets_try_btn">Let’s Try</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="carousel-item" style="background: url(images/bnnr_3.jpg);">
                        <img src="{{asset('newfrontend/images/emc_bnr_3.jpg')}}" alt="" class="img-fluid bn_img">
                        <div class="row">
                            <div class="col-md-4 bnr-md-4"></div>
                            <div class="col-md-7 bnr-md-7 bnr_content_v2 bnr-content d-flex align-items-center">
                                <div class="cnnt_bbx">
                                    {!!@$emockSliderSection->slider_2_title!!}
                                    <p class="bnr_s_p">
                                        <ul class="bnr_inflist bnr_inflist_v2">
                                            {!!@$emockSliderSection->slider_2_description!!}
                                        </ul>
                                    </p>
                                    <a href="{{route('emock-categories')}}" class="btn btn-primary lets_try_btn">Let’s Try</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="carousel-item" style="background: url(images/bnnr_2.jpg);">
                        <img src="{{asset('newfrontend/images/emc_bnr_2.jpg')}}" alt="" class="img-fluid bn_img">
                        <div class="row">
                            <div class="col-md-4 bnr-md-4"></div>
                            <div class="col-md-7 bnr-md-7 bnr_content_v2 bnr-content d-flex align-items-center">
                                <div class="cnnt_bbx">
                                    {!!@$emockSliderSection->slider_3_title!!}
                                    <p class="bnr_s_p">
                                        <ul class="bnr_inflist bnr_inflist_v2">
                                            {!!@$emockSliderSection->slider_3_description!!}
                                        </ul>
                                    </p>
                                    <a href="#" class="btn btn-primary lets_try_btn">Let’s Try</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    {{-- @endif --}}
    <section class="mock_papers">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3 mdl_tilte">{!! @$emockPaperSection->title !!}</h3>
                    <p class="df_pp">{!! @$emockPaperSection->content !!}</p>
                </div>
                @if(Auth::guard('parent')->user() == null || Auth::guard('parent')->user()['is_tuition_parent'] == 0)
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-11">
                                <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                                    @forelse($examBoardEveryOne??[] as $key => $board)
                                        <li class="nav-item" data-href='{{route('emock-exam',['slug'=>@$board->slug])}}'>
                                            <a class="nav-link e-mck-btn {{($key==0)?'active':''}}"
                                               id="pills-{{@$board->slug}}-tab" data-toggle="pill"
                                               href="#pills-{{$board->slug}}" role="tab"
                                               aria-controls="pills-{{@$board->slug}}"
                                               aria-selected="true" data-href='{{route('emock-exam',['slug'=>@$board->slug])}}'>{{ @$board->title }}</a>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                                <div class="tab-content  mt-5 mb-5" id="pills-tabContent">
                                    @forelse($examBoardEveryOne??[] as $key => $board)
                                        <div class="tab-pane fade {{($key==0)?'show active':''}}"
                                             id="pills-{{@$board->slug}}" role="tabpanel"
                                             aria-labelledby="pills-{{@$board->slug}}-tab">
                                            <div class="rspnsv_table">
                                                <table class="table-bordered table-striped table-condensed cf">
                                                    <thead class="cf">
                                                    <tr>
                                                        <th class="img_hd">{{__('formname.mock.image')}}</th>
                                                        <th>{{__('formname.mock.exam_name')}}</th>
                                                        <th>{{__('formname.mock.date')}}</th>
                                                        <th>{{__('formname.duration')}}</th>
                                                        <th>{{__('formname.mock.price')}}</th>
                                                        @if($isParent==true)
                                                            <th>{{__('formname.mock.action')}}</th>
                                                        @endif
                                                    </tr>
                                                    <tr class="middle_hdng_rw">
                                                        <th colspan="6" align="center">{{__('frontend.emock.mock_exams')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($board->relatedMockTestsLogin as $mkey => $mockTest)
                                                        <tr>
                                                            <td data-title="Images">
                                                                <a href="{{ route('mock-detail', @$mockTest->uuid ) }}">
                                                                    <img src="{{@$mockTest->image_path}}"
                                                                         class="mx-wd-95" width="100px" height="100px">
                                                                </a>
                                                            </td>
                                                            <td data-title="Exam Name">
                                                                <div>{{ @$mockTest->title }}</div>
                                                                <a href="{{ route('mock-detail', @$mockTest->uuid ) }}" class="text-primary">
                                                                    {{__('formname.view_detail')}}
                                                                </a>
                                                            </td>
                                                            <td data-title="Date">
                                                                {{ @$mockTest->proper_start_date_and_end_date }}
                                                            </td>
                                                            <td data-title="Time">
                                                                {{$mockTest->total_paper_time}}
{{--                                                                {{ $mockTest->mockTestSubjectTime->proper_time}}--}}
                                                            </td>
                                                            <td data-title="Price">{{config('constant.default_currency_symbol')}}
                                                                {{@$mockTest->price}}</td>
                                                            @if($isParent==true)
                                                                <td data-title="Action" class="min-wd-140">
                                                                    <a href="javascript:;"
                                                                    data-url="{{route('emock-add-to-cart')}}"
                                                                    data-mock_id="{{ @$mockTest->id }}"
                                                                    class="add_to_cart addToCart">{{__('formname.mock.add_to_cart')}}</a>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6">
                                                                <center>{{__('formname.records_not_found')}}</center>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endforeach
                                </div>
                                <div class="viw_all_scn text-center">
                                    <a href="javascript:;"
                                       class="btn btn_join viewAll">{{__('formname.mock.view_all')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif(Auth::guard('parent')->user()['is_tuition_parent'] == 1)
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-11">
                                <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                                    @forelse($examBoardBoth??[] as $key => $board)
                                        <li class="nav-item">
                                            <a class="nav-link e-mck-btn {{($key==0)?'active':''}}"
                                               id="pills-{{@$board->slug}}-tab" data-toggle="pill"
                                               href="#pills-{{$board->slug}}" role="tab"
                                               aria-controls="pills-{{@$board->slug}}"
                                               aria-selected="true">{{ @$board->title }}</a>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                                <div class="tab-content  mt-5 mb-5" id="pills-tabContent">
                                    @forelse($examBoardBoth??[] as $key => $board)
                                        <div class="tab-pane fade {{($key==0)?'show active':''}}"
                                             id="pills-{{@$board->slug}}" role="tabpanel"
                                             aria-labelledby="pills-{{@$board->slug}}-tab">
                                            <div class="rspnsv_table">
                                                <table class="table-bordered table-striped table-condensed cf">
                                                    <thead class="cf">
                                                    <tr>
                                                        <th class="img_hd">{{__('formname.mock.image')}}</th>
                                                        <th>{{__('formname.mock.exam_name')}}</th>
                                                        <th>{{__('formname.mock.date')}}</th>
                                                        <th>{{__('formname.duration')}}</th>
                                                        <th>{{__('formname.mock.price')}}</th>
                                                        <th>{{__('formname.mock.action')}}</th>
                                                    </tr>
                                                    <tr class="middle_hdng_rw">
                                                        <th colspan="6"
                                                            align="center">{{__('frontend.emock.mock_exams')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($board->relatedMockTests as $mkey => $mockTest)
                                                        <tr>
                                                            <td data-title="Images">
                                                                <a href="{{ route('mock-detail', @$mockTest->uuid ) }}">
                                                                    <img src="{{@$mockTest->image_path}}" class="mx-wd-95" width="100px" height="100px">
                                                                </a>
                                                            </td>
                                                            <td data-title="Exam Name">
                                                                <div>{{ @$mockTest->title }}</div>
                                                                <a href="{{ route('mock-detail', @$mockTest->uuid ) }}" class="text-primary">
                                                                    {{__('formname.view_detail')}}
                                                                </a>
                                                            </td>
                                                            <td data-title="Date">
                                                                {{ @$mockTest->proper_start_date_and_end_date }}
                                                            </td>
                                                            <td data-title="Time">
                                                                {{$mockTest->total_paper_time}}
{{--                                                                {{ $mockTest->mockTestSubjectTime->proper_time}}--}}
                                                            </td>
                                                            <td data-title="Price">{{config('constant.default_currency_symbol')}}
                                                                {{@$mockTest->price}}</td>
                                                            <td data-title="Action" class="min-wd-140">
                                                                <a href="javascript:;"
                                                                   data-url="{{route('emock-add-to-cart')}}"
                                                                   data-mock_id="{{ @$mockTest->id }}"
                                                                   class="add_to_cart addToCart">{{__('formname.mock.add_to_cart')}}</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6">
                                                                <center>{{__('formname.records_not_found')}}</center>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endforeach
                                </div>
                                <div class="viw_all_scn text-center">
                                    <a href="{{route('emock-categories')}}"
                                       class="btn btn_join">{{__('formname.mock.view_all')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <section class="how_mck_exm_wrk">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3 mdl_tilte">{{@$emockExamWorkSection->title}}</h3>
                    <p class="df_pp">{{@$emockExamWorkSection->content}}</p>
                </div>
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-md-11">
                            <div class="video-container">
                                <div class="js-load-video-medium" data-service="youtube" data-placeholder=""
                                    data-embed="{{@$emockExamWorkSection->video_url}}">
                                    <a href="#" class="btn btn__large btn__green btn__notext btn__modal--play"
                                       title="Video afspelen"></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="qustn_prepr">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('newfrontend/images/left_questn.png') }}" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <h3 class="df_h3 mdl_tilte">{{@$emockQuestionSection->title}}</h3>
                    <p class="df_pp ml-0">{{@$emockQuestionSection->content}}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="child_perfomnce">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3 mdl_tilte">{{@$emockChildSection->title}}</h3>
                    <p class="df_pp">{{@$emockChildSection->content}}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="keep_track_child">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 left_pdng_cmn right_pdng_cmn align-self-center">
                    <h3 class="df_h3 mdl_tilte">{{@$emockChildSection->title_1}}</h3>
                    <p class="df_pp ml-0">{{@$emockChildSection->content_1}}</p>
                </div>
                <div class="col-md-6  p-0 text-right">
                    <img src="{{ asset('newfrontend/images/keep_child.png') }}" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </section>
    <section class="knw_yr_child">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 p-0 align-self-end">
                    <img src="{{ asset('newfrontend/images/know_yr_chld.png') }}" class="img-fluid w-100">
                </div>
                <div class="col-md-6 left_pdng_cmn right_pdng_cmn right_knw_child">
                    <h3 class="df_h3 mdl_tilte">{{@$emockChildSection->title_2}}</h3>
                    <p class="df_pp ml-0">{{@$emockChildSection->content_2}}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="mdl_sc">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3 mdl_tilte">Parents Are Happy & So Their Kids</h3>
                </div>
                @include('newfrontend.testinomial')
            </div>
        </div>
    </section>
    @section('pageJs')
    <script>
        var rateImagePath = '{{asset("newfrontend/images")}}';
        var href = $("ul.nav-pills li a.active").attr('data-href');
        $(document).find(".viewAll").attr('href',href);
        $('.nav-item').on('click',function(){
            var href = $(this).attr('data-href');
            $(document).find(".viewAll").attr('href',href);
        })
    </script>
    <script src="{{asset('newfrontend/js/landing.js')}}"></script>
    @endsection
@stop
