$(document).ready(function(){
    $('#booking_status_confirm').on('click', function(e){
       e.preventDefault();

        updateStatus($(this), status_update_url, 'confirm');
    });
    $('#booking_status_cancel').on('click', function(e){
        e.preventDefault();

        updateStatus($(this), status_update_url, 'cancel');
    });

    function updateStatus(clicked_el, url, new_status)
    {
        clicked_el.attr('disabled', 'disabled').addClass('is-loading');
        $('html,body').css("cursor", "progress")

        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: { 'new_status': new_status },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        }).done(function(data) {
            $('#message_container').empty().append('<div class="notification is-success has-margin-bottom-md">'+ data.success +'</div>');
            if(data.new_status !== undefined){
                $('#booking-status-container').empty().append(data.new_status);
            }
            $('#booking_status_confirm, #booking_status_cancel').remove();

            clicked_el.attr('disabled', false).removeClass('is-loading');
            $('html,body').css("cursor", "default")
        })
        .fail(function(data) {
            $('#message_container').empty().append('<div class="notification is-danger has-margin-bottom-md">'+ data.responseJSON.error +'</div>');

            clicked_el.attr('disabled', false).removeClass('is-loading');
            $('html,body').css("cursor", "default")
        });
    }
});
