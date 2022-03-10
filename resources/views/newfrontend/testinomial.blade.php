<div class="col-md-12">
    <div class="row justify-content-center">
        <div class="col-md-11 tsmnls_crsl">
            <div id="TestimonialsIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @if(isset($reviewSlide1)  && count($reviewSlide1)>0)
                    <li data-target="#TestimonialsIndicators" data-slide-to="0" class="active"></li>
                    @endif
                    @if(isset($reviewSlide2) && count($reviewSlide2)>0)

                    <li data-target="#TestimonialsIndicators" data-slide-to="1" ></li>
                    @endif

                    @if(isset($reviewSlide3) && count($reviewSlide3)>0)

                    <li data-target="#TestimonialsIndicators" data-slide-to="2"></li>
                    @endif
                </ol>
                <div class="carousel-inner">
                @if(isset($reviewSlide1))
                    <div class="carousel-item active ">
                        <div class="row">
                            @forelse($reviewSlide1 as $key => $review)
                                <div class="col-lg-4 col-md-6">
                                    <div class="crsl_box">
                                        <img src="{{@$review->user->image_thumb}}" class="tstmnls_img" alt="" title="">
                                        <h4>{{@$review->user->full_name}}</h4>
                                        <div class="fixedStar fixedStar_readonly" data-score='{{@$review->rating}}' readonly></div>
                                        <p class="more">{{@$review->msg}}</p>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                @endif
                @if(isset($reviewSlide2))
                    <div class="carousel-item ">
                        <div class="row">
                            @forelse($reviewSlide2 as $key => $review)
                                <div class="col-lg-4 col-md-6">
                                    <div class="crsl_box">
                                        <img src="{{@$review->user->image_thumb}}" class="tstmnls_img" alt="" title="">
                                        <h4>{{@$review->user->full_name}}</h4>
                                        <div class="fixedStar fixedStar_readonly" data-score='{{@$review->rating}}' readonly></div>
                                        <p class="more">{{@$review->msg}}</p>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                @endif
                @if(isset($reviewSlide3))
                    <div class="carousel-item ">
                        <div class="row">
                            @forelse($reviewSlide3 as $key => $review)
                                <div class="col-lg-4 col-md-6">
                                    <div class="crsl_box">
                                        <img src="{{@$review->user->image_thumb}}" class="tstmnls_img" alt="" title="">
                                        <h4>{{@$review->user->full_name}}</h4>
                                        <div class="fixedStar fixedStar_readonly" data-score='{{@$review->rating}}' readonly></div>
                                        <p class="more">{{@$review->msg}}</p>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>