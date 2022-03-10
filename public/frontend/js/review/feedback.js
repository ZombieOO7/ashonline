$(function() {
    $(document).find('.fixedStar_working').raty({
      readOnly:  false,
      path    :  base_url+'/public/frontend/images',
      starOff : 'star-off.svg',
      starOn  : 'star-on.svg',
      scoreName:'rating[]',
      start: $(document).find(this).attr('data-score'),
      
    });

    $(document).find('.fixedStar_readonly').raty({
      readOnly:  true,
      path    :  base_url+'/public/frontend/images',
      starOff : 'star-off.svg',
      starOn  : 'star-on.svg',
      start: $(document).find(this).attr('data-score')
    });      

    // $("#feedback_form").submit(function(event) {
     
    // });

    $(document).find(".fixedStar_working").on('click',function() {
      $(document).find('.error').html('');
    });

    $("#feedback_form").validate({
      rules: {
        //   'rating[]': {
        //       required: true
        //   },
        //   'review[]': {
        //     required: true
        // },
      },
      
      ignore: [],
      errorPlacement: function (error, element) {  
        error.insertAfter(element);
      },
      messages: {
        'rating[]' : 'Please select rating',
      },
      submitHandler: function (form) {
        $(document).find('.page-loader').show();
        form.submit();
      },
  });
});