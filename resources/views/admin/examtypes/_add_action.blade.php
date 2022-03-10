@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('exam types edit')))
    <a class=" view" href="{{ URL::signedRoute('exam_types_edit',['id'=>@$examType->id]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>

    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('exam types delete')))
        <a class="delete" href="javascript:;" id="{{@$examType->uuid}}" data-module_name="Exam Type" data-table_name="exam_type_table" data-url="{{route('exam_types_delete')}}" title="{{__('formname.delete')}}">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endif
@endif