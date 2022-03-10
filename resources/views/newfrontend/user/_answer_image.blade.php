<label for="" class="'col-form-label col-lg-3 col-sm-12'"></label>
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->answer_image_path}}">
        <img id="q_image_preview_1" src="{{$question->answer_image_path}}" class="img-fluid" style="display:{{isset($question->answer_image_path) && @$question->answer_image != null ?'':'none'}};" />
    </div>
</div>
