var today = new Date();
var minDate = new Date();
var dateOption = {
    orientation: 'bottom auto',
    format: 'yyyy',
    todayHighlight:'TRUE',
    autoclose: true,
    viewMode: "years", 
    minViewMode: "years",
    startDate : '1980',
    endDate: today,
}
$('#year').datepicker(dateOption);
$(document).find("#month").select2();
$(document).find("#date").select2();
$(document).find("#status").select2();
$(document).find("#studentId").select2();
$('#yearly').on('click',function(){
    $('#yearInput').show();
    $('#monthInput').hide();
    $('#dayInput').hide();
    $('#reportCategory').val(1);
    $('#year').val('');
    $('#month').val('');
    $('#date').val('');
    $('#month').selectpicker().trigger('change');
    $('#date').selectpicker().trigger('change');
});
$('#monthly').on('click',function(){
    $('#yearInput').show();
    $('#monthInput').show();
    $('#dayInput').hide();
    $('#reportCategory').val(2);
    $('#year').val('');
    $('#month').val('');
    $('#date').val('');
    $('#month').selectpicker().trigger('change');
    $('#date').selectpicker().trigger('change');
});
$('#daily').on('click',function(){
    $('#yearInput').show();
    $('#monthInput').show();
    $('#dayInput').show();
    $('#reportCategory').val(3);
    $('#year').val('');
    $('#month').val('');
    $('#date').val('')
    $('#month').selectpicker().trigger('change');
    $('#date').selectpicker().trigger('change');
});

$(document).ready(function () {
    $("#oreder_report_form").validate({
        rules: {
            report_type:{
                required:true,
            },
            year:{
                required:true,
            },
            month:{
                required:function(element){
                    if($('#reportCategory').val()==2 || $('#reportCategory').val()==3){
                        return true;
                    }else{
                        return false;
                    }
                }
            },
            date:{
                required:function(element){
                    if($('#reportCategory').val()==3){
                        return true;
                    }else{
                        return false;
                    }
                }
            },
            export_to:{
                required:true,
            },
            report_type:{
                required:true,
            },
            reportCategory:{
                required:true,
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "export_to")
                error.insertAfter(".exportError");
            else if(element.attr("name") == "report_type")
                error.insertAfter(".reportTypeError");
            else if(element.attr("name") == "location_id")
                error.insertAfter(".dynamicError");
            else if(element.attr("name") == "problem_id")
                error.insertAfter(".dynamicError");
            else if(element.attr("name") == "machine_id" && $('#reportType').val() !=6)
                error.insertAfter(".dynamicError");
            else if(element.attr("name") == "user_id")
                error.insertAfter(".dynamicError");
            else if(element.attr("name") == "job_type_id")
                error.insertAfter(".dynamicError");
            else if(element.attr("name") == "month")
                error.insertAfter(".monthsError");
            else if(element.attr("name") == "date")
                error.insertAfter(".daysError");
            else if(element.attr("name") == "machine_id")
                error.insertAfter(".machineError");
            else
                error.insertAfter(element);
        },
        success: function() {
            $("#m_form_1_msg").addClass("m--hide").show();
        },
        invalidHandler: function (e, r) {
            $("#m_form_1_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
        },
    });
})
$('#clearBtn').on('click',function(){
    $('select').val('');
    $('input[type=text]').val('');
    $('#yearInput').hide();
    $('#monthInput').hide();
    $('#dayInput').hide();
})