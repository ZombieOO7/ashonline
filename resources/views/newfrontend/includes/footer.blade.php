<div id="loader" class="page-loader">
  <div class="loader-icon">
    <div class="circle circ-1"></div>
    <div class="circle circ-2"></div>
    <div class="circle circ-3"></div>
    <div class="circle circ-4"></div>
  </div>
</div>
<footer class="footer">
  <div class="top_footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4 ftr_brand">
          <a href="{{route('firstpage')}}"><img src="{{asset('newfrontend/images/ftr_logo.png')}}" alt="AshACE" title="AshACE"></a>
        </div>
        <div class="col-md-8 text-right">
          <ul class="flr_links">
            <li><a href="{{route('home')}}">E-Papers</a></li>
            <li><a href="{{ route('e-mock') }}">E-Mock</a></li>
            <li><a href="{{ route('practice') }}">Practice</a></li>
            <li><a href="{{ route('eblogs/index') }}">Blog</a></li>
            <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
          </ul>
          <ul class="flr_links">
            <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
            <li><a href="{{route('termsandconditions')}}">Terms & Conditions</a></li>

            @php 
                $faqs = getFooterFaqs();
            @endphp
            <li><a href="{{ route('mock-faq',['slug' =>  @$faqs[0]->frontendFaqs ? @$faqs[0]->frontendFaqs[0]->slug : __('frontend.not-found') ]) }}">{{__('formname.faq_text')}}</a></li>
       
          </ul>
        </div>
      </div>
    </div>
  </div>  
  @include('newfrontend.includes.footer_copy_right')
</footer>
