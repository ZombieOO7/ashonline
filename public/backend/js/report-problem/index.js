$(document).ready(function () {
    var url = $('#report_problem_table').attr('data-url'); // This variable is used for getting route name or url.

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
                // {
                //     "data": "checkbox",
                //     orderable: false,
                //     searchable: false
                // },
                {
                    "data": "child_id"
                },
                {
                    "data": "question"
                },
                {
                    "data": "description"
                },
                {
                    "data": "project_type"
                },
                {
                    "data": "created_at"
                },
                // {
                //     "data": "action",
                //     orderable: false,
                //     searchable: false
                // },
            ];
            var order_coloumns = [[4,"desc"]];
            backloadzCommon._generateDataTable('report_problem_table', url, field_coloumns, order_coloumns);
        };
        window.backloadzAssessment = new backloadzAssessment();
    })(jQuery);

});
