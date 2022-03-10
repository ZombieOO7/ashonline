<div class="row col-md-12">
    <div class="{{-- col-md-6 --}} m-accordion row" id="m_accordion_{{@$questionData->id}}" role="tablist">
        <div class="m-accordion__item row">
            <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_{{@$questionData->id}}_item_{{@$questionData->id}}_head" data-toggle="collapse" href="#m_accordion_{{@$questionData->id}}_item_{{@$questionData->id}}_body" aria-expanded="    false">
                <span class="m-accordion__item-title"><b>Q {{@$questionData->question_no}}).</b>{!! Str::limit(@$questionData->question, 100) !!}</span>
            </div>
        </div>
    </div>
</div>
<div class="m-accordion__item-body collapse" id="m_accordion_{{@$questionData->id}}_item_{{@$questionData->id}}_body" class=" " role="tabpanel" aria-labelledby="m_accordion_{{@$questionData->id}}" data-parent="#m_accordion_{{@$questionData->id}}">
    {{-- @forelse(@$questionData->questionsList as $key => $question) --}}
        <div class="row col-md-12 m-accordion__item-content">
            <div class="col-md-12">
                <div class="m-accordion__item-head collapsed border-bottom" role="tab" id="m_accordion_{{@$questionData->id}}_item_{{@$question->id}}_head" data-toggle="collapse" href="#m_accordion_{{@$questionData->id}}_item_{{@$questionData->id}}_body" aria-expanded="    false">
                    <div class="m-accordion__item-content">
                            @php $i=65; @endphp
                            @forelse ($questionData->answers as $answer)
                                <div class="m-2 font-bold {{($answer->is_correct==1)?'text-success':'text-danger'}}">{{chr($i)}}){{@$answer->answer}}</div>
                                @php $i++; @endphp
                            @empty
                            @endforelse
                    </div>
                </div>
            </div>
        </div>
    {{-- @empty --}}
    {{-- @endforelse --}}
</div>
