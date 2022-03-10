@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('stage edit')))
    <a class=" view" href="{{ URL::signedRoute('stage_edit',['id'=>@$stage->uuid]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>

    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('stage delete')))
        <a class="delete" href="javascript:;" id="{{@$stage->uuid}}" data-table_name="stage_table" data-url="{{route('stage_delete')}}" title="{{__('formname.delete')}}">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endif

    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('stage active inactive')))
        @if(@$stage->status=='1')
            <a class=" active_inactive" href="javascript:;" id="{{@$stage->uuid}}" data-url="{{ route('stage_active_inactive', [@$stage->id]) }}" data-table_name="stage_table" title="Active">
                <i class="fas fa-toggle-on"></i>
            </a>
        @else
            <a class=" active_inactive" href="javascript:;" id="{{@$stage->uuid}}" data-url="{{ route('stage_active_inactive', [@$stage->id]) }}" data-table_name="stage_table" title="Inactive">
                <i class="fas fa-toggle-off"></i>
            </a>
        @endif
    @endif
@endif