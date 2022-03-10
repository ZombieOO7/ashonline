<div class="review_list">
    <div class="review_card">
        <div class="header_list">
            <a href="javascript:;" class="inner_header_list d-flex align-items-center">
                <div class="user_pictuer"><img src="{{@$rating->user->image_thumb}}"></div>
                <div class="user_info">
                    <h4>{{@$rating->user->full_name}}</h4>
                    <div class="num_of_revw">
                        {{-- <i class="edit"></i> --}}
                        {{-- <span>1 review</span> --}}
                    </div>
                </div>
            </a>
        </div>
        <div class="star_time_list d-flex align-items-center justify-content-between">
            {{-- <div class="star_img"><img src="{{asset('images/stars-5.svg')}}"></div> --}}
            <div class="fixedStar fixedStar_readonly" data-score="{{$rating->rating}}" readonly></div>
            <div class="time_ls">{{@$rating->created_at_human_formate}}</div>
        </div>
        <div class="review_content_body">
            {{-- <h3><a href="#">We came to Ace Tuition at the start of…</a></h3> --}}
            <p>{{@$rating->msg}}</p>
        </div>
    </div>
</div>