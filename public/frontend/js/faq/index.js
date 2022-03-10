$(document).ready(function() {
    
    // ADD DYNAMIC SLUG TO URL
    function ChangeUrl(page, url) {
        window.history.pushState({href: page}, '', url);
    }

    $(document).on('click','.li-dtl-cls',function() {
        ChangeUrl('faq', $(this).attr('data-slug'));
        $(document).find('.li-dtl-cls').removeAttr('style');
        $(this).css('color', '#03a9f4');
        $(document).find('#faq-title').html($(this).attr('data-title'));
        $(document).find('#faq-content').html($(this).attr('data-content'));
    });

    $('.equal_height').equalHeights();
});

$.fn.equalHeights = function() {
    var max_height = 0;
    $(this).each(function() {
        max_height = Math.max($(this).height(), max_height);
    });
    $(this).each(function() {
        $(this).height(max_height);
    });
};