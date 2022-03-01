$(document).ready(function(){
    $("form[name=book-now-payment]")[0].reset();

    $('input[name=accommodation_booked]').on('change', function(){
        $('#toggle_accommodation_details').addClass('is-hidden');
        if($('input[name=accommodation_booked]:checked').val() === '1')
        {
            $('#toggle_accommodation_details').removeClass('is-hidden');
        }
    });

    $('input[name=babysitter_meet]').on('change', function(){
        $('#toggle_babysitter_meet').addClass('is-hidden');
        if($('input[name=babysitter_meet]:checked').val() === '1')
        {
            $('#toggle_babysitter_meet').removeClass('is-hidden');
        }
    });

    $('input[name=travel_trip]').on('change', function(){
        $('#toggle_travel_trip').addClass('is-hidden');
        if($('input[name=travel_trip]:checked').val() === '1')
        {
            $('#toggle_travel_trip').removeClass('is-hidden');
        }
    });

    $('#continue_booking').on('click', function(e){
       e.preventDefault();

       $("form[name=book-now-payment]").submit();
    });

    $("form[name=book-now-payment]").validate({
        ignore: [],
        rules: {
            "travel_trip": {
                required: true,
            },
            "travel_trip_details": {
                required: function () {
                    return $('input[name=travel_trip]:checked').val() === '1'
                }
            },
            "babysitter_meet": {
                required: true,
            },
            "babysitter_meet_details": {
                required: function () {
                    return $('input[name=babysitter_meet]:checked').val() === '1'
                }
            },
            "accommodation_booked": {
                required: true,
            },
            "accommodation_details": {
                required: function () {
                    return $('input[name=accommodation_booked]:checked').val() === '1'
                }
            },
            "primary_number_available": {
                required: true,
            },
            "emergency_phone_number_available": {
                required: true,
            },
            "additional_phone_number": {
                required: function () {
                    return $('input[name=primary_number_available]:checked').val() === '0' && $('input[name=emergency_phone_number_available]:checked').val() === '0'
                }
            },
            "parent_during_booking": {
                required: true,
            },
            "booking_notes": {
                required: true,
            },
        },
        submitHandler: function(form) {
            $('#continue_booking').attr('disabled', 'disabled').addClass('is-loading');
            $('html,body').css("cursor", "progress")

            $.ajax({
                url: "book-now-2",
                type: "post",
                data: $("form[name=book-now-payment]").serialize(),
            }).done(function() {
                $('#errors-container').empty().addClass('is-hidden');

                stripe.redirectToCheckout({
                    sessionId: CHECKOUT_SESSION_ID,
                }).then(function (result) {
                    $('#errors-container').html(result.error.message).removeClass('is-hidden');
                });
            })
            .fail(function(data) {
                var response = JSON.parse(data.responseText);
                var errorString = '<ul>';
                $.each( response.errors, function( key, value) {
                    errorString += '<li>' + value + '</li>';
                });
                errorString += '</ul>';

                $('#errors-container').html(errorString).removeClass('is-hidden');
                $('html, body').animate({
                    scrollTop: $('#errors-container').offset().top-80
                }, 1000);

                $('#continue_booking').attr('disabled', false).removeClass('is-loading');
                $('html,body').css("cursor", "default")
            });
        },
        highlight: function(element, errorClass, validClass) {
            if($(element).is(':radio'))
            {
                $(element).parent().parent().find('.radio').addClass('has-text-danger').removeClass(validClass);
            }
            else if($(element).attr('type') === 'hidden')
            {
                $(element).parent().addClass('is-danger').removeClass(validClass);
            }
            else
            {
                $(element).addClass(errorClass).removeClass(validClass);
            }

        },
        unhighlight: function(element, errorClass, validClass) {
            if($(element).is(':radio'))
            {
                $(element).parent().parent().find('.radio').removeClass('has-text-danger').addClass(validClass);
            }
            else if($(element).attr('type') === 'hidden')
            {
                $(element).parent().removeClass('is-danger').addClass(validClass);
            }
            else
            {
                $(element).removeClass(errorClass).addClass(validClass);
            }
        },
        errorClass: 'is-danger',
        errorElement: 'p',
        errorPlacement: function(error, element) {},
        focusInvalid: false,
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top-80
            }, 1000);

            $(validator.errorList[0].element).focus();
        }
    });
});
