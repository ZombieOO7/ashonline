@if(@$admin->id != \Auth::guard('admin')->id())
<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
    <input type="checkbox" name="admin_checkbox[]" value="{{@$admin->id}}" class="m-checkable admin_checkbox checkbox">
    <span></span>
</label>
@endif