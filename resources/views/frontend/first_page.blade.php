@extends('frontend.layouts.default')
@section('title','Home')
@section('content')
<div class="all_subjects_sc">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <h4 class="def_ttitle">
                  <strong>Websites</strong>
                </h4>
            </div>
            <div class="col-md-11">
                <div class="row">
                    <div class="col-sm-6 col-lg-3 text-center sbjcts_cntnt">
                    </div>
                    <div class="col-sm-6 col-lg-3 text-center sbjcts_cntnt">
                        <div class="box_i"><span class="ash-none-verbal-reasoning"></span></div>
                        <h4><a href="{{ url('/epaper') }}">E-Papers</a></h4>
                    </div>
                    <div class="col-sm-6 col-lg-3 text-center sbjcts_cntnt">
                        <div class="box_i"><span class="ash-verbal-reasoning"></span></div>
                        <h4><a href="javascript:void(0)">E-Mock</a></h4>
                    </div>
                    <div class="col-sm-6 col-lg-3 text-center sbjcts_cntnt">
                </div>
            </div>
        </div>
      </div>
    </div>
</div>    
@endsection
