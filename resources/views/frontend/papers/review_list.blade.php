@if(@$reviews->count() > 0)
    <div class="content mCustomScrollbar">
        <div class="inner_rating_scn ">
            @forelse (@$reviews as $review)
                <div class="detail_rew">
                    {{-- <img src="{{ asset('frontend/images/jd.jpg') }}" alt="jd" title="jd"> --}}
                    <div class="rating_detail_scn">
                        <h3>{{ @$review->parent->full_name }}</h3>
                        <div class="fixedStar" data-score="{{ @$review->rate }}"></div>
                        <p>
                            {{ @$review->content }}
                        </p>
                        <span>{{ @$review->date_text }}</span>
                    </div>
                </div>
            @empty
                
            @endforelse
            <div class="post-data"></div>
        </div>
    </div>
@endif