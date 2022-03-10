    <a class=" view" href="{{ URL::signedRoute('parent_edit',['uuid'=>@$parent->uuid]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>

    <a class="delete" href="javascript:;" data-module_name="Parent" data-module="parent" id="{{@$parent->uuid}}" data-uuid="{{@$parent->uuid}}" data-table_name="parent_table" data-url="{{route('parent_delete')}}" title="{{__('formname.delete')}}">
        <i class="fas fa-trash-alt"></i>
    </a>

    @if(@$parent->status==config('constant.status_active_value'))    
        <a class=" active_inactive" href="javascript:;" data-module="parent" id="{{@$parent->uuid}}" data-uuid="{{@$parent->uuid}}" data-url="{{ route('parent_active_inactive', [@$parent->id]) }}" data-table_name="parent_table" title="Active">
            <i class="fas fa-toggle-on"></i>
        </a>
    @else
        <a class=" active_inactive" href="javascript:;" data-module="parent" id="{{@$parent->uuid}}" data-uuid="{{@$parent->uuid}}" data-url="{{ route('parent_active_inactive', [@$parent->id]) }}" data-table_name="parent_table" title="Inactive">
            <i class="fas fa-toggle-off"></i>
        </a>
    @endif
