$(document).ready(function () {
    var url = $('#promo_code_table').attr('data-url'); // This variable is used for getting route name or url.

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
                // {
                //     "data": "checkbox",
                //     orderable: false,
                //     searchable: false
                // },
                {
                    "data": "code"
                },
                {
                    "data": "amount_1"
                },
                {
                    "data": "discount_1"
                },
                {
                    "data": "amount_2"
                },
                {
                    "data": "discount_2"
                },
                {
                    "data": "start_date"
                },
                {
                    "data": "end_date"
                },
                {
                    "data": "created_at"
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
            var order_coloumns = [[7,"desc"]];
            table = acePaperCommon._generateDataTable('promo_code_table', url, field_coloumns, order_coloumns, data = null);
        };
        window.acePaperAssessment = new acePaperAssessment();
    })(jQuery);

});
