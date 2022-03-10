$(document).ready(function () {
    var url = $('#tuition_parent_table').attr('data-url'); // This variable is used for getting route name or url.

    // This funtion is used to initialize the data table.
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
                    "data": "full_name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "gender"
                },
                {
                    "data": "mobile"
                },
                {
                    "data": "created_at"
                },
                
            ];
            var order_coloumns = [[4,"desc"]];
            table = backloadzCommon._generateDataTable('tuition_parent_table', url, field_coloumns, order_coloumns, data = null);
        };
        window.backloadzAssessment = new backloadzAssessment();
    })(jQuery);

});
