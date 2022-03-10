$(document).ready(function () {
    var url = $('#review_table').attr('data-url'); // This variable is used for getting route name or url.

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
                    'data':'paper',
                    'name':'paper',
                },
                {
                    'data':'mock_test_id',
                    'name':'mock_test_id',
                },
                {
                    'data':'email',
                    'name':'email',
                },
                {
                    'data':'rate',
                    'name':'rate',
                },
                {
                    'data':'review',
                    'name':'review',
                },
                {
                    'data':'created_at',
                    'name':'created_at',
                },
                {
                    'data':'status',
                    'name':'status',
                },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                },
            ];
            var order_coloumns = [[5,"desc"]];
            table = acePaperCommon._generateDataTable('review_table', url, field_coloumns, order_coloumns, data = null);
            table.on( 'draw.dt', function () {
                $.fn.raty.defaults.path = base_url + '/public/images';
                $(document).find('.default').raty({readOnly:  true});
                
            });
        };
        window.acePaperAssessment = new acePaperAssessment();
    })(jQuery);
    $(document).on('click','.shw-dsc',function(e) {
        $(document).find('.show_desc').html($(this).attr('data-description'));
    });
});
