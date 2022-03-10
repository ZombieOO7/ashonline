$(document).ready(function () {
    var url = $('#order_table').attr('data-url'); // This variable is used for getting route name or url.

    // This funtion is used to initialize the data table.
    (function ($) {
        var acePaperAssessment = function () {
            $(document).ready(function () {
                c._initialize();
            });
        };
        var c = acePaperAssessment.prototype;
    
        c._initialize = function () {
            c._listingView();
        };
    
        c._listingView = function () {
            var field_coloumns = [
                {
                    "data": "order_no",
                    "name": 'order_no'
                },
                {
                    "data": "invoice_no",
                    "name": 'invoice_no'
                },
                {
                    "data": "amount",
                    "name": 'amount'
                },
                {
                    "data": "discount",
                    "name": 'discount'
                },
                {
                    "data": "total",
                    "name": 'total'
                },
                {
                    "data": "created_at",
                    "name": 'created_at'
                },
                // {
                //     "data": "status",
                //     "name": 'status'
                // },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                },
            ];
            var order_coloumns = [[5,"desc"]];
            table = acePaperCommon._generateDataTable('order_table', url, field_coloumns, order_coloumns, data = null);

            // search selected date 
            $(document).find('#created_at').on('change',function(){
                table.columns( 5 ).search( this.value ).draw();
            });
        };
        window.acePaperAssessment = new acePaperAssessment();
    })(jQuery);

    // date picker
    var today = new Date();
    var dateOption = {
        orientation: 'bottom auto',
        format: 'dd-mm-yyyy',
        todayHighlight:'TRUE',
        autoclose: true,
        endDate: today,
    }
    $(document).find('#created_at').datepicker(dateOption);
});
//  download of selected paper version
$(document).find('.version-download').on('click',function() {
    var versionId = $(document).find('#version_id'+ $(this).data('key')).val();
    var filename = $(this).data('paper-slug');

    $.ajax({
       url:$(this).data('url') ,
       data:{  version_id : versionId, order_uuid  : $(this).data('order-uuid'), paper_slug  : $(this).data('paper-slug') },
       method:'POST',
       success:function(result){
          if(result.status == 'success'){
            // window.open(result.path, '_blank');
            var anchor = document.createElement('a');
            anchor.href = result.path;
            anchor.target = '_blank';
            anchor.download = filename+'.pdf';
            anchor.click();
          }else{
             swal({
                text : 'File not found',
                icon: "warning",
             })
          }
       },
       error:function(result){

       }
    })
 });
//  send mail to customer of selected paper version
 $(document).find('.version-send-mail').on('click',function() {
    var versionId = $(document).find('#version_id'+ $(this).data('key')).val();
    $.ajax({
       url:$(this).data('url') ,
       data:{  version_id : versionId, order_id  : $(this).data('order-id'), paper_id  : $(this).data('paper-id') },
       method:'POST',
       success:function(result){
             swal({
                text : result.message,
                icon: result.status,
             })
       },
       error:function(result){
          swal({
                text : 'Something went wrong',
                icon: "warning",
             })
       }
    })
 });
//  clear datepicker field value
$(document).on('click','#clr_filter', function() {
    $(document).find('#created_at').val('');
});
