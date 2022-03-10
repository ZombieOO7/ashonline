$(document).ready(function () {
    var url = $('#image_table').attr('data-url'); // This variable is used for getting route name or url.

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
                    "data": "path"
                },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                },
            ];
            var order_coloumns = [[1, "desc"]];
            backloadzCommon._generateDataTable('image_table', url, field_coloumns, order_coloumns);

        };
        window.backloadzAssessment = new backloadzAssessment();
    })(jQuery);

});

$("#m_form_image").validate({
    rules: {
        'uploadFile': {
            required: true,
            extension: "jpg|jpeg|png",
        }
    }
});
