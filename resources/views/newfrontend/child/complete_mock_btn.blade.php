@if(@$nextSubjectId != null)
    @if(@$nextQuestionId)
        <button type="button" class="drk_blue_btn nxtSubQue" disabled data-toggle="modal" data-target='#StartNextSectionModal' data-subject-id="{{ @$subject_id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
            data-mock-test-image="{{ @$mockTest->image_path }}"
            data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}">Next Paper
        </button>
    @else
        <button type="button" class="drk_blue_btn nxtSubQue" data-toggle="modal" data-target='#StartNextSectionModal'  data-subject-id="{{ @$subject_id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
            data-mock-test-image="{{ @$mockTest->image_path }}"
            data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}">Next Paper
        </button>
    @endif
@elseif(@$nextQuestionId)
    <button type="button" class="btn cmplt_btn" disabled>Submit Paper</button>
@else
    <button type="button" class="btn cmplt_btn " data-subject-id="{{ @$subject_id }}" data-type="next" data-current_question_id="{{ @$current_question_id}}"  data-mock-test-id="{{ @$mockTest->id }}" data-mock-test-title="{{ @$mockTest->title }}"
            data-mock-test-image="{{ @$mockTest->image_path }}"
            data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}">Submit Paper</button>
@endif
