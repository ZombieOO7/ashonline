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

    var page = 1;
    c._initialize = function ()
    {
        c.loadResources(catSlug);
        c.filterResources();
    };

    //Category form validation
    c.loadResources = function(slug) {
        $.ajax({
            url : '',
            data: {cat_slug: slug},
            global: false,
        }).done(function (data) {
            if(data != "") {
                $('#all_resources').html(data);
            } else {
                $('#all_resources').html('<div class="col-md-6"><h4 class="all-pdng-cls">'+CONSTANT_VARS.no_result_found+'</h4></div>');
            }
        }).fail(function () {
            $('#all_resources').append('<div class="col-md-6"><h4 class="all-pdng-cls">'+CONSTANT_VARS.no_result_found+'</h4></div>');
        });
    };

    c.filterResources = function() {
        $('.filter').on('click', function() {
            var catVal = $(this).data('values');
            $('.filter').removeClass('active');
            $(this).addClass('active');
            c.loadResources(catVal);
        });
    }

    window.acePaperResource = new acePaperResource();
})(jQuery);

