@php
use Illuminate\Support\Arr;
$roleList = Config::get('role');
[$rolekeys, $values] = Arr::divide($roleList);
@endphp

@if(!in_array($role->id,$rolekeys))
<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
    <input type="checkbox" name="role_checkbox[]" value="{{@$role->id}}" class="m-checkable role_checkbox checkbox">
    <span></span>
</label>
@endif