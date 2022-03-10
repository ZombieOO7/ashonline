jQuery.validator.addMethod("cke_required", function (value, element) {
    var idname = $(element).attr('id');
    var editor = CKEDITOR.instances[idname];
    editor_val = $(element).val(editor.getData());
    if (editor_val != "" && editor_val != "" && jQuery.trim(editor_val).length != 0)
    {
        return false;
    }else{
        return true;
    }
    // return $(element).val().length > 0;
}, "This field is required");
$(document).ready(function () {
    $("#m_form_1").validate({
        rules: {
            'title': {
                required: true,
                maxlength: CONSTANT_VARS.input_title_max_length,
                noSpace: true,
            },
            // 'paper_category_id[]': {
            //     required: true,
            // },
            'content':{
                // cke_required : true,
                required : true,
                noSpace: true,
            }
        },
        messages: {
            'paper_category_id[]': {
                required: 'Select any paper category'
            }
        },
        errorPlacement: function (error, element) {
            $('.valError').empty();
            if (element.attr("name") == "paper_category_id[]"){
                error.insertAfter(".paperCategoryError");
            }else if(element.attr("name") == 'content'){
                error.insertAfter(".contentError");
            }else{
                error.insertAfter(element);
            }
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

    CKEDITOR.replace('editor1');
});
