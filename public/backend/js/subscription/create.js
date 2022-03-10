$(document).ready(function () {
    $("#m_form_1").validate({
        rules: {
            title: {
                required: true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            status: {
                required: true,
            }
        },
        ignore: [],
        errorPlacement: function (error, element) {
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