let bulma_carousel = require('bulma-carousel');
let bulma_calendar = require('bulma-calendar');

$(document).ready(function(){
    const carousel = bulma_carousel.attach('#carousel', {
        infinite: true,
        autoplay: true,
        pauseOnHover: false,
        minDate: new Date(),
        navigation: false,
        pagination: false,
        breakpoints: []
    });

    const calendars = bulma_calendar.attach('#range-input', {
        dateFormat: 'D MMM YYYY',
        isRange: true,
        showFooter: false,
        minDate: new Date(),
        labelFrom: 'Departure',
        labelTo: 'Return'
    });

    const calendars_single = bulma_calendar.attach('#single_input', {
        dateFormat: 'D MMM YYYY',
        showFooter: false,
        minDate: new Date(),
        startDate: new Date(),
        labelFrom: 'Date'
    });

    // let date = new Date(0,0,0, 12, 0);
    // const calendars_time = bulma_calendar.attach('#range_input_time', {
    //     type: 'time',
    //     showFooter: true,
    //     showClearButton: false,
    //     validateLabel: 'Select time',
    //     labelFrom: 'Start',
    //     start: date,
    //     minuteSteps: 30,
    // });

    let bullets_container = $('.carousel-bullets');

    updateCarouselBullets((carousel[0].state.index+1), carousel[0].state.length);
    updateFlag($('select[name=travel_from]').find(':selected').data('code'), 'from');
    updateFlag($('select[name=travel_to]').find(':selected').data('code'), 'to');
    updateFlag($('select[name=location]').find(':selected').data('code'), 'location');

    carousel[0].on('show', function (bulmaCarouselInstance) {
        updateCarouselBullets((bulmaCarouselInstance.state.length - bulmaCarouselInstance.state.index), bulmaCarouselInstance.state.length);
    });

    $('.is-country-selector').on('change', function(e){
       updateFlag($(this).find(':selected').data('code'), $(this).data('countryfield_id'));
    });

    $('.datetimepicker-clear-button').on('click', function (e) { // fix issue with calendars
        e.preventDefault();
    });

    $('.option').on('click', 'a', function (e) {
       e.preventDefault();

        $('.option').removeClass('is-active');
        $(this).parent().addClass('is-active');

       if($(this).data('form_option') === 'holiday'){
           $('#holiday_form').show();
           $('#local_form').hide();
           return;
       }
        $('#holiday_form').hide();
        $('#local_form').show();
    });

    $("#holiday_form").validate({
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
                if(typeof calendar.startDate !== 'undefined' && typeof calendar.endDate !== 'undefined')
                {
                    $('#holiday_form')
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

    $("#local_form").validate({
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
                    $("#local_form").append('<input type="hidden" name="date" value="'+ calendar.startDate.toLocaleDateString('en-GB') +'" /> ');
                }
                else
                {
                    $('#single_input').parent().addClass('is-danger').removeClass('valid');
                }
            });
            // calendars_time.forEach(calendar => {
            //     let time = calendar.startTime.getHours() +':'+ String(calendar.startTime.getMinutes()).padStart(2, "0");
            //     $("#local_form").append('<input type="hidden" name="time" value="'+ time +'" /> ');
            // });

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

    function updateCarouselBullets(position, bullets_count){
        let txt = '';

        for ( var i = 1, l = bullets_count; i <= bullets_count; i++ ) {
            if(i === position)
            {
                txt += '<span class="is-active" data-id="'+ i +'"><i class="fas fa-circle fa-xs"></i></span> ';
                continue;
            }
            txt += '<span><i class="fas fa-circle fa-xs"></i></span> ';
        }

        bullets_container.empty().append(txt);
    }

    function updateFlag(selected_country, country_field)
    {
        let field = $("span").find('[data-countryfield='+ country_field +']');
        field.removeClass().addClass('flag-icon flag-icon-squared is-country flag-icon-'+ selected_country.toLowerCase());
    }
});
