@php
    $questionHtml = '';
@endphp
@forelse(@$questionData->questionsList as $key => $question)
    @php
        $key++;
        if(isset($question->correctAnswer->answer)){
            $questionHtml .= '<p><b>Ans '.$key.' => </b>'.@$question->correctAnswer->answer.'</p>';
        }else{
            $questionHtml .= '<p><b>Ans '.$key.' =>'.__('formname.answer_not_found').'</b></p>';
        }
    @endphp
@empty
    @php
        $questionHtml .= '<b>'.__('formname.answer_not_found').'</b>';
    @endphp
@endforelse
<a href="javascript:void(0);" class="shw-dsc" data-title="{{ @$title }}" data-question="{{@$questionHtml}}"
data-toggle="modal" data-target="#DescModal">
    {{ __('formname.show') }}
</a>