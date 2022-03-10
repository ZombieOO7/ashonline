$(document).ready(function () {
    $(document).find('#price').keypress(function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $("#m_form_1").validate({
        rules: {
            title: {
                required: true,
                maxlength: CONSTANT_VARS.input_title_max_length,
            },
            category_id: {
                required: true,
            },
            subject_id: {
                required: true,
            },
            exam_type_id: {
                required: true,
            },
            age_id: {
                required: true,
            },
            stage_id: {
                required: true,
            },
            price: {
                required: true,
                min: 1,
            },
            edition: {
                required: true,
                maxlength: CONSTANT_VARS.input_title_max_length,
            },
            name: {
                required:function(element) {
                    if ($("#blah").attr('src') != "" || $('image_id').val() == 'undefined') {
                        return false;
                    } else {
                        return true;
                    }
                },
                extension: "jpg|jpeg|png"
            },
            image_id: {
                required: function (element) {
                    if ($("#blah").attr('src') != "" || $('image_id').val() == 'undefined') {
                        return false;
                    } else {
                        return true;
                    }
                },
            },
            pdf_name: {
                required: function (element) {
                    if ($("#stored_pdf_id").val() != "") {
                        return false;
                    } else {
                        return true;
                    }
                },
                extension: "pdf"
            },
            content: {
                required: true,
            },
            status: {
                required: true,
            }
        },
        messages: {
            name: {
                extension: 'Only .jpg, .jpeg, .png image formats are allowed'
            },
            pdf_name: {
                extension: 'Only .pdf file formats are allowed'
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "content")
                error.insertAfter(".contentError");
            else
                error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            // $("#m_form_1_msg").removeClass("m--hide").show(),
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
        $('#blah').show();
        readURL(this);
    });
    getcolumns(cartegoryId, paperId);
});
$(document).find('#category_id').change(function () {
    id = $(this).val();
    if (id != '') {
        getcolumns(id, paperId);
    } else {
        alert('select valid id')
    }
})

function getcolumns(cartegoryId, paperId) {
    $.ajax({
        url: fieldurl,
        data: {
            category_id: cartegoryId,
            paper_id: paperId,
        },
        method: 'GET',
        dataType: 'html',
        success: function (result) {
            $('#categoryTypeColumns').empty().append(result);
        },
        error: function (result) {

        }
    })
}

