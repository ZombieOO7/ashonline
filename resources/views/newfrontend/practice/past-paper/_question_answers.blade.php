<div class="col-md-12 mb-5">
    <div class="">
        <ul class="nav nav-pills qstb_pnt" id="QS{{$questionAnswer->id}}Tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="qs{{$questionAnswer->id}}-tab" data-toggle="pill" href="#qs{{$questionAnswer->id}}"
                    role="tab" aria-controls="qs{{$questionAnswer->id}}" aria-selected="true">Question</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="ans{{$questionAnswer->id}}-tab" data-toggle="pill" href="#ans{{$questionAnswer->id}}"
                    role="tab" aria-controls="ans{{$questionAnswer->id}}" aria-selected="false">Answer</a>
            </li>
        </ul>
        <div class="tab-content qstb_cntnt_pnt" id="QS{{$questionAnswer->id}}TabContent">
            <div class="tab-pane fade show active" id="qs{{$questionAnswer->id}}" role="tabpanel"
                aria-labelledby="qs{{$questionAnswer->id}}-tab">
                {{-- <div class="q_img_sc">
                    <img src="{{@$questionAnswer->question_image_path}}" class="img-fluid">
                </div> --}}
                @if($questionAnswer->question_image != null)
                    <div class="q_img_sc">
                        @if($questionAnswer->resize_question_image != null)
                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$questionAnswer->question_image_path}}">
                                {!! @$questionAnswer->resize_question_image !!}
                            </span>
                        @else
                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$questionAnswer->question_image_path}}">
                                <img src="{{@$questionAnswer->question_image_path}}" class="img-fluid">
                            </span>
                        @endif
                    </div>
                @endif
                <div class="qs_action_sc">
                    <div class="row">
                        <div class="col-xl-7 mb-4">
                            <h4 class="mb-4">Topic</h4>
                            @forelse(@$questionAnswer->topicData??[] as $qtopicKey => $topic)
                                <a href="{{route('topic.question',['slug'=>@$topic['slug']])}}" class="btn btn_join btn_l_blue mt-2">{{@$topic->title}}</a>
                            @empty
                            @endforelse
                            {{-- <a href="javascript:;" class="btn btn_join btn_l_blue mr-2">{{@$questionAnswer->topic->title}}</a> --}}
                        </div>
                        <div class="col-xl-5 mb-3">
                            <h4>Solve this question in</h4>
                            <h6>{{hoursAndMins(@$questionAnswer->solved_question_time)}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="ans{{$questionAnswer->id}}" role="tabpanel" aria-labelledby="ans{{$questionAnswer->id}}-tab">
                {{-- @if($questionAnswer->answer_image != null) --}}
                    <div class="q_img_sc">
                        @if($questionAnswer->resize_answer_image != null)
                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$questionAnswer->answer_image_path}}">
                                {!! @$questionAnswer->resize_answer_image !!}
                            </span>
                        @else
                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$questionAnswer->answer_image_path}}">
                                <img src="{{@$questionAnswer->answer_image_path}}" class="img-fluid">
                            </span>
                        @endif
                    </div>
                {{-- @endif --}}
                <div class="qs_action_sc">
                    <div class="row">
                        <div class="col-xl-7 mb-4">
                            <h4 class="mb-4">Topic</h4>
                            @forelse(@$questionAnswer->topicData??[] as $atopicKey => $topic)
                                <a href="{{route('topic.question',['slug'=>@$topic['slug']])}}" class="btn btn_join btn_l_blue mt-2">{{ucfirst(@$topic['title'])}}</a>
                            @empty
                            @endforelse
                            {{-- <a href="javascript:;" class="btn btn_join btn_l_blue mr-2">{{@$questionAnswer->topic->title}}</a> --}}
                        </div>
                        <div class="col-xl-5 mb-3">
                            <h4>Solve this question in</h4>
                            <h6>{{hoursAndMins(@$questionAnswer->solved_question_time)}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>