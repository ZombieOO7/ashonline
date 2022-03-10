@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('user edit')))
<a class=" view" href="{{ URL::signedRoute('user_edit',['id'=>@$user->id]) }}" title="{{__('formname.edit')}}"><i
        class="fas fa-pencil-alt"></i></a>
@endif
@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('user delete')))
<a class=" delete" href="javascript:;" id="{{@$user->id}}" data-table_name="user_table"
    data-url="{{route('user_delete')}}" title="{{__('formname.delete')}}"><i class="fas fa-trash-alt"></i>
</a>
@endif
@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('user active inactive')))
@if(@$user->status==config('constant.status_active_value'))
<a class=" active_inactive" href="javascript:;" id="{{@$user->id}}"  data-url="{{ route('user_active_inactive', [@$user->id]) }}" data-table_name="user_table"  title="Active"><i class="fas fa-toggle-on"></i>
</a>

@else
<a class=" active_inactive" href="javascript:;" id="{{@$user->id}}" data-url="{{ route('user_active_inactive', [@$user->id]) }}" data-table_name="user_table"  title="Inactive"><i
        class="fas fa-toggle-off"></i>
</a>
@endif
@endif