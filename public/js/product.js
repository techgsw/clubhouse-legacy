// product.js
var SBS;
if (!SBS) {
    SBS = {};
}
(function () {
    var Product = {};
    Product.Form = {};

    Product.Form.indexOptions = function () {
        var form = $('form#create-product');
        var options = form.find('div.product-option');

        options.each(function (i, option) {
            option = $(option);
            i++;
            console.log(i);
            // Index values
            option.attr('index', i);
            option.find('.product-option-index').html(i);
            // Name
            option.find('.option-name').attr('name', 'option['+i+'][name]');
            option.find('.option-name').attr('id', 'option-'+i+'-name');
            // Price
            option.find('.option-price').attr('name', 'option['+i+'][price]');
            option.find('.option-price').attr('id', 'option-'+i+'-price');
            // Clubhouse
            option.find('.option-clubhouse').attr('name', 'option['+i+'][clubhouse]');
            option.find('.option-clubhouse').attr('id', 'option-'+i+'-clubhouse');
            option.find('.clubhouse-label').attr('for', 'option-'+i+'-clubhouse');
            // User
            option.find('.option-user').attr('name', 'option['+i+'][user]');
            option.find('.option-user').attr('id', 'option-'+i+'-user');
            option.find('.user-label').attr('for', 'option-'+i+'-user');
            // Description
            option.find('.option-description').attr('name', 'option['+i+'][description]');
            option.find('.option-description').attr('id', 'option-'+i+'-description');
            option.find('.option-description-editor').attr('id', 'option-'+i+'-description-editor');
            option.find('.markdown-editor').attr('id', 'description-'+i+'-editor');
            option.find('.markdown-input').attr('editor-id', 'description-'+i+'-editor');
        });
    }

    Product.Form.addOption = function () {
        var form = $('form#create-product');
        var option = Product.Form.optionTemplate.clone();
        // Add markdown editor classes
        option.find('.option-description').addClass('markdown-input');
        option.find('.option-description-editor').addClass('markdown-editor');
        // Append to the list
        form.find('.options').append(option);
        // Index options
        Product.Form.indexOptions();
        // Initialize the markdown editor on the last option. This depends on
        // the prior successful indexing.
        SBS.createMarkdownEditor(option.find('.option-description'));
    }

    Product.Form.removeOption = function (i) {
        var form = $('form#create-product');
        form.find('.product-option[index='+i+']').remove();
        Product.Form.indexOptions();
    }

    Product.Form.optionTemplate = $('.product-option-template .product-option');

    // Add a product option
    $('body').on(
        {
            click: function (e, ui) {
                Product.Form.addOption();
            }
        },
        '.add-product-option'
    );

    // Remove a product option
    $('body').on(
        {
            click: function (e, ui) {
                var i = $(this).parents('.product-option').attr('index');
                if (i === undefined) {
                    return;
                }
                i = parseInt(i);
                Product.Form.removeOption(i);
            }
        },
        '.product-option-delete'
    );
})();

// On-ready events
$(document).ready(function () {

});
