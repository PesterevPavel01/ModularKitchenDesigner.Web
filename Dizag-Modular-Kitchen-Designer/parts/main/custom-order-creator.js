
function GetParams($id) {

    let $currentBtn = $($id);
    
    let $currentTriggerContainer = $currentBtn.closest('.create-custom-order-btn');

    let $currentAction = $currentTriggerContainer.find('#action').val();
    let $templatePartToUpdate = $currentTriggerContainer.find('#template_part_to_update').val();
    let $htmlBlockToUpdate = $currentTriggerContainer.find('#html_block_to_update').val();

    let KITCHEN_TYPE_CODE = $currentTriggerContainer.find('#custom-order-kitchen-code').val();
    
    let sectionsArray = $('.modules-container').map(function() {
        let quantity = $(this).find('#quantity').val(); // Сохраняем значение quantity
        if (quantity > 0) { // Проверяем, что quantity больше 0
            return {
                moduleCode: $(this).find('.module-code').text(),
                quantity: quantity
            };
        }
    }).get().filter(item => item !== undefined); 

    let $parameter = {
        "KITCHEN_TYPE_CODE": KITCHEN_TYPE_CODE,
        "SECTIONS": sectionsArray
    };

    $arParams = 
    {
        ACTION: $currentAction, //'content_update'
        TEMPLATE_PART_TO_UPDATE : $templatePartToUpdate, //"parts/main/kitchen-type/kitchen-type"
        HTML_BLOCK_TO_UPDATE_CLASS : $htmlBlockToUpdate, //'kitchen-type-section'
        PARAMETERS :
        {
            PARAMETER : $parameter, //null
        } 
    };

    let data = new FormData();
    data.append('action', $currentAction);
    data.append('PARAMETERS', JSON.stringify($arParams));

    return data;
}
