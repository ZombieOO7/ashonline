@if($image_id == $mocktest->id)
    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
        <input type="checkbox" name="image_checkbox" value="{{@$mocktest->id}}" checked
               class="m-checkable trade_checkbox checkbox">
        <span></span>
    </label>
@else
    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
        <input type="checkbox" name="image_checkbox" value="{{@$mocktest->id}}"
               class="m-checkable trade_checkbox checkbox">
        <span></span>
    </label>
@endif


