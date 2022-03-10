$(document).ready(function () {
    $('#mobile').keypress(function(event){
        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault(); //stop character from entering input
        }
    });
    $("#m_form_1").validate({
        rules: {
            full_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            }, 
            // middle_name:{
            //     required:true,
            //     maxlength: rule.name_length,
            //     noSpace: true,
            // }, 
            // last_name:{
            //     required:true,
            //     maxlength: rule.name_length,
            //     noSpace: true,
            // }, 
            email:{
                required:true,
                email:true,
                maxlength: rule.email_length,
                noSpace: true,
            }, 
            password:{
                required: function (element) {
                    if ($("#id").val() != "") {
                        return false;
                    } else {
                        return true;
                    }
                },
                maxlength: rule.password_max_length,
                minlength: rule.password_min_length,
                // noSpace: true,
            },
            dob:{
                required:true,
            },
            mobile:{
                required:true,
                maxlength: rule.phone_max_length,
                minlength: rule.phone_length,
                noSpace: true,
                digits: true,
            },
            address:{
                maxlength: rule.name_length,
                required:true,
                noSpace: true,
            },
            city:{
                noSpace: true,
                maxlength: rule.name_length,
                required:true,
            },
            council:{
                noSpace: true,
                required:true,
                maxlength: rule.name_length,
            },
            country_id:{
                noSpace: true,
                required:true,
                maxlength: rule.name_length,
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
            county_id:{
                noSpace: true,
                required:true,
                maxlength: rule.name_length,
            },
            region:{
                noSpace: true,
                required:true,
                maxlength: rule.name_length,
            }
        },
        messages:{
            country_id:{
                required: "This field is required",
            },
            county_id:{
                required: "This field is required",
            }
        },
        ignore: [],
        errorPlacement: function (error, element) {
            $('.errors').remove();
            if(element.attr('name') == 'country_id'){
                error.insertAfter('.countryError');
            }else if(element.attr('name') == 'county_id'){
                error.insertAfter('.countyError');
            }else{
                error.insertAfter(element);
            }
            
        },
        invalidHandler: function (e, r) {
            // $("#m_form_1_msg").removeClass("m--hide").show(),mUtil.scrollTop()
            if($(document).find('.form-control-feedback').length >0){
                var errorId = $('.form-control-feedback:first').attr('id');
                $("body, html").animate({
                    scrollTop: $(document).find('#'+errorId).offset().top -250 
                }, 1500);
            }
        },
        submitHandler: function (form) {
            // Prevent double submission
            if (!this.beenSubmitted) {
                this.beenSubmitted = true;
                form.submit();
            }
        },
    });

    $("#dob").datepicker({    
        startDate: new Date('1920'),
        endDate: new Date(),
        autoclose: true, 
        todayHighlight: true
    })
    $('#countryId').on('change',function(){
        if($('#countryId :selected').text() != 'United Kingdom'){
            $('#county').val('Other');
            $('#county').prop('disabled',true);
            $('#county').select().trigger('change');
            $('#county').selectpicker('refresh');
        }else{
            $('#county').prop('disabled',false);
            $('#county').select().trigger('change');
            $('#county').selectpicker('refresh');
        }
        $('#countyVal').val($('#county :selected').text());
    })
    $('#county').on('change',function(){
        $('#countyVal').val($('#county :selected').text());
    })
}); 