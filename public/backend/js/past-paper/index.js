$(document).ready(function () {
    var url = $('#past_paper_table').attr('data-url'); // This variable is used for getting route name or url.

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
                    "data": "name"
                },
                {
                    "data": "subject_id"
                },
                {
                    "data": "school_year"
                },
                {
                    "data": "month"
                },
                {
                    "data": "year"
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
            var order_coloumns = [[6,"desc"]];
            backloadzCommon._generateDataTable('past_paper_table', url, field_coloumns, order_coloumns);
        };
        window.backloadzAssessment = new backloadzAssessment();
    })(jQuery);
});
