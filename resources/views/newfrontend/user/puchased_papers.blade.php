@extends('newfrontend.layouts.default')
@section('title',__('frontend.parentmock.purchase'))
@section('content')
@php
    $routeArray = [
    [
		'title' => __('frontend.my_profile'),
		'route' => route('parent-profile'),
	],
    [
		'title' => __('frontend.purchased_paper'),
		'route' => route('purchased-paper'),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
<!--inner content-->
<div class="container mrgn_bt_40">
    <div class="row">
        @include('newfrontend.user.leftbar')
        <div class="col-md-9">
            <div class="form_box">
                <h3>Purchased e-Papers</h3>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="purched_details purched_details_v1">
                            @forelse($items as $item)
                            <li>
                                <h4 class="blue_txt">{{__('frontend.parentmock.created_at')}}: {{@$item->order->proper_order_date}}</h4>
                                <div class="row align-items-center frrspnsv_txt">
                                    <div class="col-lg-3">
                                        <div class="d-md-flex align-items-center">
                                            <a href="{{ route('paper-details',['category' => @$item->paper->category->slug, 'slug' => @$item->paper->slug ]) }}"><img src="{{@$item->paper->thumb_path }}" class="img-fluid" style="width:150px;height:175px;"></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <p class="mdl_txt"><a href="{{ route('paper-details',['category' => @$item->paper->category->slug, 'slug' => @$item->paper->slug ]) }}">{{@$item->paper->title }}</a></p>
                                        <div class="fixedStar mx_w_str frrspnsv_mrgn_15" data-score="{{@$item->paper->avg_rate}}"></div>
                                    </div>
                                    <div class="col-lg-2">
                                        <p class="mdl_txt frrspnsv_mrgn_15">{{@$item->price_text}}</p>
                                    </div>
                                    @if(isset($item->review) && $item->review != null)
                                        <div class="col-md-4">
                                            <button class="drk_blue_btn btn_blue viewFeedback" data-rate="{{@$item->review->rate}}" data-review='{{@$item->review->content}}'>View
                                                Feedback</button>
                                        </div>
                                    @else
                                        <div class="col-lg-4">
                                            <button class="drk_blue_btn" data-toggle="collapse" href="#ShareFeedback_tab{{$item->paper_id}}"
                                                role="button" aria-expanded="false" aria-controls="ShareFeedback_tab">Share
                                                Feedback</button>
                                        </div>
                                    @endif
                                    <div class="col-md-12 fdbck_collaps">
                                        <div class="collapse" id="ShareFeedback_tab{{$item->paper_id}}">
                                            <div class="card card-body">
                                                <form class="def_form in_cllps_dv feedback_form" method="POST" id="feedback_form" action="{{ route('post-review') }}">
                                                    @csrf
                                                    <p>Leave your review and rate us on basis of your experience with us
                                                    </p>
                                                    <div class="row mrgn_tp_30">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="fixedStar mx_w_str editable_star bg_star"
                                                                    data-score="1"></div>
                                                            </div>

                                                            <div class="form-group">
                                                                <textarea class="form-control grtxtr" id="" rows="4"
                                                                    placeholder="Write your message here" name="review"></textarea>
                                                            </div>
                                                            <input type="hidden" name="paper_id" value="{{ @$item->paper_id }}">
                                                            <input type="hidden" name="order_id" value="{{ @$item->order_id }}">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn submit_btn btn_blue submitFeedBack">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li>
                                <h4 class="blue_txt"></h4>
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="text-left">
                                            <p class="mdl_txt">{{__('formname.not_found')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforelse
                            {{-- <li>
                                <h4 class="blue_txt">Purchased On : 20th July, 2020</h4>
                                <div class="row align-items-center frrspnsv_txt">
                                    <div class="col-md-3">
                                        <div class="d-md-flex align-items-center">
                                            <a href="#"><img src="images/pro_img.png" class="img-fluid"></a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="mdl_txt"><a href="#">7+ English Pack 1</a></p>
                                        <div class="fixedStar mx_w_str frrspnsv_mrgn_15" data-score="3"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="mdl_txt frrspnsv_mrgn_15">£12.00</p>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="drk_blue_btn btn_blue" data-toggle="modal" data-target="#feedback_modal">View
                                            Feedback</button>
                                    </div>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<!--close inner content-->
<!--Your-feedback-Modal -->
<div class="modal fade def_modal lgn_modal" id="feedback_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3>Your Feedback</h3>
                <p class="mrgn_bt_40"></p>
                <div class="fixedStar mx_w_str bg_star" data-score="3" id='pScore' style="pointer-events: none;">
                </div>
                <h4 class="middle_mdl_title mrgn_tp_40 mrgn_bt_20">Your Message</h4>
                <p class="middle_content_info mrgn_bt_30" id='paperReview'></p>
                <button type="submit" data-dismiss="modal" class="btn submit_btn">Okay</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade def_modal lgn_modal" id="success_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3>Successfully Submitted</h3>
                <p class="mrgn_bt_40">Thank you for sharing your feedback with us. It has been successfully
                    submitted.</p>
                <button type="submit" class="btn submit_btn" data-dismiss="modal">Okay</button>
            </div>

        </div>
    </div>
</div>
@php
@endphp
@stop
@section('pageJs')
<script>
    var activeMockUrl = '{{route("activate.mock")}}';
    var base_url = "{{url('/')}}";
    var feedbackUrl = "{{ route('post-review') }}";
    $(document).find('.fixedStar').raty({
        readOnly:  true,
        half:  true,
        path    :  base_url+'/public/frontend/images',
        starOff : 'star-off.svg',
        starOn  : 'star-on.svg',
        starHalf:   'star-half.svg',
        start: $(document).find(this).attr('data-score')
    });
    $(document).find('.editable_star').raty({
        readOnly:  false,
        half:  true,
        path    :  base_url+'/public/frontend/images',
        starOff : 'star-off.svg',
        starOn  : 'star-on.svg',
        starHalf:   'star-half.svg',
        start: $(document).find(this).attr('data-score')
    });
</script>
<script src="{{ asset('backend/dist/default/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{asset('backend/js/common.js')}}"></script>
<script src="{{asset('newfrontend/js/parent/mock.js')}}"></script>
@stop