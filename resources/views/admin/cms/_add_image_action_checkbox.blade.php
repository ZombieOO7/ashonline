@if($image_id == $cms->id)
    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
        <input type="checkbox" name="image_checkbox" value="{{@$cms->id}}" checked
               class="m-checkable trade_checkbox checkbox">
        <span></span>
    </label>
@else
    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
        <input type="checkbox" name="image_checkbox" value="{{@$cms->id}}"
               class="m-checkable trade_checkbox checkbox">
        <span></span>
    </label>
@endif
