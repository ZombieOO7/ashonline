{{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('topic edit'))) --}}
    <a class=" view" href="{{ URL::signedRoute('topic.edit',['id'=>@$topic->uuid]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>

    {{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('topic delete'))) --}}
        <a class="delete" href="javascript:;" id="{{@$topic->uuid}}" data-module_name="Topic" data-table_name="topic_table" data-url="{{route('topic.delete')}}" title="{{__('formname.delete')}}">
            <i class="fas fa-trash-alt"></i>
        </a>
    {{-- @endif --}}

    {{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('topic active inactive'))) --}}
        @if(@$topic->active=='1')
            <a class=" active_inactive" href="javascript:;" id="{{@$topic->uuid}}" data-url="{{ route('topic.active_inactive', [@$topic->id]) }}" data-table_name="topic_table" title="Active">
                <i class="fas fa-toggle-on"></i>
            </a>
        @else
            <a class=" active_inactive" href="javascript:;" id="{{@$topic->uuid}}" data-url="{{ route('topic.active_inactive', [@$topic->id]) }}" data-table_name="topic_table" title="Inactive">
                <i class="fas fa-toggle-off"></i>
            </a>
        @endif
    {{-- @endif --}}
{{-- @endif --}}