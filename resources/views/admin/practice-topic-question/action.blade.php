<a class=" view" href="{{ route('practice-topic-question.create',[@$questionData->uuid]) }}" title="{{__('formname.edit')}}">
    <i class="fas fa-pencil-alt"></i>
</a>
<a class="delete" href="javascript:;" data-module_name="Question" id="{{@$questionData->uuid}}" data-table_name="question_table" data-uuid="{{ @$questionData->uuid }}"
    data-url="{{route('practice-topic-question.destroy')}}" title="{{__('formname.delete')}}"><i class="fas fa-trash-alt"></i>
</a>
<a class=" view" href="{{ route('practice-topic-question.detail',[@$questionData->uuid]) }}" title="Detail">
    <i class="fas fa-eye"></i>
</a>