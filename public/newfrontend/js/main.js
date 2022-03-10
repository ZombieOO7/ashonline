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
$(document).ready(function () {

    $('.navbar-nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(170).fadeIn(170);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(170).fadeOut(170);
    });
});
//////read more less js
$(document).ready(function() {
  // Configure/customize these variables.
  var showChar = 100;  // How many characters are shown by default
  var ellipsestext = "...";
  var moretext = "read more";
  var lesstext = "read less";
  

  $('.more').each(function() {
      var content = $(this).html();

      if(content.length > showChar) {

          var c = content.substr(0, showChar);
          var h = content.substr(showChar, content.length - showChar);

          var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

          $(this).html(html);
      }

  });

  $(".morelink").click(function(){
      if($(this).hasClass("less")) {
          $(this).removeClass("less");
          $(this).html(moretext);
      } else {
          $(this).addClass("less");
          $(this).html(lesstext);
      }
      $(this).parent().prev().toggle();
      $(this).prev().toggle();
      return false;
  });
});