@extends('frontend.layouts.default')
@section('title',@$detail->title_seo)
@section('content')
@section('pageCss')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('breadcrumbs', Breadcrumbs::view('partials/breadcrumbs','common_breadcrumb',@$detail->title_with_text_papers,route('paper.detail',['slug' => @$detail->slug]), 'Papers', route('papers')))
  <div class="container">
    @include('frontend.includes.flashmessages')
    <div class="row">
      <div class="col-md-12" id="autocomplete-search-result">
          <h1 class="page_title def_ttitle">{{ @$detail->title_with_text_papers }}</h1>
        <div class="def_p mrgn_bt_30">{!! @$detail->content !!}</div>
      </div>

      <!-- FILTER BY STARTS HERE -->
      @include('frontend.papers.filter')
      <!-- FILTER BY ENDS HERE -->

      <!-- PAPERS LIST STARTS HERE -->
      <div class="col-md-12 mrgn_bt_30 mrgn_tp_10 hide_on_search" >
        <div class='paper-lst-filter'>
          @include('frontend.papers.list')
        </div>
      </div>
      <!-- PAPERS LIST ENDS HERE -->
    </div>
  </div>

  <!-- KEY PRODUCTS LIST STARTS HERE -->
  @if(@$detail->keyProducts->count() > 0)
    @include('frontend.papers.key_products')
  @endif
  <!-- KEY PRODUCTS LIST ENDS HERE -->

  @if(@$detail->keyBenefits->count() > 0)
    @include('frontend.papers.key_benefits')
  @endif

@endsection
@section('pageJs')
<script>
	// Add To Cart
	cartFlag = "{{@$cartFlag}}";
	var warningMsg = "{{@$msg}}";
	$(document).on('click','.addToCart',function() {
		redirectUrl = $(this).attr('data-redircet_url');
		if(cartFlag == 'false'){
			toastr.error(warningMsg);
		}else{
			$.ajax({
				url: $(this).attr('data-url'),
				method: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				global: false,
				data: {
						mock_id : $(this).attr('data-mock_id'),
						paper_id : $(this).attr('data-paper_id'),
					},
				success: function (result) {
					if(result.icon == 'info') {
						toastr.error(result.msg);
					} else {
						window.location.replace(redirectUrl);
					}
				}
			});
		}
	});
</script>
<script>
  var base_url = '{{url('/')}}';
</script>
<script src="{{ asset('frontend/js/papers/paper_detail.js') }}" ></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $(document).ready(function() {
    // Autocomplete papers using its title or provided keywords of papers
    url = "{{ route('autocomplete') }}";
    $("#search_text").autocomplete({
       source: function(request, response) {
           $.ajax({
               url: url,
               dataType: "json",
               data: {
                   term : request.term
               },
               global : false,
               success: function(data) {
                if (data.value != "") {
                  response(data);
                }
               }
           });
       },
       minLength: 1,
   });

   // search papers using its title or provided keywords of papers
   $('#search_text').keydown(function (e) {

    if (e.keyCode == 13) {
      searchPapers($(this).val());
    }
   });
});
$.validator.addMethod("noSpace", function (value, element) {
    return $.trim(value);
}, "Please insert keyword to find paper");
$('#searchPaper').validate({
  rules: {
    search_text:{
      required:true,
      noSpace:true,
      maxlength:150,
    }
  },
  messages:{
    search_text:{
      required:'Please insert keyword to find paper',
    }
  }
  errorPlacement:function (error, element) {
    error.insertAfter('.searchError');
  }
})

function search() {
  searchPapers($(document).find('#search_text').val());
}

function searchPapers(title) {
  if($('#searchPaper').valid()){
    var url = "{{ route('search-papers') }}";
    $.ajax({
        url: url,
        dataType: "json",
        data: {
            title : title,
        },
        global : true,
        success: function(result) {
          $(document).find(".hide_on_search").html("");
          $(document).find('#autocomplete-search-result').html(result.jsonData);
        }
    });
  }
}

</script>
@endsection

@php
$cartFlag = 'false';
$user = null;
if(Auth::guard('parent')->user() != null){
    $user = Auth::guard('parent')->user();
    $cartFlag = 'true';
}elseif(Auth::guard('student')->user() != null){
    $msg = __('frontend.child_cart_warning');
    $user = Auth::guard('student')->user();
    $cartFlag = 'false';
}else{
    $msg = __('frontend.cart_login');
}
@endphp
@section('pageJs')
<script>
// Add To Cart
cartFlag = "{{@$cartFlag}}";
var warningMsg = "{{@$msg}}";
$(document).on('click','.addToCart',function() {
    redirectUrl = $(this).attr('data-redircet_url');
    if(cartFlag == 'false'){
        toastr.error(warningMsg);
    }else{
        $.ajax({
            url: $(this).attr('data-url'),
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            global: false,
            data: {
                    mock_id : $(this).attr('data-mock_id'),
                    paper_id : $(this).attr('data-paper_id'),
                },
            success: function (result) {
                if(result.icon == 'info') {
                    toastr.error(result.msg);
                } else {
                    window.location.replace(redirectUrl);
                }
            }
        });
    }
});
</script>
@endsection
