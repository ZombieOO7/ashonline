// Header scroll class
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
    } else {
      $('#header').removeClass('header-scrolled');
    }
  });

  if ($(window).scrollTop() > 100) {
    $('#header').addClass('header-scrolled');
  }
//////counter
$(document).ready(function(){
  var numToShow = 6;
  var button = $(".next");
      $('.more-list').each(function(i){
          var list_data = $(this).data('ul_li');
          var list = $("."+list_data+".more-list li");
          var button_show = $("."+list_data);
          var numInList = list.length;
          list.hide();
          list.slice(0, numToShow).show();
          if(list.filter(':hidden').length == 0){
          $("."+list_data+".more-list").next().hide();

          }
          button.click(function(){
              var data_show = jQuery(this).data('call_div');
              var list_show = $("."+data_show+".more-list li");
              var showing = list_show.filter(':hidden').length;
              list_show.slice(showing - 1, showing + numToShow).fadeIn();
              var nowShowing = list_show.filter(':visible').length;
              if (nowShowing >= numInList) {
              //$("."+data_show+" .next").hide();
              }
              var showing_1 = list_show.filter(':hidden').length;
              if(showing_1 == 0){
              $("."+data_show).next().hide();
              }
          });

  });
});
$(document).ready(function () {

    $('.navbar-nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(170).fadeIn(170);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(170).fadeOut(170);
    });
});
