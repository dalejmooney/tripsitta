$(document).ready( function () {
    let currency_field = $('select[name="currency"]');

    toggleExtraFields(currency_field.val());

    $(currency_field).on('change', function(e){
        toggleExtraFields($(this).val());
    });
});

function toggleExtraFields(selected_currency)
{
    $('#per_currency_fields .per_currency_field_group')
        .addClass('is-hidden')
        .find('input, select').not('input[name="address2"]').attr('required', false).attr('disabled', 'disabled');

    if(selected_currency === '') return;

    if($.inArray(selected_currency, ['usd', 'gbp', 'chf']) === -1)
    {
        selected_currency = 'iban_only';
    }

    $('#per_currency_fields').find('.per_currency_field_group[data-currency="'+ selected_currency +'"]')
        .removeClass('is-hidden has-hidden-fields')
        .find('input, select').not('input[name="address2"]').attr('required', 'required').attr('disabled', false);
}
