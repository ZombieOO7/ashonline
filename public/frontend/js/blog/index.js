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
        c.loadBlogs(catSlug);
        c.filterBlogs();
    };

    //Category form validation
    c.loadBlogs = function(slug) {
        $.ajax({
            url : '',
            data: {cat_slug: slug},
            global: false,
        }).done(function (data) {
            if(data != "") {
                $('#all_blogs').html(data);
            } else {
                $('#all_blogs').html('<div class="col-md-6"><h4 class="all-pdng-cls">No result found.</h4></div>');
            }
        }).fail(function () {
            $('#all_blogs').append('<div class="col-md-6"><h4 class="all-pdng-cls">No result found.</h4></div>');
        });
    };

    c.filterBlogs = function() {
        $('.filter').on('click', function() {
            var catVal = $(this).data('values');
            $('.filter').removeClass('active');
            $(this).addClass('active');
            c.loadBlogs(catVal);
        });
    }

    window.acePaperResource = new acePaperResource();
})(jQuery);

