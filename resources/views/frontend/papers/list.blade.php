@php
$isParent = isParent();
@endphp
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
                    <div class="">
                        {{-- <button class="btn btn-addtocar" type="button" data-paper-id="{{ @$paper->id }}" data-url="{{ route('add-to-cart') }}">{{ __('frontend.cart.add_to_cart') }}</button> --}}
                        @if($isParent == true)
                        <a href="{{ route('paper-details',['category' => @$paper->category->slug, 'slug' => @$paper->slug ]) }}" data-url="{{route('check-to-cart')}}" data-redircet_url="{{ route('paper-details',['category' => @$paper->category->slug, 'slug' => @$paper->slug ]) }}" class="btn btn-addtocar" data-paper_id='{{@$paper->id}}'>
                            {{ __('frontend.cart.add_to_cart') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-lg-12 col-6 col-sm-6 col-md-4 pack-lg-3">
            <h4>{{ __('formname.coming_soon' )}}</h4>
        </div>
    @endforelse
</div>
