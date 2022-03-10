<div class="input-group err_msg">

    <input type="hidden" name="image_path"

           value="{{@$imageShow}}">
    <input type="hidden" name="image_id" id="image_id"
           value="{{@$id}}">
    <input type="hidden" name="logo_image_id" id="logo_image_id"
           value="{{@$id}}">
		@if(isset($image))
			<img id="blah" src="{{@$image}}" alt="" max-width="200px" ; height="200px" ; style="{{ isset($imageShow) ? 'display:block;' : 'display:none;' }}"/>
       	@else
			<img id="blah" src="{{url('storage/app/public/uploads/'.@$imageShow)}}" alt="" max-width="200px" ; height="200px" ; style="{{ isset($imageShow) ? 'display:block;' : 'display:none;' }}"/>
       	@endif
</div>
