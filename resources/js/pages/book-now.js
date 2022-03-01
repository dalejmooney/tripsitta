$(document).ready(function(){
    let table = $('.table-children');

    $('input[name*="[dob]"]').mask('00/00/0000');

    table.on('click', '.add-one-more', function(e){
        addNewRow(table);
    })
    .on('click', '.delete-one-row', function(e){
        let row_index = $(this).closest('tr').index();
        deleteSelectedRow(row_index, table);
        toggleAllowedChildrenNotification();
    })
    .on('click', '.child-picker', function(e){
        tripsittaModal.modal_id = '#saved_children';
        tripsittaModal.toggleModal();

        let row_index = $(this).closest('tr').index();
        $(tripsittaModal.modal_id).data('triggered_by', row_index);
    })
    .on('keyup', 'input[name*=dob]', tripsittaCommon.delay(toggleAllowedChildrenNotification, 500)
    );

    $('.modal-close').on('click', function(e){
        e.preventDefault();
        tripsittaModal.modal_id = '#saved_children';
        tripsittaModal.toggleModal();

        $(tripsittaModal.modal_id).data('triggered_by', '');
    });

    $('#continue_booking').on('click', function(e)
    {
       e.preventDefault();

       $('#booking_details_form').submit();
    });


    $("#booking_details_form").validate({
        rules: {
            "children[0][name]": {
                required: true,
            },
            "children[0][dob]": {
                required: true,
                dateITA: true,
                dobRange: true,
            },
        },
        submitHandler: function(form) {
            form.submit();
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        errorClass: 'is-danger',
        errorElement: 'p',
        errorPlacement: function(error, element) {
            $(element).parent().append(error).addClass('has-text-danger');
        }
    });

    function toggleAllowedChildrenNotification()
    {
        $('.children_notification').remove();

        if(allowedChildrenCheck($('input[name*="[dob]"]:visible')) === false)
        {
            $('#children_subtitle').after(`<div class="notification is-danger children_notification">It looks like you need more than one babysitter to help with your children. Please either proceed with 2 separate booking or contact us and we'll help.</div>`);
        }
    }

    function allowedChildrenCheck(children)
    {
        let groups = [];
        $.each( children, function( key, child ) {
            let dob = $(child).val();
            if(dob === '' || !moment(dob, 'DD/MM/YYYY').isValid()) return;
            let child_group = calculateAgeGroup(dob);
            groups.push(child_group);
        });

        let count = {};
        groups.forEach(function(i) { count[i] = (count[i]||0) + 1;});

        if(count['infant'] > 2) return false;
        if(count['infant'] === 2 && children.length > 2) return false;

        return true;
    }

    function calculateAgeGroup(dob)
    {
        dob = moment(dob, 'DD/MM/YYYY');
        let today = moment();

        let duration = moment.duration(today.diff(dob));

        if(duration.asMonths() <= 18)
        {
            return 'infant';
        }
        else if(duration.asMonths() <= 24)
        {
            return 'small_baby';
        }
        else if(duration.asYears() <= 4)
        {
            return 'baby';
        }

        return 'child';
    }

    function addNewRow(output_el)
    {
        let template = output_el.find('.hidden-template');
        let clone = template.clone().removeClass('hidden-template').removeClass('is-hidden');
        let row_index = output_el.find("tr.add-one-more").index();
        let total_row_count = output_el.find('tr').length - 3;

        if(total_row_count === 4) return;
        output_el.find('.add-one-more a').attr('disabled', false);

        clone.find('input').each(function (index, value) {
            $(this).attr('name', $(this).attr('name').replace('tmp', row_index)).attr('disabled', false);
        });

        output_el.find("tr.add-one-more").before(clone);

        // count is done before new row added
        let price_options = $('#price_estimate').data('prices');

        let child_string = 'child'
        if(total_row_count+1 > 1) child_string = 'children';
        $('#price_estimate').html('€'+ price_options[total_row_count].toFixed(2) +' for '+ (total_row_count+1) + ' ' + child_string);

        if(total_row_count === 3) output_el.find('.add-one-more a').attr('disabled', 'disabled')

        $('input[name*="[dob]"]').mask('00/00/0000');

        $("input[name*='[name]']:visible").each(function() {
            $(this).rules('add', {
                required: true,
                minlength: 3,
            });
        });
        $("input[name*='[dob]']:visible").each(function() {
            $(this).rules('add', {
                required: true,
                dateITA: true,
                dobRange: true,
            });
        });
    }

    function deleteSelectedRow(row_index, output_el)
    {
        let total_row_count = output_el.find('tr').length - 3;

        if(total_row_count === 1) return;

        output_el.find('tbody tr:eq('+ row_index +')').remove();
        output_el.find('.add-one-more a').attr('disabled', false);

        let price_options = $('#price_estimate').data('prices');
        $('#price_estimate').html('€'+ price_options[total_row_count-2].toFixed(2) +' for '+ (total_row_count-1) +' child');
    }

    $('#saved_children .button').on('click', pickChildFromList);

    function pickChildFromList()
    {
        let el = $(this).parents('tr');

        tripsittaModal.modal_id = '#saved_children';

        let row_index_to_update = $(tripsittaModal.modal_id).data('triggered_by');

        let table_row = table.find('tbody tr:eq('+ row_index_to_update +')');

        table_row.find('input[name="children['+ row_index_to_update +'][name]"]').val(el.data('name')).prop('readonly', true);
        table_row.find('input[name="children['+ row_index_to_update +'][dob]"]').val(el.data('dob')).prop('readonly', true);

        tripsittaModal.toggleModal();
        toggleAllowedChildrenNotification();
    }
});
