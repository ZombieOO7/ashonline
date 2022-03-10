@if ($question->questionData->question_type == 1)
    <span class="answerList">
        @php
            $alphabet = ord("A");
        @endphp
        <ul class="qsa_optns pl-4">
        @forelse (@$answers as $ans)
            <li>
                @if(@$ans->is_correct == '1')
                    <h6 class="text-success">
                        {{chr($alphabet)}}. {!! @$ans->answer !!}
                        <span class="fa fa-check"></span>
                    </h6>
                @else
                    <h6>
                        {{chr($alphabet)}}. {!! @$ans->answer !!}
                    </h6>
                @endif
            </li>
            @php $alphabet++; @endphp
        @empty
        @endforelse
        </ul>
    </span>
@else
    <div class="answerList ml-5">
        <strong>Correct Answer : </strong>
        <h6 class="text-success">
            {!! @$answers[0]->answer !!}
        </h6>
    </div>
    <div class="answerList ml-5">
        <label for="" class="col-form-label col-lg-3 col-sm-12"></label>
        <div class="col-lg-12 col-md-12 col-sm-12">
            @if($question->questionData->resize_full_image != null)
                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->questionData->answer_image_path}}">
                    {!! $question->questionData->resize_answer_image !!}
                </span>
            @else
                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->questionData->answer_image_path}}">
                    <img id="q_image_preview_1" src="{{@$question->questionData->answer_image_path}}" class="img-fluid" style="display:{{isset($question->questionData->answer_image_path) && @$question->questionData->answer_image != null ?'':'none'}};" />
                </span>
            @endif
        </div>
    </div>
@endif