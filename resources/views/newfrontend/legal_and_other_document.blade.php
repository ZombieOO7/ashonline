    @extends('newfrontend.layouts.default')
@section('title',__('frontend.legal_and_other_documents'))
@section('content')
<section class="lgnothr_doc_sc">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12 in_ttl mrgn_bt_20">
              <h3 class="df_h3">{{ __('frontend.legal_and_other_documents') }}</h3>
              <p class="df_pp">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo</p>
            </div>
            <div class="col-lg-3 col-sm-6 lgldc_pg_lnk">
              <a href="{{ route('privacy-policy') }}" target="_blank">Privacy Policy</a>
            </div>
            <div class="col-lg-3 col-sm-6 lgldc_pg_lnk">
              <a href="{{route('termsandconditions')}}" target="_blank">Terms & Conditions</a>
            </div>
            <div class="col-lg-3 col-sm-6 lgldc_pg_lnk">
              <a href="{{ route('payments-and-security') }}" target="_blank">Payments and Security</a>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@stop
