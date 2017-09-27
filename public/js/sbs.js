var SBS;
if (!SBS) {
    SBS = {};
}

(function () {
    var Auth = {};
    var Instagram = {};
    var Video = {};
    var Form = {
        unsaved: false
    };

    Auth.getAuthHeader = function () {
        return $.ajax({
            type: "GET",
            url: "/auth/login/header",
            params: {},
        });
    }

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
        if ($('.app-login-placeholder-after').length > 0) {
            Auth.getAuthHeader().done(
                function (resp) {
                    $('.app-login-placeholder-after').after(resp);
                }
            );
        }
    }

    Form.toggleGroup = function (group) {
        var inputs = group.find('input');
        inputs.each(function(i, input) {
            if ($(input).attr('disabled')) {
                $(input).removeAttr('disabled');
            } else {
                $(input).attr('disabled','disabled');
            }
        });
        var selects = group.find('select');
        selects.each(function(i, select) {
            if ($(select).attr('disabled')) {
                $(select).removeAttr('disabled');
            } else {
                $(select).attr('disabled','disabled');
            }
        });
        var textareas = group.find('textarea');
        textareas.each(function(i, textarea) {
            if ($(textarea).attr('disabled')) {
                $(textarea).removeAttr('disabled');
            } else {
                $(textarea).attr('disabled','disabled');
            }
        });
        group.toggleClass('hidden');
    }

    $('body').on(
        {
            change: function (e, ui) {
                var input = $(this);
                var name = $(this).attr('sbs-toggle-group');
                var group = $("div[sbs-group="+name+"]");
                if (group.length > 0) {
                    Form.toggleGroup(group);
                } else {
                    console.error("Failed to find form group: "+name);
                }
            }
        },
        'input.sbs-toggle-group'
    );

    // TODO generalize into a class of form
    $('body').on(
        {
            change: function (e, ui) {
                Form.unsaved = true;
                var input = $(this);
                var section = input.parents("li.form-section");
                section.find("span.progress-icon").addClass("hidden");
                section.find("span.progress-icon.progress-unsaved").removeClass("hidden");
            }
        },
        'form#edit-profile input, form#edit-profile select, form#edit-profile textarea'
    );

    $('body').on(
        {
            click: function (e, ui) {
                Form.unsaved = false;
            }
        },
        'button[type="submit"], input[type="submit"]'
    );

    $('body').on(
        {
            click: function () {
                var input = $(this);
                var picker = input.pickadate('picker');
                if (!input.val() || input.val() === "") {
                    var year = parseInt(input.attr('default-year'));
                    var month = parseInt(input.attr('default-month'));
                    var day = parseInt(input.attr('default-day'));
                    if (year && month && day) {
                        console.log('here');
                        picker.set('select', [year, month, day]);
                    }
                }
            }
        },
        'input.datepicker'
    );

    $(window).on("beforeunload", function (e, ui) {
        if (Form.unsaved) {
            return "You have unsaved changes. Do you still want to leave?";
        }
    });
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
    // Material boxes
    $('.materialboxed').materialbox();
    // Material datepicker
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 100,
        close: 'Ok',
        closeOnSelect: true
    });
    // Initialize
    SBS.init();
});
