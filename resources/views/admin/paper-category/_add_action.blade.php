@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('paper category edit')))
    <a class=" view" href="{{ URL::signedRoute('paper_category_edit',['id'=>@$paperCategory->id]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>

    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('paper category active inactive')))
        @if(@$paperCategory->status=='1')
            <a class=" active_inactive" href="javascript:;" id="{{@$paperCategory->uuid}}" data-url="{{ route('paper_category_active_inactive', [@$paperCategory->id]) }}" data-table_name="paper_category_table" title="Active">
                <i class="fas fa-toggle-on"></i>
            </a>
        @else
            <a class=" active_inactive" href="javascript:;" id="{{@$paperCategory->uuid}}" data-url="{{ route('paper_category_active_inactive', [@$paperCategory->id]) }}" data-table_name="paper_category_table" title="Inactive">
                <i class="fas fa-toggle-off"></i>
            </a>
        @endif
    @endif
@endif