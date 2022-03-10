$(function () {
    $.validator.addMethod("noSpace", function (value, element) {
        return $.trim(value);
    }, "This field is required");
    $.validator.addMethod("postcodeUK", function (value, element) {
        return this.optional(element) || /^(([gG][iI][rR] {0,}0[aA]{2})|((([a-pr-uwyzA-PR-UWYZ][a-hk-yA-HK-Y]?[0-9][0-9]?)|(([a-pr-uwyzA-PR-UWYZ][0-9][a-hjkstuwA-HJKSTUW])|([a-pr-uwyzA-PR-UWYZ][a-hk-yA-HK-Y][0-9][abehmnprv-yABEHMNPRV-Y]))) {0,}[0-9][abd-hjlnp-uw-zABD-HJLNP-UW-Z]{2}))$/i.test(value);
    }, "Please specify a valid Postcode");
});

$.validator.addMethod("minYear", function (value) {
    let dob = $('#dob').val();
    var birthDate = new Date(dob);
    var birthYear = birthDate.getFullYear();
    if (value > birthYear) {
        return true;
    } else {
        return false;
    }
}, "Please select school year greater than Birth year.");
$('#expiry_date').datetimepicker({
    format: 'MM/YYYY',
    minDate: moment(),
});
$(function () {
    $("#parent_register").validate({
        rules: {
            full_name: {
                required: true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            first_name: {
                required: true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            last_name: {
                required: true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            middle_name: {
                required: true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            email: {
                required: true,
                email: true,
                maxlength: rule.email_length,
                noSpace: true,
            },
            // username:{
            //     required:true,
            //     maxlength: rule.email_length,
            //     noSpace: true,
            //     // email:true,
            // },
            password: {
                noSpace: true,
                required: true,
                maxlength: rule.password_max_length,
                minlength: rule.password_min_length,
            },
            password_confirmation: {
                noSpace: true,
                required: true,
                minlength: rule.password_min_length,
                maxlength: rule.password_max_length,
                equalTo: "#password",
            },
            dob: {
                required: true,
            },
            mobile: {
                required: true,
                maxlength: rule.phone_max_length,
                minlength: rule.phone_length,
                noSpace: true,
                digits: true,
            },
            address: {
                required: true,
                noSpace: true,
                maxlength: rule.text_length,
            },
            address2: {
                maxlength: rule.text_length,
            },
            city: {
                required: true,
                noSpace: true,
                maxlength: rule.text_length,
            },
            state: {
                required: true,
                noSpace: true,
                maxlength: rule.text_length,
            },
            country_id:{
                noSpace: true,
                maxlength: rule.text_length,
                required: true,
            },
            county_id: {
                required: true,
                noSpace: true,
                maxlength: rule.text_length,
            },
            zip_code:{
                postcodeUK:true,
                maxlength: rule.zipcode_length,
                required:function(){
                    if($('#countryId :selected').text() == 'United Kingdom'){
                        return true;
                    }
                    return false;
                },
            },
            school_name: {
                required: true,
                maxlength: rule.text_length,
                noSpace: true,
            },
            "exam_board_id[]":{
                required:function(){
                    if($('.dt-checkboxes :checked').length > 0){
                        return false;
                    }
                    return true;
                },
            },
            school_year: {
                required: true,
                // minYear: true
            },
            region: {
                required: true,
                maxlength: rule.text_length,
            },
            council: {
                noSpace: true,
                maxlength: rule.text_length,
                required: true,
            },
            card_number: {
                noSpace: true,
                maxlength: rule.card_no_max_length,
                minlength: rule.card_no_min_length,
                required: true,
            },
            name_on_card: {
                noSpace: true,
                maxlength: rule.text_length,
                required: true,
            },
            expiry_date:{
                noSpace: true,
                required: true,
            },
            cvv:{
                noSpace: true,
                maxlength: rule.cvv_length,
                minlength: rule.cvv_length,
                required: true,
            }
        },
        messages: {
            school_year: {
                required: "This field is required",
                minYear: "Please select school year greater than Birth year."
            },
            "exam_board_id[]":{
                required: "Please select at least one exam board",
            },
            exam_style_id: {
                required: "This field is required",
            },
            region: {
                required: "This field is required",
            },
            country_id: {
                required: "This field is required",
            },
            county_id: {
                required: "This field is required",
            },
            zip_code:{
                required: "This field is required",
            }
        },
        errorPlacement: function (error, element) {
            // $('.errors').remove();
            if (element.attr("name") == 'school_year') {
                error.insertAfter(".yearError");
            }else if(element.attr('name') == 'country_id'){
                error.insertAfter('.countryError');
            }else if(element.attr('name') == 'county_id'){
                error.insertAfter('.countyError');
            } else if (element.attr("name") == 'exam_board_id[]') {
                error.insertAfter(".boardError");
            } else if (element.attr("name") == 'exam_style_id') {
                error.insertAfter(".styleError");
            } else if (element.attr("name") == 'region') {
                error.insertAfter(".regionError");
            } else {
                error.insertAfter(element);
            }
        },

        submitHandler: function (form) {
            form.submit();
        }
    });
    $("#dob").datepicker({
        endDate: new Date(),
        autoclose: true,
        todayHighlight: true
    })
    $('#examBoardId').on('change', function () {
        if ($(this).val() == 3) {
            $('#examStyle').show();
        } else {
            $('#examStyle').hide();
        }
    })
    $('#countryId').on('change',function(){
        if($('#countryId :selected').text() != 'United Kingdom'){
            $('#county').val('Other');
            $('#county').prop('disabled',true);
            $('#county').select().trigger('change');
            $('#county').selectpicker('refresh');
        }else{
            $('#county').prop('disabled',false);
            $('#county').val('');
            $('#county').select().trigger('change');
            $('#county').selectpicker('refresh');
        }
        $('#countyVal').val($('#county :selected').text());
    })
});
$('#county').on('change',function(){
    $('#countyVal').val($('#county :selected').text());
})