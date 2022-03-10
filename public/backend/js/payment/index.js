$(document).ready(function () {
    var url = $('#payment_table').attr('data-url'); // This variable is used for getting route name or url.

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
                    'data':'order_no',
                    'name':'order_no',
                },
                // {
                //     'data':'currency',
                //     'name':'currency',
                // },
                {
                    'data':'amount',
                    'name':'amount',
                },
                {
                    'data':'method',
                    'name':'method',
                },
                {
                    'data':'created_at',
                    'name':'created_at',
                },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                },
            ];
            var order_coloumns = [[3,"desc"]];
            table = acePaperCommon._generateDataTable('payment_table', url, field_coloumns, order_coloumns, data = null);
        };
        window.acePaperAssessment = new acePaperAssessment();
    })(jQuery);
});
