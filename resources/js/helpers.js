$(document).ready(function(){
    $('input[type=file]').on('change', function(e){
        let name = $(this).val().split('\\').pop();
        $(this).parent().find('.file-name').html(name);
    });
});


tripsittaTable = {
    table_id: "",

    createDuplicatableRow(){
        let table = $('#' + tripsittaTable.table_id + ' tbody');
        let cloned = table.find('tr:first-child').clone();

        cloned.find('input, select').each(function (index, value) {
            $(this).attr('name', $(this).attr('name').replace('0', 'tmp')).val('').attr('disabled', true);
        });

        table.find('.add_more').before(cloned.addClass('cloned').hide());
    },

    addRow(){
        let table = $('#' + tripsittaTable.table_id);

        let clone_duplicatable_row = table.find('.cloned').clone().show().removeClass('cloned');

        let row_index = table.find("tr.add_more").index();
        clone_duplicatable_row.find('input, select').each(function (index, value) {
            $(this).attr('name', $(this).attr('name').replace('tmp', row_index)).attr('disabled', false);
        });

        table.find('.add_more').before(clone_duplicatable_row);
    },

    deleteRow(row_index){
        $('#' + tripsittaTable.table_id).find('tbody tr:eq('+ row_index +')').remove();
    },

    deleteAllRows(){
        $('#' + tripsittaTable.table_id).find('tbody tr').not('.add_more').not('.cloned').remove();
    }
};

tripsittaModal = {
    modal_id: "",

    toggleModal(){
        $(tripsittaModal.modal_id).toggleClass('is-active');
    },

    makeModal(content){
        $('body').append(content);
    },

    removeModal(){
        $(tripsittaModal.modal_id).remove();
    },
};

tripsittaCommon = {
    delay(fn, ms){
        let timer = 0
        return function(...args) {
            clearTimeout(timer)
            timer = setTimeout(fn.bind(this, ...args), ms || 0)
        }
    },
};

tripsittaButtonPicker = {
    wrapper_id: "",
    selected_value: "",

    toggleSelect(button){
        tripsittaButtonPicker.clearSelection();

        tripsittaButtonPicker.selected_value = button.data('value');

        button.toggleClass('is-selected').toggleClass('is-dark');
    },

    clearSelection(){
        $('#' + tripsittaButtonPicker.wrapper_id).find('.button').removeClass('is-selected').removeClass('is-dark');
    },

    updateHiddenField(button, hidden_field_el)
    {
        let new_val = button.data('value');
        hidden_field_el.val(new_val);
    }
};
