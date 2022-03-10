
$(document).ready(function () {
    $("#oreder_report_form").validate({
        rules: {
            year: {
                required: true,
            },
            'months[]': {
                required: true,
            },
            'export_to':{
                required: true,
            }
        },
        ignore: [],
        errorPlacement: function (error, element) {
            if (element.attr("name") == "months[]")
                error.insertAfter(".monthsError");
            else if(element.attr("name") == "export_to")
                error.insertAfter(".exportError");
            else
                error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            $("#oreder_report_form").removeClass("m--hide").show(),
                mUtil.scrollTop()
        },
    })
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
    $(document).find("#categoryIds").select2();
    $(document).find("#months").select2();
    $(document).find("#subjectIds").select2();
})