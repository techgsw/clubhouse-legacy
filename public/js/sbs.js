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
    var Twitter = {};
    var Job = {};
    var League = {};
    var Markdown = {};
    var Mentor = {};
    var Note = {};
    var Organization = {};
    var Pipeline = {};
    var Tag = {
        map: {}
    };
    var Video = {};
    var ContactRelationship = {
        map: {}
    };
    var LinkAccounts = {};
    var UI = {};

    Pipeline.Inquiry = {};
    Pipeline.Assignment = {};
    UI.Pipeline = {};

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

    LinkAccounts.showLinkAccountSuggestions = function (user_id) {
        return $.ajax({
            'type': 'GET',
            'url': '/admin/user/show-link-account-suggestions',
            'data': {
                'user_id': user_id
            }
        });
    };

    $('body').on(
        {
            click: function (e, ui) {
                var user_id = $(this).attr('data-user-id');
                LinkAccounts.showLinkAccountSuggestions(user_id).done(function (data) {
                    $('.link-account-modal').modal('open');
                    $('.link-account-modal').find('#primary_user_id').val(user_id);
                    if (!data.suggested_emails.length) {
                        // place one empty account row
                        var account_row = $('.linked-account-template .linked-account').clone();
                        $('.link-account-modal').find('div.add-linked-account').before(account_row);
                    } else {
                        data.suggested_emails.forEach(function (email) {
                            var account_row = $('.linked-account-template .linked-account').clone();
                            account_row.find('input#email').val(email);
                            $('.link-account-modal').find('div.add-linked-account').before(account_row);
                        });
                    }
                    Materialize.updateTextFields();
                });
            }
        },
        'a#link-account'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var email = $(this).attr('data-user-email');
                return window.confirm('This will unlink ' + email + ' from this account. Are you sure?');
            }
        },
        'a#unlink-account'
    );

    // Add a linked account
    $('body').on(
        {
            click: function (e, ui) {
                var account_row = $('.linked-account-template .linked-account').clone();
                $('.link-account-modal').find('div.add-linked-account').before(account_row);
            }
        },
        'button.add-linked-account'
    );

    // Remove a linked account
    $('body').on(
        {
            click: function (e, ui) {
                $(this).parents('.linked-account').remove();
            }
        },
        'button.remove-linked-account'
    );

    // TODO: something is preventing default on this submit button. this is a temporary fix
    //  we should look into why this is happening
    $('body').on(
        {
            click: function (e, ui) {
                e.preventDefault();
                $('form#link-account-form').submit();
            }
        },
        'button#link-account-submit'
    );

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

    Job.getJobOptionUpgrades = function (job_id) {
        return $.ajax({
            type: 'GET',
            url: '/job-options/upgrade_options',
            data: {
                'job_id': job_id
            }
        });
    }

    Job.getJobOptionExtension = function (job_id) {
        return $.ajax({
            type: 'GET',
            url: '/job-options/extend_options',
            data: {
                'job_id': job_id
            }
        });
    }

    $('body').on(
        {
            click: function (e, ui) {
                var job_id = $(this).attr('data-job-id');
                Job.getJobOptionUpgrades(job_id).done(function (view) {
                    $('.job-options-modal .modal-content').html(view);
                    $('.job-options-modal').modal('open');
                });
            }
        },
        '.job-options-upgrade-btn'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var job_id = $(this).attr('data-job-id');
                Job.getJobOptionExtension(job_id).done(function (view) {
                    $('.job-options-modal .modal-content').html(view);
                    $('.job-options-modal').modal('open');
                });
            }
        },
        '.job-options-extend-btn'
    );

    $('body').on(
        {
            click:function (e) {
                $('div#job-apply-info').removeClass('hidden');
                $(this).addClass('hidden');
            }
        },
        'button#job-apply-button'
    );

    $('body').on(
        {
            click: function (e, ui) {
                $(this).attr('disabled', 'disabled');
                $(this).html('Sending, please wait...');
                e.preventDefault();
                $('#checkout-form').submit();
            }
        },
        '#checkout-submit-button'
    );

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

    $('body').on(
        {
            click: function (e, ui) {
                return window.confirm("This action will convert this job to an admin job posting. Admin job postings do not expire. You will become the new owner of this job posting and the original owner will no longer have access to this posting. \n\nAre you sure?");
            }
        },
        '.convert-to-admin-job-button'
    );

    $('body').on(
        {
            submit: function (e, ui) {
                let owner_email_field = $(this).find('input#owner_email');
                console.log(owner_email_field.attr('data-current-owner'));
                console.log(owner_email_field.val());
                if (owner_email_field.attr('data-current-owner') != 'admin' && owner_email_field.val() != owner_email_field.attr('data-current-owner')) {
                    if (!confirm('This will change the job owner to ' + owner_email_field.val() + ' and you will no longer have access to this job. Are you sure?')) {
                        e.preventDefault();
                    }
                }
            }
        },
        'form#edit-job'
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

                if (Object.keys(options).length == 1) {
                    $('form select#organization-id').trigger('change');
                }

                // Initialize autocompletes
                organization_autocomplete.autocomplete({
                    data: options,
                    limit: 10,
                    onAutocomplete: function (name) {
                        target_input.val(Organization.map[name]);
                        target_input.trigger('change')
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

    Organization.create = function (form) {
        return $.ajax({
            'type': 'POST',
            'url': '/organization/create',
            'data': form,
        })
    }

    $('body').on(
        {
            click: function (e, ui) {
                var organization_name = $('form.organization-create').find('#name').val()

                Organization.create($('form.organization-create').serialize())
                .done(function (response) {
                    if (!response.organization) {
                        UI.displayMessage({ type: 'danger', message: response.message });
                        return;
                    }

                    $('input#organization-id').attr('value', response.organization.id);
                    $('input#organization.organization-autocomplete').attr('value', response.organization.name);
                    $('input#organization.organization-autocomplete').val(response.organization.name);

                    /*
                    Organization.getPreview(response.id, 'medium')
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

                            UI.displayMessage({ type: 'success', message: "Successfully added you to the " + resp.name  + " organization" });
                        })
                        .fail(function (response) {
                            UI.displayMessage({ type: 'danger', message: "We were unable to create your organization." });
                        });
                    */
                })
                .fail(function (response) {
                    UI.displayMessage({ type: 'danger', message: reps.message });
                });

                $('.organization-create-modal').modal('close');
            }
        },
        'form.organization-create .submit-org-create'
    );

    $('body').on(
        {
            click: function (e, ui) {
                $('.organization-create-modal').modal('close');
            }
        },
        'form.organization-create .cancel-organization-form'
    );

    $('body').on(
        {
            change: function(e, ui) {
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
        'form select#organization-id'
    );

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
                        if (resp.address.city !== null) {
                            $('form.organization-field-autocomplete input[name="city"]').val(resp.address.city);
                        } else {
                            $('form.organization-field-autocomplete input[name="city"]').val('');
                        }
                        $('form.organization-field-autocomplete input[name="city"]').trigger('change');
                        if (resp.address.state !== null) {
                            $('form.organization-field-autocomplete select[name="state"]').val(resp.address.state);
                        } else {
                            $('form.organization-field-autocomplete select[name="state"]').val("Select one");
                            $('#state option[selected="selected"]').each(function(ele) { ele.removeAttr('selected')});
                            $($('#state option')[0]).attr('selected', 'selected');
                        }
                        $('form.organization-field-autocomplete select[name="state"]').trigger('change');

                         if (resp.address.state !== null) {
                            $('form.organization-field-autocomplete select[name="country"]').val(resp.address.country);
                            $('form.organization-field-autocomplete select[name="country"]').trigger('change');
                         }
                    })
                    .fail(function (resp) {
                        console.error(resp);
                    });
            }
        },
        'form.organization-field-autocomplete input#organization-id'
    );

    $('body').on(
        {
            click: function (e, ui) {
                $('.organization-create-modal').modal('open');
            }
        },
        '#organization-modal-open'
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
                    } else {
                        UI.addMessage({
                            'message': resp.message,
                            'type': 'danger'
                        });
                    }
                });
            }
        },
        '.contact-job-unassignment-btn'
    );

    //Delete Contact Confirmation
    $('body').on(
        {
            click: function (e, ui) {
                var email = $(this).attr('data-contact-email');
                var has_mentor = $(this).attr('data-contact-has-mentor') === "true";
                return window.confirm('This will delete the contact ' + email + ' and all associated information from the system completely. '
                + (has_mentor ? '\n\nCAUTION: This contact is tied to a mentor. The mentor will be deleted from the mentor page' : '') + '\n\nAre you sure?');
            }
        },
        'a#delete-contact'
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

    Tag.getPostOptions = function () {
        return $.ajax({
            'type': 'GET',
            'url': '/tag/posts',
            'data': {}
        });
    }

    Tag.getMentorOptions = function () {
        return $.ajax({
            'type': 'GET',
            'url': '/tag/mentors',
            'data': {}
        });
    }

    Tag.getJobOptions = function () {
        return $.ajax({
            'type': 'GET',
            'url': '/tag/jobs',
            'data': {}
        });
    }

    Tag.getTrainingVideoOptions = function () {
        return $.ajax({
            'type': 'GET',
            'url': '/sales-vault/training-videos/all-tags',
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
                <button type="button" name="button" class="x remove-tag" tag-name="${name}" target-input-id="${json_input.attr('id')}">&times;</button>${name}
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
        try {
            var button = $('button[tag-name="' + name + '"]');
        } catch (e) {
            var button = $("button[tag-name='" + name + "']");
        }
        if (button) {
            button.parent().remove();
        }
    }

    Tag.deleteFromType = function (name, type) {
        $.ajax({
            'type': 'GET',
            'url': '/tag/delete-from-type',
            'data' : {
                type: type,
                tag_name: name
            }
        })
        .done(function(response) {
            if (response.responseJSON && response.responseJSON.type != 'success') {
                UI.addMessage(response.responseJSON);
            } else {
                var button = $('button[tag-name="' + name + '"]');
                if (button) {
                    button.parent().remove();
                }
            }
        })
        .fail(function() {
            UI.addMessage({
                'message': 'Oops! Something went wrong. Please contact support.',
                'type': 'danger'
            });
        })
        .always(function() {
        });
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

                if (tag_autocomplete.hasClass('posts')) {
                    Tag.getPostOptions().done( function(data) {
                        Tag.populateAutocompleteOptions(data, autocomplete, json_input, view_element)
                    });
                } else if (tag_autocomplete.hasClass('training-videos')) {
                    Tag.getTrainingVideoOptions().done( function(data) {
                        Tag.populateAutocompleteOptions(data, autocomplete, json_input, view_element)
                    });
                } else if (tag_autocomplete.hasClass('mentors')) {
                    Tag.getMentorOptions().done( function(data) {
                        Tag.populateAutocompleteOptions(data, autocomplete, json_input, view_element)
                    });
                } else if (tag_autocomplete.hasClass('jobs')) {
                    Tag.getJobOptions().done( function(data) {
                        Tag.populateAutocompleteOptions(data, autocomplete, json_input, view_element)
                    });
                } else {
                    Tag.getOptions().done( function(data) {
                        Tag.populateAutocompleteOptions(data, autocomplete, json_input, view_element)
                    });
                }
            });
        }
    }

    Tag.populateAutocompleteOptions = function(data, autocomplete, json_input, view_element) {
        var tags = {}
        data.forEach(function (t) {
            Tag.map[t.name] = t.slug;
            tags[t.name] = "";
        });
        var x = autocomplete.autocomplete({
            data: tags,
            limit: 10,
            onAutocomplete: function (val) {
                if (view_element.is('#find-training-video-by-tag')) {
                    $('input#find-tag-name').val(Tag.map[val]);
                    view_element.submit();
                } else {
                    Tag.addToEntity(val, json_input, view_element);
                    autocomplete.val("");
                }
            },
            minLength: 2,
        });
    }

    UI.initializeDatePicker = function() {
        $('.datepicker').pickadate({
            format: 'yyyy-mm-dd',
            selectMonths: true,
            selectYears: 100,
            close: 'Ok',
            closeOnSelect: false,
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
                $(template).find('.alert').addClass('grey lighten-3');
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

    $('#password_send_reset').click(function(e) {
        e.preventDefault();
	    $.post('/password/email', {email: $(this).data('email'), '_token': window.Laravel.csrfToken}, function(data) {
    	    UI.addMessage({type: 'success', message: 'Password reset email sent!'});
        });
    });

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

                if ($(this).hasClass('no-submit')) {
                    e.preventDefault();
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
            click: function(e, ui){
                result = window.confirm("Are you sure? \nThis action modifies user roles.");
                if (!result) {
                    UI.displayMessage({type: 'warning', message: "You have unsaved changes."})
                    e.preventDefault();
                }
            }
        },
        '.submit-roles'
    );

    $('body').on(
        {
            click: function (e, ui) {
                var name = $(this).attr('tag-name');
                if ($(this).hasClass('job-discipline-edit')) {
                    if (window.confirm('This will remove the tag from any associated jobs and prevent admins from creating jobs with this tag. Are you sure?')) {
                        Tag.deleteFromType(name, 'job');
                    }
                } else {
                    var json_input = $("#"+$(this).attr('target-input-id'));
                    var view_element = $(this).parent().parent();
                    Tag.removeFromEntity(name, json_input, view_element);
                }
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

    Instagram.getFeed = function (is_same_here) {
        return $.ajax({
            type: "GET",
            url: "/social/instagram",
            data: { is_same_here: is_same_here},
        });
    }

    Instagram.init = function () {
        var ig = $('#instagram');
        var is_same_here = $('.same-here-instagram-feed').length > 0;
        if (ig.length > 0) {
            Instagram.getFeed(is_same_here).done(
                function (resp, status, xhr) {
                    if (xhr.status == 200) {
                        ig.find('.preloader-wrapper').remove();
                        ig.append(resp);
                    } else {
                        if (is_same_here) {
                            $('.same-here-instagram-feed').remove();
                        } else {
                            ig.find('.preloader-wrapper').remove();
                            ig.append("<a class=\"username\" href=\"https://instagram.com/sportsbizsol\"><span>@</span>sportsbizsol</a>");
                        }
                        console.error("Failed to load Instagram feed.");
                    }
                }
            ).fail(
                function () {
                    if (is_same_here) {
                        $('.same-here-instagram-feed').remove();
                    } else {
                        ig.find('.preloader-wrapper').remove();
                        ig.append("<a class=\"username\" href=\"https://instagram.com/sportsbizsol\"><span>@</span>sportsbizsol</a>");
                    }
                    console.error("Failed to load Instagram feed.");
                }
            );
        }
    }

    Twitter.getFeed = function (context) {
        return $.ajax({
            type: "GET",
            url: "/social/twitter",
            data: { context : context},
        });
    }

    Twitter.init = function () {
        var tw = $('#twitter');
        if (tw.length > 0) {
            let context = $('.sales-vault-twitter').length ? 'sales-vault' : 'same-here';
            Twitter.getFeed(context).done(
                function (resp, status, xhr) {
                    if (xhr.status == 200) {
                        tw.find('.preloader-wrapper').remove();
                        tw.append(resp);
                        twttr.widgets.load();
                    } else {
                        $('.twitter-hashtag-feed').remove();
                        console.error("Failed to load Twitter feed.");
                    }
                }
            ).fail(
                function () {
                    $('.twitter-hashtag-feed').remove();
                    console.error("Failed to load Twitter feed.");
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

    Pipeline.move = function (id, type, action, comm_type, reason, token) {
        var url = '/admin/' + (type == 'user' ? 'inquiry' : 'contact-job') + '/pipeline-';
        return $.ajax({
            method: "POST",
            url: url + action,
            data: { id: id, reason: reason, comm_type: comm_type, _token: token }
        });
    }

    // Open negative response modal
    $('body').on(
        {
            click: function (e, ui) {
                var inquiry_id = parseInt($(this).attr('data-id')),
                    pipeline_id = parseInt($(this).attr('data-pipeline-id')),
                    action = $(this).attr('data-move'),
                    type = $(this).attr('data-type'),
                    comm_type = $(this).attr('data-comm-type'),
                    modal_class = ($(this).hasClass('user-managed') ? '.user-managed-inquiry-negative-modal' : '.inquiry-contact-job-negative-modal'),
                    token = $('[name="_token"]').val();

                $(modal_class + ' button[data-action="inquiry-pipeline"]').attr('data-id', inquiry_id);
                $(modal_class + ' button[data-action="inquiry-pipeline"]').attr('data-pipeline-id', pipeline_id);
                $(modal_class + ' button[data-action="inquiry-pipeline"]').attr('data-move', action);
                $(modal_class + ' button[data-action="inquiry-pipeline"]').attr('data-type', type);
                $(modal_class + ' button[data-action="inquiry-pipeline"]').attr('data-comm-type', comm_type);
                $(modal_class + ' button[data-action="inquiry-pipeline"]').removeClass('inverse');

                $(modal_class).modal('open');
            }
        },
        'button.negative-pipeline-modal-button'
    );

    UI.Pipeline.clearNegativeReason = function(id, type) {
        $('.reason-note-button[data-id="' + id + '"][data-type="'+ type + '"]').addClass('hidden');
        $('.reason-note-button[data-id="' + id + '"][data-type="'+ type + '"] span.reason-text').html("");
    }

    UI.Pipeline.buttonClick = function(button) {
        var id = parseInt($(button).attr('data-id')),
            pipeline_id = parseInt($(button).attr('data-pipeline-id')),
            action = $(button).attr('data-move'),
            type = $(button).attr('data-type'),
            reason = $(button).attr('data-reason'),
            comm_type = $(button).attr('data-comm-type'),
            selected_btn = $(button),
            btn_set = $('button[data-id="' + id + '"][data-type="'+ type + '"]'),
            pipeline_label = $('#pipeline-label-' + id),
            token = $('[name="_token"]').val();

        if (!id) {
           return;
        }

        if (pipeline_id == 1 && comm_type !== 'none' && ((type == 'user') || (action == 'forward' && type == 'contact'))) {
            result = window.confirm("This action will notify the person via email of your opinion of them as a candidate. \n\nAre you sure?");
            if (!result) {
                return;
            }
        }

        btn_set.each(function (i, ui) {
            $(ui).removeClass('blue');
            $(ui).addClass('gray');
        });

        Pipeline.move(id, type, action, comm_type, reason, token).done(function (resp) {
            btn_set.each(function (i, ui) {
                $(ui).removeClass('inverse');

                if (['forward', 'backward', 'halt'].includes($(ui).attr('data-move'))) {
                    if ($(ui).children().hasClass('fa-envelope')) {
                        $(ui).children('i.fa-envelope').remove();
                        $(ui).html(function (i, html) {
                            return html.replace(/&nbsp;/g, '');
                        });
                    }

                    if (resp.pipeline_id != 1
                        && (($(ui).hasClass('cold-comm') || $(ui).hasClass('warm-comm'))
                        || (($(ui).hasClass('default-comm') || $(ui).hasClass('user-managed')) && !$(ui).hasClass('admin'))
                        )
                    ) {
                        $(ui).remove();
                    }
                }

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

                    UI.Pipeline.clearNegativeReason(id, type);
                } else if ($(ui).attr('data-move') == 'forward') {
                    if (type == 'contact' && resp.pipeline_id > 1) {
                        $(ui).find('span.thumbs-up-text').remove();
                    }

                    if (resp.pipeline_id == 2 && resp.status != 'halted') {
                        $('[data-id="' + id + '"].user-decision-positive').removeClass('hidden');
                    }

                    if (resp.pipeline_id == 6) {
                        $(ui).attr('disabled', 'disabled');
                        $(ui).addClass('gray')
                    } else {
                        $(ui).removeClass('gray');
                        $(ui).addClass('blue');
                        $(ui).removeAttr('disabled');
                    }

                    UI.Pipeline.clearNegativeReason(id, type);
                } else {
                    $(ui).removeClass('gray');
                    $(ui).addClass('blue');

                    if (resp.status == 'halted') {
                        $('.inquiry-contact-job-negative-modal').modal('close');
                        $('.user-managed-inquiry-negative-modal').modal('close');
                        $('button.negative-pipeline-modal-button[data-id="' + id + '"][data-move="halt"]').addClass('inverse');
                        $('.reason-note-button[data-id="' + id + '"][data-type="' + type + '"] span.reason-text').html(resp.reason);
                        $('.reason-note-button[data-id="' + id + '"][data-type="' + type + '"]').removeClass('hidden');
                    } else if (resp.status == 'paused') {
                        $(selected_btn).addClass('inverse');
                        $('.reason-note-button[data-id="' + id + '"][data-type="' + type + '"]').addClass('hidden');
                        $('.reason-note-button[data-id="' + id + '"][data-type="' + type + '"] span.reason-text').html("");
                    }
                }
            });

            if (resp.type != 'success') {
                SBS.UI.displayMessage(resp);
                return;
            } else {
                $('.inquiry-contact-job-negative-modal').modal('close');
                $('.user-managed-inquiry-negative-modal').modal('close');
            }

            if (resp.pipeline_name !== undefined) {
                pipeline_label.html(resp.pipeline_name);
                pipeline_label.removeClass("hidden");
            }

            if (resp.pipeline_id !== undefined) {
                $('[data-id="' + id +'"][data-type="' + type + '"]').attr('data-pipeline-id', resp.pipeline_id);
            }
        });
    }

    // Change pipline step
    $('body').on(
        {
            click: function () {
                UI.Pipeline.buttonClick(this);
            }
        },
        'button[data-action="inquiry-pipeline"]'
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
                } else if (id == 'email_preference_job') {
                    $('input[id^=email_preference_job_]').prop('checked', false);
                    $('input[name="profile_email_preference_job"]').each(function() {
                        job_preference_id = $(this).attr('target-value');
                        $('input#email_preference_job_' + job_preference_id).prop('checked', true);
                    });
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
                    $('#id="note-"' + note_id + '"').remove();
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


    // Blog editor
    $('body').on(
        {
            'change input': function () {
                var this_input = $(this);
                if (this_input.val().length) {
                    $('#formatted-blog-image-caption-' + this_input.attr('data-index')).html('[caption]' + this_input.val() + '[/caption]');
                } else {
                    $('#formatted-blog-image-caption-' + this_input.attr('data-index')).empty();
                }
            }
        },
        'input[id^=blog-image-caption]'
    )

    $('body').on(
        {
            change: function () {
                // we don't want the current file path, we might be uploading to S3
                // we can replace this on the server side once we have the right filepath
                $('#formatted-blog-image-url-' + $(this).attr('data-index')).html("(/)");
            }
        },
        'input[id^=blog-image-url-text]'
    )

    $('body').on(
        {
            click: function (e) {
                e.preventDefault();
                var new_index = $('.blog-images input[id^=blog-image-id]').length;
                var image = $('.blog-images-template').children().clone();

                // index the template
                image.find('.image-id').attr('id', 'blog-image-id-' + new_index);
                image.find('.image-id').attr('name', 'image[' + new_index + '][id]');
                image.find('.file-button').attr('name', 'image[' + new_index + '][url]');
                image.find('.file-path').attr('name', 'image[' + new_index + '][url_text]');
                image.find('.file-path').attr('id', 'blog-image-url-text-' + new_index);
                image.find('.file-path').attr('data-index', new_index);
                image.find('.blog-alt-input').attr('name', 'image[' + new_index + '][alt]');
                image.find('.blog-alt-input').attr('id', 'blog-image-alt-' + new_index);
                image.find('.blog-alt-input').attr('data-index', new_index);
                image.find('.blog-caption-input').attr('name', 'image[' + new_index + '][caption]');
                image.find('.blog-caption-input').attr('id', 'blog-image-caption-' + new_index);
                image.find('.blog-caption-input').attr('data-index', new_index);
                image.find('span[id^=formatted-blog-image-alt]').attr('id', 'formatted-blog-image-alt-' + new_index);
                image.find('span[id^=formatted-blog-image-alt]').html(new_index);
                image.find('span[id^=formatted-blog-image-caption]').attr('id', 'formatted-blog-image-caption-' + new_index);
                image.find('span[id^=formatted-blog-image-url]').attr('id', 'formatted-blog-image-url-' + new_index);

                $('.blog-images').append(image);
            }
        },
        '#add-blog-image'
    );

    $('#blog_delete').on('click', function (event) {
        event.preventDefault();
        var targetUrl = $(this).attr('href');

        if (confirm("Are you sure you want to delete this post? \n(Cannot be undone)")) {
            location.href = targetUrl;
        }
    });

    //end Blog editor


    // Registration Modal

    // highlight the correct membership option card on check
    $('input[type="checkbox"].membership-selection').each(function() {
        if ($(this).is(':checked')) {
            $(this).closest('div.card').css("background-color", "#F6F6F6");
        }
    });

    // swap the correct checkboxes when membership options are checked/unchecked
    $('body').on(
        {
            change: function(e) {
                if ($(this).is(':checked')) {
                    $('div.card').css("background-color", "#FFFFFF");
                    $(this).closest('div.card').css("background-color", "#F6F6F6");
                    $('input[type="checkbox"].membership-selection').prop('checked', false);
                    if ($(this).attr('id') === 'membership-selection-pro-monthly' || $(this).attr('id') === 'membership-selection-pro-annually') {
                        $('.pro-payment-type-warning').addClass('hidden');
                        $('input[type="checkbox"][id="membership-selection-pro"]').prop('checked', true);
                    } else {
                        //don't scroll into view for payment options, just the top two checkboxes
                        $('.input-field #first-name')[0].scrollIntoView({behavior: "smooth", block:'center', inline:'center'});
                    }
                    $(this).prop('checked', true);
                    $('.membership-type-warning').addClass('hidden');
                } else {
                    if ($(this).attr('id') === 'membership-selection-free') {
                        $(this).closest('div.card').css("background-color", "#FFFFFF");
                    } else if ($(this).attr('id') === 'membership-selection-pro') {
                        $(this).closest('div.card').css("background-color", "#FFFFFF");
                        $('input[type="checkbox"][id="membership-selection-pro-monthly"]').prop('checked', false);
                        $('input[type="checkbox"][id="membership-selection-pro-annually"]').prop('checked', false);
                    }
                }
            }
        },
        'input[type="checkbox"].membership-selection'
    );

    // make "years worked" radio buttons with checkboxes, remove warning on checked
    $('body').on(
        {
            change: function(e) {
                if ($(this).is(':checked')) {
                    $('input[type="checkbox"].years-worked').prop('checked', false);
                    $(this).prop('checked', true);
                    $('.years-worked-warning').addClass('hidden');
                }
            }
        },
        'input[type="checkbox"].years-worked'
    );

    // remove "planned services" warning on checked`
    $('body').on(
        {
            change: function(e) {
                if ($(this).is(':checked')) {
                    $('.planned-services-warning').addClass('hidden');
                }
            }
        },
        'input[type="checkbox"].planned-services'
    );

    // validate input for checkboxes
    $('body').on(
        {
            click: function(e) {
                if ($('input[type="checkbox"].membership-selection').length && !$('input[type="checkbox"].membership-selection').is(':checked')) {
                    $('.membership-type-warning').removeClass('hidden');
                    $('.membership-type-warning')[0].scrollIntoView({behavior: "smooth"});
                    e.preventDefault();
                } else if ($('input[type="checkbox"][id="membership-selection-pro"]').length && $('input[type="checkbox"][id="membership-selection-pro"]').is(':checked') &&
                    !$('input[type="checkbox"][id="membership-selection-pro-monthly"]').is(':checked') &&
                    !$('input[type="checkbox"][id="membership-selection-pro-annually"]').is(':checked')
                ) {
                    $('.pro-payment-type-warning').removeClass('hidden');
                    $('.pro-payment-type-warning')[0].scrollIntoView({behavior: "smooth"});
                    e.preventDefault();
                } else if ($('input[type="checkbox"].years-worked').length && !$('input[type="checkbox"].years-worked').is(':checked')) {
                    $('.years-worked-warning').removeClass('hidden');
                    $('.years-worked-warning')[0].scrollIntoView({behavior: "smooth", block:"center"});
                    e.preventDefault();
                } else if ($('input[type="checkbox"].planned-services').length && !$('input[type="checkbox"].planned-services').is(':checked')) {
                    $('.planned-services-warning').removeClass('hidden');
                    $('.planned-services-warning')[0].scrollIntoView({behavior: "smooth", block:"center"});
                    e.preventDefault();
                } else if (grecaptcha && !grecaptcha.getResponse()) {
                    // the grecaptcha field can be found in google's recaptcha api js file imported in the registration modal
                    $('.recaptcha-warning').removeClass('hidden')
                    e.preventDefault();
                }
            }
        },
        'form.registration-form button[type="submit"]'
    );

    //end Registration Modal

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

    // edit profile - "Opt out of new clubhouse content" emails should be based on the individual checkboxes
    $('body').on(
        {
            change: function (e, ui) {
                if (!$('input#email_preference_new_content_webinars').is(':checked')
                    && !$('input#email_preference_new_content_blogs').is(':checked')
                    && !$('input#email_preference_new_content_mentors').is(':checked')
                    && !$('input#email_preference_new_content_training_videos').is(':checked')
                   ) {
                    $('input#email_preference_new_content_all').prop('checked', true);
                } else {
                    $('input#email_preference_new_content_all').prop('checked', false);
                }
            }
        },
        'input#email_preference_new_content_webinars, input#email_preference_new_content_blogs, input#email_preference_new_content_mentors, input#email_preference_new_content_training_videos'
    );
    $('body').on(
        {
            change: function (e, ui) {
                if ($(this).is(':checked')) {
                    $('input#email_preference_new_content_webinars').prop('checked', false);
                    $('input#email_preference_new_content_blogs').prop('checked', false);
                    $('input#email_preference_new_content_mentors').prop('checked', false);
                    $('input#email_preference_new_content_training_videos').prop('checked', false);
                } else {
                    $('input#email_preference_new_content_webinars').prop('checked', true);
                    $('input#email_preference_new_content_blogs').prop('checked', true);
                    $('input#email_preference_new_content_mentors').prop('checked', true);
                    $('input#email_preference_new_content_training_videos').prop('checked', true);
                }
            }
        },
        'input#email_preference_new_content_all'
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
            click: function (e) {
                var input = $(this);

                if (!input.val() || input.val() === "") {
                    var year = parseInt(input.attr('default-year'));
                    var month = parseInt(input.attr('default-month'));
                    var day = parseInt(input.attr('default-day'));
                    if (year && month && day) {
                        input.pickadate('set', 'select', [year, month, day]);
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

    // Server-side filesize validation is also in place. This not only provides an error sooner but
    // mitigates an issue we were having with files larger than post_max_size throwing exceptions.
    $('body').on(
        {
            change: function (e, ui) {
                if (this.files[0].size/1024/1024 > 1.5) {
                    $(this).val('');
                    $('.filesize-error[for="' + $(this).attr('name') + '"]').removeClass('hidden');
                } else {
                    $('.filesize-error[for="' + $(this).attr('name') + '"]').addClass('hidden');
                }
            }
        },
        'input[name="resume_url"],input[name="headshot_url"]'
    )

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
                var input_id, value, input, form;

                input_id = $(this).attr('input-id');
                if (!input_id) {
                    return;
                }
                value = $(this).attr('value');
                if (!value) {
                    return;
                }

                if (value == 'all') {
                    $('#filter').val('');
                }

                input = $('#'+input_id);
                if (!input) {
                    return;
                }

                input.val(value);

                form = $(this).parents('form');
                form.submit();
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

    // Unsubscribe email functionality

    $('body').on(
        {
            change: function (e, ui) {
                let unsubscribe_all = $('input#email_unsubscribe_all');
                if (unsubscribe_all.length) {
                    if (['marketing', 'new_content', 'new_job'].filter(type =>
                        !$('input#email_preference_'+type+'_opt_out').is(':checked')
                    ).length) {
                        unsubscribe_all.prop('checked', false);
                    } else {
                        unsubscribe_all.prop('checked', true);
                    }
                }
            }
        },
        'input#email_preference_marketing_opt_out, input#email_preference_new_content_opt_out, input#email_preference_new_job_opt_out, input#email_preference_newsletter_opt_out'
    );
    $('body').on(
        {
            change: function (e, ui) {
                if ($(this).is(':checked')) {
                    ['marketing', 'new_content', 'new_job', 'newsletter'].forEach(function(type) {
                        $('input#email_preference_'+type+'_opt_out').prop('checked', true);
                    });
                } else {
                    ['marketing', 'new_content', 'new_job', 'newsletter'].forEach(function(type) {
                        let opt_out_input = $('input#email_preference_'+type+'_opt_out')
                        if (!opt_out_input.is(':disabled')) {
                            opt_out_input.prop('checked', false);
                        }
                    });
                }
            }
        },
        'input#email_unsubscribe_all'
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

    // Check/Uncheck all associated checkboxes
    var checkAll = $('[data-action="check-all"]');
    var autoChecks = $('[data-type="auto-check"]');
    checkAll.on('click', function(event) {
        var isChecked = event.target.checked;
        autoChecks.each(function () {
            $(this).prop('checked', isChecked);
        });
    });

    // If all are checked and one is then unchecked, uncheck the CHECK ALL box
    autoChecks.on('click', function (event) {
        var shouldCheck = event.target.checked;

        if (shouldCheck) {
            autoChecks.each(function () {
                shouldCheck = shouldCheck && event.target.checked;
            });
        }
        if (checkAll.prop('checked')) {
            checkAll.prop('checked', shouldCheck);
        }
    });


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
        Twitter.init();
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
            $('.carousel.testimonial').css('height', '1230px');
        }
        // medium
        if ($(window).width() > 600) {
            $('.carousel.testimonial').css('height', '850px');
        }
        // large
        if ($(window).width() > 992) {
            $('.carousel.testimonial').css('height', '720px');
        }
        // x-large
        if ($(window).width() > 1200) {
            $('.carousel.testimonial').css('height', '680px');
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
        }, 10000);
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
                }
            });
            Carousel.startAutoplay(carousel);
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
        closeOnSelect: false,
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

    // Any external links or links between SBS and theClubhouse should open in a new tab
    $("a[href^=http]").each(function() {
        if (!this.href.includes(window.location.origin)) {
            $(this).attr({
                target: "_blank",
                rel: "noopener"
            });
        }
    });

    // All links inside the blog post body should open in a new tab
    $(".blog-post-body a").each(function() {
        $(this).attr({
            target: "_blank",
            rel: "noopener"
        });
    });

    // Fix for Chrome 73 breaking Materialize calendars and dropdowns
    $('body').on(
        {
            mousedown: function() {
                event.preventDefault();
            }
        },
        '.datepicker'
    );
    $('body').on(
        {
            mousedown: function() {
                event.preventDefault();
            }
        },
        '.select-dropdown'
    );
    $('.select-wrapper select').on('change select', function(e){
        $(this).material_select();
    });

    if (/iPad|iPhone|iPod/.test(navigator.platform || "")) {
        $('a[href="#register-modal"]').each(function () {
            $(this).attr('href', '/register');
        });
        $('a[href="#register-pro-modal"]').each(function () {
            $(this).attr('href', '/register/pro');
        });
    }

    // Initialize
    SBS.init();
});
