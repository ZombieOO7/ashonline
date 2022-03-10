@extends('newfrontend.layouts.default')
@section('title', __('frontend.past-paper'))
@section('content')
    <div class="main">
        <div class="pq_tp_bnner">
            <div class="row">
                <div class="col-lg-8 pq_lf_sc align-items-center d-flex">
                    <h1><span>Geometry</span>Questions from all 11+ Exam Papers</h1>
                </div>
                <div class="col-lg-4 pq_rt_sc align-items-center d-flex justify-content-center">
                    <img src="{{asset('newfrontend/images/pq_arrow.svg')}}" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <nav class="bradcrumb_pr" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Practice By Past Paper</a></li>
                            <li class="breadcrumb-item"><a href="#">Merchant Taylors</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Maths Specimen Paper 2</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-lg-3 mb-5 sdbr_box sdbr_box_v2">
                    <div class="sdbx_bx_wt_sdw">
                        <div class="prfl_ttl">
                            <h3>
                                Segregated 11+ Maths Topics List
                                <a class="btn btn-dttgl" data-toggle="collapse" href="#SidebarMenu" role="button"
                                    aria-expanded="false" aria-controls="SidebarMenu"><span class="ash-menu"></span></a>
                                <div class="clearfix"></div>
                            </h3>

                        </div>
                        <div class="collapse" id="SidebarMenu">
                            <div class="card card-body">
                                <ul class="crd_list">
                                    <li><a href="#">Place value</a></li>
                                    <li><a href="#">Addition and subtraction</a></li>
                                    <li><a href="#">Multiplication</a></li>
                                    <li><a href="#">Division</a></li>
                                    <li><a href="#">Factors, multiples and prime numbers</a></li>
                                    <li><a href="#">Fractions</a></li>
                                    <li><a href="#">Decimals</a></li>
                                    <li><a href="#">Percentages, ratios and proportion</a></li>
                                    <li><a href="#">Sequences</a></li>
                                    <li><a href="#">Special numbers</a></li>
                                    <li><a href="#">Equations and algebra</a></li>
                                    <li><a href="#">2D shapes</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="wtbxwtsdw">
                                <ul class="nav nav-pills qstb_pnt" id="QS1Tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="qs1-tab" data-toggle="pill" href="#qs1" role="tab"
                                            aria-controls="qs1" aria-selected="true">Question</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="ans1-tab" data-toggle="pill" href="#ans1" role="tab"
                                            aria-controls="ans1" aria-selected="false">Answer</a>
                                    </li>
                                </ul>
                                <div class="tab-content qstb_cntnt_pnt" id="QS1TabContent">
                                    <div class="tab-pane fade show active" id="qs1" role="tabpanel"
                                        aria-labelledby="qs1-tab">
                                        <div class="q_img_sc">
                                            <img src="{{asset('newfrontend/images/qs_1_img.jpg')}}" class="img-fluid">
                                        </div>
                                        <div class="qs_action_sc">
                                            <h4 class="mb-4">See similar topic questions:</h4>
                                            <div class="row">
                                                <div class="col-xl-7 mb-4">
                                                    <a href="#" class="btn btn_join btn_l_blue mr-2">Geometry</a>
                                                    <a href="#" class="btn btn_join btn_wb">Area and Perimeter</a>
                                                </div>
                                                <div class="col-xl-5 mb-3">
                                                    <h4>Solve this question in</h4>
                                                    <h6>1 min 30 sec</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="ans1" role="tabpanel" aria-labelledby="ans1-tab">
                                        <div class="q_img_sc">
                                            <img src="{{asset('newfrontend/images/ans_1_img.jpg')}}" class="img-fluid">
                                        </div>
                                        <div class="qs_action_sc">
                                            <h4 class="mb-4">See similar topic questions:</h4>
                                            <div class="row">
                                                <div class="col-xl-7 mb-4">
                                                    <a href="#" class="btn btn_join btn_l_blue mr-2">Geometry</a>
                                                    <a href="#" class="btn btn_join btn_wb">Area and Perimeter</a>
                                                </div>
                                                <div class="col-xl-5 mb-3">
                                                    <h4>Solve this question in</h4>
                                                    <h6>1 min 30 sec</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-5">
                            <div class="wtbxwtsdw">
                                <ul class="nav nav-pills qstb_pnt" id="QS1Tab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="qs2-tab" data-toggle="pill" href="#qs2" role="tab"
                                            aria-controls="qs2" aria-selected="true">Question</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="ans2-tab" data-toggle="pill" href="#ans2" role="tab"
                                            aria-controls="ans2" aria-selected="false">Answer</a>
                                    </li>
                                </ul>
                                <div class="tab-content qstb_cntnt_pnt" id="QS1Tab2Content">
                                    <div class="tab-pane fade show active" id="qs2" role="tabpanel"
                                        aria-labelledby="qs2-tab">
                                        <div class="q_img_sc">
                                            <img src="{{asset('newfrontend/images/qs_2_img.jpg')}}" class="img-fluid">
                                        </div>
                                        <div class="qs_action_sc">
                                            <h4 class="mb-4">See similar topic questions:</h4>
                                            <div class="row">
                                                <div class="col-xl-7 mb-4">
                                                    <a href="#" class="btn btn_join btn_l_blue mr-2">Geometry</a>
                                                    <a href="#" class="btn btn_join btn_wb">Area and Perimeter</a>
                                                </div>
                                                <div class="col-xl-5 mb-3">
                                                    <h4>Solve this question in</h4>
                                                    <h6>1 min 30 sec</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="ans2" role="tabpanel" aria-labelledby="ans2-tab">
                                        <div class="q_img_sc">
                                            <img src="{{asset('newfrontend/images/ans_2_img.jpg')}}" class="img-fluid">
                                        </div>
                                        <div class="qs_action_sc">
                                            <h4 class="mb-4">See similar topic questions:</h4>
                                            <div class="row">
                                                <div class="col-xl-7 mb-4">
                                                    <a href="#" class="btn btn_join btn_l_blue mr-2">Geometry</a>
                                                    <a href="#" class="btn btn_join btn_wb">Area and Perimeter</a>
                                                </div>
                                                <div class="col-xl-5 mb-3">
                                                    <h4>Solve this question in</h4>
                                                    <h6>1 min 30 sec</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-5">
                            <div class="wtbxwtsdw">
                                <ul class="nav nav-pills qstb_pnt" id="QS1Tab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="qs3-tab" data-toggle="pill" href="#qs3" role="tab"
                                            aria-controls="qs3" aria-selected="true">Question</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="ans3-tab" data-toggle="pill" href="#ans3" role="tab"
                                            aria-controls="ans3" aria-selected="false">Answer</a>
                                    </li>
                                </ul>
                                <div class="tab-content qstb_cntnt_pnt" id="QS1Tab3Content">
                                    <div class="tab-pane fade show active" id="qs3" role="tabpanel"
                                        aria-labelledby="qs3-tab">
                                        <div class="q_img_sc">
                                            <img src="{{asset('newfrontend/images/qs_3_img.jpg')}}" class="img-fluid">
                                        </div>
                                        <div class="qs_action_sc">
                                            <h4 class="mb-4">See similar topic questions:</h4>
                                            <div class="row">
                                                <div class="col-xl-7 mb-4">
                                                    <a href="#" class="btn btn_join btn_l_blue mr-2">Geometry</a>
                                                    <a href="#" class="btn btn_join btn_wb">Area and Perimeter</a>
                                                </div>
                                                <div class="col-xl-5 mb-3">
                                                    <h4>Solve this question in</h4>
                                                    <h6>1 min 30 sec</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="ans3" role="tabpanel" aria-labelledby="ans3-tab">
                                        <div class="q_img_sc">
                                            <img src="{{asset('newfrontend/images/ans_3_img.jpg')}}" class="img-fluid">
                                        </div>
                                        <div class="qs_action_sc">
                                            <h4 class="mb-4">See similar topic questions:</h4>
                                            <div class="row">
                                                <div class="col-xl-7 mb-4">
                                                    <a href="#" class="btn btn_join btn_l_blue mr-2">Geometry</a>
                                                    <a href="#" class="btn btn_join btn_wb">Area and Perimeter</a>
                                                </div>
                                                <div class="col-xl-5 mb-3">
                                                    <h4>Solve this question in</h4>
                                                    <h6>1 min 30 sec</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-5">
                            <div class="wtbxwtsdw">
                                <ul class="nav nav-pills qstb_pnt" id="QS1Tab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="qs4-tab" data-toggle="pill" href="#qs4" role="tab"
                                            aria-controls="qs4" aria-selected="true">Question</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="ans4-tab" data-toggle="pill" href="#ans4" role="tab"
                                            aria-controls="ans4" aria-selected="false">Answer</a>
                                    </li>
                                </ul>
                                <div class="tab-content qstb_cntnt_pnt" id="QS1Tab4Content">
                                    <div class="tab-pane fade show active" id="qs4" role="tabpanel"
                                        aria-labelledby="qs3-tab">
                                        <div class="q_img_sc">
                                            <img src="{{asset('newfrontend/images/qs_4_img.jpg')}}" class="img-fluid">
                                        </div>
                                        <div class="qs_action_sc">
                                            <h4 class="mb-4">See similar topic questions:</h4>
                                            <div class="row">
                                                <div class="col-xl-7 mb-4">
                                                    <a href="#" class="btn btn_join btn_l_blue mr-2">Geometry</a>
                                                    <a href="#" class="btn btn_join btn_wb">Area and Perimeter</a>
                                                </div>
                                                <div class="col-xl-5 mb-3">
                                                    <h4>Solve this question in</h4>
                                                    <h6>1 min 30 sec</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="ans4" role="tabpanel" aria-labelledby="ans4-tab">
                                        <div class="q_img_sc">
                                            <img src="{{asset('newfrontend/images/ans_4_img.jpg')}}" class="img-fluid">
                                        </div>
                                        <div class="qs_action_sc">
                                            <h4 class="mb-4">See similar topic questions:</h4>
                                            <div class="row">
                                                <div class="col-xl-7 mb-4">
                                                    <a href="#" class="btn btn_join btn_l_blue mr-2">Geometry</a>
                                                    <a href="#" class="btn btn_join btn_wb">Area and Perimeter</a>
                                                </div>
                                                <div class="col-xl-5 mb-3">
                                                    <h4>Solve this question in</h4>
                                                    <h6>1 min 30 sec</h6>
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
    </div>
@stop
