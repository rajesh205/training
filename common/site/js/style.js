$(function () {
    $('#aboutSee').waypoint(function () {
        alert('hola');
    })

    $('.count').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
})

(function($) {
    var $window = $(window),
        $html = $('.social');

    function resize() {
        if ($window.width() < 514) {
            return $html.addClass('float-center');
        } else {
            return $html.addClass('float-right');
        }
    }
    
    $window
        .resize(resize)
        .trigger('resize');
})(jQuery);

