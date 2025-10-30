$(document).ajaxComplete(reinitComboboxHandlers);

function reinitComboboxHandlers() {

    $('#order-item-facade-configurator-clear').off('click').on('click', function(event){resetConfigurationForm(this);});

    $('.configurator-combobox').off('change.comboboxHandler');
    
    $('.configurator-combobox').on('change.comboboxHandler', handleComboboxChange);

    $('#milling-combobox').on('change.comboboxHandler', handleMillingComboboxChange);

}

function resetConfigurationForm(button) {
        
    const deactivateGroup = button.getAttribute('data-bs-deactivate-element');

    if(deactivateGroup != ""){

        $(deactivateGroup).removeClass('active');

    }

    var form = $('#order-item-facade-configurator-form');

    form[0].reset();
   
    fileList = form.find('#catalog-facade-configurator-file-list');

    fileList.empty();
    
    form.find('input[type="checkbox"]').prop('checked', false);
    
    form.find('input[type="number"]').val('');

    form.find('input[type="hidden"]').val('');
    
    form.find('.combobox-input').val('');
    
    form.find('.configurator-combobox').val('0').trigger('change');
}

function handleComboboxChange() {
       
    var selectedOption = $(this).find('option:selected');

    var displayText = selectedOption.data('text') || selectedOption.text();

    var value = $(this).val();
    
    var $container = $(this).closest('.combobox-conteiner');

    var $input = $container.find('.combobox-input');
    
    $input.val(displayText);
    
    //console.log('Value:', value, 'Display:', displayText);
}

function handleMillingComboboxChange() {
       
    var value = $(this).val();

    const $content = $('#custom-milling-content');

    if(value != "CUSTOM_MILLING")
        $content.addClass('d-none');
    else
        $content.removeClass('d-none');
    
}

