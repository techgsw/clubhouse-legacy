var SBS;
if (!SBS) {
    SBS = {};
}

(function () {
    var Instagram = {};
    var Video = {};

    Instagram.getFeed = function () {
        return $.ajax({
            type: "GET",
            url: "/social/instagram",
            params: {},
        });
    }
    Instagram.init = function () {
        var ig = $('#instagram');
        if (ig.length > 0) {
            Instagram.getFeed().done(
                function (resp, status, xhr) {
                    if (xhr.status == 200) {
                        ig.find('.preloader-wrapper').remove();
                        ig.append(resp);
                    } else {
                        ig.find('.preloader-wrapper').remove();
                        ig.append("<a class=\"username\" href=\"https://instagram.com/sportsbizsol\"><span>@</span>sportsbizsol</a>");
                        console.error("Failed to load Instagram feed.");
                    }
                }
            );
        }
    }


    Video.init = function () {
        if ($('#hub-video-modal iframe').length) {
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
        }
    };

    SBS.init = function () {
        Instagram.init();
        Video.init();
    }
})();

$(document).ready(function () {
    $('.button-collapse').sideNav();
    $('select').material_select();
    $('.carousel.carousel-slider').carousel({fullWidth: true});
    $('.collapsible').collapsible();
    $('.modal').modal();

    SBS.init();
});
