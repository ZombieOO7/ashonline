$(document).ready(function () {
    $("#m_form_1").validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: function (element) {
                    if ($("#id").val().length > 0) {
                        return false;
                    } else {
                        return true;
                    }
                },
                minlength: 6,
                maxlength: 16
            },
            conform_password: {
                required: function (element) {
                    if ($("#id").val().length > 0) {
                        return false;
                    } else {
                        return true;
                    }
                },
                minlength: 6,
                maxlength: 16,
                equalTo: "#password"
            },
            "role[]": {
                required: true,
            },
        },
        messages: {
            'role[]': "Please select at least 1 role"
        },
        ignore: [],
        errorPlacement: function (error, element) {
            if (element.attr("name") == "password")
                error.insertAfter(".passwordError");
            else if (element.attr("name") == "conform_password")
                error.insertAfter(".conformPasswordError");
            else if (element.attr("name") == "role[]")
                error.insertAfter(".roleError");
            else
                error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            $("#m_form_1_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
        },
    });
});
$(document).on('change','#selectAll', function(){
    if($("#selectAll").is(':checked'))
    {
        $('#permission > option').prop("selected",true);
        $('#permission').select().trigger("change");
    }else{
        $('#permission > option').prop("selected",false);
        $('#permission').select().trigger("change");
    }
});
$(document).ready(function () {
    $('.selectpicker').selectpicker({  
        placeholder: "Select a state",
        allowClear: true
    }) 
    $("#permission").select2();
    if($('#permission > option').prop("selected")==true)
        $("#selectAll").prop( "checked", true );
})
