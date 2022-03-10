@if($type == 'question_image')
    @if($question->question_image != null)
        @if($question->resize_question_image != null)
            <div class="col-md-12">
                <div class="optn_infrmtn_v1 pt-3 pl-4">
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->question_image_path}}">
                        {!! @$question->resize_question_image !!}
                    </span>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="optn_infrmtn_v1 pt-3 pl-4">
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->question_image_path}}">
                        <img class="img-fluid" src="{{@$question->question_image_path}}">
                    </span>
                </div>
            </div>
        @endif
    @endif
@endif
@if($type == 'answer_image')
    @if($question->answer_image != null)
        @if($question->resize_answer_image != null)
            <div class="col-md-12">
                <div class="optn_infrmtn_v1 pt-3 pl-4">
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->answer_image_path}}">
                        {!! @$question->resize_answer_image !!}
                    </span>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="optn_infrmtn_v1 pt-3 pl-4">
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->answer_image_path}}">
                        <img class="img-fluid" src="{{@$question->answer_image_path}}">
                    </span>
                </div>
            </div>
        @endif
    @endif
@endif