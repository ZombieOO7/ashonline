// This function is used to get image url on change.


(function ($) {
    var acePaperResource = function () {
        //On class intialize call default
        c.intialize();
    };
    var c = acePaperResource.prototype;

    //Page on load event
    c.intialize = function () {
        c.validateForm();
        c.ckEditor();
        c.changeFile();
    };
    $.validator.addMethod("extensionempty", function (value, element, param) {

        param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";
        console.log(value, param);
        return this.optional(element) || value.match(new RegExp("\\.(" + param + ")$", "i")) || value.indexOf('.') == -1;
    }, $.validator.format("Please enter a value with a valid extension."));
    //form validation
    c.validateForm = function () {
        $("#m_form_1").validate({
            rules: {
                title: {
                    required: true,
                    maxlength: CONSTANT_VARS.input_title_max_length
                },
                /* resource_category_id: {
                    required: true
                }, */
                // featured: {
                //     // required: function (element) {
                //     //     if ($("#uuid").val().length > 0)
                //     //         return false;
                //     //     else
                //     //         return true;
                //     // },
                //     // required:false,
                //     // extension: "jpeg|jpg|pdf",
                //     extensionempty: 'jpeg|jpg|png',
                // },
                featured: {
                    required: function (element) {
                        if ($("#blah").attr('src') != "" || $('#image_id').val() != "") {
                            return false;
                        } else {
                            return true;
                        }
                    },
                    extension: "jpg|jpeg|png"
                },
                image_id: {
                    required: function (element) {
                        if ($("#blah").attr('src') != "" || $('#image_id').val() != "") {
                            return false;
                        } else {
                            return true;
                        }
                    },
                },
                content: {
                    required: function (element) {
                        if ($("#uuid").val().length > 0)
                            return false;
                        else
                            return true;
                    },
                },
                meta_title: {
                    required: true,
                    maxlength: CONSTANT_VARS.input_title_max_length
                },
                meta_keyword: {
                    required: true,
                    maxlength: CONSTANT_VARS.input_title_max_length
                },
                meta_description: {
                    required: true,
                    maxlength: CONSTANT_VARS.input_desc_max_length
                },
                grade_id: {
                    required: true,
                }
            },
            ignore: [],
            errorPlacement: function (error, element) {
                if (element.attr("name") == "content")
                    error.insertAfter(".contentError");
                else if(element.attr("name") == "image_id")
                    error.insertAfter(".imgError");
                else
                    error.insertAfter(element);
            },
            invalidHandler: function (e, r) {
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
    };

    c.ckEditor = function () {
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

        CKEDITOR.replace('content', {
            filebrowserUploadUrl: base_url + '/admin/editor/file/save',
            filebrowserUploadMethod: 'form'
        });
    }

    c.readImageUrl = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    c.changeFile = function () {
        $("#featured").change(function () {
            $('#blah').show();
            c.readImageUrl(this);
        });
    }

    window.acePaperResource = new acePaperResource();
})(jQuery);
