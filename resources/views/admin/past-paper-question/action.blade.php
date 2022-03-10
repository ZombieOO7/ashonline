<a class=" view" href="{{ route('past-paper-question.edit',[@$questionData->uuid]) }}" title="{{__('formname.edit')}}">
    <i class="fas fa-pencil-alt"></i>
</a>
<a class="delete" href="javascript:;" data-module_name="Question" id="{{@$questionData->uuid}}" data-table_name="question_table" data-uuid="{{ @$questionData->uuid }}"
    data-url="{{route('past-paper-question.delete',['uuid'=>@$questionData->uuid])}}" title="{{__('formname.delete')}}"><i class="fas fa-trash-alt"></i>
</a>