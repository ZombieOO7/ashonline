
{{-- Action bar for user --}}
@if(isset($Schools) && $colType == config('constant.col_action'))
    <a target="_blank"href="{{route('admin.schools.show',[@$Schools->uuid])}}" class="glyphicon glyphicon-list-alt" title="Detail">
        <i class="fa fa-eye">
        </i>
    </a>
    <a class=" view" href="{{ route('admin.schools.edit',[@$Schools->uuid]) }}" title="{{trans('general.school.edit_school')}}">
        <i class="fas fa-pencil-alt">
        </i>
    </a>

    <a class="delete" href="javascript:;" id="{{@$Schools->uuid}}" data-module_name="School" data-uuid="{{@$Schools->uuid}}" data-url="{{ route('schools.destroy',[@$Schools->uuid])}}" data-table_name="schools_table"  title="{{trans('general.school.delete_school')}}">
        <i class="fas fa-trash-alt">
        </i>
    </a>

    <a class="active_inactive" href="javascript:;" id="{{@$Schools->uuid}}"
        data-url="{{ route('schools/active/inactive', [@$Schools->uuid]) }}" data-uuid="{{ @$Schools->uuid }}" data-status="{{ (@$Schools->active == config('constant.status_active_value') ) ? 0 : 1 }}" data-table_name="schools_table"
        title="{{@$Schools->active_text}}">
        @if(@$Schools->active == config('constant.status_active_value'))
            <i class="fas fa-toggle-on"></i>
        @else
            <i class="fas fa-toggle-off"></i>
        @endif
    </a>

{{-- Checkbox for users --}}
@elseif(isset($SchoolsTable) && $colType == config('constant.col_checkbox'))
    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
        <input type="checkbox" name="users_checkbox[]" value="{{@$SchoolsTable->id}}" class="m-checkable checkbox">
        <span></span>
    </label>
@endif