@extends('frontend.layouts.default')
@section('title', __('formname.papers') )
@section('content')
@section('pageCss')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
<!--inner content-->
@section('breadcrumbs', Breadcrumbs::render('common_breadcrumb', __('formname.papers') ,route('home')))
  <div class="container">
    
    @include('frontend.includes.flashmessages')  
    <div class="row">
      <div class="col-md-12">
            <h1 class="page_title def_ttitle">{{ __('formname.papers') }}</h1>
            <div class="def_p mrgn_bt_30">{!! nl2br(e($paperContent->content)) !!}</div>
      </div>
      <div class="col-md-12 mrgn_bt_30 mrgn_tp_10" id="autocomplete-search-result">
        <div class="row">
          @forelse(@$paperCategories as $paperCategory)
          <div class="col-lg-3 col-sm-4 col-6 listiteminfo">
            <a href="{{ route('paper.detail',['route' => @$paperCategory->slug ]) }}" class="pro_img " style='background-color:{{@$paperCategory->color_code}}'>
              <img src="{{asset('frontend/images/product.png')}}" class="img-fluid" alt="product image" title="{{@$paperCategory->title_with_text_papers}}">
              <div class="box-title">{{@$paperCategory->title_with_text_papers}}</div>
            </a>
            <h2><a href="{{ route('paper.detail',['route' => @$paperCategory->slug ]) }}" title="{{@$paperCategory->title_with_text_papers}}">{{@$paperCategory->title_with_text_papers}}</a></h2>
            @if(@$paperCategory->papers)
            <ul class=" more-list" data-ul_li="IndependentPapers">
              @forelse(@$paperCategory->papers->take(6) as $paper)
                <li><a href="{{route('paper-details',[@$paperCategory->slug,@$paper->slug])}}" data-tooltip="tooltip" title="{{@$paper->title}}">{{ @$paper->title_text }}</a></li>
              @empty
              <li><a href="javascript:void(0)">{{ __('formname.coming_soon' )}}</a></li>
              @endforelse
            </ul>
            @endif
            @if(@$paperCategory->papers->count() > 0) 
            <a style="text-decoration:none;" href="{{ route('paper.detail',['route' => @$paperCategory->slug ]) }}" class="showmore_btn next">
              {{__('formname.view_all')}}
            </a>
            @endif
          </div>
          @empty
          @endforelse
        </div>
      </div>
    </div>
  </div>
  <!--close inner content-->
@endsection

@section('pageJs')
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
          $(document).find('#autocomplete-search-result').html(result.jsonData);
        }
    });
  }
}

</script>
@endsection