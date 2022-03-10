{{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('Past Paper edit'))) --}}
    <a class="" href="{{route('past-paper.show',['uuid'=>@$pastPaper->uuid])}}" id="{{@$pastPaper->uuid}}" data-module_name="Past Paper" data-table_name="past_paper_table" title="{{__('formname.show')}}">
        <i class="fas fa-eye"></i>
    </a>
    <a class=" view" href="{{ URL::signedRoute('past-paper.edit',['id'=>@$pastPaper->uuid]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>

    {{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('Past Paper delete'))) --}}
        <a class="delete" href="javascript:;" id="{{@$pastPaper->uuid}}" data-module_name="Past Paper" data-table_name="past_paper_table" data-url="{{route('past-paper.delete')}}" title="{{__('formname.delete')}}">
            <i class="fas fa-trash-alt"></i>
        </a>
    {{-- @endif --}}

    {{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('Past Paper active inactive'))) --}}
        @if(@$pastPaper->status=='1')
            <a class=" active_inactive" href="javascript:;" id="{{@$pastPaper->uuid}}" data-url="{{ route('past-paper.active_inactive', [@$pastPaper->uuid]) }}" data-table_name="past_paper_table" title="Active">
                <i class="fas fa-toggle-on"></i>
            </a>
        @else
            <a class=" active_inactive" href="javascript:;" id="{{@$pastPaper->uuid}}" data-url="{{ route('past-paper.active_inactive', [@$pastPaper->uuid]) }}" data-table_name="past_paper_table" title="Inactive">
                <i class="fas fa-toggle-off"></i>
            </a>
        @endif
    {{-- @endif --}}
{{-- @endif --}}