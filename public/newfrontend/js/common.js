    // Newsletter subscribtion
    // $('#subscriber_email').on('keypress', function(e) {
    //     if(e.which == 13) {
    //       $('.newsletter-subscribe').trigger('click');
    //       return false;
    //     }
    // });
    $(document).ajaxStart(function () {
        
        $('.main_loader').show();   //ajax request went so show the loading image
    }).ajaxStop(function () {
        $('.main_loader').hide();   //got response so hide the loading image
    });
    $(document).ready(function () {
        jQuery.validator.addMethod("accept", function(value, element, param) {
            var EmailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return EmailRegex.test(value);
        },'please enter a valid email');
        $("#subscribeForm").validate({
            rules: {
                subscribe_email: {
                    required: true,
                    email:true,
                    accept:true,
                },
            },
            messages: {
                // subscribe_email: {
                    // required: "Please enter a valid email address",
                // },
            },
            errorPlacement: function (error, element) {
                error.insertAfter('.subscribeError');
            },
        });
    });

    $(document).find('.newsletter-subscribe').on('click',function() {
        console.log($("#subscribeForm").valid());
        if($("#subscribeForm").valid()){
            $.ajax({
                url: $(this).attr('data-url'),
                method: "post",
                data: { email : $(document).find('#subscriber_email').val(),_token: "{{ csrf_token() }}" },
                success: function (result) {
                    if (result.msg) {
                        toastr.success(result.msg);
                    } else {
                        toastr.error(result.error);
                    }
                    $('#subscriber_email').val('');
                }
            });
        }

    });
    if(routeName == 'mock-exam' || routeName == 'mock-exam-review'){
        allowClick = false;
    }
    $(document).find('.epaper').on('click', function(){
        if(allowClick == true){
            var newUrl = $(this).attr('data-href');
            window.location.replace(newUrl);
        }
    })