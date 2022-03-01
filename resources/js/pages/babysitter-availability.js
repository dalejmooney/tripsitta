import '../dncalendar';

$(document).ready(function(){
    if($('input[name=jobs_babysitter]:checked').val() == 0)
    {
        $('#babysitting_availability').addClass('is-hidden');
    }
    else
    {
        $('#babysitting_availability').removeClass('is-hidden');
    }

    if($('input[name=jobs_holiday_nanny]:checked').val() == 0)
    {
        $('#holiday_nanny_availability').addClass('is-hidden');
    }
    else
    {
        $('#holiday_nanny_availability').removeClass('is-hidden');
    }


     $('input[name="jobs_babysitter"]').on('change', function(e){
         $('#babysitting_availability').toggleClass('is-hidden');
     });

    $('input[name="jobs_holiday_nanny"]').on('change', function(e){
        $('#holiday_nanny_availability').toggleClass('is-hidden');
    });

    var my_calendar = $("#calendar").dnCalendar({
        dataTitles: { defaultDate: 'default', today : 'Today' },
        notes: JSON.parse(availability_babysitter),
        dayClick: function(date, view) {
            my_calendar.addNoteExpanded(date, 'babysitter');
        }
    });

    my_calendar.build();

    var my_calendar2 = $("#calendar2").dnCalendar({
        dataTitles: { defaultDate: 'default', today : 'Today' },
        notes: JSON.parse(availability_holiday_nanny),
        dayClick: function(date, view) {
            my_calendar2.addNote(date, 'holiday_nanny');
        }
    });

    my_calendar2.build();

    $('form').on('submit', function(e){
        $('input[name=availability_babysitter], input[name=availability_holiday_nanny]').remove();

        var input = $("<input>")
            .attr("type", "hidden")
            .attr("name", "availability_babysitter").val(JSON.stringify(my_calendar.returnNotes()));

        var input2 = $("<input>")
            .attr("type", "hidden")
            .attr("name", "availability_holiday_nanny").val(JSON.stringify(my_calendar2.returnNotes()));

        $('form').append(input, input2);
    });
});
