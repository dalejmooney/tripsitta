$(document).ready( function () {
    if(filter_booking_id !== '')
    {
        filter_table(filter_booking_id);
        $('#search').val(filter_booking_id);
    }

    $('table').on('click', 'tr:not(.table-actions)', function(e){
        e.preventDefault();

        $(this).next('.table-actions').toggle();
    });

    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase().trim();

        filter_table(value);
    });

    function filter_table(value)
    {
        $("table tr").each(function(index) {
            if (index != 0) {
                $row = $(this);
                var id = $row.find("td.table-booking-id").text().toLowerCase().trim();

                if (!id.includes(value)) {
                    $(this).hide();
                }
                else {
                    $(this).not('.table-actions').show();
                }
            }
        });
    }
});
