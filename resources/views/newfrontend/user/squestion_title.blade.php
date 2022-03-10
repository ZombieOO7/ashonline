<div class="quest-title">
    <h3 class="mb-0">
        <div class="mb-3">
            <span class="q_no">Q {{ @$question->questionData->question_no }}. </span>
            {!! @$question->questionData->instruction !!}
            {!! @$question->questionData->question !!}
        </div>
        @if(($question->questionData->image != null))
            <div class="viwDetail">
                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">{{__('formname.view_question')}}</a>
            </div>
        @endif
    </h3>
    @if(($question->questionData->image != null))
        <div class='row collapse ml-5' id="collapseExample">
            @if($question->questionData->resize_full_image)
                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->questionData->image_path}}">
                    {!! @$question->questionData->resize_full_image !!}
                </span>
            @else
                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->questionData->image_path}}">
                    <img class="img-fluid mb-3" src="{{@$question->questionData->image_path}}">
                </span>
            @endif
        </div>
    @endif
</div>
@if ($question->questionData->questionData_type == 1)
    <span class="answerList">
        @php
            $alphabet = ord("A");
        @endphp
        <ul class="qsa_optns pl-4">
        @forelse (@$question->questionData->answers as $ans)
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
    <span class="answerList">
        <div class="quest-title ml-5">
            <strong>Correct Answer : </strong>
            <h6 class="text-success">
                {!! @$answers[0]->answer !!}
                <span class="fa fa-check"></span>
            </h6>
        </div>
    </span>
@endif
<div class="ml-4 row">
    <label for="" class="col-form-label col-lg-3 col-sm-12"></label>
    <div class="col-lg-12 col-md-12 col-sm-12 ml-2">
        @if(($question->questionData->answer_image != null))
            @if($question->questionData->resize_answer_image)
                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->questionData->answer_image_path}}">
                    {!! @$question->questionData->resize_answer_image !!}
                </span>
            @else
                <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->questionData->answer_image_path}}">
                    <img id="q_image_preview_1" src="{{@$question->questionData->answer_image_path}}" class="img-fluid" style="display:{{isset($question->questionData->answer_image_path) && @$question->questionData->answer_image != null ?'':'none'}};" />
                </span>
            @endif
        @endif
    </div>
</div>
@if(@$question->questionData->explanation != null)
    <div class="row row ml-5 mt-5">
        <h5>Explanation</h5>
        {!! @$question->questionData->explanation !!}
    </div>
@endif
<div class="row ml-2 mt-5">
    <span class="h5 lastQuestionLabel text-danger" style="display: @if($nextQuestionId != '' || $nextQuestionId != null) none; @endif">{{__('formname.last_paper_question_note')}}</span>
</div>