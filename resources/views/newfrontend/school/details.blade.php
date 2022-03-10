@extends('newfrontend.layouts.default')
@section('title','Home')
@section('content')
<!--inner content-->
<div class="container pdng_btm_90">
    <div class="row">
        <div class="col-md-12 prfl_ttl">
            <h3>{{@$school->title}}<a class="btn btn-dttgl" data-toggle="collapse" href="#SidebarMenu" role="button"
                    aria-expanded="false" aria-controls="SidebarMenu"><span class="ash-menu"></span></a></h3>
        </div>
        <div class="col-md-3 sdbr_box">
            <div class="collapse" id="SidebarMenu">
                <div class="card card-body">
                    <ul class="crd_list nav navbar-nav">
                        <li class="active"><a href="#about">About</a></li>
                        <li><a href='javascript:;' class="nav-list" data-href="#mock-exam">Mock Exams</a></li>
                        <li><a href='javascript:;' class="nav-list" data-href="#e-paper">E-Papers</a></li>
                        <li><a href='javascript:;' class="nav-list" data-href="#e-style">Exam Styles</a></li>
                        <li><a href='javascript:;' class="nav-list" data-href="#info">More Info</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="school_details" id="about">
                <div class="title_school d-flex justify-content-center align-items-center mb-3">
                    @php
                        $imagePath = ($school->image != null && file_exists(storage_path().'/'.'app/public/uploads/'.$school->image)) ? url('storage/app/public/uploads/'. $school->image) : asset('images/mock_img_tbl.png');
                        $logoPath = ($school->logo != null && file_exists(storage_path().'/'.'app/public/uploads/'.$school->logo)) ? url('storage/app/public/uploads/'. $school->logo) : asset('images/mock_img_tbl.png');
                    @endphp
                    <img src="{{$logoPath}}" alt="" title="" width="75px" height="75px">
                    <h3>{{@$school->title}}</h3>
                </div>
                <div class="">
                    <div class="col-md-12">
                        <img src="{{$imagePath}}" class="img-fluid" align="" title="" style="width: 830px;height: 300px;">
                    </div>
                    <div class="col-md-12 mrgn_tp_20">
                        <p>{!! @$school->short_description !!}</p>
                    </div>
                </div>
            </div>
            @if($school->mocks)
                <hr>
                <!--mock-exam-->
                <div class="mock_exam_papers" id="mock-exam">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="df_h3 mdl_tilte spcng_less">Mock Exams</h3>
                            {{-- <p class="df_pp">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                                tincidunt ut laoreet dolore magna aliquam erat</p> --}}
                        </div>
                        <div class="col-md-12">
                            <div class="row justify-content-center">
                                <div class="col-xl-11">
                                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                                        @forelse($examBoards as $key => $examBoard)
                                        <li class="nav-item">
                                            <a class="nav-link e-mck-btn {{($key==0)?'active':''}}" id="{{@$examBoard->slug}}-tab" data-toggle="pill"
                                                href="#{{@$examBoard->slug}}" role="tab" aria-controls="{{@$examBoard->slug}}"
                                                aria-selected="false">{{@$examBoard->title}}</a>
                                        </li>
                                        @empty
                                        @endforelse
                                    </ul>
                                    <div class="tab-content mt-4 mb-5" id="pills-tabContent">
                                        @forelse($examBoards as $key => $examBoard)
                                        <div class="tab-pane fade {{($key==0)?'show active':''}}" id="{{@$examBoard->slug}}" role="tabpanel"
                                            aria-labelledby="{{@$examBoard->slug}}-tab">
                                            <div class="rspnsv_table scrollble-table">
                                                <table class="table-bordered table-striped table-condensed cf">
                                                    <thead>
                                                        <tr>
                                                            <th class="img_hd">{{__('formname.mock.image')}}</th>
                                                            <th>{{__('formname.mock.exam_name')}}</th>
                                                            <th>{{__('formname.mock.date')}}</th>
                                                            <th>{{__('formname.mock.time')}}</th>
                                                            <th>{{__('formname.mock.price')}}</th>
                                                            <th>{{__('formname.mock.action')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($examBoard['mocks'] as $key => $mock)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ route('mock-detail', @$mock->uuid ) }}">
                                                                        <img src="{{$school->proper_logo_path }}" class="mx-wd-95" width="100px" height="100px">
                                                                    </a>
                                                                </td>
                                                                <td>{{@$mock->title}}</td>
                                                                <td>{{@$mock->proper_start_date_and_end_date}}</td>
                                                                <td>{{@$mock->total_time}}</td>
                                                                <td>{{@$mock->price_text}}</td>
                                                                <td data-title="Action" class="min-wd-140">
                                                                    <a href="javascript:;"
                                                                       data-url="{{route('emock-add-to-cart')}}"
                                                                       data-mock_id="{{ @$mock->id }}"
                                                                       class="add_to_cart addToCart">{{__('formname.mock.add_to_cart')}}</a>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td>{{__('formname.records_not_found')}}</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @empty
                                        @endforelse

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if($school->papers)
                <hr>
                <!--e-papers-->
                <div class="paper_list_scn" id="e-paper">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="df_h3 mdl_tilte spcng_less">E-Papers</h3>
                        </div>
                        <div class="col-md-12 mrgn_bt_30 mrgn_tp_10">
                            <div class="row justify-content-center">
                                <div class="col-xl-11">
                                    <div class="row">
                                        @forelse($school->papers as $paper)
                                        <div class="col-lg-3 col-6 col-sm-6 col-md-4 pack-lg-3">
                                            <div class="pack_box">
                                                <div class="pack_img">
                                                    <a href="#"><img src="{{@$paper->paper->thumb_path}}" class="img-fluid"
                                                            alt="{{@$paper->paper->title}}" title="{{@$paper->paper->title}}"></a>
                                                </div>
                                                <div class="pack_content">
                                                    <a class="dflt_lnk" href="{{route('paper-details',['category' => @$paper->paper->category->slug, 'slug' => @$paper->paper->slug])}}">{{Str::limit(@$paper->paper->title, 15)}}</a>
                                                    <p class="price_p">{{@$paper->paper->price_text}}</p>
                                                    <div class="fixedStar fixedStar_readonly" data-score='{{@$paper->paper->avg_rate}}' readonly></div>
                                                    <div class="addtocart">
                                                        <button class="btn btn-add-to-cart addToCart" data-url="{{route('emock-add-to-cart')}}" data-paper_id="{{ @$paper->paper->id }}">Add To Cart</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <table class="rspnsv_table scrollble-table">
                                            <thead></thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{__('formname.records_not_found')}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <hr>
            <div class="lst_sc">
                <div class="row">
                    <div class="col-md-12 text-center" id="e-style">
                        <h3 class="df_h3 mdl_tilte spcng_less">Exam Styles</h3>
                        {!! @$school->exam_style !!}
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12 text-center" id="info">
                        <h3 class="df_h3 mdl_tilte spcng_less">More Information</h3>
                        {!! @$school->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('pageJs')
<script src="{{ asset('backend/dist/default/assets/demo/default/base/scripts.bundle.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/dist/default/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{asset('backend/js/common.js')}}"></script>
<script>
    var base_url = "{{url('/')}}";
    var school_id = '{{@$school->id}}'
    $(function() {
        $(document).find('.fixedStar_readonly').raty({
            readOnly:  true,
            path    :  base_url+'/public/frontend/images',
            starOff : 'star-off.svg',
            starOn  : 'star-on.svg',
            start: $(document).find(this).attr('data-score')
        });
    });
    $(".nav-list").click(function() {
        //var div = $(this).attr('data-href');
        //$('html, body').animate({
        //    scrollTop: $(div).offset().top - 100
        //}, 1500, 'linear');
        var position = $($(this).attr("data-href")).offset().top - 100;
        $("body, html").animate({
            scrollTop: position
        }, 1000 );
    });
</script>
<script src="{{asset('newfrontend/js/school/detail.js')}}"></script>
@stop
