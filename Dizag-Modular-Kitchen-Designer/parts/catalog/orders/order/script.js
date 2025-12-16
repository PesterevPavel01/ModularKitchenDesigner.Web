$(document).ready(function() {

    $('#order-submit-reset-form').trigger('submit');
    $('#order-item-send-to-configurator-form-').trigger('submit');
    
});

/*CONFIGURATOR SCRIPTS*/

$(document).ready(function() {
    MasterSlaveSelectsInit('data-membrane-master', 'data-membrane-slave');
});
/*
$(document).ajaxComplete(function() {
    MasterSlaveSelectsRefresh('data-membrane-master', 'data-membrane-slave');
});*/

$(document).ajaxComplete(reinitComboboxHandlers);

$(document).ready(reinitComboboxHandlers);

function reinitComboboxHandlers() {

    $('#order-item-facade-configurator-clear').off('click').on('click', function(event){resetConfigurationForm(this);});

    $('.configurator-combobox').off('change.comboboxHandler');
    
    $('.configurator-combobox').on('change.comboboxHandler', handleComboboxChange);

    $('#milling-combobox').on('change.comboboxHandler', handleMillingComboboxChange);

    $('#hinge-combobox').on('change.comboboxHandler', handleHingeComboboxChange);

}

function resetConfigurationForm(button) {
        
    const deactivateGroup = button.getAttribute('data-bs-deactivate-element');

    if(deactivateGroup != ""){

        const elements = $('[data-form-group="' + deactivateGroup + '"]');
        
        if (elements.length > 0) {
            elements.removeClass('active');
        }

    }

    var form = $('#order-item-facade-configurator-form');

    //нельзя, т.к. сотрутся 
    //form[0].reset();
   
    fileList = form.find('#catalog-facade-configurator-file-list');

    fileList.empty();
    
    form.find('input[type="checkbox"]').prop('checked', false);
    
    form.find('input[type="number"]').val('');

    form.find('input[type="hidden"]:not([data-no-reset="true"])').val('');

    console.log(form.find('input[type="hidden"]:not([data-no-reset="true"])'));
    
    form.find('.combobox-input').val('');
    
    form.find('.configurator-combobox').val('0').trigger('change');

    //отправляю формы, отвечающие за очистку списков файлов в конфигураторе

    $('#configurator-blueprints-milling-reset-form').trigger('submit');

    $('#configurator-blueprints-hinge-reset-form').trigger('submit');

    var messengerResetForm = $('#catalog-order-item-messenger-reset-form');

    messengerResetForm.find('input[type="hidden"]:not([data-no-reset="true"])').val('');

    $('#catalog-order-item-messenger-reset-form').trigger('submit');
}

function handleComboboxChange() {

    var value = $(this).val();
    
    var $container = $(this).closest('.combobox-conteiner');

    var $input = $container.find('.combobox-input');
    
    $input.val(value);
}

function handleMillingComboboxChange() {

    //делает видимой секцию с чертежами

    var value = $(this).val();

    const $content = $('#custom-milling-blueprints-form');

    if(value != "CUSTOM_MILLING")

        $content.addClass('d-none');

    else

        $content.removeClass('d-none');
    
}

function handleHingeComboboxChange() {

    //делает видимой секцию с чертежами

    var value = $(this).val();

    const $content = $('#custom-hinge-blueprints-form');

    if(value != "CUSTOM_HINGE")

        $content.addClass('d-none');

    else

        $content.removeClass('d-none');
    
}