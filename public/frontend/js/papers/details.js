$(function() {
    $(window).load(function() {		

      $("a[rel='load-content']").click(function(e){
        e.preventDefault();
        var url=$(this).attr("href");
        $.get(url,function(data){
          $(".content .mCSB_container").append(data); //load new content inside .mCSB_container
          //scroll-to appended content 
          $(".content").mCustomScrollbar("scrollTo","h2:last");
        });
      });
      
      $(".content").delegate("a[href='top']","click",function(e){
        e.preventDefault();
        $(".content").mCustomScrollbar("scrollTo",$(this).attr("href"));
      });    
    });
});
$(document).ready(function() {
    
    var page = 1; //track user scroll as page number, right now page number is 1
    // load_more(page); //initial content load
    $(window).scroll(function() { //detect page scroll
        
        // if($('.mCSB_draggerRail').scrollTop() + $('.mCSB_draggerRail').height() >= $('.mCSB_draggerRail').height()) {
        //     page++; //page number increment
        //     load_more(page); //load content   
        // }
    });     
    function load_more(page){
        $.ajax(
              {
                  url: '?page=' + page,
                  type: "get",
                  datatype: "html",
                  beforeSend: function()
                  {
                      $('.ajax-loading').show();
                  }
              })
              .done(function(data)
              {
                  if(data.length == 0){
                  console.log(data.length);
                     
                      //notify user if nothing to load
                      $('.ajax-loading').html("No more records!");
                      return;
                  }
                  $('.ajax-loading').hide(); //hide loading animation once data is received
                  $("#results").append(data); //append data into #results element          
              })
              .fail(function(jqXHR, ajaxOptions, thrownError)
              {
                    alert('No response from server');
              });
       }
    // Add To Cart
    $(document).find('.add-to-cart').on('click',function() {
        // var redirectUrl = $(this).attr('data-redircet_url');
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
                data: { paper_id : $(this).attr('data-paper_id') },
                success: function (result) {
                    if(result.icon == 'error' || result.icon =='info') {
                        swal({
                            text: result.msg,
                            icon: "info",
                        })
                    } else {
                        // window.location.replace(redirectUrl);
                        $(document).find('.itmcounts').text(result.total);
                        $(document).find('.added-crt').html('<button class="btn btn-addtocar btn_added">Added</button><a href="'+ cartURL +'" class="btn btnviewcart" >View Cart <span class="ash-right-thin-chevron"></span></a>');
                    }
                }
            });
        }
    });
});
