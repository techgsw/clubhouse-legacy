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
    card.mount('#cc-number-wrapper');

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
        }).done(function (response) {
            var select = $('#payment-method'), option;

            if (response.type == "success") {
                if (response.payment_methods.length > 0) {
                    $('#payment-method option').remove();
                    response.payment_methods.forEach(function(method) {
                        option = document.createElement('option');
                        option.setAttribute('value', method.id);
                        $(option).text('XXX-XXX-XXX-' + method.last4);

                        select.append(option);
                    });
                }
                card.clear();
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
                if (window.confirm('Are you sure you want to cancel?')) {
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
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        //TODO call log service
                        console.log(result);
                    } else {
                        try {
                            $('#payment-method-wrapper').addClass('hidden');
                            $('#card-waiting').removeClass('hidden');
                            $('#add-cc-button').attr('disabled');
                            tokenHandler(result.token);
                        } catch (e) {
                            console.log(e);
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
});
