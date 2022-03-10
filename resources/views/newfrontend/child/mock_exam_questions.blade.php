@if(isset($question->questionData->questionPdfs->question_pdf))
<embed src="{{$question->questionData->questionPdfs->question_pdf}}" type="application/pdf" width="100%" height="400px" />
@endif
@if(isset($question->questionData->questionImages->question_pdf))
    <img class="img-fluid" src="{{$question->questionData->questionImages->question_pdf}}" width="250px" height="250px" >
@endif
<b><p>{{ @$question->questionData->question_title }}</p></b>
<h3><span>Q <b class="qus-no">{{ @$questionNo }}</b>.</span> {{ @$question->questionList->question }}</h3>
@if(isset($question->questionList->image_path) && ($question->questionList->image_path != null))
    <img class="img-fluid" src="{{@$question->questionList->image_path}}" width="250px" height="250px" >
@endif
<div class="inin_qstn_box mrgn_bt_30 mrgn_tp_40">
@php
    $alphabet = ord("a");
@endphp
@if(@$question->questionData->question_type == 1)
<ul class="qsa_optns @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2) unread_tr @endif" style="@if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)pointer-events: none;@endif">
        @forelse ($answers as $ans)
        <li>
            <div class="optn_bbx">
                <input @if(@$prev_selected_ans == $ans->id && $review == true) checked @endif type="radio" class="ans-rdo" data-mock-test-id="{{ @$mockTest->id }}" data-current_question_id="{{ @$question->id }}" name="asnwer" value="{{ @$ans->id }}" id="asnwer_{{chr($alphabet)}}" @if($mockTest->stage_id != NULL && $mockTest->stage_id == 2)disabled @endif>
                <label><span>{{chr($alphabet)}}.</span> {{ @$ans->answer }}</label>
                <input type="hidden" name="time_taken" value="{{ @$ans->time_taken }}" id='timeTaken'>
            </div>
        </li>
        @php  $alphabet++; @endphp
        @empty
            
        @endforelse
    </ul>
@endif
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>