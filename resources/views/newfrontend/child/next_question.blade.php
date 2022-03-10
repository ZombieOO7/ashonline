@if(@$nextQuestionId ) 
    <button type="button" class="btn nxt_btn nxt_qus" data-question-number="" data-subject-id="{{ @$subject_id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}" data-prev-question-id="{{ @$prev_question_id }}" data-mock-test-id="{{ @$mockTest->id }}" data-next-question-id="{{ @$nextQuestionId }}"  >Next Question</button>
@else
    <button type="button" class="btn nxt_btn" disabled>Next Question</button>
@endif