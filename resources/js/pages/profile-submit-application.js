let bulma_calendar = require('bulma-calendar');

$(document).ready(function(){
    blocked_dates = JSON.parse(blocked_dates);

    blocked_dates.forEach(function(date, index) {
        blocked_dates[index] = new Date(date);
    });

    const calendars_single = bulma_calendar.attach('#single_input', {
        dateFormat: 'YYYY-MM-DD',
        showFooter: false,
        minDate: new Date(),
        maxDate: new Date(max_date),
        disabledDates: blocked_dates,
        labelFrom: 'Date',
    });
});
