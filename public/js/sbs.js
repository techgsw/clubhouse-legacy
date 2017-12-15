var SBS;
if (!SBS) {
    SBS = {};
}

/**
 * Shim from http://api.jquery.com/val/ to preserve newline characters
 */
$.valHooks.textarea = {
    get: function( elem ) {
        return elem.value.replace( /\r?\n/g, "\r\n" );
    }
};

(function () {
    var Auth = {};
    var Blog = {};
    var Form = {
        unsaved: false
    };
    var Instagram = {};
    var Tag = {
        map: {}
    };
    var Video = {};

    Auth.getAuthHeader = function () {
        return $.ajax({
            type: "GET",
            url: "/auth/login/header",
            params: {},
        });
    }

    Blog.init = function () {
        var editor = $(".markdown-editor");
        if (!editor) {
            return;
        }
        var input = $("textarea.markdown-input");
        if (!input) {
            return;
        }
        new MediumEditor(editor, {
            extensions: {
                markdown: new MeMarkdown(function (md) {
                    input.val(md);
                })
            },
            paste: {
                forcePlainText: false,
                cleanPastedHTML: true,
                cleanReplacements: [],
                cleanAttrs: ['class', 'style', 'dir', 'span'],
                cleanTags: ['meta', 'span']
            },
            placeholder: {
                text: 'Write here',
                hideOnClick: true
            }
        });
    }

    Tag.create = function (name) {
        return $.ajax({
            'type': 'POST',
            'url': '/tag',
            'data': {
                'name': name,
                '_token': $('form#create-tag input[name="_token"]').val()
            }
        });
    }

    Tag.getOptions = function () {
        return $.ajax({
            'type': 'GET',
            'url': '/tag/all',
            'data': {}
        });
    }

    Tag.addToPost = function (name, input, view) {
        // Append to input
        var tags = JSON.parse(input.val());
        tags.push(name);
        $(input).val(JSON.stringify(tags));
        // Append to view
        var tag =
            `<span class="flat-button gray small tag">
                <button type="button" name="button" class="x" tag-name=${name}>&times;</button>${name}
            </span>`;
        $(view).append(tag);
    }

    Tag.removeFromPost = function (name, input, view) {
        // Remove from input
        var tags = JSON.parse(input.val());
        var i = tags.indexOf(name);
        if (i > -1) {
            tags.splice(i, 1);
        }
        input.val(JSON.stringify(tags));
        // Remove from view
        var button = $('button[tag-name="'+name+'"]');
        if (button) {
            button.parent().remove();
        }
    }

    Tag.init = function () {
        var tag_autocomplete = $('input.tag-autocomplete');
        if (tag_autocomplete.length > 0) {
            Tag.getOptions().done(function (data) {
                var tags = {}
                data.forEach(function (t) {
                    Tag.map[t.name] = t.slug;
                    tags[t.name] = "";
                });
                var x = tag_autocomplete.autocomplete({
                    data: tags,
                    limit: 10,
                    onAutocomplete: function (val) {
                        Tag.addToPost(val, $('input#post-tags-json'), $('.post-tags'));
                        tag_autocomplete.val("");
                    },
                    minLength: 2,
                });
            });
        }
    }

    $('body').on(
        {
            submit: function (e, ui) {
                e.preventDefault();
            }
        },
        'form#create-tag'
    )

    $('body').on(
        {
            keydown: function (e, ui) {
                if (e.keyCode != 13) {
                    return;
                }
                var input = $(this);
                var name = $(this).val();
                if (!name || name == "") {
                    return;
                }
                // Tag already exists in map. Add it and clear input.
                if (Tag.map[name] !== undefined) {
                    Tag.addToPost(name, $('input#post-tags-json'), $('.post-tags'));
                    tag_autocomplete.val("");
                    return;
                }
                // Create new tag, add it, and clear input.
                Tag.create(name).done(function (resp) {
                    var tag_name = resp.tag.name;
                    Tag.addToPost(tag_name, $('input#post-tags-json'), $('.post-tags'));
                    input.val("");
                });
            }
        },
        '.tag-autocomplete'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var name = $(this).attr('tag-name');
                Tag.removeFromPost(name, $('input#post-tags-json'), $('.post-tags'));
            }
        },
        'span.tag button.x'
    );

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

    SBS.Inquiry = {};
    SBS.Inquiry.rate = function (id, rating) {
        var action = '';
        // Normalize rating to -1, 0, or 1
        rating = (rating > 0) ? 1 : (rating < 0) ? -1 : 0;
        switch (rating) {
            case 1:
                action = 'rate-up';
                break;
            case 0:
                action = 'rate-maybe';
                break;
            case -1:
                action = 'rate-down';
                break;
        }
        // POST and return deferred object
        return $.ajax({
            method: "GET",
            url: "/inquiry/"+id+"/"+action,
            data: {}
        });
    }

    // Rate an inquiry upon clicking a rating button
    $('body').on(
        {
            click: function (e, ui) {
                var id = parseInt($(this).attr('inquiry-id'));
                var rating = parseInt($(this).attr('rating'));

                if (!id) {
                    console.error('Inquiry.rate: ID and rating are required');
                    return;
                }

                // The clicked rating button
                var btn = $(this);
                // All rating buttons, including the clicked one
                var rating_btns = $(this).parent().find('button[action="inquiry-rate"]');
                // Switch all buttons to gray to indicate a pending action
                rating_btns.each(function (i, b) {
                    $(b).removeClass('blue');
                    $(b).addClass('gray');
                });

                SBS.Inquiry.rate(id, rating).done(function (resp) {
                    if (resp.type != 'success') {
                        console.error('An error occurred trying to rate inquiry '+id);
                        return;
                    }
                    // Deactivate the selection class for all buttons. Return
                    // all buttons to blue now that the app has responded.
                    rating_btns.each(function (i, b) {
                        $(b).removeClass('gray');
                        $(b).addClass('blue');
                        $(b).removeClass('inverse');
                    });
                    // Activate the selection class for the clicked button only
                    btn.addClass('inverse');
                });
            }
        },
        'button[action="inquiry-rate"]'
    );

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
                        picker.set('select', [year, month, day]);
                    }
                }
            }
        },
        'input.datepicker'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var upload_resume = $("#upload-resume");
                if (!upload_resume) {
                    return;
                }

                var checked = $(this).prop('checked');
                if (checked) {
                    upload_resume.addClass('hidden');
                } else {
                    upload_resume.removeClass('hidden');
                }
            }
        },
        'input#use_profile_resume'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var featured = $(this).prop('checked');
                var rank = $('input[name="rank"]');

                if (!rank) {
                    return;
                }

                if (featured) {
                    rank.removeAttr('disabled');
                } else {
                    rank.val("");
                    rank.attr('disabled', 'disabled');
                }
            }
        },
        'input[name="featured"]'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var button = $(this);
                var showHideId = "#"+button.attr('show-hide-id');
                var element = $(showHideId);

                if (!element) {
                    return;
                }

                if (element.hasClass('hidden')) {
                    element.removeClass('hidden');
                    button.find('span.show-options').addClass('hidden');
                    button.find('span.hide-options').removeClass('hidden');
                } else {
                    element.addClass('hidden');
                    button.find('span.hide-options').addClass('hidden');
                    button.find('span.show-options').removeClass('hidden');
                }
            }
        },
        'button.show-hide'
    );

    $('body').on(
        {
            change: function (e, ui) {
                var form = $(this).parents('form');
                form.submit();
            }
        },
        '.submit-on-change'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var inputId = $(this).attr('input-id');
                if (!inputId) {
                    return;
                }
                var value = $(this).attr('value');
                if (!value) {
                    return;
                }
                var input = $('#'+inputId);
                if (!input) {
                    return;
                }

                input.val(value);
                input.change();
            }
        },
        'button.input-control'
    );

    /**
     * PDF viewer modal.
     *
     * Trigger element:
     * <a class="modal-trigger pdf-modal-trigger" href="#pdf-view-modal" pdf-src="{{ ... }}">View</a>
     *
     * Modal element:
     * <div id="pdf-view-modal" class="modal modal-large modal-fixed-footer">
     *   ...
     *     <iframe class="pdf-frame" src="" width="100%"></iframe>
     */
    $('body').on(
        {
            click: function (e, ui) {
                e.preventDefault();

                var href = $(this).attr('href');
                var pdf_src = $(this).attr('pdf-src');
                if (!href || !pdf_src) {
                    return;
                }

                var modal = $(href);
                var frame = modal.find('iframe.pdf-frame');
                if (!modal || !frame) {
                    return;
                }

                frame.attr('src', pdf_src);
                modal.modal();
            }
        },
        'a.modal-trigger.pdf-modal-trigger'
    );

    $(window).on("beforeunload", function (e, ui) {
        if (Form.unsaved) {
            return "You have unsaved changes. Do you still want to leave?";
        }
    });

    SBS.init = function () {
        Blog.init();
        Instagram.init();
        Video.init();
        Tag.init();
        if ($('.app-login-placeholder-after').length > 0) {
            Auth.getAuthHeader().done(
                function (resp) {
                    $('.app-login-placeholder-after').after(resp);
                }
            );
        }
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
