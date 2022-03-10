<a class=" view" href="{{ route('question.create',[@$questionData->uuid]) }}" title="{{__('formname.edit')}}">
    <i class="fas fa-pencil-alt"></i>
</a>
<a class="delete" href="javascript:;" data-module_name="Question" id="{{@$questionData->uuid}}" data-table_name="question_table" data-uuid="{{ @$questionData->uuid }}"
    data-url="{{route('question.destroy')}}" title="{{__('formname.delete')}}"><i class="fas fa-trash-alt"></i>
</a>
<a class=" view" href="{{ route('question.detail',[@$questionData->uuid]) }}" title="Detail">
    <i class="fas fa-eye"></i>
</a>
{{-- <a class="active_inactive" href="javascript:;" id="{{@$questionData->uuid}}"
    data-url="{{ route('question.active.inactive', [@$questionData->uuid]) }}" data-uuid="{{ @$questionData->uuid }}" data-status="{{ (@$questionData->active == 1 ) ? 0 : 1 }}" data-table_name="question_table"
    title="{{@$questionData->active_text}}">
    @if(@$questionData->active == 1)
        <i class="fas fa-toggle-on"></i>
    @else
        <i class="fas fa-toggle-off"></i>
    @endif
</a> --}}