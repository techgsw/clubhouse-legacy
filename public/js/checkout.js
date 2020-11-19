(function() {
    var stripe, elements, style, card, tokenHandler;

    stripe = Stripe(SBS.stripe_token);
    elements = stripe.elements();

    var style = {
        base: {
            fontSize: '18px',
            color: "#32325d",
        }
    };
    card = elements.create('card', {style: style});
    if ($('#cc-number-wrapper').length) {
        card.mount('#cc-number-wrapper');
    }

    tokenHandler = function(token) {
        var form = $('#add-card'), input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', 'stripe_token');
        input.setAttribute('value', token.id);

        form.append(input);

        $.ajax({
            type: 'POST',
            url: '/checkout/add-card',
            data: form.serialize()
        }).fail(function (response) {
            $('#add-card-error').removeClass('hidden');
        }).done(function (response) {
            var select = $('#payment-method'), option;

            if (response.type == "success") {
                if (response.payment_methods.length > 0) {
                    $('#payment-method option').remove();
                    response.payment_methods.forEach(function (method) {
                        option = document.createElement('option');
                        option.setAttribute('value', method.id);
                        $(option).text('XXX-XXX-XXX-' + method.last4);

                        select.append(option);
                    });
                }
                card.clear();
                //if we're adding a card from the user account page, reload to show card changes
                if ($('.cc-form.user-account-page').length) {
                    location.reload(true);
                }
            } else {
                $('#add-card-error').removeClass('hidden');
            }
        }).always(function () {
            $('#card-waiting').addClass('hidden');
            $('#payment-method').material_select();
            $('#payment-method-wrapper').removeClass('hidden');
            $('#add-cc-button').removeAttr('disabled');
        });
    }

    // Event handlers
    $('body').on(
        {
            click: function() {
                if (window.confirm('Are you sure you want to cancel at the end of the billing cycle?')) {
                    $(this).attr('disabled', true);
                    var csrf = $(this).parents('div').find('input[name="_token"]').val();
                    $.ajax({
                        type: 'POST',
                        url: '/checkout/cancel-subscription',
                        data: { 
                            subscription_id: $(this).data('subscription-id'),
                            _token: csrf
                        }
                    }).done(function (response) {
                        if (response.type == 'success') {
                            location.reload()
                        } else {
                            window.alert("Sorry, there was an error cancelling your subscription. Please try again.")
                        }
                        $(this).attr('disabled', false);
                    });
                }
            }
        },
        '#cancel-subscription-button'
    );

    $('body').on(
        {
            click: function() {
                $(this).attr('disabled', true);
                var csrf = $(this).parents('div').find('input[name="_token"]').val();
                $.ajax({
                    type: 'POST',
                    url: '/checkout/reactivate-subscription',
                    data: { 
                        subscription_id: $(this).data('subscription-id'),
                        _token: csrf
                    }
                }).done(function (response) {
                    if (response.type == 'success') {
                        location.reload()
                    } else {
                        window.alert("Sorry, there was an error reactivating your subscription. Please make sure your card settings are up to date or contact clubhouse@sportsbusiness.solutions for help.")
                    }
                    $(this).attr('disabled', false);
                });
            }
        },
        '#reactivate-subscription-button'
    );

    $('body').on(
        {
            click: function() {
                $('#checkout-submit-button').addClass('hidden');
                $('.cc-form.scale-transition').removeClass('hidden');
                setTimeout(function() {
                    $('.cc-form.scale-transition').removeClass('scale-out');
                }, 100);
            }
        },
        '#add-cc-button'
    );

    $('body').on(
        {
            click: function() {
                setTimeout(function() {
                        $('.cc-form.scale-transition').addClass('scale-out');
                        $('#checkout-submit-button').removeClass('hidden');
                        $('.cc-form.scale-transition').addClass('scale-out');
                        setTimeout(function() {
                            $('.cc-form.scale-transition').addClass('hidden');
                            $('#add-cc-button').removeClass('hidden');
                        }, 200);
                }, 100);
            }
        },
        '#cancel-cc-button'
    );

    $('body').on(
        {
            click: function() {
                $(this).attr('disabled', true);
                $(this).siblings('a').attr('disabled', true);
                var csrf = $(this).parents('div').find('input[name="_token"]').val();
                $.ajax({
                    type: 'POST',
                    url: '/checkout/make-card-primary',
                    data: { 
                        card_id: $(this).data('card-id'),
                        _token: csrf
                    }
                }).done(function (response) {
                    if (response.type == 'success') {
                        location.reload()
                    }
                }).always(function () {
                    $(this).attr('disabled', false);
                });
            }
        },
        'a.make-primary-button'
    );

    $('body').on(
        {
            click: function() {
                $(this).attr('disabled', true);
                $(this).siblings('a').attr('disabled', true);
                var csrf = $(this).parents('div').find('input[name="_token"]').val();
                $.ajax({
                    type: 'POST',
                    url: '/checkout/remove-card',
                    data: { 
                        card_id: $(this).data('card-id'),
                        _token: csrf
                    }
                }).done(function (response) {
                    if (response.type == 'success') {
                        location.reload()
                    }
                }).always(function () {
                    $(this).attr('disabled', false);
                });
            }
        },
        'a.remove-card-button'
    );

    $('body').on(
        {
            submit: function(e) {
                e.preventDefault();
                $('#add-card-error').addClass('hidden');
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        //TODO call log service
                        $('#add-card-error').removeClass('hidden');
                        console.log(result);
                    } else {
                        try {
                            $('#payment-method-wrapper').addClass('hidden');
                            $('#card-waiting').removeClass('hidden');
                            $('#add-cc-button').attr('disabled');
                            tokenHandler(result.token);
                        } catch (e) {
                            $('#add-card-error').removeClass('hidden');
                            console.log(e);
                            return;
                        }
                        $('#add-cc-button').removeClass('hidden');
                        $('#add-cc-button').html('Add Card');
                        $('#checkout-submit-button').removeClass('hidden');
                        $('.cc-form.scale-transition').addClass('scale-out');
                        setTimeout(function() {
                            $('.cc-form.scale-transition').addClass('hidden');
                        }, 200);
                    }
                });
            }
        },
        'form#add-card'
    );

    window.addEventListener('message', function(e) {
        if (e.data.event && e.data.event === 'calendly.event_scheduled') {
            var transaction_id = $('div#career-service-calendly-embed').attr('transaction-id');
            var url = "/career-services/"+transaction_id+"/schedule";
            return $.ajax({
                type: 'GET',
                url: url
            })
        }
    });

})();
$(document).ready(function () {
    var payment_method = $('#payment-method'),
        product_type = $('.product-card').attr('data-product-type');
    if (payment_method && $(payment_method).children()) {
        if ($(payment_method).children().length == 1) {
            if ($(payment_method).children()[0].value == '') {
                $('#add-cc-button').click();
            }
        }
    }

    var career_service_calendly_embed = $('div#career-service-calendly-embed');
    if (career_service_calendly_embed.length) {
        Calendly.initInlineWidget({
            url: career_service_calendly_embed.attr('calendly-link'),
            parentElement: career_service_calendly_embed.get(0),
            prefill: {
                name: career_service_calendly_embed.attr('user-name'),
                email: career_service_calendly_embed.attr('user-email'),
                customAnswers: {
                    a1: career_service_calendly_embed.attr('user-is-clubhouse'),
                    a2: career_service_calendly_embed.attr('product-name')
                }
            }
        });
    }
});
