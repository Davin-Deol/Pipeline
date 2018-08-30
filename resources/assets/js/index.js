$(function () {
    $('a').on('click', function (e) {
        var offset = parseInt($($(this).attr('href')).offset().top);
        var bheight = $(window).height();
        var percent = 0.07;
        var hpercent = bheight * percent;
        $('html,body').animate({
            scrollTop: offset - hpercent
        }, 300, 'linear');
    });
});
