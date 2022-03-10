// This function is used to get image url on change.



(function ($)
{
    var acePaperResource = function ()
    {
        //On class intialize call default
        c.intialize();
    };
    var c = acePaperResource.prototype;

    //Page on load event
    c.intialize = function() {
        c.validateForm();
        c.ckEditor();
    };

    //form validation
    c.validateForm = function() {
        $("#m_form_1").validate({
            rules: {
                title: {
                    required: true,
                    maxlength: CONSTANT_VARS.input_title_max_length
                },
                /* resource_category_id: {
                    required: true
                }, */
                question: {
                    required: function (element) {
                        if ($("#uuid").val().length > 0)
                            return false;
                        else
                            return true;
                    },
                    extension: "pdf"
                },
                answer: {
                    required: function (element) {
                        if ($("#uuid").val().length > 0)
                            return false;
                        else
                            return true;
                    },
                    extension: "pdf"
                },
            },
            ignore: [],
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

    c.ckEditor = function() {
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

        CKEDITOR.replace( 'content', {
            // filebrowserUploadUrl: base_url+'/admin/cms/save/cms/image',
            // filebrowserUploadMethod: 'form'
        });
    }

    window.acePaperResource = new acePaperResource();
})(jQuery);