$(document).ready(function () {
    $("#m_form_1").validate({
        rules: {
            title: {
                required: true,
                maxlength: CONSTANT_VARS.input_title_max_length,
            },
            color_code: {
                required: true,
                maxlength: 10,
            },
            product_content:{
                required:true,
            },
            type:{
                required:true,
            }
        },
        // errorPlacement: function (error, element) {
        //     if (element.attr("name") == "product_content")
        //         error.insertAfter(".productContentError");
        //     else
        //         error.insertAfter(element);
        // },
        invalidHandler: function (e, r) {
            $("#m_form_1_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
        },
        submitHandler: function (form) {
            // Prevent double submission
            if (!this.beenSubmitted) {
                this.beenSubmitted = true;
                form.submit();
            }
        },
    });
    var benefits = $('input[name^="benefits"]');
    benefits.filter('input[name$="[title]"]').each(function() {
        $(this).rules("add", {
            required: true,
        });
    });
    var products = $('input[name^="products"]');
    products.filter('input[name$="[title]"]').each(function() {
        $(this).rules("add", {
            required: true,
        });
    });
    var benefits2 = $('textarea[name^="benefits"]');
    benefits2.filter('textarea[name$="[description]"]').each(function() {
        $(this).rules("add", {
            required: true,
        });
    });

    
    
    var products2 = $('textarea[name^="products"]');
    products2.filter('textarea[name$="[description]"]').each(function() {
        $(this).rules("add", {
            required: true,
            messages: {
                required: "this field is required"
            }
        });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInp").change(function () {
        readURL(this);
    });
    CKEDITOR.on('instanceReady', function() {
        $.each(CKEDITOR.instances, function(instance) {
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
    CKEDITOR.replace('content');
    CKEDITOR.replace('productContent');
    $('.colorpicker').colorpicker();
})