/*profile-upload*/
$(document).ready(function() {
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".file-upload-nw").on('change', function(){
        readURL(this);
    });

    $(".profile-pic").on('click', function() {
        $(".file-upload-nw").click();
    });
    $(".change-pic").on('click', function() {
        $(".file-upload-nw").click();
    });

});

$(function () {
    $("#profile_update").validate({
        ignore: ":hidden",
        rules: {
            full_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            }, 
            email:{
                required:true,
                email:true,
                maxlength: rule.email_length,
                noSpace: true,
            }, 
            mobile:{
                required:true,
                noSpace: true,
                number:true,
            },
            country_id:{
                noSpace: true,
                maxlength: rule.text_length,
                required:true,
            },
            region:{
                required:true,
            },
            county_id:{
                noSpace: true,
                maxlength: rule.text_length,
                required:true,
            },
            name: {
                extension: "jpg|jpeg|png"
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
            new_password:{
                noSpace: true,
                required:true,
                maxlength: rule.password_max_length,
                minlength: rule.password_min_length,
            },
            password_confirmation:{
                noSpace: true,
                required:true,
                maxlength: rule.password_max_length,
                minlength: rule.password_min_length,
                equalTo: "#password",
            }
        },
        messages: {
            region:{
                required: "This field is required",
            },
            country_id:{
                required: "This field is required",
            },
            county_id: {
                required: "This field is required",
            },
        },
        errorPlacement: function (error, element) {
            if(element.attr('name') == 'country_id'){
                error.insertAfter('.countryError');
            }else if(element.attr('name') == 'county_id'){
                error.insertAfter('.countyError');
            }else{
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
$('#changePass').on('click',function(){
    $('input[name=old_password]').val('');
    $('input[name=new_password]').val('');
    $('input[name=password_confirmation]').val('');
})
$('#countryId').on('change',function(){
    if($('#countryId :selected').text() != 'United Kingdom'){
        $('#county').val('Other');
        $('#county').prop('disabled',true);
        $('#county').select().trigger('change');
        $('#county').selectpicker('refresh');
    }else{
        $('#county').val('');
        $('#county').prop('disabled',false);
        $('#county').select().trigger('change');
        $('#county').selectpicker('refresh');
    }
    $('#countyVal').val($('#county :selected').text());
})
$('#county').on('change',function(){
    $('#countyVal').val($('#county :selected').text());
})