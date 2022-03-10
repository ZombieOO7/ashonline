$(document).ready(function () {
    $("#m_form_1").validate({
        rules: {
            name: {
                required: true
            },
            // "permission[]": {
            //     required: true
            // },
        },
        messages: {
            'permission[]': "Please select at least 1 permission"
        },
        ignore: [],

        errorPlacement: function (error, element) {
            if (element.attr("name") == "permission[]")
                error.insertAfter(".permissionError");
            else
                error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            $("#m_form_1_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
        },
    });
}); 