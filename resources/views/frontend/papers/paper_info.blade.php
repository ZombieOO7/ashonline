@extends('frontend.layouts.default')
@section('title',@$detail->title_seo)
@section('content')
@section('breadcrumbs', Breadcrumbs::view('partials/breadcrumbs','common_breadcrumb',@$detail->title,'#',@$categoryDetail->title_with_text_papers,route('paper.detail',['slug' => @$categoryDetail->slug]), 'Papers', route('papers')))
@section('pageCss')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@section('pageJs')
@php
$cartFlag = 'false';
$user = null;
if(Auth::guard('parent')->user() != null){
    $user = Auth::guard('parent')->user();
    $cartFlag = 'true';
}elseif(Auth::guard('student')->user() != null){
    $msg = __('frontend.child_cart_warning');
    $user = Auth::guard('student')->user();
    $cartFlag = 'true';
}else{
    $msg = __('frontend.cart_login');
}
$isParent = isParent();
@endphp
<script>
  var cartURL = "{{ route('emock-cart') }}";
  var flag = false;
  cartFlag = "{{@$cartFlag}}";
  var warningMsg = "{{@$msg}}";
</script>
<script src="{{asset('frontend/js/papers/details.js')}}"></script>
@endsection
<div class="container">
    <div class="row">
      <div class="col-md-12 mrgn_bt_30 mrgn_tp_40">
        <div class="row">
          <div class="col-lg-4 pack-lg-3 details_pr">
            <div class="pack_box">
              {{-- <div class="pack_logo">
                <img src="{{ asset('frontend/images/logo.png')}}" class="img-fluid" alt="pack logo" title="pack logo">
              </div> --}}
              <div class="pack_img">
                <img src="{{ @$detail->detail_path }}" class="img-fluid" alt="{{ @$detail->title }}" title="{{ @$detail->title }}">
              </div>
            </div>
          </div>

          <!-- PAPER DETAIL STARTS HERE -->
          <div class="col-lg-8 pack-lg-3 info_details_pr">
            <div class="pack_box">
              <div class="product_id">{{ @$detail->edition }}</div>
              <div class="pack_content">
                <h1 class="dflt_lnk">{{ @$detail->title }}</h1>
                <p class="price_p">{{ @$detail->price_text }} </p>
                <div class="d_ratings">
                    <div class="fixedStar" data-score='{{ @$detail->avg_rate }}'></div>
                    <span class="rate_counts">{{ @$detail->avg_rate }}  | {{ __('frontend.review.5_reviews') }}</span>
				</div>
				<div class="added-crt">
                  @if(count($checkProductInSession)>0)
                    <button class="btn btn-addtocar btn_added">{{ __('frontend.papers.added') }}</button>
                  @else
                    {{-- @if($flag ==true && $isParent = true) --}}
                    <button class="btn btn-addtocar add-to-cart" data-paper_id="{{ @$detail->id }}" data-url="{{ route('emock-add-to-cart') }}">{{ __('frontend.cart.add_to_cart') }}</button>
                    {{-- @endif --}}
                  @endif
                  @if(count($checkProductInSession)>0)
                    <a href="{{ route('emock-cart') }}" class="btn btnviewcart" >
                      {{ __('frontend.cart.view_cart') }} <span class="ash-right-thin-chevron"></span>
                    </a>
                  @endif
                </div>
                <p class="ylw_p">*{{ __('frontend.papers.immediately_download_after_purchase') }}</p>
                <p class="def_p">{{ @$detail->title }}</p>

                <ul class="list_pp">
                  @php
                      $search = '<li>';
                      $content = @$detail->content;
                  @endphp
                  @if (strpos($content, $search) == false)
                    <li>{!! @$detail->content !!}</li>
                  @else
                    </li>{!! strip_tags(@$detail->content,'<li>') !!}</li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
          <!-- PAPER DETAIL ENDS HERE -->

          <!-- REVIEWS LIST STARTS HERE -->
          <div class="col-lg-12 review_sc">
            <h2>{{ @$reviews->count() > 0 ? @$reviews->count() : 'No' }} {{ __('frontend.review.reviews') }}</h2>
            @include('frontend.papers.review_list')
          </div>
          <!-- REVIEWS LIST ENDS HERE -->

          <!-- PAPERS LIST STARTS HERE -->
          <div class="col-lg-12 related_product">
              <div class="d-flex justify-content-between related_title">
              <h4>{{ __('frontend.papers.related_papers') }}</h4>

                  @if(@$papers->count() > 0)
                  <a href="{{ route('paper.detail',['slug' => @$categoryDetail->slug ]) }}" class="view_all">{{ __('frontend.papers.view_all') }}</a>
                  @endif
              </div>

              <div class="col-md-12 mrgn_bt_30 mrgn_tp_10">
                  <div class='paper-lst-filter'>
                  @include('frontend.papers.list')
                  </div>
              </div>
          </div>
          <!-- PAPERS LIST ENDS HERE -->

        </div>
      </div>
    </div>
  </div>

  <!-- KEY PRODUCTS LIST STARTS HERE -->
  @if(@$categoryDetail->keyProducts->count() > 0)
    @include('frontend.papers.key_products',['detail' => @$categoryDetail])
  @endif
  <!-- KEY PRODUCTS LIST ENDS HERE -->

  <!-- KEY BENEFITS LIST STARTS HERE -->
  @if(@$categoryDetail->keyBenefits->count() > 0)
    @include('frontend.papers.key_benefits',['detail' => @$categoryDetail])
  @endif
  <!-- KEY BENEFITS LIST STARTS HERE -->

@endsection
@section('pageJs')
<script>
// Add To Cart
cartFlag = "{{@$cartFlag}}";
var warningMsg = "{{@$msg}}";
$(document).on('click','.addToCart',function() {
    redirectUrl = $(this).attr('data-redircet_url');
    if(cartFlag == 'false'){
        toastr.error(warningMsg);
    }else{
        $.ajax({
            url: $(this).attr('data-url'),
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            global: false,
            data: {
                    mock_id : $(this).attr('data-mock_id'),
                    paper_id : $(this).attr('data-paper_id'),
                },
            success: function (result) {
                if(result.icon == 'info') {
                    toastr.error(result.msg);
                } else {
                    window.location.replace(redirectUrl);
                }
            }
        });
    }
});
</script>
@stop
