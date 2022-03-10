@php
    $questionHtml = '';
    $questionTitle = '';
@endphp
@php
    $questionTitle .= '<b>Q-'.$questionData->id.' </b>';
@endphp
@forelse(@$questionData->questionsList as $key => $question)
    @php
        $key++;
        $questionHtml .= '<p><b>'.$key.' </b> '.$question->question.'</p>';
    @endphp
@empty
@endforelse
@php
    if($questionData->question_title != null){
       $questionTitle .= '<b>'.$questionData->question_title.'</b>';
     $questionTitle .='<br/>'.$questionHtml;
    } else {
        $questionTitle = '<b>Q-'.$questionData->id.' </b>'.$questionHtml;
    }
@endphp
{!! Str::limit($questionTitle, 20) !!}
@if( strlen($questionTitle) > 25)
    <a href="javascript:void(0);" class="shw-dsc"
       data-title="{{ @$title }}"
       {{-- data-question="{{@$questionTitle}}" --}}
       data-description="{{ @$questionTitle }}"
       data-toggle="modal"
       data-target="#DescModal">
        {{ __('formname.read_more') }}
    </a>
@elseif(strlen($questionTitle) < 25)
    <a href="javascript:void(0);" class="shw-dsc"
       data-title="{{ @$title }}"
       data-description="{{ @$questionTitle }}"
       data-toggle="modal"
       data-target="#DescModal">
    </a>
@endif
