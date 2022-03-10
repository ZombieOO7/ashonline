    <button type="button" class="btn cmplt_btn2"
    data-subject-id="{{ @$subject_id }}"
    data-type="next"
    data-current_question_id="{{ @$current_question_id}}"
    data-mock-test-id="{{ @$mockTest->id }}"
    data-mock-test-title="{{ @$mockTest->title }}"
{{--    data-mock-test-image="{{ @$mockTest->image_path }}" --}}
    data-mock-test-image="{{@$mockTest->image ? url('storage/app/public/uploads/'.@$mockTest->image)
                                                                                : $mockTest->imagepath  }}"
    data-url="{{ route('mock-detail',[@$mockTest->uuid]) }}"
    data-toggle="modal"
    data-target="#CompletionSuccessfulModal">Submit Paper</button>
