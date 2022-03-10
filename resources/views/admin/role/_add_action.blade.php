@php
use Illuminate\Support\Arr;
$roleList = Config::get('role');
[$rolekeys, $values] = Arr::divide($roleList);
@endphp

@if(!in_array(@$role->id,$rolekeys))
@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('role edit')))
<a class=" view" href="{{ URL::signedRoute('role_edit',['id'=>@$role->id]) }}" title="{{__('formname.edit')}}"><i
        class="fas fa-pencil-alt"></i></a>
@endif
@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('role delete')))
<a class=" delete" href="javascript:;" id="{{@$role->id}}" data-table_name="role_table"
    data-url="{{route('role_delete')}}"  title="{{__('formname.delete')}}"><i class="fas fa-trash-alt"></i>
</a>
@endif
@endif