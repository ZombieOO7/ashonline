@if(@$papers)
    <div class="row">    
        @forelse (@$papers as $key => $paper)
            <div class="col-lg-3 col-6 col-sm-6 col-md-4 pack-lg-3">
                <div class="pack_box">
                    {{-- <div class="pack_logo">
                        <img src="{{ asset('frontend/images/logo.png')}}" class="img-fluid" alt="pack logo" title="pack logo">
                    </div> --}}
                    <div class="pack_img">
                        <a href="{{ route('paper-details',['category' => @$paper->category->slug, 'slug' => @$paper->slug ]) }}"><img src="{{ @$paper->thumb_path}}" class="img-fluid" alt="{{ @$paper->title }}" title="{{ @$paper->title }}"></a>
                    </div>
                    <div class="pack_content">
                        <a class="dflt_lnk" href="{{ route('paper-details',['category' => @$paper->category->slug, 'slug' => @$paper->slug ]) }}">{{ @$paper->title_text_for_list }}</a>
                        <p class="price_p">{{ @$paper->price_text }}</p>
                        <div class="fixedStar" data-score='{{ @$paper->avg_rate }}'></div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-lg-12 col-6 col-sm-6 col-md-4 pack-lg-3">
                <h4>{{__('formname.not_available_paper')}} <a href="{{ route('contact-us') }}" style="text-decoration:none;">Contact Us</a></h4>
            </div>
        @endforelse
    </div>
@else 
    <div class="row">  
        <div class="col-lg-12 col-6 col-sm-6 col-md-4 pack-lg-3">
            <h4>{{__('formname.not_available_paper')}} <a href="{{ route('contact-us') }}" style="text-decoration:none;">Contact Us</a></h4>
        </div>
    </div>
@endif
