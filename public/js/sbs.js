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
    var Contact = {};
    var Form = {
        unsaved: false
    };
    var Instagram = {};
    var Job = {};
    var League = {};
    var Markdown = {};
    var Mentor = {};
    var Note = {};
    var Organization = {};
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

    Markdown.createEditor = function (input) {
        input = $(input);
        var editor = $("#"+input.attr('editor-id'));
        if (editor.length === 0) {
            editor = $(".markdown-editor");
        }
        if (editor.length === 0) {
            console.error("No markdown editor for input", input);
            return;
        }
        var placeholder = editor.attr('placeholder');
        if (placeholder === undefined) {
            placeholder = 'Write here';
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
                text: placeholder,
                hideOnClick: true
            },
            toolbar: {
                buttons: ['bold', 'italic', 'underline', 'anchor', 'h2', 'h3', 'quote'],
            }
        });
    }

    Markdown.init = function () {
        var inputs = $("textarea.markdown-input");
        if (inputs.length === 0) {
            return;
        }
        inputs.each(function (i, input) {
            Markdown.createEditor(input);
        });
    }
    SBS.initializeMarkdownEditors = function () {
        Markdown.init();
    }
    SBS.createMarkdownEditor = function (input) {
        Markdown.createEditor(input);
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
                admin_user_autocomplete.autocomplete({
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

    Note.getContactJobNotes = function (inquiry_id) {
        return $.ajax({
            type: 'GET',
            url: '/contact-job/'+inquiry_id+'/show-notes'
        });
    }

    Note.postContactJobNote = function (data) {
        return $.ajax({
            type: 'POST',
            url: '/contact-job/'+data.contact_job_id+'/create-note',
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

    // Job

    Job.getAssignContact= function (contact_id) {
        return $.ajax({
            type: 'GET',
            url: '/job/assign-contact',
            data: {
                'contact_id': contact_id
            }
        });
    }

    Job.assignContact = function (contact_id, job_id) {
        return $.ajax({
            type: 'POST',
            url: '/contact-job',
            data: {
                '_token': $('form#assign-contact-job input[name="_token"]').val(),
                'contact_id': contact_id,
                'job_id': job_id 
            }
        });
    }

    Job.unassignContact = function (contact_id, job_id) {
        return $.ajax({
            type: 'POST',
            url: '/contact-job/delete',
            data: {
                '_token': $('form#assign-contact-job input[name="_token"]').val(),
                'contact_id': contact_id,
                'job_id': job_id 
            }
        });
    }

    $('body').on(
        {
            change: function (e, ui) {
                var target_id = $(this).attr('show-hide-target-id');
                var target = $("#"+target_id);
                if (target.length === 0) {
                    return;
                }

                target.toggleClass('hidden');
            }
        },
        'input[type="checkbox"].show-hide'
    );

    League.create = function (name) {
        return $.ajax({
            'type': 'POST',
            'url': '/league',
            'data': {
                'name': name,
                '_token': $('form#create-league input[name="_token"]').val()
            }
        });
    }

    League.getOptions = function () {
        return $.ajax({
            'type': 'GET',
            'url': '/organization/leagues',
            'data': {}
        });
    }

    League.addToOrganization = function (name, input, view) {
        // Append to input
        var leagues = JSON.parse(input.val());
        leagues.push(name);
        $(input).val(JSON.stringify(leagues));
        // Append to view
        var league =
            `<span class="flat-button gray small league">
                <button type="button" name="button" class="x" league-name=${name}>&times;</button>${name}
            </span>`;
        $(view).append(league);
    }

    League.removeFromOrganization = function (name, input, view) {
        // Remove from input
        var leagues = JSON.parse(input.val());
        var i = leagues.indexOf(name);
        if (i > -1) {
            leagues.splice(i, 1);
        }
        input.val(JSON.stringify(leagues));
        // Remove from view
        var button = $('button[league-name="'+name+'"]');
        if (button) {
            button.parent().remove();
        }
    }

    League.init = function () {
        var league_autocomplete = $('input.league-autocomplete');
        if (league_autocomplete.length > 0) {
            League.getOptions().done(function (data) {
                League.map = {};
                var options = data.leagues.reduce(function (options, league, key) {
                    League.map[league.abbreviation] = league.id;
                    options[league.abbreviation] = null;
                    return options;
                }, {});
                var x = league_autocomplete.autocomplete({
                    data: options,
                    limit: 10,
                    onAutocomplete: function (val) {
                        // TODO Multi-select league tagging
                        // League.addToOrganization(val, $('input#organization-leagues-json'), $('.organization-leagues'));
                        // league_autocomplete.val("");
                    },
                    minLength: 2,
                });
            });
        }
    }

    $('body').on(
        {
            change: function (e, ui) {
                var league_type_id = null;
                $(this).find('option').each(function (i, o) {
                    if ($(o).html() == "League") {
                        league_type_id = $(o).val();
                    }
                });

                if ($(this).val() == league_type_id) {
                    $(".organization-type-default").hide();
                    $(".organization-type-league").show();
                } else {
                    $(".organization-type-league").hide();
                    $(".organization-type-default").show();
                }
            }
        },
        'select#organization_type_id'
    );

    Organization.init = function () {
        var organization_autocomplete = $('input.organization-autocomplete');
        if (organization_autocomplete.length > 0) {
            var target_input_id = organization_autocomplete.attr('target-input-id');
            var target_input = $('input#'+target_input_id);
            Organization.getOptions().done(function (data) {
                Organization.map = {};
                var options = data.organizations.reduce(function (options, org, key) {
                    Organization.map[org.name] = org.id;
                    options[org.name] = null;
                    return options;
                }, {});
                // Initialize autocompletes
                organization_autocomplete.autocomplete({
                    data: options,
                    limit: 10,
                    onAutocomplete: function (name) {
                        target_input.val(Organization.map[name]);
                        target_input.trigger('change');
                    },
                    minLength: 2,
                });
            });
            // Empty the target input if the field is emptied
            organization_autocomplete.on('change', function (e, ui) {
                if ($(this).val() === '') {
                    target_input.val('');
                }
            });
        }
    }

    Organization.getOptions = function () {
        return $.ajax({
            'type': 'GET',
            'url': '/organization/all',
            'data': {}
        });
    }

    Organization.getPreview = function (id, quality) {
        return $.ajax({
            'type': 'GET',
            'url': '/organization/'+id+'/preview?quality='+quality,
            'data': {}
        });
    }

    // TODO Move this
    $('body').on(
        {
            change: function (e, ui) {
                var org_id = parseInt($(this).val());
                $('img#organization-image').attr('src', '/images/progress.gif');
                $('div.organization-image-preview').removeClass('hidden');
                Organization.getPreview(org_id, 'medium')
                    .done(function (resp) {
                        $('img#organization-image').attr('src', resp.image_url);
                        $('form.organization-field-autocomplete select[name="league"]').val(resp.league);
                        $('form.organization-field-autocomplete select[name="league"]').trigger('change');
                        $('form.organization-field-autocomplete input[name="city"]').val(resp.address.city);
                        $('form.organization-field-autocomplete input[name="city"]').trigger('change');
                        $('form.organization-field-autocomplete select[name="state"]').val(resp.address.state);
                        $('form.organization-field-autocomplete select[name="state"]').trigger('change');
                        $('form.organization-field-autocomplete select[name="country"]').val(resp.address.country);
                        $('form.organization-field-autocomplete select[name="country"]').trigger('change');
                    })
                    .fail(function (resp) {
                        console.error(resp);
                    });
            }
        },
        'form.organization-field-autocomplete input#organization-id'
    );

    // Open contact job assigment modal
    $('body').on(
        {
            click: function (e, ui) {
                var contact_id = parseInt($(this).attr('contact-id')),
                    uri_patt = /(user|contact)\/\d+\/jobs$/i;

                Job.getAssignContact(contact_id).done(function (view) {
                    $('.contact-job-assignment-modal').html(view);

                    if (location.pathname.match(uri_patt)) {
                        $('.contact-job-assignment-modal').modal({
                            complete: function() { location.reload(); }
                          });
                    }

                    $('.contact-job-assignment-modal').modal('open');
                });
            }
        },
        '.view-contact-job-assignment-btn'
    );

    // Assign contact to job 
    $('body').on(
        {
            click: function (e, ui) {
                var button = $(this),
                    assigned_by = $(button).parent().find('.assigned-by .admin-name'),
                    assigned_at = $(button).parent().find('.assigned-at .assigned-date'),
                    contact_id = parseInt($(this).attr('contact-id')),
                    job_id = parseInt($(this).attr('job-id'));

                Job.assignContact(contact_id, job_id).done(function (resp) {
                    if (resp.type == 'success') {
                        $(button).removeClass('contact-job-assignment-btn');
                        $(button).removeClass('sbs-red');
                        $(button).addClass('contact-job-unassignment-btn');
                        $(button).addClass('blue');
                        $(button).addClass('lighten-1');
                        $(button).html('UNASSIGN JOB');

                        $(assigned_by).html(resp.values['admin_name']);
                        $(assigned_by).parent().removeClass('hidden');

                        $(assigned_at).html(resp.values['created_at']);
                        $(assigned_at).parent().removeClass('hidden');
                    }
                });
            }
        },
        '.contact-job-assignment-btn'
    );

    // Remove contact from job 
    $('body').on(
        {
            click: function (e, ui) {
                var button = $(this),
                    button_group_id = $(this).attr('data-button-group-id'),
                    contact_id = parseInt($(this).attr('contact-id')),
                    job_id = parseInt($(this).attr('job-id'));

                    if (button_group_id !== undefined) {
                        button = $('[data-button-group-id = "' + button_group_id + '"]');
                    }
                                        
                Job.unassignContact(contact_id, job_id).done(function (resp) {
                    if (resp.type == 'success') {
                        $.each(button, function (index, button) {
                            var assigned_by = $(button).parent().find('.assigned-by .admin-name'),
                                assigned_at = $(button).parent().find('.assigned-at .assigned-date');

                            $(button).removeClass('contact-job-unassignment-btn');
                            $(button).removeClass('blue');
                            $(button).removeClass('lighten-1');
                            $(button).addClass('contact-job-assignment-btn');
                            $(button).addClass('sbs-red');
                            $(button).html('ASSIGN TO JOB');
    
                            $(assigned_by).html('');
                            $(assigned_by).parent().addClass('hidden');
    
                            $(assigned_at).html('');
                            $(assigned_at).parent().addClass('hidden');
                        });
                    } 
                });
            }
        },
        '.contact-job-unassignment-btn'
    );

    // Tag

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

    Tag.addToEntity = function (name, json_input, view) {
        // Append to JSON input
        var tags = JSON.parse(json_input.val());
        tags.push(name);
        $(json_input).val(JSON.stringify(tags));
        // Append to view
        var tag =
            `<span class="flat-button gray small tag">
                <button type="button" name="button" class="x" tag-name=${name}>&times;</button>${name}
            </span>`;
        $(view).append(tag);
    }

    Tag.removeFromEntity = function (name, json_input, view) {
        // Remove from JSON input
        var tags = JSON.parse(json_input.val());
        var i = tags.indexOf(name);
        if (i > -1) {
            tags.splice(i, 1);
        }
        json_input.val(JSON.stringify(tags));
        // Remove from view
        var button = $('button[tag-name="'+name+'"]');
        if (button) {
            button.parent().remove();
        }
    }

    Tag.init = function () {
        var tag_autocomplete = $('input.tag-autocomplete');
        if (tag_autocomplete.length > 0) {
            tag_autocomplete.each(function (i, element) {
                var autocomplete = $(element);
                var json_input = $("#"+$(autocomplete).attr('target-input-id'));
                if (json_input.length === 0) {
                    console.warn("Missing JSON input element for tags");
                }

                var view_element = $("#"+$(autocomplete).attr('target-view-id'));
                if (view_element.length === 0) {
                    console.warn("Missing view element for tags");
                }

                Tag.getOptions().done(function (data) {
                    var tags = {}
                    data.forEach(function (t) {
                        Tag.map[t.name] = t.slug;
                        tags[t.name] = "";
                    });
                    var x = autocomplete.autocomplete({
                        data: tags,
                        limit: 10,
                        onAutocomplete: function (val) {
                            Tag.addToEntity(val, json_input, view_element);
                            autocomplete.val("");
                        },
                        minLength: 2,
                    });
                });
            });
        }
    }

    UI.initializeDatePicker = function() {
        $('.datepicker').pickadate({
            format: 'yyyy-mm-dd',
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
        'form.prevent-default'
    )

    $('body').on(
        {
            keydown: function (e, ui) {
                if (e.keyCode != 13) {
                    return;
                }

                var json_input = $("#"+$(this).attr('target-input-id'));
                if (json_input.length === 0) {
                    console.warn("Missing JSON input element for tags");
                }

                var view_element = $("#"+$(this).attr('target-view-id'));
                if (view_element.length === 0) {
                    console.warn("Missing view element for tags");
                }

                var input = $(this);
                var name = $(this).val();
                if (!name || name == "") {
                    return;
                }

                // Tag already exists in map. Add it and clear input.
                if (Tag.map[name] !== undefined) {
                    Tag.addToEntity(name, json_input, view_element);
                    tag_autocomplete.val("");
                    return;
                }
                // Create new tag, add it, and clear input.
                Tag.create(name).done(function (resp) {
                    var tag_name = resp.tag.name;
                    Tag.addToEntity(tag_name, json_input, view_element);
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
                var json_input = $("#"+$(this).attr('target-input-id'));
                var view_element = $(this).parent().parent();
                Tag.removeFromEntity(name, json_input, view_element);
            }
        },
        'span.tag button.remove-tag'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var name = $(this).attr('tag-name');
                if (name == null) {
                    var user_id = $(this).attr('admin-user-id');
                    ContactRelationship.removeRelationship(user_id);
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
    SBS.Inquiry.pipeline = function (id, action, token) {
        return $.ajax({
            method: "POST",
            url: "/admin/inquiry/pipeline-" + action,
            data: { id: id, _token: token }
        });
    }

    // Change inquiry pipline step 
    $('body').on(
        {
            click: function (e, ui) {
                var inquiry_id = parseInt($(this).attr('data-id')),
                    pipeline_id = parseInt($(this).attr('data-pipeline-id')),
                    action = $(this).attr('data-move'),
                    type = $(this).attr('data-type'),
                    selected_btn = $(this),
                    btn_set = $(this).parent().find('button[data-action="inquiry-pipeline"]'),
                    pipeline_label = $('#pipeline-label-' + inquiry_id),
                    token = $('[name="_token"]').val();


                if (pipeline_id == 1) {
                    result = window.confirm("Are you sure? \nThis action sends an email, and cannot be undone.");
                    if (!result) {
                        return;
                    }
                }

                if (!inquiry_id) {
                    console.error('Inquiry.rate: ID and rating are required');
                    return;
                }

                // Switch all buttons to gray to indicate a pending action
                btn_set.each(function (i, ui) {
                    $(ui).removeClass('blue');
                    $(ui).addClass('gray');
                });

                SBS.Inquiry.pipeline(inquiry_id, action, token).done(function (resp) {
                    btn_set.each(function (i, ui) {
                        $(ui).removeClass('inverse');
                        if ($(ui).attr('data-move') == 'backward') {
                            if (resp.pipeline_id > 2) {
                                $(ui).removeAttr('disabled');
                                $(ui).removeClass('gray');
                                $(ui).addClass('blue');
                            } else {
                                $(ui).attr('disabled', 'disabled');
                                $(ui).addClass('gray');
                                $(ui).removeClass('blue');
                            }
                        } else if ($(ui).attr('data-move') == 'forward') {
                            if (resp.pipeline_id == 6) {
                                $(ui).attr('disabled', 'disabled');
                            } else {
                                $(ui).removeClass('gray');
                                $(ui).addClass('blue');
                                $(ui).removeAttr('disabled');
                            }
                        } else {
                            $(ui).removeClass('gray');
                            $(ui).addClass('blue');
                            if (resp.status == 'halted' || resp.status == 'paused') {
                                $(selected_btn).addClass('inverse');
                            } else {
                                $(selected_btn).removeClass('inverse');
                            }
                            
                            if (resp.pipeline_id > 1 && $(ui).hasClass('cold-comm')) {
                                $(ui).find('span.thumbs-up-text').html('');
                            }
                            if (resp.pipeline_id > 1 && $(ui).hasClass('warm-comm')) {
                                $(ui).remove();
                            }
                        }
                    });

                    if (resp.type != 'success') {
                        SBS.UI.displayMessage(resp);
                        return;
                    }

                    if (resp.pipeline_name !== undefined) {
                        pipeline_label.html(resp.pipeline_name);
                    }
                    if (resp.pipeline_id !== undefined) {
                        $('[data-id="' + inquiry_id +'"]').attr('data-pipeline-id', resp.pipeline_id);
                    }
                });
            }
        },
        'button[data-action="inquiry-pipeline"][data-type="user"]'
    );

    SBS.ContactJob = {};
    SBS.ContactJob.pipeline = function (id, action, token) {
        return $.ajax({
            method: "POST",
            url: "/admin/contact-job/pipeline-" + action,
            data: { id: id, _token: token }
        });
    }

    // Change contact job step 
    $('body').on(
        {
            click: function (e, ui) {
                var inquiry_id = parseInt($(this).attr('data-id')),
                    pipeline_id = parseInt($(this).attr('data-pipeline-id')),
                    action = $(this).attr('data-move'),
                    type = $(this).attr('data-type'),
                    selected_btn = $(this),
                    btn_set = $(this).parent().find('button[data-action="inquiry-pipeline"]'),
                    pipeline_label = $('#pipeline-label-' + inquiry_id),
                    token = $('[name="_token"]').val();

                if (pipeline_id == 1) {
                    result = window.confirm("Are you sure? \nThis action sends an email, and cannot be undone.");
                    if (!result) {
                        return;
                    }
                }

                if (!inquiry_id) {
                    console.error('Inquiry.rate: ID and rating are required');
                    return;
                }

                // Switch all buttons to gray to indicate a pending action
                btn_set.each(function (i, ui) {
                    $(ui).removeClass('blue');
                    $(ui).addClass('gray');
                });

                SBS.ContactJob.pipeline(inquiry_id, action, token).done(function (resp) {
                    btn_set.each(function (i, ui) {
                        $(ui).removeClass('inverse');
                        if ($(ui).attr('data-move') == 'backward') {
                            if (resp.pipeline_id > 2) {
                                $(ui).removeAttr('disabled');
                                $(ui).removeClass('gray');
                                $(ui).addClass('blue');
                            } else {
                                $(ui).attr('disabled', 'disabled');
                                $(ui).addClass('gray');
                                $(ui).removeClass('blue');
                            }
                        } else if ($(ui).attr('data-move') == 'forward') {
                            if (resp.pipeline_id == 6) {
                                $(ui).attr('disabled', 'disabled');
                            } else {
                                $(ui).removeClass('gray');
                                $(ui).addClass('blue');
                                $(ui).removeAttr('disabled');
                            }
                        } else {
                            $(ui).removeClass('gray');
                            $(ui).addClass('blue');
                            if (resp.status == 'halted' || resp.status == 'paused') {
                                $(selected_btn).addClass('inverse');
                            } else {
                                $(selected_btn).removeClass('inverse');
                            }
                            
                            $(ui).removeClass('inverse');
                            if (resp.pipeline_id > 1 && $(ui).hasClass('cold-comm')) {
                                $(ui).find('span.thumbs-up-text').html('');
                            }
                            if (resp.pipeline_id > 1 && $(ui).hasClass('warm-comm')) {
                                $(ui).remove();
                            }
                        }
                    });

                    if (resp.type != 'success') {
                        SBS.UI.displayMessage(resp);
                        return;
                    }

                    if (resp.pipeline_name !== undefined) {
                        pipeline_label.html(resp.pipeline_name);
                    }
                    if (resp.pipeline_id !== undefined) {
                        $('[data-id="' + inquiry_id +'"]').attr('data-pipeline-id', resp.pipeline_id);
                    }
                });
            }
        },
        'button[data-action="inquiry-pipeline"][data-type="contact"]'
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
                var inquiry_id = parseInt($(this).attr('inquiry-id'));
                console.log(inquiry_id);
                Note.getContactJobNotes(inquiry_id).done(function (view) {
                    $('.contact-job-notes-modal .modal-content').html(view);
                    $('.contact-job-notes-modal').modal('open');
                    $('form#create-contact-job-note input[name="contact_job_id"]').val(inquiry_id);
                });
            }
        },
        '.view-contact-job-notes-btn'
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

    $('body').on(
        {
            click: function (e, ui) {
                var form = $(this).parents('form#create-contact-job-note');
                if (form.length == 0) {
                    return;
                }

                var values = {};
                data = form.serializeArray();
                data.forEach(function (input) {
                    values[input.name] = input.value;
                });

                form.find('input, textarea, button').attr('disabled', 'disabled');
                Note.postContactJobNote(values).done(function (response) {
                    if (response.type != 'success') {
                        // TODO better messaging for failure
                        console.error('Failed to add note');
                        form.find('input, textarea, button').removeAttr('disabled');
                        return;
                    }
                    Note.getContactJobNotes(values.contact_job_id).done(function (view) {
                        form.find('textarea#note').val("");
                        form.find('input, textarea, button').removeAttr('disabled');
                        $('.contact-job-notes-modal .modal-content').html(view);
                        $('.contact-job-notes-modal').modal('open');
                    });
                });
            }
        },
        '.submit-contact-job-note-btn'
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
                // TODO 113
            }
        },
        'input[type="checkbox"].show-hide'
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
        Markdown.init();
        Instagram.init();
        Note.init();
        League.init();
        Organization.init();
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

    $(window).resize(function() {
        // Move Registration Form
        var wrapper_top = $('#registration-form-wrapper-top'),
            wrapper_bottom = $('#registration-form-wrapper-bottom'),
            registration_form = $('#registration-form-wrapper');
        if ($(window).width() <= 585 && $(wrapper_bottom).html() == '') {
            $(registration_form).detach(); 
            $(wrapper_top).html('');
            $(wrapper_bottom).append(registration_form);
        }
        if ($(window).width() > 585 && $(wrapper_top).html() == '') {
            $(registration_form).detach(); 
            $(wrapper_bottom).html('');
            $(wrapper_top).append(registration_form);
        }
        // Change carousel heights
        // small
        if ($(window).width() <= 600) {
            $('.carousel.testimonial').css('height', '800px');
        }
        // medium
        if ($(window).width() > 600) {
            $('.carousel.testimonial').css('height', '500px');
        }
        // large
        if ($(window).width() > 992) {
            $('.carousel.testimonial').css('height', '500px');
        }
        // x-large
        if ($(window).width() > 1200) {
            $('.carousel.testimonial').css('height', '400px');
        }
    });
    $(window).resize();
})();

$(document).ready(function () {
    // Rotating words
    var rotate = function() {
        var rotating_words = ['learn', 'give back', 'connect', 'share', 'grow'];
        var rotating_word = $('#rotating-word');
        var index = rotating_words.indexOf($(rotating_word).html());
        if (index == rotating_words.length -1) {
            index = 0;
        } else {
            index += 1;
        }
        $(rotating_word).html(rotating_words[index]);
    }

    setInterval(rotate, 3000);

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
        try {
            carousel.carousel({
                fullWidth: true,
                indicators: true,
                duration: 300,
                onCycleTo : function(item, dragged) {
                    Carousel.stopAutoplay();
                    Carousel.startAutoplay(carousel);
                }
            });
        } catch (e) {
        }
    }
    // Side Nav
    $('.button-collapse-default').sideNav();
    $('.button-collapse-custom').sideNav();
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
        format: 'yyyy-mm-dd',
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
            this.on("removedfile", function(file) {
                $('.dz-preview').each(function(index, element) {
                    $(element).attr('id', (index + 1));
                });
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
        params: { count: $('.dz-image-preview').length },
        init: function() {
            var thedrop = this, i, files_copy, order, index, count;
            this.on("addedfile", function(file) {
                Dropzone.options.sessionEditDropzone.params.count += 1;
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
                $('.dz-complete').each(function(index, image) {
                    $(image).attr('id', response.values['images'][index].id);
                    $(image).find('.dz-remove').remove();
                });
            });
            this.on("errormultiple", function(files, response) {
                $(files).each(function(file) {
                    $(file.previewElement).remove();
                });
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
