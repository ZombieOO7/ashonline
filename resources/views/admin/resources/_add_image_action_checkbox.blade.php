@if($image_id == $resource->id)
    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
        <input type="checkbox" name="image_checkbox" value="{{@$resource->id}}" checked
               class="m-checkable trade_checkbox checkbox">
        <span></span>
    </label>
@else
    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
        <input type="checkbox" name="image_checkbox" value="{{@$resource->id}}"
               class="m-checkable trade_checkbox checkbox">
        <span></span>
    </label>
@endif


