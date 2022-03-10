$(document).ready(function () {
    var $min_range = $("#amount_1"),$max_range = $("#amount_2");
    
    var $min_discount = $("#discount_1"),$max_discount = $("#discount_2");
    
    $(document).find('#amount_1').keypress(function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $(document).find('#amount_2').keypress(function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $(document).find('#discount_1').keypress(function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $(document).find('#discount_2').keypress(function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $("#m_form_1").validate({
        rules: {
            'amount_1': {
                required: true,
                max:function(){
                    if (parseInt($max_range.val()) != "" && parseInt($min_range.val()) > parseInt($max_range.val())) {  
                        return parseInt($max_range.val());
                    }
                },
                number:true,
            },
            'amount_2':{
                required: true,
                min:function(){
                    if (parseInt($min_range.val()) != "" && parseInt($max_range.val()) < parseInt($min_range.val())) {  
                        return parseInt($min_range.val());
                    } 
                },
                number:true,
            },
            'discount_1':{
                required: true,
                max:function(){
                    if (parseInt($max_discount.val()) != "" && parseInt($min_discount.val()) > parseInt($max_discount.val())) {  
                        return parseInt($max_discount.val());
                    }
                },
                min:1,
                number:true,
                max:100,
            },
            'discount_2':{
                required: true,
                min:function(){
                    if (parseInt($min_discount.val()) != "" && parseInt($max_discount.val()) < parseInt($min_discount.val())) {  
                        return parseInt($min_discount.val());
                    } 
                },
                max:100, 
                number:true,
            },
            code:{
                required: true,
                maxlength: CONSTANT_VARS.input_title_max_length,
            },
            start_date:{
                required: true,
            },
            end_date:{
                required: true,
            },
            
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
    $("#start_date").datepicker({    
        startDate: new Date(),     
        autoclose: true, 
        todayHighlight: true
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#end_date').datepicker('setStartDate', minDate);
    });

    $("#end_date").datepicker({ 
        startDate: $("#start_date").val(),
        autoclose: true, 
        todayHighlight: true
    }).on('changeDate', function (selected) {
        var maxDate = new Date(selected.date.valueOf());
        $('#start_date').datepicker('setEndDate', maxDate);
    });
}); 