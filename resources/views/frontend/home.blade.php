@extends('frontend.layouts.default')
@section('title','Home')
@section('content')
<div class="main_banner">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 bnr-md-3"><img src="{{ asset('frontend/images/banner_1.jpg') }}" alt="banner 1 image" title="banner 1" class="img-fluid"></div>
        <div class="col-md-3 bnr-md-3 bnrordr3"><img src="{{ asset('frontend/images/banner_2.jpg') }}" alt="banner 2 image" title="banner 2" class="img-fluid"></div>
        <div class="col-md-6 bnr-md-6 text-center bnr-content">
          <h1>
              {!! @$homeBannerSection->title !!}
          </h1>
          <h2>{!! @$homeBannerSection->sub_title !!}<span>!</span></h2>
          <div class="bnr_inflist">
            {!! @$homeBannerSection->content !!}
          </div>
          <a href="{{ route('papers') }}" class="btn btn-primary btm-buy">Buy e-Papers</a>
          <p>{!! @$homeBannerSection->note !!}</p>
        </div>
      </div>
    </div>
  </div>
  <div class="banner_bottom_section">
    <div class="container">
      <div class="row">
        <div class="col-md-7">
          <h3 class="def_ttitle def_ttle_left exprtttl">
            <strong>{!! @$homeDesignedByExperts->title !!}</strong> {!! @$homeDesignedByExperts->sub_title !!}
            </h3>
            {!! @$homeDesignedByExperts->content !!}
        </div>
        <div class="col-md-5 d-flex align-items-end">
          <img src="{{ asset('frontend/images/expert_img.jpg') }}" alt="expert image" title="expert image" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
  <div class="all_subjects_sc">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12 text-center">
          <h4 class="def_ttitle">
              <strong>{!! @$homeAllSubjects->title !!}</strong>
          </h4>
        </div>
        <div class="col-md-11">
          <div class="row">
            <div class="col-sm-6 col-lg-3 text-center sbjcts_cntnt">
              <div class="box_i"><span class="ash-abc"></span></div>
              <h4>{!! @$homeAllSubjects->subject_title_1 !!}</h4>
              <p>
                {!! @$homeAllSubjects->subject_title_1_content !!}
              </p>
            </div>
            <div class="col-sm-6 col-lg-3 text-center sbjcts_cntnt">
              <div class="box_i"><span class="ash-verbal-reasoning"></span></div>
              <h4>{!! @$homeAllSubjects->subject_title_2 !!}</h4>
              <p>
                {!! @$homeAllSubjects->subject_title_2_content !!}
              </p>
            </div>
            <div class="col-sm-6 col-lg-3 text-center sbjcts_cntnt">
              <div class="box_i"><span class="ash-maths"></span></div>
              <h4>{!! @$homeAllSubjects->subject_title_3 !!}</h4>
              <p>
                {!! @$homeAllSubjects->subject_title_3_content !!}
              </p>
            </div>
            <div class="col-sm-6 col-lg-3 text-center sbjcts_cntnt">
              <div class="box_i"><span class="ash-none-verbal-reasoning"></span></div>
              <h4>{!! @$homeAllSubjects->subject_title_4 !!}</h4>
              <p>
                {!! @$homeAllSubjects->subject_title_4_content !!}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- <div class="counter_sc">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10" id="counter">
          <div class="row">
            <div class="col-sm-4 cntr_cntnt">
              <h5><span class="ash-subjects"></span> Subjects</h5>
              <h6>+<span class="counter-value" data-count="{{ @$subjectsCount }}">0</span></h6>
            </div>
            <div class="col-sm-4 cntr_cntnt">
              <h5><span class="ash-experience"></span> Years of Experience</h5>
              <h6>+<span class="counter-value" data-count="8">0</span></h6>
            </div>
            <div class="col-sm-4 cntr_cntnt">
              <h5><span class="ash-create"></span> Papers Created</h5>
              <h6>+<span class="counter-value" data-count="{{ @$papersCount }}">0</span></h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
  <div class="exam_formats_sc">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 text-center">
          <h4 class="def_ttitle"><strong> {!! @$homeExamFormats->title !!}</strong></h4>
        </div>
        <div class="col-md-6 frmt_cntnt frmt-lf">
          <div class="frmt_inn_cntnt">
            <h5>{!! @$homeExamFormats->exam_format_title_1 !!}</h5>
            <div class="exm_cnt">
              {!! @$homeExamFormats->exam_format_title_1_content !!}
            </div>
          </div>
        </div>
        <div class="col-md-6 frmt_cntnt frmt-rt">
          <div class="frmt_inn_cntnt">
            <h5>{!! @$homeExamFormats->exam_format_title_2 !!}</h5>
            <div class="exm_cnt">
              {!! @$homeExamFormats->exam_format_title_2_content !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="exam_style_sc">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h4 class="def_ttitle"><strong>{!! @$homeExamStyles->title !!}</strong></h4>
          <div class="def_p">
            {!! @$homeExamStyles->content !!}
          </div>
        </div>
        <div class="col-md-12 text-center">
          <img src="{{ asset('frontend/images/exam_style.jpg') }}" alt="exam style" title="exam style" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
@endsection
@section('pageJs')
  <script>
    // TODO::M2
    // var a = 0;
    // $(window).scroll(function() {
    //   var oTop = $('#counter').offset().top - window.innerHeight;
    //   if (a == 0 && $(window).scrollTop() > oTop) {
    //     $('.counter-value').each(function() {
    //       var $this = $(this),
    //         countTo = $this.attr('data-count');
    //         $({ countNum: $this.text() }).animate({ 
    //           countNum: countTo 
    //         },
    //         { duration: 2000, easing: 'swing',
    //           step: function() {
    //             $this.text(Math.floor(this.countNum));
    //           },
    //           complete: function() {
    //             $this.text(this.countNum);
    //           }
    //         });
    //     });
    //     a = 1;
    //   }
    // });
</script>
@endsection