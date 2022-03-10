// This function is used to initialize the data table.
(function ($)
{
    var acePaperSubscriber = function ()
    {
        $(document).ready(function ()
        {
            c._initialize();
        });
    };
    var c = acePaperSubscriber.prototype;

    c._initialize = function ()
    {
        c._listingView();
    };

    c._listingView = function(){
        var field_coloumns = [
            // {"data": "checkbox", orderable: false, searchable: false },
            {"data": "email" },
            {"data": "created_at"},
        ];
        var order_coloumns = [[1, "desc"]];
        var url = $('#subscriber_table').data('url');
        acePaperCommon._generateDataTable('subscriber_table',url,field_coloumns,order_coloumns);
    };
    window.acePaperSubscriber = new acePaperSubscriber();
})(jQuery);

