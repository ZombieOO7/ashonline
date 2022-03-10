<a class=" view" href="{{ route('assessment.question.create',[@$questionData->uuid]) }}" title="{{__('formname.edit')}}">
    <i class="fas fa-pencil-alt"></i>
</a>
<a class="delete" href="javascript:;" data-module_name="Question" id="{{@$questionData->uuid}}" data-table_name="question_table" data-uuid="{{ @$questionData->uuid }}"
    data-url="{{route('assessment.question.destroy')}}" title="{{__('formname.delete')}}"><i class="fas fa-trash-alt"></i>
</a>
<a class=" view" href="{{ route('assessment.question.detail',[@$questionData->uuid]) }}" title="Detail">
    <i class="fas fa-eye"></i>
</a>