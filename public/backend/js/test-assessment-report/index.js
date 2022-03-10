$("#start_date").datepicker({    
    endDate: new Date(),     
    autoclose: true, 
    format: 'dd-mm-yyyy',
    todayHighlight: true
}).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#end_date').datepicker('setStartDate', minDate);
});

$("#end_date").datepicker({ 
    startDate: $("#start_date").val(),
    format: 'dd-mm-yyyy',
    autoclose: true, 
    todayHighlight: true
}).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#start_date').datepicker('setEndDate', maxDate);
});


var url = $('#student_test_table').attr('data-url'); // This variable is used for getting route name or url.
// This function is used to initialize the data table.
var url2 = $('#mock_test_table').attr('data-url');

$(document).on('click','.resetTest',function(){
    var url = $(this).attr('data-url');
    swal({
        title: message['sure'],
        text: 'You want to reset test attempt data ?',
        icon: "warning",
        buttons: true,
        dangerMode: true,
        closeOnClickOutside: false,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: url,
                method:'GET',
                success: function (response) {
                    if (response['msg'] != 'error') {
                        swal(response['msg'], {
                            icon: response['icon'],
                            closeOnClickOutside: false,
                        });
                        $('#mock_test_table').DataTable().ajax.reload(null, false);
                        // window.location.reload();
                    }
                }
            });
        }
    });
})
if($('#mock_test_table').length > 0){
    var backloadzAssessment = function ()
    {
        $(document).ready(function ()
        {
            c._initialize();
        });
    };
    var c = backloadzAssessment.prototype;

    c._initialize = function ()
    {
        c._listingView();
    };

    c._listingView = function(){
        var field_coloumns = [
            {data: 'mock_test_title', name : 'mock_test_title'},
            {data: 'start_date', name: 'start_date' , orderable: true},
            {data: 'end_date', name: 'end_date' , orderable: true},
            {data: 'mock_completion', name: 'mock_completion' , orderable: true},
            {data: 'no_of_attempt', name : 'no_of_attempt'},
            {data: 'action', name: 'action' , orderable: false},
        ];
        var order_coloumns = [[2, "desc"]];
        backloadzCommon._generateDataTable('mock_test_table',url2,field_coloumns,order_coloumns);
    };
    window.backloadzAssessment = new backloadzAssessment();
}
$('#getData').validate({
    rules: {
        student_id:{
            required:true,
        },
        from_date:{
            required:true,
        },
        to_date:{
            required:true,
        }
    },
    errorPlacement: function (error, element) {
        error.insertAfter(element);
    },
    invalidHandler: function (e, r) {
        // $("#m_form_1_msg").removeClass("m--hide").show(),
            mUtil.scrollTop()
    },
})
$('#submitBtn').on('click',function(){
    if($('#getData').valid() && $('#studentId').val() != 'all'){
        if($('#getData').valid() && $('#studentId').val() != 'all'){
            $("#student_test_table").DataTable().destroy();
            $("#student_test_table tbody").empty();
            var backloadzAssessment = function ()
            {
                $(document).ready(function ()
                {
                    c._initialize();
                });
            };
            var c = backloadzAssessment.prototype;

            c._initialize = function ()
            {
                c._listingView();
            };

            c._listingView = function(){
                var field_coloumns = [
                    {data: 'student_no', name: 'student_no'},
                    // {data: 'full_name', name : 'full_name'},
                    {data: 'no_of_test', name: 'no_of_test' , orderable: true},
                    {data: 'parent_name', name: 'parent_name' , orderable: true},
                    {data: 'action', name: 'action' , orderable: false},
                ];
                var order_coloumns = [[0, "asc"]];
                backloadzCommon._generateDataTable('student_test_table',url,field_coloumns,order_coloumns);
            };
            window.backloadzAssessment = new backloadzAssessment();
        }
    }
})
// $('#studentId').on('change',function(){
// })
//  send mail to customer of selected paper version
$(document).on('click', '.send-mail',function () {
    $.ajax({
       url:$(this).attr('data-url') ,
    //    data:{  version_id : versionId, order_id  : $(this).data('order-id'), paper_id  : $(this).data('paper-id') },
       method:'GET',
       success:function(result){
          if(result.status == 'success'){
             swal({
                text : 'Mail sent successfully',
                icon: "success",
             })
          }else{
             swal({
                text : 'Something went wrong',
                icon: "warning",
             })
          }
       },
       error:function(result){
          swal({
                text : 'Something went wrong',
                icon: "warning",
             })
       }
    })
 });
 $('.questionDetail').on('click',function(){
    var uuid = $(this).attr('data-uuid');
    var id = $(this).attr('data-id');
    $.ajax({
        url:questionDetailUrl,
        method:'POST',
        data:{
            uuid:uuid,
            id:id,
        },
        success:function(response){
            if(response.status='success'){
                $('#questionData').html(response.html);
                $('#questionDetailModal').modal('show');
            }
        },
    })
})