$(document).ready(function(){
    var table = $('.table');

    table.on('click', '.add-one-more', function(e){
        addNewRow(table);
    });

    table.on('click', '.delete-one-row', function(e){
        let row_index = $(this).closest('tr').index();

        deleteSelectedRow(row_index, table);
    });

    function addNewRow(output_el)
    {
        let template = output_el.find('.hidden-template');
        let clone = template.clone().removeClass('hidden-template').removeClass('is-hidden');
        let row_index = output_el.find("tr.add-one-more").index();

        clone.find('select').each(function (index, value) {
            $(this).attr('name', $(this).attr('name').replace('tmp', row_index)).attr('disabled', false);
        });

        output_el.find("tr.add-one-more").before(clone);
    }

    function deleteSelectedRow(row_index, output_el)
    {
        output_el.find('tbody tr:eq('+ row_index +')').remove();
    }
});
