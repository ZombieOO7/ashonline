$(document).ready(function () {
    $("#m_datepicker_1").datepicker({    
        startDate: new Date('1920'),
        endDate: new Date(),
        autoclose: true, 
        todayHighlight: true
    })

    $("#m_form_1").validate({
        ignore: ':hidden',
        rules: {
            first_name: {
                required: true,
                noSpace: true,
            },
            middle_name: {
                noSpace: true,
                required: true,
            },
            last_name: {
                noSpace: true,
                required: true,
            },
            dob: {
                noSpace: true,
                required: true,
            },
            gender: {
                noSpace: true,
                required: true,
            },
            email: {
                noSpace: true,
                required: true,
                maxlength: rule.email_length,
            },
            password:{
                required: function (element) {
                    if ($("#uuid").val() != "" ) {
                        return false;
                    } else{
                        return true;
                    }
                },
                maxlength: rule.password_max_length,
                minlength: rule.password_min_length,
            },
            address:{
                noSpace: true,
                required:true,
                maxlength:300,
            },
            city:{
                noSpace: true,
                required:true,
            },
            county:{
                noSpace: true,
                required:true,
            },
            zip_code:{
                noSpace: true,
                required:true,
                maxlength:6,
            },
            // mobile:{
            //     noSpace: true,
            //     digits: true,
            //     maxlength:12,
            //     minlength:10,
            //     required:true,
            // },
            "exam_board_id[]":{
                required:function(){
                    if($('.chkbx :checked').length > 0){
                        return false;
                    }
                    return true;
                },
            },
            school_id:{
                required:true,
            },
            school_year:{
                required:true,
                // max:function(element){
                //     var date = $('#m_datepicker_1').val();
                //     birthYear = new Date(date).getFullYear();
                //     year = $('#schoolYear').val();
                //     return parseInt(birthYear);
                // }
            },
            active:{
                required:true,
            }
        },
        messages: {
            exam_style_id:{
                required:'This field is required',
            },
            "exam_board_id[]":{
                required:'Please select at least one exam board',
            },
            school_id:{
                required:'This field is required',
            },
            // mobile:{
            //     minlength:'Please enter at least 10 digits.',
            //     maxlength:'Please enter no more than 12 digits.',
            // },
            school_year:{
                required:'This field is required',
            }
        },
        errorPlacement: function (error, element) {
            $('.errors').remove();
            if (element.attr("name") == "exam_style_id")
                error.insertAfter(".styleError");
            else if(element.attr("name") =="exam_board_id[]"){
                error.insertAfter(".boardError");
            }else if(element.attr("name") =="school_id"){
                error.insertAfter(".schoolError");
            }else if(element.attr("name") =="school_year"){
                error.insertAfter(".yearError");
            }else if(element.attr("name") =="active"){
                error.insertAfter(".statusError");
            }else{
                error.insertAfter(element);
            }
        },
        invalidHandler: function (e, r) {
            // mUtil.scrollTop()
            $('.errors').remove();
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
});

$('#examBoardId').on('change',function(){
    if($(this).val()=='3'){
        $('#examStyle').show();
    }else{
        $('#examStyle').hide();
    }
});
