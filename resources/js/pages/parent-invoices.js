$(document).ready( function () {
    if(filter_booking_id !== '')
    {
        filter_table(filter_booking_id);
        $('#search').val(filter_booking_id);
    }

    $('table').on('click', 'tr:not(.table-actions)', function(e){
        e.preventDefault();

        $(this).next('.table-actions').toggle();
    }).on('click', '.pay-invoice', function(e){
        e.preventDefault();

        var invoice_id = $(this).data('invoice');

        var modal = `<div class="modal" id="pay_invoice">
          <div class="modal-background"></div>
          <div class="modal-content">
            <div class="box">
                <p>You'll be redirected to our payment gateway (Stripe) to make the payment. <br />Please confirm below if you want to proceed. </p>
                <div class="buttons has-margin-top-md">
                    <a class="button is-primary" id="make_payment" data-invoice="`+ invoice_id +`">Proceed to payment</a>
                    <a class="button is-primary is-outlined modal-close-button">Cancel</a>
                </div>
            </div>
          </div>
          <button class="modal-close is-large" aria-label="close"></button>
        </div>
        `;

        tripsittaModal.makeModal(modal)
        tripsittaModal.modal_id = '#pay_invoice';
        tripsittaModal.toggleModal();
    });

    $('body').on('click', '.modal-close, .modal-close-button', function(e){
        e.preventDefault();
        tripsittaModal.modal_id = '#pay_invoice';
        tripsittaModal.toggleModal();
        tripsittaModal.removeModal();
    });

    $('body').on('click', '#make_payment', function(e){
        e.preventDefault();

        $('#make_payment').attr('disabled', 'disabled').addClass('is-loading');
        $('html,body').css("cursor", "progress")

        var invoice_id = $(this).data('invoice');

        $.ajax({
            url: select_invoice_url + '/' + invoice_id,
            type: "GET",
        }).done(function(data) {
            if(data.session === undefined || data.session.length === 0) return;
            $('#errors-container').empty().addClass('is-hidden');

            stripe.redirectToCheckout({
                sessionId: data.session,
            }).then(function (result) {
                $('#errors-container').html(result.error.message).removeClass('is-hidden');
                $('#make_payment').attr('disabled', false).removeClass('is-loading');
                tripsittaModal.modal_id = '#pay_invoice';
                tripsittaModal.toggleModal();
                tripsittaModal.removeModal();
                $('html,body').css("cursor", "default")
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

                $('#make_payment').attr('disabled', false).removeClass('is-loading');
                tripsittaModal.modal_id = '#pay_invoice';
                tripsittaModal.toggleModal();
                tripsittaModal.removeModal();
                $('html,body').css("cursor", "default")
            });
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
