@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('stage edit')))
    <a class=" view" href="{{ URL::signedRoute('examboard.edit',['id'=>@$stage->uuid]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>

    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('stage delete')))
        <a class="delete" href="javascript:;" id="{{@$stage->uuid}}" data-module_name="Exam Board" data-table_name="faq_table" data-url="{{route('examboard.delete')}}" title="{{__('formname.delete')}}">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endif

    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('stage active inactive')))
        @if(@$stage->status=='1')
            <a class=" active_inactive" href="javascript:;" id="{{@$stage->uuid}}" data-url="{{ route('examboard.active_inactive', [@$stage->id]) }}" data-table_name="faq_table" title="Active">
                <i class="fas fa-toggle-on"></i>
            </a>
        @else
            <a class=" active_inactive" href="javascript:;" id="{{@$stage->uuid}}" data-url="{{ route('examboard.active_inactive', [@$stage->id]) }}" data-table_name="faq_table" title="Inactive">
                <i class="fas fa-toggle-off"></i>
            </a>
        @endif
    @endif
@endif