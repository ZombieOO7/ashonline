$(document).ready(function () {
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'File size must be less than {0}');
    
    var amount1 = $(document).find('#amount_1').val();
    var amount2 = $(document).find('#amount_2').val();

    $(document).find("#web_general_setting_form").validate({
        rules:{
            logo:{
                extension:rule.logo_extension,
                filesize: rule.logo_size
            },
            favicon:{
                extension: rule.favicon_extension,
                filesize:rule.favicon_size
            },
        },
        ignore: [],
        errorPlacement: function (error, element) {

            error.insertAfter(element);
        },
        invalidHandler: function (e, r) {

            $("#web_general_form_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
                e.preventDefault();

        },
    });
    $(document).find("#socila_media_link_form").validate({
        rules: {
            facebook_url: {
                url: rule.url
            },
            google_url:{
                url: rule.url
            },
            youtube_url:{
                url: rule.url
            },
            twitter_url:{
                url: rule.url
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
    $(document).on('change','input[name=logo]',function () {
        filePreview(this,'logoImg');
    });
    $(document).on('change','input[name=favicon]',function () {
        filePreview(this,'faviconImg');
    });
    function filePreview(input,id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#'+id).empty();
                $('#'+id).append('<img src="'+e.target.result+'" style="width:100px;height:100px;"/>');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).find("#web_general_setting_form").validate({
        rules:{
            logo:{
                extension:rule.logo_extension,
                filesize: rule.logo_size
            },
            favicon:{
                extension: rule.favicon_extension,
                filesize:rule.favicon_size
            },
        },
        ignore: [],
        errorPlacement: function (error, element) {

            error.insertAfter(element);
        },
        invalidHandler: function (e, r) {

            $("#web_general_form_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
                e.preventDefault();

        },
    });
    var $min_range = $("#amount_1"),$max_range = $("#amount_2");
    
    var $min_discount = $("#discount_1"),$max_discount = $("#discount_2");
    $(document).find("#promo_code_setting_form").validate({
        rules:{
            'amount_1': {
                required: function() {
                    return !($min_range.val() === "" && $max_range.val() === "");
                },
                max:function(){
                    if (parseInt($max_range.val()) != "" && parseInt($min_range.val()) > parseInt($max_range.val())) {  
                        return parseInt($max_range.val());
                    }
                },
                number:true,
            },
            'amount_2':{
                required: function() {
                    return !($max_range.val() === "" && $max_discount.val() === "");
                },
                min:function(){
                    if (parseInt($min_range.val()) != "" && parseInt($max_range.val()) < parseInt($min_range.val())) {  
                        return parseInt($min_range.val());
                    } 
                },
                number:true,
            },
            'discount_1':{
                required: function() {
                    return !($min_range.val() === "" && $min_discount.val() === "" && $max_discount.val() === "");
                },
                max:function(){
                    if (parseInt($max_discount.val()) != "" && parseInt($min_discount.val()) > parseInt($max_discount.val())) {  
                        return parseInt($max_discount.val());
                    }
                },
                min:1,
                number:true,
            },
            'discount_2':{
                required: function() {
                    return !($max_range.val() === "" && $max_discount.val() === "");
                },
                min:function(){
                    if (parseInt($min_discount.val()) != "" && parseInt($max_discount.val()) < parseInt($min_discount.val())) {  
                        return parseInt($min_discount.val());
                    } 
                },
                max:100, 
                number:true,
            },
            code:{
                required: function() {
                    return !(($min_range.val() === "" && $min_discount.val() === "") );
                },
            },
        },
        
        ignore: [],
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            $("#web_general_form_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
                e.preventDefault();
        }
    });
    $(document).find("#rating_mail_form").validate({
        rules:{
            rating_mail:{
                required:true,
                number:true,
                min:1,
                max:365,
            }
        },
        ignore: [],
        messages : {
            rating_mail : {
                'min' : 'Please enter days greater than or equal to 1.',
                'max' : 'Please enter days less than or equal to 365.'
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            $("#rating_mail_form").removeClass("m--hide").show(),
                mUtil.scrollTop()
                e.preventDefault();
        }
    });
    $(document).find("#notification_form").validate({
        rules:{
            'notification_content':{
                required:true,
                maxlength:rule.input_title_max_length,
            }
        },
        ignore: [],
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            $("#notification_form").removeClass("m--hide").show(),
                mUtil.scrollTop()
                e.preventDefault();
        }
    });
}); 
//deal with copying the ckeditor text into the actual textarea
CKEDITOR.on('instanceReady', function () {
    $.each(CKEDITOR.instances, function (instance) {
        CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
        CKEDITOR.instances[instance].document.on("paste", CK_jQ);
        CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
        CKEDITOR.instances[instance].document.on("blur", CK_jQ);
        CKEDITOR.instances[instance].document.on("change", CK_jQ);
    });
});

function CK_jQ() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}

CKEDITOR.replace('notification');

$('#variables a').click(function () {
    var str = $(this).text();
    CKEDITOR.instances['notification'].insertHtml(str);
});