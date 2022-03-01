$(document).ready(function(){
    $('#available_background_images').on('click', 'a', function(e){
       e.preventDefault();

       let img_name = $(this).data('img_value');
       $('select[name=profile_background]').find('option[value="'+ img_name +'"]').attr('selected','selected');
       $('#available_background_images a figure').removeClass('is_selected').removeClass('is_highlighted');
       $(this).find('figure').addClass('is_selected');
    });
});
