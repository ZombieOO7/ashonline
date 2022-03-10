@extends('newfrontend.layouts.default')
@section('title', __('frontend.practice'))
@section('content')
    <!--inner content-->
    <section class="banner_sc_v1">
        <div id="BannerIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#BannerIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#BannerIndicators" data-slide-to="1"></li>
                <li data-target="#BannerIndicators" data-slide-to="2"></li>
                {{-- <li data-target="#BannerIndicators" data-slide-to="3"></li> --}}
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active" style="background: url({{ asset('practice/images/prct_b_01.png') }});">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="banner_content">
                                {!!@$emockSliderSection->slider_1_title!!}
                                {!!@$emockSliderSection->slider_1_sub_title!!}
                                <ul class="bnr_in_list">
                                    {!! @$emockSliderSection->slider_1_description !!}
                                </ul>
                                <a href="{{route('parent-sign-up')}}" class="btn btn_join">Join Us</a>
                            </div>
                        </div>
                        <div class="col-md-5 text-right d-flex align-items-end">
                            <img src="{{ asset('practice/images/prct_b_img_01.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="background: url({{ asset('practice/images/prct_b_03.png') }});">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="banner_content">
                                {!! @$emockSliderSection->slider_2_title !!}
                                {!! @$emockSliderSection->slider_2_description !!}
                                <a href="{{route('parent-sign-up')}}" class="btn btn_join">Join Us</a>
                            </div>
                        </div>
                        <div class="col-md-5 text-right d-flex align-items-end">
                            <img src="{{ asset('practice/images/prct_b_img_02.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="background: url({{ asset('practice/images/prct_b_02.png') }});">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="banner_content">
                                {!! @$emockSliderSection->slider_3_title !!}
                                <ul class="bnr_in_list">
                                    {!! @$emockSliderSection->slider_3_description !!}
                                </ul>
                                <a href="{{route('parent-sign-up')}}" class="btn btn_join">Join Us</a>
                            </div>
                        </div>
                        <div class="col-md-5 text-right d-flex align-items-end">
                            <img src="{{ asset('practice/images/prct_b_img_03.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>

                {{-- <div class="carousel-item" style="background: url({{ asset('practice/images/prct_b_01.png') }});">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="banner_content">
                                <h1>Lorem ipsum dolor sit amet, <br><strong>E-Papers</strong> <strong class="d_bl">
                                        Online</strong>sit amet</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                    ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                    reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>

                                <a href="{{route('parent-sign-up')}}" class="btn btn_join">Join Us</a>
                            </div>
                        </div>
                        <div class="col-md-5 text-right d-flex align-items-end">
                            <img src="{{ asset('practice/images/prct_b_img_04.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div> --}}

            </div>

        </div>
    </section>
    <!-- <section class="banner_sc">
          <div class="container">
            <div class="banner_content">
              <h1>An <strong class="d_bl">Online</strong> <strong>Portal</strong> To Help <br>Your Kids Achieve Their Goals!</h1>
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat</p>
              <a href="#" class="btn btn_join">Join Us</a>
            </div>
          </div>
        </section> -->
    <section class="mlt_sc">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3 wt_h3">{!! @$homeOurModules->title !!}</h3>
                    <span class="df_pp wt_p">{!! @$homeOurModules->content !!}</span>
                </div>
                <div class="col-lg-4">
                    <div class="wt_info_box">
                        <div class="top_dlfx">
                            <img src="{{ asset('practice/images/as_ppr.png') }}" class="img-fluid rsp_sml" alt="" title="">
                            <img src="{{ asset('practice/images/ash_wkl_a_ic.png') }}" class="img-fluid" alt="" title="">
                        </div>
                        <div class="inn_wt_info">
                            <h4>{!! @$homeOurModules->title_1 !!}</h4>
                            <a href="{{route('parent-sign-up')}}" class="stts_btn stts_fl">Payable</a>
                            {!! @$homeOurModules->content_1 !!}
                            <a href="javascript:;" class="ash_lgn_btn practiceExam" data-url="{{route('weekly-assessments')}}">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="wt_info_box">
                        <div class="top_dlfx">
                            <img src="{{ asset('practice/images/as_mkexms.png') }}" class="img-fluid rsp_sml" alt=""
                                title="">
                            <img src="{{ asset('practice/images/ash_tpc_a_ic.png') }}" class="img-fluid" alt="" title="">
                        </div>
                        <div class="inn_wt_info">
                            <h4>{!! @$homeOurModules->title_2 !!}</h4>
                            <a href="{{route('parent-sign-up')}}" class="stts_btn stts_sccss">Free Access</a>
                            {!! @$homeOurModules->content_2 !!}
                            <a href="javascript:;" class="ash_lgn_btn practiceExam" data-url="{{route('topic-list')}}">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="wt_info_box">
                        <div class="top_dlfx">
                            <img src="{{ asset('practice/images/as_prctc.png') }}" class="img-fluid rsp_sml" alt=""
                                title="">
                            <img src="{{ asset('practice/images/ash_pstppr_ic.png') }}" class="img-fluid" alt="" title="">
                        </div>
                        <div class="inn_wt_info">
                            <h4>{!! @$homeOurModules->title_3 !!}</h4>
                            <a href="#" class="stts_btn stts_sccss">Free Access</a>
                            {!! @$homeOurModules->content_3 !!}
                            <a href="javascript:;" class="ash_lgn_btn">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="abt_as_sc">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>{{@$homeAboutAsh->title}}</h3>
                    <img src="{{ asset('practice/images/qt_img.png') }}" class="img-fluid rsp_sml" alt="" title="">
                </div>
                <div class="col-md-8 about_info" id="counter">
                    {!! @$homeAboutAsh->content !!}
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="abt_ic_bx">
                                <span class="abticon abt_ic_1"></span>
                                <h5 class="counter-value" data-count="{{@$homeAboutAsh->subject_title_1}}">0</h5>
                                <h6>Total Practice Papaers</h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="abt_ic_bx">
                                <span class="abticon abt_ic_2"></span>
                                <h5 class="counter-value" data-count="{{@$homeAboutAsh->subject_title_2}}">0</h5>
                                <h6>Total Practice Questions</h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="abt_ic_bx">
                                <span class="abticon abt_ic_4"></span>
                                <h5 class="counter-value" data-count="{{@$homeAboutAsh->subject_title_3}}">0</h5>
                                <h6>Practice Papers</h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="abt_ic_bx">
                                <span class="abticon abt_ic_5"></span>
                                <h5 class="counter-value" data-count="{{@$homeAboutAsh->subject_title_4}}">0</h5>
                                <h6>Happy Customers</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="howmuchtopay_sc">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3">{{@$homePaySection->title}}</h3>
                    <p class="df_pp">{!! @$homePaySection->content !!}</p>
                </div>
                <div class="col-md-12">
                    <div class="brderbx">
                        <div class="row align-items-center">
                            <div class="col-md-5 text-center hmtp_info_lft">
                                <img src="{{ asset('practice/images/hmctpy_img.png') }}" class="img-fluid" alt="" title="">
                            </div>
                            <div class="col-md-7 hmtp_info_rt">
                                <h3>{{@$homePaySection->slider_1_title}}</h3>
                                <h6>{{@$homePaySection->slider_1_sub_title}}</h6>
                                <h4 class="mb-4">{{@$homePaySection->sub_title}}</h4>
                                <ul class="list_w_ckbx">
                                    {{@$homePaySection->slider_1_description}}
                                </ul>
                                <a href="{{route('parent-sign-up')}}" class="ash_lgn_btn btn_smll">BUY NOW</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="whychooss_sc">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3">{{@$homeWhyChooseAsh->title}}</h3>
                    <p class="df_pp">{!! @$homeWhyChooseAsh->content !!}</p>
                </div>
                <div class="col-md-4 whychooss_info">
                    <i class="wcs_ic wc_crc1"></i>
                    <h4>{{@$homeWhyChooseAsh->title_1}}</h4>
                    {!! @$homeWhyChooseAsh->content_1 !!}
                </div>
                <div class="col-md-4 whychooss_info">
                    <i class="wcs_ic wc_crc2"></i>
                    <h4>{{@$homeWhyChooseAsh->title_2}}</h4>
                    {!! @$homeWhyChooseAsh->content_2 !!}
                </div>
                <div class="col-md-4 whychooss_info">
                    <i class="wcs_ic wc_crc3"></i>
                    <h4>{{@$homeWhyChooseAsh->title_3}}</h4>
                    {!! @$homeWhyChooseAsh->content_3 !!}
                </div>
                <div class="col-md-4 whychooss_info">
                    <i class="wcs_ic wc_crc4"></i>
                    <h4>{{@$homeWhyChooseAsh->title_4}}</h4>
                    {!! @$homeWhyChooseAsh->content_4 !!}
                </div>
                <div class="col-md-4 whychooss_info">
                    <i class="wcs_ic wc_crc5"></i>
                    <h4>{{@$homeWhyChooseAsh->title_5}}</h4>
                    {!! @$homeWhyChooseAsh->content_5 !!}
                </div>
                <div class="col-md-4 whychooss_info">
                    <i class="wcs_ic wc_crc6"></i>
                    <h4>{{@$homeWhyChooseAsh->title_6}}</h4>
                    {!! @$homeWhyChooseAsh->content_6 !!}
                </div>

            </div>
        </div>
    </section>

    <section class="mdl_sc">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="video-container">
                        <div class="js-load-video-medium" data-service="youtube" data-placeholder=""
                            data-embed="{{@$homeVideoSection->video_url}}">
                            <a href="#" class="btn btn__large btn__green btn__notext btn__modal--play"
                                title="Video afspelen"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 vrtcl_algn_mddl">
                    <div class="vdcontent">
                        <h6>{{@$homeVideoSection->title}}</h6>
                        {!! @$homeVideoSection->content !!}
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <h3 class="df_h3">Parents Are Happy & So Their Kids</h3>
                </div>
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-md-11 tsmnls_crsl">
                            <div id="TestimonialsIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#TestimonialsIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#TestimonialsIndicators" data-slide-to="1"></li>
                                    <li data-target="#TestimonialsIndicators" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_1.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Leo Gill</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_2.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Gugu Mbatha-Raw</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_3.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Andrew Kumar</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_4.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Alison Brie</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_1.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Leo Gill</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_2.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Gugu Mbatha-Raw</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_1.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Leo Gill</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_2.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Gugu Mbatha-Raw</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_3.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Andrew Kumar</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_4.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Alison Brie</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_1.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Leo Gill</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_2.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Gugu Mbatha-Raw</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_1.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Leo Gill</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_2.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Gugu Mbatha-Raw</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_3.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Andrew Kumar</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_4.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Alison Brie</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_1.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Leo Gill</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="crsl_box">
                                                    <img src="{{ asset('practice/images/test_2.png') }}"
                                                        class="tstmnls_img" alt="" title="">
                                                    <h4>Gugu Mbatha-Raw</h4>
                                                    <div class="fixedStar fixedStar_readonly" data-score='3' readonly></div>
                                                    <p class="more">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis</p>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="wehelp_sc">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="df_h3">{{@$homeHelpSection->title}}</h3>
                    <p class="df_pp">{!! @$homeHelpSection->content !!} </p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mn_hlp_bx">
                        <h3>{{@$homeHelpSection->title_1}}</h3>
                        <div class="inn_hlp_bx">
                            {!! @$homeHelpSection->content_1 !!}
                            <h5>01.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mn_hlp_bx">
                        <h3>{{@$homeHelpSection->title_2}}</h3>
                        <div class="inn_hlp_bx">
                            {!! @$homeHelpSection->content_2 !!}
                            <h5>02.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mn_hlp_bx">
                        <h3>{{@$homeHelpSection->title_3}}</h3>
                        <div class="inn_hlp_bx">
                            {!! @$homeHelpSection->content_3 !!}
                            <h5>03.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mn_hlp_bx">
                        <h3>{{@$homeHelpSection->title_4}}</h3>
                        <div class="inn_hlp_bx">
                            {!! @$homeHelpSection->content_4 !!}
                            <h5>04.</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--close inner content-->
@stop
@section('pageJs')
    <script>
        var loginMsg = "{{__('frontend.login_msg')}}";
        //////counter
        var a = 0;
        $(window).scroll(function() {
            var oTop = $('#counter').offset().top - window.innerHeight;
            if (a == 0 && $(window).scrollTop() > oTop) {
                $('.counter-value').each(function() {
                    var $this = $(this),
                        countTo = $this.attr('data-count');
                    $({
                        countNum: $this.text()
                    }).animate({
                            countNum: countTo
                        },

                        {

                            duration: 2000,
                            easing: 'swing',
                            step: function() {
                                $this.text(Math.floor(this.countNum));
                            },
                            complete: function() {
                                $this.text(this.countNum);
                                //alert('finished');
                            }

                        });
                });
                a = 1;
            }

        });
        (function($) {
            $('.js-load-video-medium').joldLoadVideo({
                youtubeThumbSize: 'maxresdefault'
            });
        })(jQuery);

        $(function() {
            $(document).find('.fixedStar_readonly').raty({
                readOnly: true,
                path: '{{ asset('newfrontend/images/') }}',
                starOff: 'star-off.svg',
                starOn: 'star-on.svg',
                start: $(document).find(this).attr('data-score')
            });
        });
        $(function(){
            $('.practiceExam').on('click',function(){
                if(cartFlag == 'false'){
                    toastr.error(loginMsg);
                }else{
                    var redirectUrl = $(this).attr('data-url');
                    window.location.href.replace(redirectUrl);
                }
            })
        })
    </script>
@endsection
