<div class="pprbtm_sc hide_on_search">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3 class="def_ttitle">{{ __('frontend.papers.key_benefits') }}</h3>
        </div>
        <div class="col-md-12">
          <ul class="k_bnft_sc">
            @php 
              $index = 1;
            @endphp
            @forelse (@$detail->keyBenefits as $benefit)
              <li>
                <div class="k_b_ic"><span class="ash-dark_ic{{ @$index++ }}"></span></div>
                <h5>{{ @$benefit->title }}</h5>
                <p>{!! nl2br(e($benefit->description)) !!}</p>
              </li>
            @empty
            @endforelse
          </ul>
        </div>
      </div>
    </div>
</div>