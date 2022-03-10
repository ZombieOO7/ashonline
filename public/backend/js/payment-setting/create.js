$(document).ready(function () {
    $(document).find("#paypal_setting_form").validate({
        rules: {
            'paypal_client_id': {
                required: true
            },
            'paypal_sandbox_api_username': {
                required: true
            },
            'paypal_sandbox_api_password': {
                required: true
            },
            'paypal_sandbox_api_secret': {
                required: true
            },
            'paypal_currency': {
                required: true
            },
            'paypal_sandbox_api_certificate': {
                // required: true
            },
            'paypal_mode': {
                required: true
            },
            'paypal_currency':{
                required: true
            }
        },
        ignore: [],
        errorPlacement: function (error, element) {

            error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            $("#web_social_media_link_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
        },
    });
    $(document).find("#payment_setting_form").validate({
        rules: {
            'stripe_key': {
                required: true
            },
            'stripe_secret': {
                required: true
            },
            'stripe_currency': {
                required: true
            },
            'stripe_mode': {
                required: true
            },
        },
        ignore: [],
        errorPlacement: function (error, element) {

            error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            $("#web_social_media_link_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
        },
    });
});
