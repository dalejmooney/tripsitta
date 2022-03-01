$(document).ready( function () {
    $('#send_message').on('click', function(e){
        e.preventDefault();

        var new_message_text = $('textarea[name="new_message"]').val();
        sendMessage($(this), new_message_url, new_message_text);
    });

    function sendMessage(clicked_el, url, new_message)
    {
        clicked_el.attr('disabled', 'disabled').addClass('is-loading');
        $('html,body').css("cursor", "progress")

        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: { 'new_message': new_message },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        }).done(function(data) {
            $('#chat_form').before('<div class="notification is-success has-margin-bottom-md">'+ data.success +'</div>');

            $('#previous_messages').prepend(`<div class="column is-8-desktop is-paddingless has-margin-bottom-lg">
                                <div class="notification is-light is-primary">
                                    `+ new_message +`
                                </div>
                            </div>`);

            $('textarea[name="new_message"]').val('');

            clicked_el.attr('disabled', false).removeClass('is-loading');
            $('html,body').css("cursor", "default")
        })
            .fail(function(data) {
                var response = data.responseJSON;
                var errorString = '<ul>';
                $.each( response.errors, function( key, value) {
                    errorString += '<li>' + value + '</li>';
                });
                errorString += '</ul>';

                $('#chat_form').before('<div class="notification is-danger has-margin-bottom-md">'+ errorString +'</div>');

                clicked_el.attr('disabled', false).removeClass('is-loading');
                $('html,body').css("cursor", "default")
            });
    }
});
