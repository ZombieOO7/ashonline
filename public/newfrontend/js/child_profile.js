/*profile-upload*/
$(document).ready(function() {
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.propic0').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".upic0").on('change', function(){
        readURL(this);
    });

    $(".propic0").on('click', function() {
        $(".upic0").click();
    });
    $(".cpic0").on('click', function() {
        $(".upic0").click();
    });
    var readURL2 = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.propic1').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".upic1").on('change', function(){
        readURL2(this);
    });

    $(".propic1").on('click', function() {
        $(".upic1").click();
    });
    $(".cpic1").on('click', function() {
        $(".upic1").click();
    });
    $(".dob").datepicker({
        endDate: new Date(),
        autoclose: true,
        todayHighlight: true
    })
    $("#dob").datepicker({
        endDate: new Date(),
        autoclose: true,
        todayHighlight: true
    })

});


$.validator.addMethod("minYear", function(value) {
    let dob = $('#dob').val();
    var birthDate = new Date(dob);
    var birthYear = birthDate.getFullYear();
    if(value > birthYear){
        return true;
    }else{
        return false;

    }

}, "Please select school year greater than Birth year.");

$(function () {

    $("#child_profile_update0").validate({
        rules: {
            full_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            first_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            last_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            middle_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            email:{
                required:true,
                // email:true,
                maxlength: rule.email_length,
                noSpace: true,
            },
            username:{
                required:true,
                noSpace: true,
            },
            dob:{
                required:true
            },
            school_name:{
                required:true,
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
            school_year:{
                required:true,
                // minYear: true
            },
        },
        ignore:':hidden',
        messages: {
            school_year:{
                required: "This field is required",
                minYear: "Please select school year greater than Birth year."
            },
            "exam_board_id[]":{
                required: "Please select at least one exam board",
            },
            exam_style_id:{
                required: "This field is required",
            },
            region:{
                required: "This field is required",
            }
        },
        errorPlacement: function (error, element) {
            if(element.attr("name") =='school_year'){
                error.insertAfter(".yearError");
            }else if(element.attr("name") =='exam_board_id[]'){
                error.insertAfter(".boardError");
            }else if(element.attr("name") =='exam_style_id'){
                error.insertAfter(".styleError");
            }else if(element.attr("name") =='region'){
                error.insertAfter(".regionError");
            }else{
                error.insertAfter(element);
            }

        },

        submitHandler: function (form) {
            form.submit();
        }
    });
    $("#child_profile_update1").validate({
        rules: {
            full_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            first_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            last_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            middle_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            email:{
                required:true,
                // email:true,
                maxlength: rule.email_length,
                noSpace: true,
            },
            username:{
                required:true,
                noSpace: true,
            },
            dob:{
                required:true
            },
            school_name:{
                required:true,
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
            school_year:{
                required:true,
                // minYear: true
            },
        },
        ignore:':hidden',
        messages: {
            school_year:{
                required: "This field is required",
                minYear: "Please select school year greater than Birth year."
            },
            "exam_board_id[]":{
                required: "Please select at least one exam board",
            },
            exam_style_id:{
                required: "This field is required",
            },
            region:{
                required: "This field is required",
            }
        },
        errorPlacement: function (error, element) {
            if(element.attr("name") =='school_year'){
                error.insertAfter(".yearError");
            }else if(element.attr("name") =='exam_board_id[]'){
                error.insertAfter(".boardError");
            }else if(element.attr("name") =='exam_style_id'){
                error.insertAfter(".styleError");
            }else if(element.attr("name") =='region'){
                error.insertAfter(".regionError");
            }else{
                error.insertAfter(element);
            }

        },

        submitHandler: function (form) {
            form.submit();
        }
    });
    $("#child_register").validate({
        rules: {
            full_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            first_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            last_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            middle_name:{
                required:true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            email:{
                required:true,
                // email:true,
                maxlength: rule.email_length,
                noSpace: true,
            },
            username:{
                required:true,
                noSpace: true,
            },
            dob:{
                required:true
            },
            school_name:{
                required:true,
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
            school_year:{
                required:true,
                // minYear: true
            },
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
        },
        ignore:':hidden',
        messages: {
            school_year:{
                required: "This field is required",
                minYear: "Please select school year greater than Birth year."
            },
            "exam_board_id[]":{
                required: "Please select at least one exam board",
            },
            exam_style_id:{
                required: "This field is required",
            },
            region:{
                required: "This field is required",
            }
        },
        errorPlacement: function (error, element) {
            if(element.attr("name") =='school_year'){
                error.insertAfter(".yearError");
            }else if(element.attr("name") =='exam_board_id[]'){
                error.insertAfter(".boardError");
            }else if(element.attr("name") =='exam_style_id'){
                error.insertAfter(".styleError");
            }else if(element.attr("name") =='region'){
                error.insertAfter(".regionError");
            }else{
                error.insertAfter(element);
            }

        },

        submitHandler: function (form) {
            form.submit();
        }
    });
});
$('#examBoardId').on('change',function(){
    if($(this).val()=='3'){
        $('#examStyle').show();
    }else{
        $('#examStyle').hide();
    }
});
