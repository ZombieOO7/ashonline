@extends('newfrontend.layouts.default')
@section('title',__('frontend.parentmock.purchase'))
@section('content')
<!--inner content-->
<div class="container mrgn_bt_40">
      <div class="row">
        <div class="col-md-12 prfl_ttl">
          <h3>Result</h3>
        </div>
        <div class="col-md-12">
          <div class="mn_qs_bx">
            <div class="row">
              <div class="col-md-12">
                <div class="float-left">
                  <ul class="ex_tp_dtls">
                    <li>
                      <label>Name</label>
                      <p>Natalia Raikova</p>
                    </li>
                  </ul>
                </div>
                <div class="float-right">
                  <ul class="ex_tp_dtls">
                    <li>
                      <label>Attempt</label>
                      <p></p>
                    </li>
                    <li>
                      <label>Exam Name</label>
                      <p></p>
                    </li>
                    <li>
                      <label>Exam ID</label>
                      <p>{{ $mock_test_id}}</p>
                    </li>
                    <li>
                      <label>Date</label>
                      <p></p>
                    </li>
                  </ul>
                </div>
                
              </div>
              <div class="col-md-12">
                <ul class="ex_bt_dtls ex_bt_dtls_v2">
                  <li>
                    <span class="ul_in_info ex_i_01">
                      <h6>{{ $totalQuestions }}</h6>
                      <label>Questions</label>
                    </span>
                  </li>
                  <li>
                    <span class="ul_in_info ex_i_02">
                      <h6>{{ $totalQuestionAttempted }}</h6>
                      <label>Attempted</label>
                    </span>
                  </li>
                  <li>
                    <span class="ul_in_info ex_i_04">
                      <h6>{{ $correctlyAnswered }}</h6>
                      <label>Correctly Answered</label>
                    </span>
                  </li>
                  <li>
                    <span class="ul_in_info ex_i_05">
                      <h6>-</h6>
                      <label>Unanswered</label>
                    </span>
                  </li>
                  
                  <li class="float-right">
                    <span class="ul_in_info_v1">
                      <label>Marks</label>
                      <h6>{{ $totalMarksObtained }} out of {{ $totalMarks }}</h6>
                    </span>
                  </li>
                  <li class="float-right">
                    <span class="ul_in_info_v1">
                      <label>Overall Result</label>
                      <h6>-</h6>
                    </span>
                  </li>
                  <div class="clearfix"></div>
                </ul>
                <div class="rtng_b_box">
                  <img src="images/mlt_str.png" alt="">
                  <h4><span>Your Ranking</span></h4>
                  <!-- <h4><b>06</b><span> out of 1023</span></h4> -->
                  <h4><b>-</b><span> </span></h4>
                </div>
              </div>
              <div class="col-md-12">
               <div class="mrks_box">
                 <h3>Question Analysis</h3>
                 <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim </p>
                 <ul class="mrk_list">
                   <li>Q1</li>
                   <li>Q2</li>
                   <li>Q3</li>
                   <li>Q4</li>
                   <li>Q5</li>
                   <li>Q6</li>
                   <li>Q7</li>
                   <li class="unanswered">Q8</li>
                   <li>Q9</li>
                   <li>Q10</li>
                   <li>Q11</li>
                   <li>Q12</li>
                   <li>Q13</li>
                   <li class="incorrectly">Q14</li>
                   <li>Q15</li>
                   <li>Q16</li>
                   <li>Q17</li>
                   <li>Q18</li>
                   <li>Q19</li>
                   <li class="incorrectly">Q20</li>
                   <li>Q21</li>
                   <li>Q22</li>
                   <li>Q23</li>
                   <li>Q24</li>
                   <li>Q25</li>
                   <li>Q26</li>
                   <li>Q27</li>
                   <li>Q28</li>
                   <li>Q29</li>
                   <li>Q30</li>
                   <li>Q31</li>
                   <li>Q32</li>
                   <li>Q33</li>
                   <li>Q34</li>
                   <li>Q35</li>
                   <li>Q36</li>
                   <li>Q37</li>
                   <li>Q38</li>
                   <li>Q39</li>
                   <li class="incorrectly">Q40</li>
                   <li>Q41</li>
                   <li>Q42</li>
                   <li>Q43</li>
                   <li>Q44</li>
                   <li>Q45</li>
                   <li>Q46</li>
                   <li>Q47</li>
                   <li>Q48</li>
                   <li>Q49</li>
                   <li class="unanswered">Q50</li>
                   <li>Q51</li>
                   <li>Q52</li>
                   <li>Q53</li>
                   <li>Q54</li>
                   <li>Q55</li>
                   <li>Q56</li>
                   <li>Q57</li>
                   <li>Q58</li>
                   <li>Q59</li>
                   <li>Q60</li>
                 </ul>
               </div>
              </div>
              <div class="col-md-12">
                <ul class="clr_info_lst">
                  <li><span class="ans_crcl"></span>Answered Correctly</li>
                  <li><span class="ans_incrcl"></span>Answered Incorrectly</li>
                  <li><span class="ans_unnsrd"></span>Unanswered</li>
                </ul>
               </div>
               <div class="col-md-12">
                  <div class="mrks_box">
                    <h3>Answers</h3>
                    <p>Want to check the answers for the questions you didn’t attempt and the wrong answered ones?</p>
                    <button type="submit" class="btn submit_btn">View Questions</button>
                  </div>
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