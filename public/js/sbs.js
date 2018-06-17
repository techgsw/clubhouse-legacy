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
    var Contact = {};
    var Form = {
        unsaved: false
    };
    var Instagram = {};
    var Note = {};
    var Tag = {
        map: {}
    };
    var Video = {};
    var ContactRelationship = {
        map: {}
    };
    var UI = {};

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

    Contact.scheduleFollowUp = function (data) {
        return $.ajax({
            type: 'POST',
            url: '/contact/'+data.contact_id+'/schedule-follow-up',
            data: data
        });
    }

    Contact.rescheduleFollowUp = function (data) {
        return $.ajax({
            type: 'POST',
            url: '/contact/'+data.contact_id+'/reschedule-follow-up',
            data: data
        });
    }

    Contact.closeFollowUp = function (data) {
        return $.ajax({
            type: 'POST',
            url: '/contact/'+data.contact_id+'/close-follow-up',
            data: data
        });
    }

    Contact.handleSubmitNote = function (form, type) {
        var actions = $('#note-actions');
        var progress = $('#note-progress');
        var contact_notes_container = $('.contact-notes-modal');
        if (!contact_notes_container.hasClass('open')) {
            contact_notes_container = $('#contact-note-collapsible-body');
        }

        var values = form.serializeArray().reduce(function (values, curr) {
            values[curr.name] = curr.value;
            return values;
        }, {});

        actions.addClass('hidden');
        progress.removeClass('hidden');

        switch (type) {
        case 'schedule-follow-up':
            // Schedule a follow-up and (optionally) add a contact note
            Contact.scheduleFollowUp(values)
                .fail(function (response) {
                    if (response.responseJSON.follow_up_date) {
                        $(form).find('input#follow-up-date').addClass('invalid').val('Required');
                    }
                    progress.addClass('hidden');
                    actions.removeClass('hidden');
                    return;
                })
                .done(function (response) {
                    $(form).find('input#follow-up-date').removeClass('invalid');
                    if (response.error) {
                        console.error(response.error);
                        progress.addClass('hidden');
                        actions.removeClass('hidden');
                        return;
                    }
                    Note.getContactNotes(values.contact_id).done(function (view) {
                        contact_notes_container.html(view);
                        UI.initializeDatePicker();
                    });
                });
            break;
        case 'reschedule-follow-up':
            // Reschedule a follow-up and add a contact note
            Contact.rescheduleFollowUp(values)
                .fail(function (response) {
                    if (response.responseJSON.note) {
                        $(form).find('textarea#note').addClass('invalid');
                        $(form).find('textarea#note').attr('placeholder', 'Note is required.');
                    }
                    if (response.responseJSON.follow_up_date) {
                        $(form).find('input#follow-up-date').addClass('invalid').val('Required');
                    }
                    progress.addClass('hidden');
                    actions.removeClass('hidden');
                    return;
                })
                .done(function (response) {
                    $(form).find('input#follow-up-date').removeClass('invalid');
                    $(form).find('textarea#note').removeClass('invalid').attr('placeholder', "What's the latest?");
                    if (response.error) {
                        console.error(response.error);
                        progress.addClass('hidden');
                        actions.removeClass('hidden');
                        return;
                    }
                    Note.getContactNotes(values.contact_id).done(function (view) {
                        contact_notes_container.html(view);
                        UI.initializeDatePicker();
                    });
                });
            break;
        case 'close-follow-up':
            // Close a follow-up and add a contact note
            Contact.closeFollowUp(values)
                .fail(function (response) {
                    if (response.responseJSON.note) {
                        $(form).find('textarea#note').addClass('invalid');
                        $(form).find('textarea#note').attr('placeholder', 'Note is required.');
                    }
                    progress.addClass('hidden');
                    actions.removeClass('hidden');
                    return;
                })
                .done(function (response) {
                    $(form).find('textarea#note').removeClass('invalid').attr('placeholder', "What's the latest?");
                    if (response.error) {
                        console.error(response.error);
                        progress.addClass('hidden');
                        actions.removeClass('hidden');
                        return;
                    }
                    Note.getContactNotes(values.contact_id).done(function (view) {
                        contact_notes_container.html(view);
                        UI.initializeDatePicker();
                    });
                });
            break;
        default:
            // Just a contact note
            Note.postContactNote(values)
                .fail(function (response) {
                    if (response.responseJSON.note) {
                        $(form).find('textarea#note').addClass('invalid');
                        $(form).find('textarea#note').attr('placeholder', 'Note is required.');
                    }
                    progress.addClass('hidden');
                    actions.removeClass('hidden');
                    return;
                })
                .done(function (response) {
                    if (response.type != 'success') {
                        // TODO
                        progress.addClass('hidden');
                        actions.removeClass('hidden');
                        return;
                    }
                    Note.getContactNotes(values.contact_id).done(function (view) {
                        contact_notes_container.html(view);
                        UI.initializeDatePicker();
                    });
                });
        }

        return;
    }

    ContactRelationship.create = function (user_id, contact_id) {
        return $.ajax({
            'type': 'POST',
            'url': '/contact/add-relationship',
            'data': {
                'contact_id': contact_id,
                'user_id': user_id,
                '_token': $('form#create-contact-relationship input[name="_token"]').val()
            }
        });
    }

    ContactRelationship.remove = function (user_id, contact_id) {
        return $.ajax({
            'type': 'POST',
            'url': '/contact/remove-relationship',
            'data': {
                'contact_id': contact_id,
                'user_id': user_id,
                '_token': $('form#create-contact-relationship input[name="_token"]').val()
            }
        });
    }

    ContactRelationship.getOptions = function () {
        return $.ajax({
            'type': 'GET',
            'url': '/admin/admin-users',
            'data': {}
        });
    }

    ContactRelationship.createRelationship = function (user_name, contact_id, view) {
        var user_id = ContactRelationship.map[user_name];
        ContactRelationship.create(user_id, contact_id).done(function (data) {
            if (data.error == null) {
                var admin_user =
                    `<span class="flat-button gray small tag">
                        <button type="button" name="button" class="x" tag-name=${user_name}>&times;</button>${user_name}
                    </span>`;
                $(view).append(admin_user);
            }
        });
    }

    ContactRelationship.removeRelationship = function (user_id) {
        var contact_id = $('input#contact_id').val();
        ContactRelationship.remove(user_id, contact_id).done(function (data) {
            if (!data.error) {
                // Remove from view
                var button = $('button[admin-user-id="'+user_id+'"]');
                if (button) {
                    button.parent().remove();
                }
            }
        });
    }

    ContactRelationship.init = function () {
        var admin_user_autocomplete = $('input.admin-user-autocomplete');
        if (admin_user_autocomplete.length > 0) {
            ContactRelationship.getOptions().done(function (data) {
                var users = {}
                var contact_id = $('input#contact_id').val();
                data.users.forEach(function (u) {
                    var full_name = u.first_name+ " " + u.last_name;
                    ContactRelationship.map[full_name] = u.id;
                    users[full_name] = "";
                });
                var x = admin_user_autocomplete.autocomplete({
                    data: users,
                    limit: 10,
                    onAutocomplete: function (val) {
                        ContactRelationship.createRelationship(val, contact_id, $('.contact-user-relationships'));
                        admin_user_autocomplete.val("");
                    },
                    minLength: 2,
                });
            });
        }
    }

    Note.init = function () {
        $('.contact-notes-modal').modal({
            dismissible: true,  // Modal can be dismissed by clicking outside of the modal
            opacity: .5,        // Opacity of modal background
            inDuration: 300,    // Transition in duration
            outDuration: 200,   // Transition out duration
            startingTop: '4%',  // Starting top style attribute
            endingTop: '10%',   // Ending top style attribute
        });
    };

    Note.getContactNotes = function (contact_id) {
        return $.ajax({
            type: 'GET',
            url: '/contact/'+contact_id+'/show-note-control'
        });
    }

    Note.deleteNote = function (data) {
        return $.ajax({
            type: 'POST',
            url: '/note/'+data.note_id+'/delete',
            data: data
        });
    }

    Note.postContactNote = function (data) {
        return $.ajax({
            type: 'POST',
            url: '/contact/'+data.contact_id+'/create-note',
            data: data
        });
    }

    Note.getInquiryNotes = function (inquiry_id) {
        return $.ajax({
            type: 'GET',
            url: '/inquiry/'+inquiry_id+'/show-notes'
        });
    }

    Note.postInquiryNote = function (data) {
        return $.ajax({
            type: 'POST',
            url: '/inquiry/'+data.inquiry_id+'/create-note',
            data: data
        });
    }

    Note.postFollowUpNote = function (data) {
        return $.ajax({
            type: 'POST',
            url: '/contact/'+data.contact_id+'/complete-follow-up',
            data: data
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

    UI.initializeDatePicker = function() {
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: 100,
            close: 'Ok',
            closeOnSelect: true,
            container: 'body'
        });
    };

    UI.addMessage = function (response) {
        var template = $('.message-template.hidden').clone();
        if (!template) {
            console.warning("Missing message template");
            console.log(response);
            return;
        }
        $(template).find('.message-text').html(response.message);
        switch (response.type) {
            case 'success':
                $(template).find('.alert').addClass('green lighten-4 green-text text-darken-4');
                $(template).find('.material-icons').html('check_circle');
                break;
            case 'warning':
                $(template).find('.alert').addClass('alert card-panel yellow lighten-4 yellow-text text-darken-4');
                $(template).find('.material-icons').html('warning');
                break;
            case 'danger':
                $(template).find('.alert').addClass('alert card-panel red lighten-4 red-text text-darken-4');
                $(template).find('.material-icons').html('error');
                break;
            default:
                break;
        }
        $(template).removeClass('hidden');
        $('main div.container').first().prepend(template);
    }

    UI.displayMessage = function (response) {
        var message = $('.message');
        if (message.length == 0) {
            message = $('.message-template.hidden').clone();
            message.removeClass('message-template').addClass('message');
            if (message.length == 0) {
                console.warning("Missing message template");
                console.log(response);
                return;
            }
            $('main div.container').first().prepend(message);
        }

        $(message).find('.message-text').html(response.message);
        switch (response.type) {
            case 'success':
                $(message).find('.alert').addClass('green lighten-4 green-text text-darken-4');
                $(message).find('.material-icons').html('check_circle');
                break;
            case 'warning':
                $(message).find('.alert').addClass('alert card-panel yellow lighten-4 yellow-text text-darken-4');
                $(message).find('.material-icons').html('warning');
                break;
            case 'danger':
                $(message).find('.alert').addClass('alert card-panel red lighten-4 red-text text-darken-4');
                $(message).find('.material-icons').html('error');
                break;
            default:
                break;
        }

        if ($(message).hasClass('hidden')) {
            $(message).removeClass('hidden');
        }
    }

    UI.removeMessage = function () {
        var message = $('.message');
        if (message.length == 0) {
            return;
        }
        $(message).remove();
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
                if (name == null) {
                    var user_id = $(this).attr('admin-user-id');
                    ContactRelationship.removeRelationship(user_id);
                } else {
                    Tag.removeFromPost(name, $('input#post-tags-json'), $('.post-tags'));
                }
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

    Form.acceptValue = function(id, value) {
        var target = $('#'+id);
        if (target.length == 0) {
            return;
        }

        target.val(value);
        return target;
    }

    $('body').on(
        {
            click: function (e, ui) {
                var id = $(this).attr('target-id');
                var value = $(this).attr('target-value');
                if (!id) {
                    console.error("No target ID given.");
                    return;
                }
                Form.acceptValue(id, value);
            }
        },
        '.accept-change-button'
    );

    $('body').on(
        {
            click: function (e, ui) {
                $('.accept-change-button').click();
            }
        },
        '.accept-all-changes-button'
    );

    // Hover effect on archive page
    $('body').on(
        {
            mouseover: function (e, ui) {
                var overlay = $(this).parents('.session-image').first().children('.overlay');
                $(overlay).addClass('active');
            },
            mouseout: function (e, ui) {
                var overlay = $(this).parents('.session-image').first().children('.overlay');
                $(overlay).removeClass('active');
            }
        },
        '.materialboxed'
    );

    // Notes

    // Open the contact notes on contact page collapse drawer
    $('body').on(
        {
            click: function (e, ui) {
                var progress = $('#note-progress');
                var contact_id = parseInt($(this).attr('contact-id'));

                progress.removeClass('hidden');
                Note.getContactNotes(contact_id).done(function (view) {
                    $('#contact-note-collapsible-body').html(view);
                    UI.initializeDatePicker();
                });
            }
        },
        '#contact-note-collapsible-header'
    );

    // Open the contact notes modal
    $('body').on(
        {
            click: function (e, ui) {
                var contact_id = parseInt($(this).attr('contact-id'));
                Note.getContactNotes(contact_id).done(function (view) {
                    $('.contact-notes-modal').html(view);
                    UI.initializeDatePicker();
                    $('.contact-notes-modal').modal('open');
                });
            }
        },
        '.view-contact-notes-btn'
    );

    // Submit contact note
    $('body').on(
        {
            click: function (e, ui) {
                var form = $(this).parents('form#create-contact-note');
                if (form.length == 0) {
                    return;
                }
                Contact.handleSubmitNote(form);
            }
        },
        'button#submit-contact-note'
    );

    // Submit schedule-follow-up
    $('body').on(
        {
            click: function (e, ui) {
                var form = $(this).parents('form#create-contact-note');
                if (form.length == 0) {
                    return;
                }
                Contact.handleSubmitNote(form, 'schedule-follow-up');
            }
        },
        'button#schedule-follow-up'
    );

    // Submit reschedule-follow-up
    $('body').on(
        {
            click: function (e, ui) {
                var form = $(this).parents('form#create-contact-note');
                if (form.length == 0) {
                    return;
                }
                Contact.handleSubmitNote(form, 'reschedule-follow-up');
            }
        },
        'button#reschedule-follow-up'
    );

    // Submit close-follow-up
    $('body').on(
        {
            click: function (e, ui) {
                var form = $(this).parents('form#create-contact-note');
                if (form.length == 0) {
                    return;
                }
                Contact.handleSubmitNote(form, 'close-follow-up');
            }
        },
        'button#close-follow-up'
    );

    $('body').on(
        {
            click: function (e, ui) {
                if (!window.confirm("Delete this note?")) {
                    return;
                }

                var note = $(this).parents('div.note')[0];
                var contact_id = parseInt($(this).attr('contact-id'));
                var note_id = parseInt($(this).attr('note-id'));
                if (!note_id || note_id === 0) {
                    return console.error("Missing note ID");
                }

                var csrf = $(this).parents('div#note-'+note_id).find('input[name="_token"]').val();
                var data = {
                    note_id: note_id,
                    _token: csrf
                }

                $(note).hide();
                Note.deleteNote(data).done(function (response) {
                    if (response.error != null) {
                        console.error('Failed to delete note '+note_id);
                        $(note).show();
                        return;
                    }
                    Note.getContactNotes(contact_id).done(function (view) {
                        $('.contact-notes-modal').html(view);
                        UI.initializeDatePicker();
                    });
                });
            }
        },
        '.delete-note-btn'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var inquiry_id = parseInt($(this).attr('inquiry-id'));
                Note.getInquiryNotes(inquiry_id).done(function (view) {
                    $('.inquiry-notes-modal .modal-content').html(view);
                    $('.inquiry-notes-modal').modal('open');
                    $('form#create-inquiry-note input[name="inquiry_id"]').val(inquiry_id);
                });
            }
        },
        '.view-inquiry-notes-btn'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var form = $(this).parents('form#create-inquiry-note');
                if (form.length == 0) {
                    return;
                }

                var values = {};
                data = form.serializeArray();
                data.forEach(function (input) {
                    values[input.name] = input.value;
                });

                form.find('input, textarea, button').attr('disabled', 'disabled');
                Note.postInquiryNote(values).done(function (response) {
                    if (response.type != 'success') {
                        // TODO better messaging for failure
                        console.error('Failed to add note');
                        form.find('input, textarea, button').removeAttr('disabled');
                        return;
                    }
                    Note.getInquiryNotes(values.inquiry_id).done(function (view) {
                        form.find('textarea#note').val("");
                        form.find('input, textarea, button').removeAttr('disabled');
                        $('.inquiry-notes-modal .modal-content').html(view);
                        $('.inquiry-notes-modal').modal('open');
                    });
                });
            }
        },
        '.submit-inquiry-note-btn'
    );

    // end Notes

    // Contact
    $('body').on(
        {
            click: function () {
                var form = $('form#admin-contact-search');
                if (form.length == 0) {
                    return;
                }
                location.href = '/admin/contact/download?' + form.serialize();
            }
        },
        '#download-search-contacts'
    );
    // end Contact

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

                if (element.hasClass('hide-on-small-only')) {
                    element.removeClass('hide-on-small-only');
                    button.find('span.show-options').addClass('hidden');
                    button.find('span.hide-options').removeClass('hidden');
                } else {
                    element.addClass('hide-on-small-only');
                    button.find('span.hide-options').addClass('hidden');
                    button.find('span.show-options').removeClass('hidden');
                }
            }
        },
        'button.show-hide'
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

                if (element.hasClass('hide-on-small-only')) {
                    element.removeClass('hide-on-small-only');
                    button.find('span.show-options').addClass('hidden');
                    button.find('span.hide-options').removeClass('hidden');
                } else {
                    element.addClass('hide-on-small-only');
                    button.find('span.hide-options').addClass('hidden');
                    button.find('span.show-options').removeClass('hidden');
                }
            }
        },
        'button.show-hide-sm'
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

    // Image Order Change
    $('body').on(
        {
            sortupdate: function() {
                var action = $('#session-edit-dropzone').attr('action');
                if (action === undefined) {
                    // We're in a create context, so no need to async reorder
                    return;
                }
                var url = action+'-order';
                $.ajax({
                    type: "POST",
                    url: url,
                    data: { image_order: $(this).sortable('toArray'), _token: $('input[name="_token"]').val() }
                })
                .done(function(response) {
                    SBS.UI.displayMessage(response);
                })
                .fail(function() {
                })
                .always(function() {
                });
            }
        },
        '#dropzone-previews .dz-preview-flex-container'
    );

    // Session Image Remove 
    $('body').on(
        {
            click: function() {
                var post_id = $('#session-edit-dropzone').attr('data-post-id'),
                    image_id = $(this).attr('data-image-id')
                    element = $(this);

                $.ajax({
                    type: "GET",
                    url: "/session/" + post_id + "/delete-image/" + image_id
                })
                .done(function(response) {
                    SBS.UI.displayMessage(response);

                    if (response.type == "success") {
                        $(element).parent().remove();
                    }
                })
                .fail(function() {
                })
                .always(function() {
                });
            }
        },
        '#dropzone-previews .dz-preview-flex-container .image-remove-link'
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

                var modal_id = $(this).attr('modal-id');
                var pdf_src = $(this).attr('pdf-src');
                if (!modal_id || !pdf_src) {
                    return;
                }

                if (pdf_src.substr(-4) !== ".pdf") {
                    console.warn("File to preview is not a PDF");
                    location.href = pdf_src;
                    return;
                }

                var modal = $(modal_id);
                var frame = modal.find('iframe.pdf-frame');
                if (!modal || !frame) {
                    return;
                }

                frame.attr('src', pdf_src);
                modal.modal('open');
            }
        },
        '.pdf-modal-trigger'
    );

    $(window).on("beforeunload", function (e, ui) {
        if (Form.unsaved) {
            return "You have unsaved changes. Do you still want to leave?";
        }
    });

    SBS.UI = {};
    SBS.UI.displayMessage = UI.displayMessage;
    SBS.UI.addMessage = UI.addMessage;
    SBS.UI.removeMessage = UI.removeMessage;

    SBS.init = function () {
        Blog.init();
        Instagram.init();
        Note.init();
        Video.init();
        Tag.init();
        ContactRelationship.init();
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
        closeOnSelect: true,
        container: 'body'
    });

    //Daterange Picker
    // Initialize date range picker
    (function() {
        if ($('input#date-range.drp').length > 0) {
            var start, end;
            if ($('input#date-range-start').val()) {
                start = moment($('input#date-range-start').val(), "YYYY-MM-DD");
            } else {
                start = moment().subtract(3, "month");
            }
            if ($('input#date-range-end').val()) {
                end = moment($('input#date-range-end').val(), "YYYY-MM-DD");
            } else {
                end = moment();
            }
            $('input#date-range').daterangepicker({
                "startDate": start.format('MM-DD-YYYY'),
                "endDate": end.format('MM-DD-YYYY'),
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });
            $('input#date-range-start').val(start.format('YYYY-MM-DD'));
            $('input#date-range-end').val(end.format('YYYY-MM-DD'));
        }
    })();

    $('body').on(
        {
            change: function() {
                var start, end;
                start = $('input#date-range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                end = $('input#date-range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                $('input#date-range-start').val(start);
                $('input#date-range-end').val(end);
                var form = $(this).parents('form');
                if (form.length == 0) {
                    return;
                }
                form.submit();
            }
        },
        'input#date-range.drp'
    );

    // Dropzone
    // Create dropzone
    Dropzone.options.sessionCreateDropzone = {
        acceptedFiles: "image/jpeg, image/jpg",
        uploadMultiple: true,
        parallelUploads: 20,
        paramName: "image_list",
        autoProcessQueue: false,
        addRemoveLinks: true,
        thumbnailWidth: 180,
        thumbnailHeight: 180,
        previewsContainer: '#dropzone-previews div',
        clickable: ".dropzone-clickable",
        dictDefaultMessage: "",
        init: function() {
            var thedrop = this, i, files_copy, order, index, count;
            // First change the button to actually tell Dropzone to process the queue.
            this.element.querySelector("input[type=submit]").addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();

                SBS.UI.removeMessage();

                var file;

                // Provide warning if no images have been uploaded
                if (thedrop.files.length == 0) {
                    console.warning('You must upload images to submit a product.');
                }

                //Update the order before processing the queue.
                files_copy = thedrop.files.slice(0, thedrop.files.length);
                // return;
                order = $('#dropzone-previews .dz-preview-flex-container').sortable('toArray');
                for (i = 0; i < files_copy.length; i += 1) {
                    file = files_copy[(order[i]-1)];
                    if (file.type != 'image/jpeg') {
                        console.warning('Images must be JPEGs.');
                        return;
                    }
                    thedrop.files[i] = file;
                }

                thedrop.processQueue();
            });
            this.on("addedfile", function(file) {
                $(file.previewElement).attr('id', this.files.length);
                $("#dropzone-previews .dz-preview-flex-container").sortable({
                    items:'.dz-preview',
                    cursor: 'move',
                    opacity: 0.5,
                    containment: '#dropzone-previews .dz-preview-flex-container',
                    distance: 20,
                    tolerance: 'pointer'
                });
            });
            this.on("sendingmultiple", function() {
                $('form input[type="submit"]').hide();
                $('.dz-image').hide();
                $('.dz-remove').hide();
                $('.dz-preview').append($('.progress-gif').clone().removeClass('hidden'));
            });
            this.on("successmultiple", function(files, response) {
                $('.dz-preview .progress-gif').remove();
                $('.dz-image').show();

                if (response.code == 500) {
                    SBS.UI.displayMessage(response);
                    return false;
                }

                window.location = response.url;
            });
            this.on("errormultiple", function(files, response) {
                var resp = {
                    message: "Failed to upload session. Please check images and fields and try again.",
                    type: "warning"
                }

                if (response.title) {
                    resp.message = "Failed to upload session: " + response.title[0];
                }

                SBS.UI.displayMessage(resp);

                thedrop.files.forEach(function (file, i) {
                    if (file.status == 'error') {
                        thedrop.files[i].status = 'queued';
                    }
                });

                // Restore the images and submit button
                $('.dz-image').show();
                $('.dz-remove').show();
                $('.dz-preview .progress-gif').remove();
                $('form input[type="submit"]').show();
            });
        }
    };

    // Edit dropzone
    Dropzone.options.sessionEditDropzone = {
        acceptedFiles: "image/jpeg, image/jpg",
        uploadMultiple: true,
        parallelUploads: 20,
        paramName: "image_list",
        autoProcessQueue: true,
        addRemoveLinks: true,
        thumbnailWidth: 210,
        thumbnailHeight: 210,
        previewsContainer: '#dropzone-previews .dz-preview-flex-container',
        clickable: ".dropzone-clickable",
        dictDefaultMessage: "",
        init: function() {
            var thedrop = this, i, files_copy, order, index, count;
            this.on("addedfile", function(file) {
                $(file.previewElement).attr('id', this.files.length);
                $("#dropzone-previews .dz-preview-flex-container").sortable({
                    items:'.dz-preview',
                    cursor: 'move',
                    opacity: 0.5,
                    containment: '#dropzone-previews .dz-preview-flex-container',
                    distance: 20,
                    tolerance: 'pointer'
                });
            });
            this.on("sendingmultiple", function() {
                $('form input[type="submit"]').hide();
            });
            this.on("successmultiple", function(files, response) {
                $('.dz-preview .progress-gif').remove();
                $('.dz-image').show();

                if (response.code == 500) {
                    SBS.UI.displayMessage(response);
                    return false;
                }
            });
            this.on("errormultiple", function(files, response) {
                if (response.message) {
                    SBS.UI.displayMessage(response);
                } else {
                    SBS.UI.displayMessage({
                        message: 'File not uploaded. Something has gone wrong.',
                        type: 'danger'
                    });
                }
            });
        }
    };

    // Image Sortable
    if ($('#dropzone-previews .dz-preview-flex-container') && $('.dz-preview').length > 0) {
        $("#dropzone-previews .dz-preview-flex-container").sortable({
            items:'.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '#dropzone-previews .dz-preview-flex-container',
            distance: 20,
            tolerance: 'pointer'
        });
    }

    // Initialize
    SBS.init();
});
