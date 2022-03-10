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
        c.loadMorePapers(page, 'true');
        $('.pagination').hide();
        $(".resource_table").scroll(function() {
            var ele = $(this);
            if(ele.scrollTop() + ele.innerHeight() >= ele[0].scrollHeight) {
                page++;
                var totalPage = $('#total_pages').val();
                if(page <= totalPage){
                    c.loadMorePapers(page);
                }
            }
        });
    };

    //Category form validation
    c.loadMorePapers = function(page, filter = null){
        // alert(page);
        $.ajax({
            url : '?page=' + page,
            global: false,
            beforeSend: function() {
                $('.res_loader').show();
            },
            complete: function(){
                $('.res_loader').hide();
            },
        }).done(function (data) {
            if(data != "") {
                if(filter) {
                    $('#all_resources').html(data);
                } else {
                    $('#all_resources').append(data);
                }
                $('#all_resources .pagination').hide();
            } else {
                $('#all_resources').html('<tr><td><h4 class="all-pdng-cls">'+CONSTANT_VARS.no_result_found+'</h4></td></tr>');
            }
        }).fail(function () {
            $('#all_resources').append('<tr><td><h4 class="all-pdng-cls">'+CONSTANT_VARS.no_result_found+'</h4></td></tr>');
        });
    };

    window.acePaperResource = new acePaperResource();
})(jQuery);

