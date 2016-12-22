$('#special-pagination').click(function () {
    $('#hidden-pagination').slideToggle('slow');
    $('#special-pagination').hide();
});

$(document).ready(function () {
    var pp = $("#pp"),
        bg = $("#pp-bg");

    // set cookie timeout in minutes
    var date = new Date();
    var minutes = 99999999999; // 1 equals minute
    date.setTime(date.getTime() + (minutes * 60 * 1000));

    function pp_hide(pp, bg) {
        pp.animate({top: "-550px"}, 1000, function () {
            bg.fadeOut(1000);
        });
    }

    function pp_show(pp, bg) {
        pp.animate({top: "150px"}, 2000);
        bg.fadeIn(1000).click(function () {
            pp_hide(pp, bg)
        });
    }

    if ($.cookie('visit') == undefined) {
        $.cookie('visit', true, { expires: date } );
        setTimeout(function(){
            pp_show(pp, bg);
        }, 15000);
    }
});