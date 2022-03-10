@extends('frontend.layouts.default')
@section('title',__('frontend.review.feedback'))
@section('content')
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',__('frontend.review.feedback'),route('home')))
<div class="container">
  @include('frontend.includes.flashmessages')  
  <div class="row">
    <div class="col-md-12 mrgn_bt_30 mrgn_tp_40">
        <div class="row">
          <div class="col-md-12">
            <div class="product_id mrgn_tp_0 mrgn_bt_35" style="font-size:20px !important;">
              {{__('formname.review_thank')}} {{ @$billingAddress->full_name }}</div>
            </div> 
          
            <div class="col-md-12">
              <form class="feedback_form def_form" method="POST" id="feedback_form" action="{{ route('post-review') }}">
                @csrf
                @php 
                  $pending = 0; 
                  $pendingPapers = true;
                @endphp
                @forelse (@$orderItems as $key => $item)

                  @if(!in_array(@$item->paper->id,$review) && $pendingPapers)
                    <div style="font-size:30px !important;" align="center">{{__('formname.write_review')}}</div>
                  @endif
                  <div class="row mrgn_bt_20 mrgn_tp_20">
                    <div class="col-lg-2">
                      <div class="pack_box">
                        {{-- <div class="pack_logo">
                          <img src="{{ asset('frontend/images/logo.png') }}" class="img-fluid" alt="pack logo" title="pack logo">
                        </div> --}}
                        <div class="pack_img">
                          <a href="{{ route('paper-details',['category' => @$item->paper->category->slug,'slug' => @$item->paper->slug ]) }}"><img src="{{ asset('frontend/images/english_pack.png') }}" class="img-fluid" alt="english pack" title="english pack"></a>
                        </div>
                        <div class="pack_content">
                          <a class="dflt_lnk" href="{{ route('paper-details',['category' => @$item->paper->category->slug,'slug' => @$item->paper->slug ]) }}">{{ @$item->paper->title }}</a>
                          <p class="price_p">{{ @$item->paper->price_text }}</p>  
                          <div class="fixedStar fixedStar_readonly " id="default{{ $key }}" readonly data-score="{{ @$item->paper->avg_rate }}" data-key="{{ $key }}"></div>
                        </div>
                      </div>
                    </div>
                    @if (in_array(@$item->paper->id,$review))
                      <div class="col-lg-10">
                        {{__('formname.thank_review_of')}} <span style="color:#3399ff;">{{ @$item->paper->title }}</span>
                      </div>
                      
                    @else 
                      @php 
                        $pending++; 
                        $pendingPapers = false;
                      @endphp
                      <div class="col-lg-4 info_details_pr">
                        <div class="pack_box">
                          <div class="feedback_content">
                              <div class="d_ratings bg_ratings mrgn_bt_35 mrgn_tp_35">
                                <div class="fixedStar fixedStar_working" data-rate_name='rating[]'></div>
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <textarea class="form-control" name="review[] " placeholder="Write your message here" rows="6"></textarea>
                        </div>
                      </div>
                      <input type="hidden" name="paper_id[]" value="{{ @$item->paper_id }}">
                    @endif
                    
                    <input type="hidden" name="order_id" value="{{ @$item->order_id }}">
                    <div class="col-md-12"><hr/></div>
                  </div>
                @empty
                    
                @endforelse
            
                @if (@$pending > 0)
                  <div class="text-right">
                    <button type="submit" class="btn btncheckout sbmtwtpdng mrgn_tp_20">{{__('formname.submit')}}</button>
                  </div>
                @endif
              </form>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
@section('pageJs')
  <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('frontend/js/review/feedback.js') }} "></script>
@endsection