// This function is used to initialize the data table.
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
                "data": "title"
            },
            {
                "data": "exam_board_id"
            },
            {
                "data": "grade_id"
            },
            {
                "data": "start_date"
            },
            {
                "data": "end_date"
            },
            {
                "data": "price"
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
        var order_coloumns = [[7, "desc"]];
        backloadzCommon._generateDataTable('mock_test_table', url, field_coloumns, order_coloumns);
    };
    window.backloadzAssessment = new backloadzAssessment();
})(jQuery);