 <!--inner content-->
 <div id="loader" class="page-loader">
  <div class="loader-icon">
    <div class="circle circ-1"></div>
    <div class="circle circ-2"></div>
    <div class="circle circ-3"></div>
    <div class="circle circ-4"></div>
  </div>
</div>
<div class="subscibe_sc">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h4>{!! __('formname.subscribes.title') !!}</h4>
          <p>{!!__('formname.subscribes.content')!!}
          </p>
          
        </div>
        <div class="col-md-6 newsletter">
          <div class="input-group">
            <input type="email" class="form-control" placeholder="{{ __('frontend.email_address') }}" id="subscriber_email">
            <span class="input-group-btn">
              <button class="btn newsletter-subscribe" type="button" data-url="{{ route('subscribe') }}">{{ __('frontend.subscribe')}}</button>
            </span>
          </div>
          <div class="subscriber_msg"></div>
        </div>
      </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
      <div class="top_footer">
        <div class="row">
          <div class="col-md-12">
            <ul class="footer_links">
              <li><a href="{{ route('about-us') }}">{{__('formname.about')}}</a></li>
              <li><a href="{{ route('papers')}}">{{__('formname.papers')}}</a></li>
              <li><a href="{{ route('resources/index', 'past-papers') }}">{{__('formname.resources')}}</a></li>
              <li><a href="{{ route('tution') }}">{{__('formname.tuition')}}</a></li>
              <li><a href="{{ route('eblogs/index') }}">{{__('formname.blog')}}</a></li>
              <li><a href="{{route('contact-us')}}">{{__('formname.contact_us')}}</a></li>
            </ul>
          </div>
          <div class="col-md-12">
            <ul class="second_links">
              <li><a href="{{ route('privacy-policy') }}">{{__('formname.privacy_polacy')}}</a></li>
              <li><a href="{{ route('termsandconditions') }}">{{__('formname.terms_of_service')}}</a></li>
              @php 
                  $faqs = getFooterFaqs();
              @endphp
              <li><a href="{{ route('mock-faq',['slug' =>  @$faqs[0]->frontendFaqs ? @$faqs[0]->frontendFaqs[0]->slug : __('frontend.not-found') ]) }}">{{__('formname.faq_text')}}</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  <div class="footer_open">
    <div class="view_ours_papers">
      <div class="container">
        <div class="text-center">
          <a class="view_all_papers" data-toggle="collapse" href="#ftcollapseshw" role="button" aria-expanded="false" aria-controls="ftcollapseshw">{{ __('frontend.view_our_papers')}}</a>
        </div>
      </div>
    </div>
    <div class="collapse" id="ftcollapseshw">
        <div class="container">
          <div class="bottom_footer">
            <div class="row">
              @forelse(@$footerCategories as $key => $paperCategory)
              <div class="ascol col-lg-3 as-lg-3">
                <a class="cate_ttlbtn" data-toggle="collapse" href="#ftcollapse{{ $key }}" role="button" aria-expanded="false" aria-controls="ftcollapse{{ $key }}">
                    {{@$paperCategory->title_with_text_papers}}
                </a>
                <div class="collapse" id="ftcollapse{{ $key }}">
                  <ul class="ftr_catelist">
                    @forelse(@$paperCategory->papers as $paper)
                      <li><a href="{{route('paper-details',[@$paperCategory->slug,@$paper->slug])}}">{{@$paper->title_text}}</a></li>
                    @empty
                      <li><a href="javascript:void(0)">{{ __('formname.coming_soon' )}}</a></li>
                    @endforelse
                  </ul>
                </div>
              </div>
              @empty
              @endforelse
          </div>
        </div>
        </div>
    </div>
  </div>
  {{-- For notification --}}
  <span id="last_notify_id" style="display: none;"></span>  {{-- Do not delete --}}
  @include('frontend.includes.footer_copy_right')
</footer>