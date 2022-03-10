$(document).ready(function () {

    $("#m_form_1").validate({
        rules: {
            school_name: {
                required: true,
                maxlength:50,
                noSpace: true,
            },
            // exam_board: {
            //     required: true,
            //     maxlength:30,
            // },
            categories: {
                required: true,
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
});


