$(document).ready(function(){
    $('table').on('click', 'tr:not(.table-actions)', function(e){
       e.preventDefault();

       $(this).next('.table-actions').toggle();
    });
});
