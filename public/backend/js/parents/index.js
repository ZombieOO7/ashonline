var url = $('#parent_table').attr('data-url'); // This variable is used for getting route name or url.
$(document).ready(function () {
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
                    "data": "checkbox",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "full_name"
                },
                {
                    "data": "email"
                },
                // {
                //     "data": "gender"
                // },
                {
                    "data": "is_tuition_parent"
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
            var order_coloumns = [[5,"desc"]];
            table = backloadzCommon._generateDataTable('parent_table', url, field_coloumns, order_coloumns, data = null);
        };
        window.backloadzAssessment = new backloadzAssessment();
    })(jQuery);

});
