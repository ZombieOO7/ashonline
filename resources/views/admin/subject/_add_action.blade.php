@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('subject edit')))
    <a class=" view" href="{{ URL::signedRoute('subject_edit',['id'=>$subject->id]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>

    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('subject delete')))
        <a class="delete" href="javascript:;" id="{{$subject->uuid}}" data-table_name="subject_table" data-module_name="Subject" data-url="{{route('subject_delete')}}" title="{{__('formname.delete')}}">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endif
@endif