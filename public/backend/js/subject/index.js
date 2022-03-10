$(document).ready(function () {
    var url = $('#subject_table').attr('data-url'); // This variable is used for getting route name or url.
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
                // {
                //     "data" : "id",
                // },
                {
                    "data": "order_seq"
                },
                {
                    "data": "title"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                },
                
                
            ];
            var order_coloumns = [[1,"asc"]];
            table = acePaperCommon._generateDataTable('subject_table', url, field_coloumns, order_coloumns, data = null);
        };
        
        window.acePaperAssessment = new acePaperAssessment();
    })(jQuery);
});



// Sortable datatable with drag row
var last_order;

$( "#subject_table" ).sortable({
    items: "tr",
    cursor: 'move',
    opacity: 0.6,
    update: function() {
        $.map($(this).find('tr'), function(el) {
            var id = $(el).attr('data-id');
            var sorting = $(el).index();
            if (id != undefined) {
                $.ajax({
                    url: site_url + '/admin/subject/sorting',
                    type: 'POST',
                    global: false,
                    data: {
                        id: id,
                        sorting: sorting
                    },success(){
                        $('#subject_table').DataTable().ajax.reload(null, false);
                    }
                });
                last_order  = sorting;
            }
        });
    }
});