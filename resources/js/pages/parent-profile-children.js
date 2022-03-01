require('../helpers.js');

$(document).ready(function(){
    let childrenTable = tripsittaTable;

    childrenTable.table_id = 'table_children';
    childrenTable.createDuplicatableRow();

    $('#' + childrenTable.table_id)
        .on('click', '.add_more', function(e){
            childrenTable.addRow();
         })
        .on('click', '.delete-one-row', function(e){
            let row_index = $(this).closest('tr').index();
            childrenTable.deleteRow(row_index);
        })
        .on('click', '.delete-all-rows', function(e){
            childrenTable.deleteAllRows();
        })
    ;
});
