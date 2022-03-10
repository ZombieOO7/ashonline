@extends('newfrontend.layouts.default')
@section('title',__('frontend.faq'))
@section('content')
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb',__('frontend.faq'),route('home')))
<link rel="stylesheet" href="{{asset('frontend/css/blog.css')}}">
<div class="container">
    <div class="row mrgn_tp_30">
      <div class="col-md-12 mrgn_tp_30">
        <div class="row">
          <div class="col-lg-12">
              {{-- <h1 class="small_title smllwtbrdr">{{ __('frontend.faq') }}</h1> --}}
          </div>

          @if(@$faqCategories[0]->frontendFaqs ) <!-- Check faq category has atleast one faq added -->
            <div class="col-lg-12">
              <div class="main-faq-scn">
                <div class="row">
                  <div class="col-lg-5">
                      <div class="accordion accordion_accnt" id="account_collapse">
                        <div class="card">
                          <div class="card-header" id="Acc_heading">
                            <h2 class="arw">
                              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#Acc_menu" aria-expanded="false" aria-controls="Acc_menu">Tools categories</button>
                            </h2>
                          </div>
                          <div id="Acc_menu" class="ascollapse collapse" aria-labelledby="Acc_heading" data-parent="#Acc_heading">
                            <div class="card-body">
                              <div class="left-sidebar equal_height">
                                  <div class="main-accordian" id="accordion">
                                      @forelse (@$faqCategories as $key => $faqCategory)
                                          <div class="card">
                                              <div class="card-header" id="heading-{{ $key }}">
                                                  <h5 class="medum-titl rigt-arw">
                                                  <a role="button" data-toggle="collapse" href="#collapse-{{ $key }}" aria-expanded="true" aria-controls="collapse-{{ $key }}">{!! @$faqCategory->title !!}</a>
                                                  </h5>
                                              </div>
                                              <div id="collapse-{{ $key}}" class="collapse {{ in_array(@$faqDetail->id,@$faqCategory->frontendFaqs->pluck('id')->toArray() ) ? 'show' : ''}}" data-parent="#accordion" aria-labelledby="heading-{{ $key }}">
                                                  <div class="card-body inner_faq_body">
                                                    <ul>
                                                        @forelse (@$faqCategory->frontendFaqs as $faq)
                                                            <li>
                                                              <a href="javascript:void(0)" data-title="{{ @$faq->title }}" data-content="{{ @$faq->content }}" data-slug="{{ @$faq->slug }}" class="li-dtl-cls" @if( @$faqDetail->slug == @$faq->slug) style="color:#03a9f4;" @endif>
                                                                <span class="ash-info"></span>{{ @$faq->title }}
                                                              </a>
                                                            </li>
                                                        @empty
                                                            
                                                        @endforelse
                                                    </ul>
                                                  </div>
                                              </div>
                                          </div>
                                      @empty
                                          <h3>{{ __('frontend.no_faqs_available') }}</h3>
                                      @endforelse
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-lg-7">
                    <div class="faq-content equal_height ">
                      <div class="inner-blog-details">
                          <div class="inner_blog_info"> 
                              <h2 id="faq-title">
                                  {!! @$faqDetail->title !!}
                              </h2>
                              <div id="faq-content">
                                  {!! @$faqDetail->content ? @$faqDetail->content : __('frontend.faq_is_not_active_or_no_longer_available') !!}
                              </div>
                                
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @else 
            <div class="col-lg-12">
              <div class="main-faq-scn">
                <h3>{{ __('frontend.no_faqs_available') }}</h3>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
