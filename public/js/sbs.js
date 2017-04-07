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

    // Carousels
    var Carousel = {}
    Carousel.autoplay_id;
    Carousel.startAutoplay = function (c) {
       Carousel.autoplay_id = setInterval(function() {
          c.carousel('next');
        }, 5000);
    }
    Carousel.stopAutoplay = function () {
      if (Carousel.autoplay_id) {
        clearInterval(Carousel.autoplay_id);
      }
    }
    var carousel = $('.carousel.carousel-slider');
    if (carousel) {
        carousel.carousel({
            fullWidth: true,
            indicators: true,
            duration: 300,
            onCycleTo : function(item, dragged) {
                Carousel.stopAutoplay();
                Carousel.startAutoplay(carousel);
            }
        });
    }
    // Size Nav
    $('.button-collapse').sideNav();
    // Select fields
    $('select').material_select();
    // Collapsible elements
    $('.collapsible').collapsible();
    // Modals
    $('.modal').modal();

    SBS.init();
});
