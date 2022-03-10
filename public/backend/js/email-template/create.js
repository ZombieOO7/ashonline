$(document).ready(function () {
    $("#m_form_1").validate({
        rules: {
            title: {
                required: true,
                maxlength: CONSTANT_VARS.input_title_max_length,
            },
            subject: {
                required: true,
                maxlength: 200,
            },
            body: {
                required: true
            }
        },
        
        ignore: [],
        errorPlacement: function (error, element) {
            if (element.attr("name") == "body")
                error.insertAfter(".contentError");
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
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

CKEDITOR.replace('editor1');

$('#variables a').click(function () {
    var str = $(this).text();
    CKEDITOR.instances['editor1'].insertHtml(str);
});