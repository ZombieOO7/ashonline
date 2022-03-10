<ul class="qsrslt_lst">
    @forelse(@$previewQuestionList??[] as $qKey => $previewQuestion)
        @php
            $class2 = '';
            if($previewQuestion['is_attempted']== 1){
                $class = 'correctAns';
            }else{
                $class = '';
            }
            if($previewQuestion['question_id'] == @$question->id){
                $class2 = 'font-weight-bold';
            }
        @endphp
        <li class="goToQuestion cursor-pointer {{$class.' '.$class2}}" 
            data-index="{{$qKey}}"  data-questionNo="{{$qKey+1}}" 
            data-id="{{@$question->id}}" data-questionId="{{$previewQuestion['id']}}">
            <span class="{{$class2}}">{{@$qKey+1}}</span>
        </li>
    @empty
    @endforelse
</ul>