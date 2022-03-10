
@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('paper edit')))
    <a class=" view" href="{{ URL::signedRoute('paper_edit',['id'=>@$paper->id]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>
    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('paper delete')))
    <a class="deletePaper" href="javascript:;" data-module_name="Paper" id="{{@$paper->uuid}}" data-table_name="paper_table" data-delete-url="{{route('paper_delete')}}" data-url="{{route('paper_info',[@$paper->uuid])}}" title="{{__('formname.delete')}}">
        <i class="fas fa-trash-alt"></i>
    </a>
    @endif

    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('paper active inactive')))
        @if(@$paper->status=='1')
            <a class=" active_inactive" href="javascript:;" id="{{@$paper->uuid}}" data-url="{{ route('paper_active_inactive', [@$paper->id]) }}" data-table_name="paper_table" title="Active">
                <i class="fas fa-toggle-on"></i>
            </a>
        @else
            <a class=" active_inactive" href="javascript:;" id="{{@$paper->uuid}}" data-url="{{ route('paper_active_inactive', [@$paper->id]) }}" data-table_name="paper_table" title="Inactive">
                <i class="fas fa-toggle-off"></i>
            </a>
        @endif
    @endif

    <a class=" view" href="{{ route('paper_version',['uuid'=>@$paper->uuid]) }}" title="Paper Versions">
        <i class="fas fa-eye"></i>
    </a>
@endif