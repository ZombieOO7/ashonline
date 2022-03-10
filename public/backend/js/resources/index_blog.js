var url = base_url + "/admin/resources/datatable/guidance"; // This variable is used to get route or url.

// This function is used to initialize the data table.
(function ($)
{
    var acePaperResource = function ()
    {
        $(document).ready(function ()
        {
            c._initialize();
        });
    };
    var c = acePaperResource.prototype;

    c._initialize = function ()
    {
        c._listingView();
        c.validateForm();
    };

    c._listingView = function(){
        var field_coloumns = [
            {"data": "checkbox", orderable: false, searchable: false },
            // {
            //     "data" : "id",
            // },
            {
                "data": "order_seq"
            },
            {"data": "title"},
            {"data": "slug"},
            {"data": "category_id"},
            {"data": "featured_img", orderable: false, searchable: false},
            {"data": "created_at"},
            {"data": "status"},
            {"data": "action", orderable: false, searchable: false},
        ];
        var order_coloumns = [[1, "asc"]];
        var data = { slug: $('#resources_table').data('type') };
        acePaperCommon._generateDataTable('resources_table',url,field_coloumns,order_coloumns,data);
    };

    //Category form validation
    c.validateForm = function() {
        $("#category_form").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: CONSTANT_VARS.input_title_max_length
                },
                content: {
                    required: true,
                    maxlength: CONSTANT_VARS.input_desc_max_length
                },
            },
            ignore: [],
            submitHandler: function (form) {
                // Prevent double submission
                if (!this.beenSubmitted) {
                    this.beenSubmitted = true;
                    form.submit();
                }
            },
        });
    };

    window.acePaperResource = new acePaperResource();
})(jQuery);

// Sortable datatable with drag row
var last_order;

$( "#resources_table" ).sortable({
    items: "tr",
    cursor: 'move',
    opacity: 0.6,
    update: function() {
        $.map($(this).find('tr'), function(el) {
            var id = $(el).attr('data-id');
            var sorting = $(el).index();
            if (id != undefined) {
                $.ajax({
                    url: site_url + '/admin/blog/sorting',
                    type: 'POST',
                    global: false,
                    data: {
                        id: id,
                        sorting: sorting
                    },success(){
                        $('#resources_table').DataTable().ajax.reload(null, false);
                    }
                });
                last_order  = sorting;
            }
        });
    }
});