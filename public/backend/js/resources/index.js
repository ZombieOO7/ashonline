var url = base_url + "/admin/resources/datatable"; // This variable is used to get route or url.

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
            {"data": "title"},
            {"data": "question"},
            {"data": "answer"},
            {"data": "created_at"},
            {"data": "action", orderable: false, searchable: false},
        ];
        var order_coloumns = [[4, "desc"]];
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

