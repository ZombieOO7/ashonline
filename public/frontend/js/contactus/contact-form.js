$(document).ready(function() {
    jQuery.validator.addMethod("equalToValue", function(value, element, param) {
        return this.optional(element) || value == $captcha;
    },'Please enter valid captcha');
    // $.validator.addMethod( "phonePattern", function( phone_number, element ) {
    //     return phone_number.match(/[\+]\d{2}[\(]\d{3}[\)]\d{3}[\-]\d{4}/)
    //  }, "Please specify a valid phone number" );
    // ALLOW CVV TO ONLY NUMBERS
    $(document).find('#phone').keypress(function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $(document).find("#contact_form").validate({
        rules: {
            full_name: {
                required: true,
                maxlength: CONSTANT_VARS.input_title_max_length,
            },
            email: {
                email:true,
                required: true,
                maxlength: CONSTANT_VARS.input_email_max_length,
            },
            subject: {
                required: true,
                maxlength: CONSTANT_VARS.input_email_max_length,
            },
            phone: {
                required: true,
                // phonePattern:true,
                minlength: 10,
                maxlength: 20,
            },
            captcha:{
                required:true,
                maxlength: 6,
                equalToValue:$captcha,
            },
            message: {
                required: true,
                maxlength: CONSTANT_VARS.input_desc_max_length,
            },
        },
        messages: {
            subject: {
                required: 'Please select subject.'
            }
        },
        errorPlacement: function (error, element) {
            if(element.attr('name') == 'subject')
                error.insertAfter('.subjectError');
            else if(element.attr('name') == 'captcha')
                error.insertAfter('.captchaError');
            else
                error.insertAfter(element);
        },
        submitHandler: function (form) {
            // Prevent double submission
            if (!this.beenSubmitted) {
                this.beenSubmitted = true;
                $(document).find('.page-loader').show(); 
                form.submit();
            }
        },
    });
    
});
/* This function is use for refresh captcha */
function refreshCaptcha(){
    $.ajax({
        url:captchaurl,
        method:'GET',
        global:false,
        success:function(result){
            $captcha = result.captcha;
            $('#captchaImg').empty();
            var d = new Date ();
            var html = '';
            html +='<img src="'+result.imagePath+'?r='+ d.getTime()+'" alt="">';
            $('#captchaImg').append(html);
        },
        error:function(result){

        }
    })
}