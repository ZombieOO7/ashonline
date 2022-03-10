@extends('newfrontend.layouts.default')
@section('title',__('frontend.parentmock.purchase'))
@section('content')

<!--inner content-->
<div class="container mrgn_bt_40">
      <div class="row">
        <div class="col-md-12 prfl_ttl">
          <h3>Validate Answers</h3>
        </div>
        <div class="col-md-12">
          <div class="mn_qs_bx">
            <div class="row">
              <div class="col-md-12">
                <div class="float-left">
                  <h3 class="qs_h3">Section 1</h3>
                </div>
                <div class="float-right">
                  <ul class="ex_tp_dtls">
                    <li>
                      <h4>Total Sections : 1</h4>
                    </li>
                    <li>
                      <label>Mock Exam</label>
                      <p>GL Mock Exam 1</p>
                    </li>
                    
                  </ul>
                </div>
                
              </div>
              <div class="col-md-12">
                <ul class="ex_bt_dtls">
                  <li>
                    <span class="ul_in_info ex_i_01">
                      <h6>80</h6>
                      <label>Questions</label>
                    </span>
                  </li>
                  <li>
                    <span class="ul_in_info ex_i_02">
                      <h6>78</h6>
                      <label>Attempted</label>
                    </span>
                  </li>
                  <!-- <li class="float-right">
                    <span class="ul_in_info ex_i_03">
                      <h6>00:45:00</h6>
                      <label>Time Left</label>
                    </span>
                  </li> -->
                  <div class="clearfix"></div>
                </ul>
              </div>
              <div class="col-md-12">
                <form class="qstn_form">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="in_qstn_box">
                        <h3><span>Q 1.</span> Circle the most appropriate unit of measure for the following:</h3>
                        <div class="inin_qstn_box">
                          <h4 class="mrgn_bt_0">The length of an airplane</h4>
                          <!-- <ul class="qsa_optns">
                            <li>
                              <h6>a. millimetres</h6>
                            </li>
                            <li>
                              <h6>b. centimetres</h6>
                            </li>
                            <li>
                              <h6>c. kilometres</h6>
                            </li>
                            <li>
                              <h6>d. metres</h6>
                            </li>
                          </ul> -->
                          <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="ans_bx_v2">
                        <h4>Answer</h4>
                        <div class="ans_bxx">d. metres </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <h6 class="mrk_ttl">Mark Question Here</h6>
                    </div>
                    <div class="col-md-12">
                      <ul class="ex_bt_dtls">
                        <li>
                          <span class="ul_in_info ex_i_06">
                            <h6>01 out of 80</h6>
                            <label>Marks Obtained</label>
                          </span>
                        </li>
                        
                        <div class="clearfix"></div>
                      </ul>
                    </div>
                    <div class="col-md-12">
                      <ul class="qsa_optns qsa_optns_v2 row">
                        <li class="col-md-5">
                          <div class="optn_bbx">
                            <input type="radio" name="asnwer" id="asnwer_a">
                            <label><span>a.</span> Incorrect = 0%</label>
                          </div>
                        </li>
                        <li class="col-md-5">
                          <div class="optn_bbx">
                            <input type="radio" name="asnwer" id="asnwer_a">
                            <label><span>b.</span> Fairly Correct = 25%</label>
                          </div>
                        </li>
                        <li class="col-md-5">
                          <div class="optn_bbx">
                            <input type="radio" name="asnwer" id="asnwer_a">
                            <label><span>c.</span> Half Correct = 50%</label>
                          </div>
                        </li>
                        <li class="col-md-5">
                          <div class="optn_bbx">
                            <input type="radio" name="asnwer" id="asnwer_a">
                            <label><span>d.</span> Mostly Correct = 75%</label>
                          </div>
                        </li>
                        <li class="col-md-5">
                          <div class="optn_bbx">
                            <input type="radio" name="asnwer" id="asnwer_a">
                            <label><span>e.</span> Fully Correct = 100%</label>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-12">
                      <ul class="action_lst">
                        <li>
                          <button type="button" class="btn prvs_btn">Previous Question</button>
                        </li>
                        <li>
                          <button type="button" class="btn nxt_btn">Next Question</button>
                        </li>
                        
                        <li class="float-right">
                          <button type="button" class="btn cmplt_btn" disabled>Complete Mock</button>
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
        </div>
      </div>
    </div>
    <!--close inner content-->
@php
@endphp
@stop