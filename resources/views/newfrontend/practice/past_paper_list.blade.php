@extends('newfrontend.layouts.default')
@section('title', __('frontend.past-paper'))
@section('content')
<!--inner content-->
    <div class="main">
      <div class="prc_tp_bnr">
        <div class="row">
          <div class="col-lg-2 pr_b_l_img"></div>
          <div class="col-lg-4 pr_b_cl_prnt d-flex align-items-center">
            <div class="mx-475">
              <h1>AshACE Papers with Detailed <b>Answers</b></h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit lectus ac dolor rhoncus malesuada. Morbi at cursus odio. Morbi pulvinar libero a purus tincidunt pharetra. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit lectus ac dolor rhoncus malesuada. Morbi at cursus odio. Morbi pulvinar libero a purus tincidunt pharetra.</p>
            </div>
          </div>
          <div class="col-lg-4 pr_b_cr_prnt d-flex align-items-center">
            <div class="mx-475 text-center">
              <h4>
                Free 11+ Maths Past Papers with handwritten Answers
                <img src="{{asset('newfrontend/images/hnd_img.jpg')}}">
              </h4>
              <a href="#" class="btn btn_join btn_join_v2 mb-3 mr-2"><span class="btnic pdf_ic"></span>11 + Independent Paper 1 <img src="{{asset('newfrontend/images/arrow_ic.svg')}}" class="ml-1"></a>
              <a href="#" class="btn btn_join btn_join_v2 mb-3"><span class="btnic eye_ic"></span>Answers</a>
              <a href="#" class="btn btn_join btn_join_v2 mb-3 mr-2"><span class="btnic pdf_ic"></span>11 + Independent Paper 1 <img src="{{asset('newfrontend/images/arrow_ic.svg')}}" class="ml-1"></a>
              <a href="#" class="btn btn_join btn_join_v2 mb-3"><span class="btnic eye_ic"></span>Answers</a>
              <a href="#" class="btn btn_join btn_join_v2 mb-3 mr-2"><span class="btnic pdf_ic"></span>11 + Independent Paper 1 <img src="{{asset('newfrontend/images/arrow_ic.svg')}}" class="ml-1"></a>
              <a href="#" class="btn btn_join btn_join_v2 mb-3"><span class="btnic eye_ic"></span>Answers</a>
            </div>
            
          </div>
          <div class="col-lg-2 pr_b_r_img"></div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <nav class="bradcrumb_pr" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
              </ol>
            </nav>
          </div>
          <div class="col-md-12 mb-5">
            <div class="rrspnsvtbl_v2">
              <table class="table table-bordered blue_head_tbl">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Independent School Past Exam Papers</th>
                    <th>Question Paper</th>
                    <th>Detailed Answers</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>02</td>
                    <td><a href="#">City of London School for Girls – Maths sample paper</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>01</td>
                    <td><a href="#">Merchant Taylors – Maths Specimen Paper 2</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>03</td>
                    <td><a href="#">St Paul’s Girls School Sample Maths Paper 1 – 2017</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>04</td>
                    <td><a href="#">Haberdashers’ Aske’s Boys’ School (HABS) 11 Plus Maths Sample Paper – 2009</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>05</td>
                    <td><a href="#">Haberdashers’ Aske’s Boys’ School (HABS) 11 Plus Maths Sample Paper – 2011</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>06</td>
                    <td><a href="#">Merchant Taylors – Maths Specimen Paper 2</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>07</td>
                    <td><a href="#">City of London School for Girls – Maths sample paper</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>08</td>
                    <td><a href="#">St Paul’s Girls School Sample Maths Paper 1 – 2017</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>09</td>
                    <td><a href="#">Haberdashers’ Aske’s Boys’ School (HABS) 11 Plus Maths Sample Paper – 2009</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>10</td>
                    <td><a href="#">Haberdashers’ Aske’s Boys’ School (HABS) 11 Plus Maths Sample Paper – 2011</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-12 mb-5">
            <div class="rrspnsvtbl_v2">
              <table class="table table-bordered blue_head_tbl">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Independent & Grammar School Past Exam Papers</th>
                    <th>Question Paper</th>
                    <th>Detailed Answers</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>02</td>
                    <td><a href="#">City of London School for Girls – Maths sample paper</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>01</td>
                    <td><a href="#">Merchant Taylors – Maths Specimen Paper 2</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>03</td>
                    <td><a href="#">St Paul’s Girls School Sample Maths Paper 1 – 2017</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>04</td>
                    <td><a href="#">Haberdashers’ Aske’s Boys’ School (HABS) 11 Plus Maths Sample Paper – 2009</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>05</td>
                    <td><a href="#">Haberdashers’ Aske’s Boys’ School (HABS) 11 Plus Maths Sample Paper – 2011</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>06</td>
                    <td><a href="#">Merchant Taylors – Maths Specimen Paper 2</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>07</td>
                    <td><a href="#">City of London School for Girls – Maths sample paper</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>08</td>
                    <td><a href="#">St Paul’s Girls School Sample Maths Paper 1 – 2017</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>09</td>
                    <td><a href="#">Haberdashers’ Aske’s Boys’ School (HABS) 11 Plus Maths Sample Paper – 2009</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                  <tr>
                    <td>10</td>
                    <td><a href="#">Haberdashers’ Aske’s Boys’ School (HABS) 11 Plus Maths Sample Paper – 2011</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/denld_ic.svg')}}" class="mr-1 wt20">Download</a></td>
                    <td><a href="#"><img src="{{asset('newfrontend/images/lck_ic.svg')}}" class="mr-1 wt14">Answers</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--end inner content-->
@stop