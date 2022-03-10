<div class="our_p_sc hide_on_search">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3 class="def_ttitle">{{ __('frontend.papers.our_products') }}</h3>
          <div class="def_p">{!! @$detail->product_content !!}</div>
        </div>
        @php 
          $index = 1;
        @endphp
        @forelse (@$detail->keyProducts as $product)
          <div class="col-md-4 text-center p_sc_bx">
            <div class="p_sc_ic"><span class="ash-blue_ic{{ @$index++ }}"></span></div>
            <h4>{{ @$product->title }}</h4>
            <p>{!! nl2br(e($product->description)) !!}</p>
          </div>
        @empty
        @endforelse
      </div>
    </div>
</div>