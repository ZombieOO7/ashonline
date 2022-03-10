$(document).ready(function () {
    $("#m_form_1").validate({
        rules: {
            'title': {
                required: true
            },
            'content': {
                required: true
            },
            'faq_category_id': {
                required: true,
            },
        },
        
        ignore: [],
        errorPlacement: function (error, element) {
            if (element.attr("name") == "faq_category_id")
                error.insertAfter(".categoryErr");
            else if (element.attr("name") == "content")
                error.insertAfter(".contentErr");
            else
                error.insertAfter(element);
        },
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

CKEDITOR.replace('editor1');
CKEDITOR.config.removePlugins = 'image';

$(document).find('.selectpicker').selectpicker({  
    placeholder: "Select Paper Category",
    allowClear: true
}) 