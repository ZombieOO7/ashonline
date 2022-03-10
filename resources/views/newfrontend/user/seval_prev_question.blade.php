

<button type="button" class="btn prvs_btn prv_qus" 
data-subject_id="{{ @$firstQuestion->subject_id }}"  
data-mock_test_id="{{ @$firstQuestion->mock_test_id  }}" 
data-btn_type="prev-sub-question" 
data-current_question_id="{{ @$firstQuestion->id  }}" 
data-prev_question_id="{{ @$prevQuestionId }}" 
data-next_question_id="{{ @$nextQuestionId }}" 
data-current_sub_question_id="{{ @$firstQuestion->id }}" 
data-prev_sub_question_id="{{ @$prevQuestionId }}" 
data-next_sub_question_id="{{ @$nextQuestionId }}" 
data-current_question_number="{{ @$questionNo }}" 
data-prev_question_number="{{ @$prevQuestionNo }}" 
data-next_question_number="{{ @$nextQuestionNo}}" 
{{($prevQuestionId =='' || $prevQuestionId==null) ?'disabled':''}}> Prev Question</button>