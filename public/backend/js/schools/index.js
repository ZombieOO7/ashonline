var url = $('#schools_table').attr('data-url'); // This variable is used for getting route name or url.
// This function is used to initialize the data table.
(function ($)
{
    var acePaperAssessment = function ()
    {
        $(document).ready(function ()
        {
            c._initialize();
        });
    };
    var c = acePaperAssessment.prototype;

    c._initialize = function ()
    {
        c._listingView();
    };

    c._listingView = function(){
        var field_coloumns = [
            {"data": "checkbox", orderable: false, searchable: false },
            {data: 'school_name', name: 'school_name'},
            {data: 'categories', name: 'categories'},
            {"data": "active"},
            {"data": "created_at", orderable: true},
            {"data": "action" , orderable: false},
        ];
        var order_coloumns = [[4, "desc"]];
        backloadzCommon._generateDataTable('schools_table',url,field_coloumns,order_coloumns);
    };
    window.acePaperAssessment = new acePaperAssessment();
})(jQuery);

   