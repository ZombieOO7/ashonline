@if(isset($section->passage) && $section->passage_path !=null)
    <div class="pdfApp border" data-index="00" data-src="{{@$section->passage_path}}">
        <div id="viewport-container00" class="viewport-container" data-index="00"><div role="main" class="viewport" id="viewport00" data-index="00"></div></div>
    </div>
@endif