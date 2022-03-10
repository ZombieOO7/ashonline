@if(@$question->instruction != null)
    <div class="row col-md-12">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <label for="" class="form-label font-weight-bold">Question Instruction</label>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! @$question->instruction !!}
        </div>
    </div>
@endif
<div class="row col-md-12 mt-2">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <label for="" class="form-label font-weight-bold">Question</label>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
        {!! @$question->question !!}
    </div>
</div>
@if(@$question->topic_id != null && @$question->topic->title != null)
    <div class="row col-md-12 mt-2">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <label for="" class="form-label font-weight-bold">Topic:</label>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! @$question->topic->title !!}
        </div>
    </div>
@endif
<div class="row">
    @if(@$question->image != null)
        <div class="col-lg-12 col-md-6 col-sm-12">
            <div class="col-md-12">
                <label for="" class="form-label font-weight-bold">Image Full</label>
            </div>
            <div class="col-md-12">
                @if($question->resize_full_image != null)
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                        {!! @$question->resize_full_image !!}
                    </span>
                @else
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                        <img class="img-fluid mb-3" src="{{@$question->image_path}}">
                    </span>
                @endif
            </div>
        </div>
    @endif
    @if(@$question->question_image != null)
        <div class="col-lg-12 col-md-6 col-sm-12">
            <div class="col-md-12">
                <label for="" class="form-label font-weight-bold">Question Image </label>
            </div>
            <div class="col-md-12">
                @if(@$question->resize_question_image != null)
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->question_image_path}}">
                        {!! @$question->resize_question_image !!}
                    </span>
                @else
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->question_image_path}}">
                        <img class="img-fluid mb-3" src="{{@$question->question_image_path}}">
                    </span>
                @endif
            </div>
        </div>
    @endif
    @if(@$question->answer_image != null)
        <div class="col-lg-12 col-md-6 col-sm-12">
            <div class="col-md-12">
                <label for="" class="form-label font-weight-bold">Answer Image </label>
            </div>
            <div class="col-md-12">
                @if($question->resize_full_image != null)
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->answer_image_path}}">
                        {!! $question->resize_answer_image !!}
                    </span>
                @else
                    <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->answer_image_path}}">
                        <img id="q_image_preview_1" src="{{@$question->answer_image_path}}" class="img-fluid" style="display:{{isset($question->answer_image_path) && @$question->answer_image != null ?'':'none'}};" />
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>
@if (@$mockTest->stage_id == 1)
<div class="row col-md-12 mt-2">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <label for="" class="form-label font-weight-bold">Options:</label>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
        @php $alphabet = ord("A"); @endphp
        @if(@$question->type == 4)
        <div class="col-md-12 row">
            <div class="col-md-6">
                @forelse(@$question->answers??[] as $akey => $answer)
                    @if($akey < 3)
                        <div>
                            @if($answer->is_correct == 1)
                                <h6 class="text-success">
                                    <strong>{{chr($alphabet)}}. {!! @$answer->answer !!} </strong>
                                    <span class="fa fa-check"></span>
                                </h6>
                            @else
                                @if(in_array(@$answer->id,$studentTestQuestionAnswer->selected_answers))
                                    <span class="text-danger">
                                @endif
                                    <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!}
                                @if(in_array(@$answer->id,$studentTestQuestionAnswer->selected_answers))
                                    <i class="fa fa-times"></i>
                                    </span>
                                @endif
                                {{-- <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!} --}}
                            @endif
                            @php $alphabet++; @endphp
                        </div>
                    @endif
                @empty
                @endforelse
            </div>
            <div class="col-md-6">
                @forelse(@$question->answers??[] as $akey => $answer)
                    @if($akey > 2)
                        <div>
                            @if($answer->is_correct == 1)
                                    <h6 class="text-success">
                                        <strong>{{chr($alphabet)}}. {!! @$answer->answer !!} </strong>
                                        <span class="fa fa-check"></span>
                                    </h6>
                            @else
                                @if(in_array(@$answer->id,$studentTestQuestionAnswer->selected_answers))
                                    <span class="text-danger">
                                @endif
                                    <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!}
                                @if(in_array(@$answer->id,$studentTestQuestionAnswer->selected_answers))
                                    <i class="fa fa-times"></i>
                                    </span>
                                @endif
                                {{-- <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!} --}}
                            @endif
                            @php $alphabet++; @endphp
                        </div>
                    @endif
                @empty
                @endforelse
            </div>
        @else
            @forelse(@$question->answers??[] as $answer)
                <div class="col-md-12">
                    @if($answer->is_correct == 1)
                        <h6 class="text-success">
                            <strong>{{chr($alphabet)}}. {!! @$answer->answer !!} </strong>
                            <span class="fa fa-check"></span>
                        </h6>
                    @else
                        @if(in_array(@$answer->id,$studentTestQuestionAnswer->selected_answers))
                            <span class="text-danger">
                        @endif
                            <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!}
                        @if(in_array(@$answer->id,$studentTestQuestionAnswer->selected_answers))
                            <i class="fa fa-times"></i>
                            </span>
                        @endif
                    @endif
                </div>
                @php
                    $alphabet++;
                @endphp
            @empty
            @endforelse
        @endif
    </div>
</div>
@else
    @if(@$question->answers[0]->answer != null && @$question->answers[0]->answer != ' ')
        <div class="col-md-12 mt-2">
            <strong>Correct Answer : </strong>
            <div class="text-success">
                {!! $question->answers[0]->answer !!}
            </div>
        </div>
    @endif
@endif
@if (@$mockTest->stage_id == 1)
    <div class="row col-md-12 mt-2">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <label for="" class="form-label font-weight-bold">Your Answer:</label>
            {{$studentTestQuestionAnswer->selected_answer_text ?? @$studentTestQuestionAnswer->selected_answer_text }}
        </div>
    </div>
@endif
@if(@$question->explanation != null)
    <div class="row col-md-12 mt-2">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <label for="" class="form-label font-weight-bold">Explanation:</label>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! @$question->explanation !!}
        </div>
    </div>
@endif