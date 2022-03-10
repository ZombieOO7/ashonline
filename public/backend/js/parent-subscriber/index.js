$(document).ready(function () {
    // This funtion is used to initialize the data table.
    if($('#parent_subscriber_table').length > 0){
        (function ($) {
            var backloadzAssessment = function () {
                $(document).ready(function () {
                    c._initialize();
                });
            };
            var c = backloadzAssessment.prototype;
        
            c._initialize = function () {
                c._listingView();
            };
        
            c._listingView = function () {
                var field_coloumns = [
                    {
                        "data": "checkbox",
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "subscriber_id"
                    },
                    {
                        "data": "full_name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "action",
                        orderable: false,
                        searchable: false
                    },
                ];
                var order_coloumns = [[1,"desc"]];
                backloadzCommon._generateDataTable('parent_subscriber_table', url, field_coloumns, order_coloumns);
            };
            window.backloadzAssessment = new backloadzAssessment();
        })(jQuery);
    }

    // parent subscription payment data
    if($('#parent_payment_table').length > 0){
        (function ($) {
            var backloadzAssessment = function () {
                $(document).ready(function () {
                    c._initialize();
                });
            };
            var c = backloadzAssessment.prototype;
        
            c._initialize = function () {
                c._listingView();
            };
        
            c._listingView = function () {
                var field_coloumns = [
                    {
                        "data": "checkbox",
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "transaction_id"
                    },
                    {
                        "data": "amount"
                    },
                    {
                        "data": "method"
                    },
                    {
                        "data": "payment_date"
                    },
                    {
                        "data": "description",
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "action",
                        orderable: false,
                        searchable: false
                    },

                ];
                var order_coloumns = [[3,"desc"]];
                backloadzCommon._generateDataTable('parent_payment_table', url, field_coloumns, order_coloumns);
            };
            window.backloadzAssessment = new backloadzAssessment();
        })(jQuery);
    }

    /** Show description modal */
    $(document).on('click','.shw-dsc',function(e) {
        $(document).find('.show_desc').html($(this).attr('data-description'));
        $(document).find('.show_sbjct').html($(this).attr('data-subject'));
    });

    /** send invoice mail */
    $(document).on('click','.sendMail',function(){
        $.ajax({
            url:$(this).data('url'),
            data:{
                id : $(this).data('id'), 
            },
            method:'POST',
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
    })
});
