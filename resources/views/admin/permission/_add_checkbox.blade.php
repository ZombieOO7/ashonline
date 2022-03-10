@php
use Illuminate\Support\Arr;
$permissionList = Config::get('rolePermission');
[$permissionkeys, $values] = Arr::divide($permissionList);
@endphp
@if(!in_array($permission->id,$permissionkeys))
<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
    <input type="checkbox" name="permission_checkbox[]" value="{{@$permission->id}}"
        class="m-checkable permission_checkbox checkbox">
    <span></span>
</label>
@endif