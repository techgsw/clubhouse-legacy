(function() {
    var stripe, elements, style, card;

    stripe = Stripe('pk_test_s7EussOnEB5d3pO2DYORDuSg');
    elements = stripe.elements();

    var style = {
        base: {
            fontSize: '18px',
            color: "#32325d",
        }
    };
    card = elements.create('card', {style: style});
    card.mount('#cc-number-wrapper');

    // Event handlers
    $('body').on(
        {
            click: function() {
                $(this).html('Cancel');
                $(this).addClass('blue-grey darken-1');
                $('#checkout-submit-button').addClass('hidden');
                if ($('.cc-form.scale-transition').hasClass('hidden')) {
                    $('.cc-form.scale-transition').removeClass('hidden');
                }
                setTimeout(function() {
                    if ($('.cc-form.scale-transition').hasClass('scale-out')) {
                        $('.cc-form.scale-transition').removeClass('scale-out');
                    } else {
                        $('.cc-form.scale-transition').addClass('scale-out');
                        $('#add-cc-button').removeClass('hidden');
                        $('#add-cc-button').removeClass('blue-grey darken-1');
                        $('#add-cc-button').html('Add Card');
                        $('#checkout-submit-button').removeClass('hidden');
                        $('.cc-form.scale-transition').addClass('scale-out');
                        setTimeout(function() {
                            $('.cc-form.scale-transition').addClass('hidden');
                        }, 200);
                        }
                }, 100);
            }
        },
        '#add-cc-button'
    );

    $('body').on(
        {
            submit: function() {
                $('#add-cc-button').removeClass('hidden');
                $('#add-cc-button').html('Add Card');
                $('#checkout-submit-button').removeClass('hidden');
                $('.cc-form.scale-transition').addClass('scale-out');
                setTimeout(function() {
                    $('.cc-form.scale-transition').addClass('hidden');
                }, 200);
            }
        },
        'form#add-card'
    );
})();
