@extends('newfrontend.layouts.default')
@section('title',__('frontend.paymentsandsecurity'))
@section('content')
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',__('frontend.paymentsandsecurity'),route('home')))
 <!--inner content-->
 <section class="lgnothr_doc_sc">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12 in_ttl mrgn_bt_20">
                <h3 class="df_h3">{{@$cms->title}}</h3>
                <p class="df_pp">{!! @$cms->content !!}</p>
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!--close inner content-->
@endsection