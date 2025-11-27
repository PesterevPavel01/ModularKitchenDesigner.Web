$(document).on('click', '[modal-button-trigger]', function(event) {

    event.preventDefault();

    var $button = $(this);

    var formSelector = $button.attr('data-bs-current-form');

    var $form = $(formSelector);
    
    if ($form.length) {
        $form.submit(); 
    }

})