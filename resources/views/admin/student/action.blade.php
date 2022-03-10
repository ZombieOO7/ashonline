{{-- Action bar for category --}}
@if(isset($student) && $type == config('constant.col_action'))
    <a href="{{route('admin.student.show',[@$student->uuid])}}" class="glyphicon glyphicon-list-alt" title="Student Detail Page">
        <i class="fa fa-eye">
        </i>
    </a>
    &nbsp;
    <a class=" view" href="{{ route('admin.student.edit',[@$student->uuid]) }}" title="{{trans('general.edit')}}">
        <i class="fas fa-pencil-alt">
        </i>
    </a>

    <a class="delete" href="javascript:;" data-module_name="Student" id="{{@$student->uuid}}" data-uuid="{{@$student->uuid}}" data-url="{{ route('student.destroy',[@$student->uuid])}}" data-table_name="student_table"  title="{{trans('general.delete')}}" data-module="student">
        <i class="fas fa-trash-alt">
        </i>
    </a>
    <a class="active_inactive" href="javascript:;" id="{{@$student->uuid}}" data-status="{{(@$student->active) ? 0 : 1}}" data-uuid="{{@$student->uuid}}" data-url="{{ route('student.active.inactive', [@$student->uuid]) }}" data-table_name="student_table" title="{{@$student->active_text}}" data-module="student">
        @if(@$student->active)
            <i class="fas fa-toggle-on"></i>
        @else
            <i class="fas fa-toggle-off"></i>
        @endif
    </a>
@elseif(isset($student) && $type == config('constant.col_checkbox'))
    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
        <input type="checkbox" name="student_checkbox[]" value="{{@$student->uuid}}" class="m-checkable checkbox">
        <span></span>
    </label>
@endif