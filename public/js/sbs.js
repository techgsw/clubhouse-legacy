var SBS;
if (!SBS) {
    SBS = {};
}

(function () {
    SBS.Video = {};
    SBS.Video.init = function () {
        var vimeo = $('#hub-video-modal iframe');
        var player = new Vimeo.Player(vimeo);
        $('#hub-video-modal').modal({
            ready: function() {
                player.play();
            },
            complete: function() {
                player.pause();
            },
        });
    };
})();

$(document).ready(function () {
    $('.button-collapse').sideNav();
    $('select').material_select();
    $('.carousel.carousel-slider').carousel({fullWidth: true});
    $('.collapsible').collapsible();
    $('.modal').modal();

    SBS.Video.init();
});
