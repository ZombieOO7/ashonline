if ($('#counter').length > 0) {
    var a = 0;
    $(window).scroll(function () {
        var oTop = $('#counter').offset().top - window.innerHeight;
        if (a == 0 && $(window).scrollTop() > oTop) {
            $('.counter-value').each(function () {
                var $this = $(this),
                    countTo = $this.attr('data-count');
                $({
                    countNum: $this.text()
                }).animate({
                        countNum: countTo
                    },

                    {

                        duration: 2000,
                        easing: 'swing',
                        step: function () {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function () {
                            $this.text(this.countNum);
                        }

                    });
            });
            a = 1;
        }

    });
}
(function ($) {
    $('.js-load-video-medium').joldLoadVideo({
        youtubeThumbSize: 'maxresdefault'
    });
})(jQuery);

$(function () {
    $(document).find('.fixedStar_readonly').raty({
        readOnly: true,
        path: rateImagePath,
        starOff: 'star-off.svg',
        starOn: 'star-on.svg',
        starHalf: 'star-half.svg',
        start: $(document).find(this).attr('data-score')
    });
});
