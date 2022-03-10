$(document).ready(function () {
var url = $('#paper_category_table').attr('data-url'); // This variable is used for getting route name or url.

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
                "data": "checkbox",
                orderable: false,
                searchable: false
            },
            {
                "data": "title",
                "name": 'title'
            },
            {
                "data": "type",
                "name": 'type'
            },
            {
                "data": "color_code",
                "name": 'color_code'
            },
            {
                "data": "created_at",
                "name": 'created_at'
            },
            {
                "data": "status",
                "name": 'status'
            },
            {
                "data": "action",
                orderable: false,
                searchable: false
            },
        ];
        var order_coloumns = [[4,"desc"]];
        acePaperCommon._generateDataTable('paper_category_table',url,field_coloumns,order_coloumns,data = null);
    };
    window.acePaperAssessment = new acePaperAssessment();
})(jQuery);
});