@if(@$prev_question_id ) 
    <button type="button" class="btn prvs_btn nxt_qus" data-question-number=""  data-subject-id="{{ @$subject_id }}" data-current_question_id="{{ @$current_question_id}}" data-type="prev" data-prev-question-id="{{ @$prev_question_id }}" data-mock-test-id="{{ @$mockTest->id }}" data-next-question-id="{{ @$nextQuestionId }}">Previous Question</button>
@else 
    <button type="button" class="btn prvs_btn" disabled>Previous Question</button>
@endif