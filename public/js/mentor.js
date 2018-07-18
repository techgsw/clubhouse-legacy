// mentor.js

// Attach to SBS global object to export
var SBS;
if (!SBS) {
    SBS = {};
}

// Internal logic
(function () {
    var Mentor = {};

    // Submit a request to meet
    Mentor.submitRequest = function (values) {
        var url = "/mentor/"+values.mentor_id+"/request";
        return $.ajax({
            type: 'POST',
            url: url,
            data: values
        })
    }

    // Inject mentor details into mentor request modal form
    $('body').on(
        {
            click: function (e, ui) {
                var mentor_name = $(this).attr('mentor-name');
                var mentor_id = $(this).attr('mentor-id');

                $('div#mentor-request-modal').find('span.mentor-name').html(mentor_name);
                $('div#mentor-request-modal').find('input#mentor_id').val(mentor_id);
                $('form#mentor-request').attr('action', "/mentor/"+mentor_id+"/request");
            }
        },
        'a.mentor-request-trigger'
    );

    // Submit form
    $('body').on(
        {
            submit: function (e, ui) {
                var form = $('form#mentor-request');
                var modal = $('div#mentor-request-modal');
                var messages = modal.find('#messages');
                var progress = $('div#mentor-progress');
                var submit = $('div#mentor-submit');
                var values = {};

                values = form.serializeArray().reduce(function (values, curr) {
                    values[curr.name] = curr.value;
                    return values;
                }, {});

                form.find('input, select').attr('disabled', 'disabled');
                submit.toggleClass('hidden');
                progress.toggleClass('hidden');
                messages.find('.success-message, .error-message').addClass('hidden');

                Mentor.submitRequest(values)
                    .fail(function (res) {
                        messages.find('.error-message').html("Failed to schedule meeting. Please try again later.").removeClass('hidden');
                        form.find('input, select').removeAttr('disabled');
                        submit.toggleClass('hidden');
                        progress.toggleClass('hidden');
                    })
                    .done(function (res) {
                        console.log(res);

                        if (res.error) {
                            messages.find('.error-message').html(res.error).removeClass('hidden');
                            form.find('input, select').removeAttr('disabled');
                            submit.toggleClass('hidden');
                            progress.toggleClass('hidden');
                            return;
                        }

                        messages.find('.success-message').html(res.success).removeClass('hidden');
                        form.find('input, select').removeAttr('disabled');
                        submit.toggleClass('hidden');
                        progress.toggleClass('hidden');
                    });
            }
        },
        'form#mentor-request'
    );
})();

// On-ready events
$(document).ready(function () {

});
