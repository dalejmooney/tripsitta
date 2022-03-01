let bulma_calendar = require('bulma-calendar');
let filtering = require('../filter_results');

$(document).ready(function(){
    const calendars = bulma_calendar.attach('#range-input', {
        dateFormat: 'D MMM YYYY',
        isRange: true,
        showFooter: false,
        minDate: new Date(),
        startDate: selected_start,
        endDate: selected_return,
        labelFrom: 'Departure',
        labelTo: 'Return',
    });

    updateFlag($('select[name=travel_from]').find(':selected').data('code'), 'from');
    updateFlag($('select[name=travel_to]').find(':selected').data('code'), 'to');

    $('.is-country-selector').on('change', function(e){
       updateFlag($(this).find(':selected').data('code'), $(this).data('countryfield_id'));
    });

    $('.datetimepicker-clear-button').on('click', function (e) { // fix issue with calendars
        e.preventDefault();
    });

    $("#search-form").validate({
        rules: {
            travel_from: {
                required: true,
            },
            travel_to: {
                required: true,
            },
            start_date: {
                required: true,
            },
            return_date: {
                required: true,
            },
        },
        submitHandler: function(form) {
            calendars.forEach(calendar => {
                if(typeof calendar.startDate !== 'undefined' && typeof calendar.endDate !== 'undefined' && calendar.startDate !== '' && calendar.endDate !== '')
                {
                    $('#search-form')
                        .append('<input type="hidden" name="start_date" value="'+ calendar.startDate.toLocaleDateString('en-GB') +'" /> ')
                        .append('<input type="hidden" name="return_date" value="'+ calendar.endDate.toLocaleDateString('en-GB') +'" /> ');
                }
            });

            if($('input[name=start_date]').length && $('input[name=return_date]').length)
            {
                $('#range-input').parent().removeClass('is-danger').addClass('valid');
                form.submit();
            }
            else
            {
                $('#range-input').parent().addClass('is-danger').removeClass('valid');
            }
        },
        errorClass: 'is-danger',
        highlight: function(element, errorClass, validClass) {
            $(element).parent().addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parent().removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function(error, element) {}
    });

    function updateFlag(selected_country, country_field)
    {
        let field = $("span").find('[data-countryfield='+ country_field +']');
        field.removeClass().addClass('flag-icon flag-icon-squared is-country flag-icon-'+ selected_country.toLowerCase());
    }

    $('#reset_search').on('click', function(e){
        let form = $('form');

        form.find('select').prop('selectedIndex',0);
        form.find('input[type=text], input[type=date]').val('');
        updateFlag('gb', 'from');
        updateFlag('', 'to');

        calendars.forEach(calendar => {
           calendar.clear();
        });

        $(this).find('[data-fa-i2svg]').addClass('fa-spinner fa-pulse');
    });

    $('.filters_show').on('click', 'a', filtering.triggerFilters);
    $('.filters-column').on('click', '.close', filtering.triggerFilters);

    $('#filter_results').on('click', filtering.filter);
});
