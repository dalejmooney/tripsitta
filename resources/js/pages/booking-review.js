$(document).ready(function(){
    $(".rating")
        .rate({
            max_value: 5,
            step_size: 1,
            cursor: 'pointer',
        })
        .on("change", function(ev, data){
            $('input[name="rating"]').val(data.to);
        });

    $('#add_review:enabled').on('click', function(e){
        e.preventDefault();

        storeReview();
    });

});

function storeReview()
{
    let button = $('#add_review');

    button.attr('disabled', 'disabled').addClass('is-loading');
    $('html,body').css("cursor", "progress")

    $.ajax({
        url: storeReviewUrl,
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json",
        data: $("#review_form").serialize(),
    }).done(function(data) {
        $('.notification.is-ajax').remove();
        $('#review_form').prepend('<div class="notification is-ajax is-success has-margin-bottom-md">'+ data.success +'</div>');

        button.removeClass('is-loading').addClass('is-success').empty().append('Review added !');
        $('html,body').css("cursor", "default")
    }).fail(function(data) {
        $('.notification.is-ajax').remove();

        let error_message = data.responseJSON.error;
        if(typeof error_message === 'undefined') error_message = 'Error occurred!';

        $('#review_form').prepend('<div class="notification is-ajax is-danger has-margin-bottom-md">'+ error_message +'</div>');

        button.attr('disabled', false).removeClass('is-loading');
        $('html,body').css("cursor", "default")
    });
}
