@forelse($previewQuestionList??[] as $qKey => $sectionQuestionList)
    @if(isset($previewQuestionList) && count($previewQuestionList) > 1)
    <div class="font-weight-bold mb-3">{{@$sectionQuestionList['section']}}</div>
    @endif
    <ul>
        @forelse(@$sectionQuestionList['data']??[] as $qKey => $previewQuestion)
        @php
            $class2 = '';
            if(@$previewQuestion['mark_as_review'] == 1){
                $class = 'yellow_review_actv';
            }elseif(@$previewQuestion['is_attempted']== 1){
                // $class = 'active_green';
                $class = '';
            }else{
                $class = '';
            }
            if(@$previewQuestion['question_id'] == @$firstQuestion->id){
                $class2 = 'font-weight-bold';
            }
        @endphp
        <li class="quest_lst_n {{$class.' '.$class2}}" data-index="{{$qKey}}">
            <span class="q_counter_num {{$class2}}">{{@$previewQuestion['q_no']}}</span>
            {{@shortContent($previewQuestion['question'],120)}}
        </li>
        @empty
        @endforelse
    </ul>
@empty
@endforelse