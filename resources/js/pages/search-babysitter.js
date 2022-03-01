let bulma_calendar = require('bulma-calendar');
let filtering = require('../filter_results');

$(document).ready(function(){
    const calendars_single = bulma_calendar.attach('#single_input', {
        dateFormat: 'D MMM YYYY',
        showFooter: false,
        minDate: new Date(),
        startDate: date,
        labelFrom: 'Date',
    });

    updateFlag($('select[name=location]').find(':selected').data('code'), 'location');

    $('.is-country-selector').on('change', function(e){
       updateFlag($(this).find(':selected').data('code'), $(this).data('countryfield_id'));
    });

    $('.datetimepicker-clear-button').on('click', function (e) { // fix issue with calendars
        e.preventDefault();
    });

    $("#search-form").validate({
        rules: {
            location: {
                required: true,
            },
            date: {
                required: true,
            },
            duration: {
                required: true,
            },
            time: {
                required: true,
            },
        },
        submitHandler: function(form) {
            calendars_single.forEach(calendar => {
                if(typeof calendar.startDate !== 'undefined')
                {
                    $("#search-form").append('<input type="hidden" name="date" value="'+ calendar.startDate.toLocaleDateString('en-GB') +'" /> ');
                }
                else
                {
                    $('#single_input').parent().addClass('is-danger').removeClass('valid');
                }
            });

            if($('input[name=date]').length)
            {
                $('#single_input').parent().removeClass('is-danger').addClass('valid');
                form.submit();
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
        let form = $('#search-form');

        form.find('select').prop('selectedIndex',0);
        form.find('input[type=text], input[type=date]').val('');
        updateFlag('', 'location');

        calendars_single.forEach(calendar => {
           calendar.clear();
        });

        $(this).find('[data-fa-i2svg]').addClass('fa-spinner fa-pulse');
    });

    $('.filters_show').on('click', 'a', filtering.triggerFilters);
    $('.filters-column').on('click', '.close', filtering.triggerFilters);

    $('#filter_results').on('click', filtering.filter);
});
