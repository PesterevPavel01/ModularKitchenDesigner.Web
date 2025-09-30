
function GetOrderListParams($id) {

    let $currentBtn = $('#' + $id);

    let $currentTriggerContainer = $currentBtn.closest('#catalog-order-list-ajax-trigger-conteiner');

    let $period = $currentTriggerContainer.find('#catalog-order-list-period').val();
    let $ascending = $currentTriggerContainer.find('input#catalog-order-list-ascending').is(':checked');
    let $custom = $currentTriggerContainer.find('input#catalog-order-list-custom-only').is(':checked');
    let $incomplete = $currentTriggerContainer.find('input#catalog-order-list-incomplete-only').is(':checked');

    let $templatePartToUpdate = $currentTriggerContainer.find('#catalog-order-list-template_part_to_update').val();
    let $htmlBlockToUpdate = $currentTriggerContainer.find('#catalog-order-list-html_block_to_update').val();

    let $parameter = {
        "PERIOD": $period,
        "ASCENDING":  $ascending,
        "INCOMPLETE_ONLY" : $incomplete,
        "CUSTOM_ONLY" : $custom
    };
    
    $arParams = 
    {
        ACTION: 'catalog_content_update', //'content_update'
        TEMPLATE_PART_TO_UPDATE : $templatePartToUpdate,
        HTML_BLOCK_TO_UPDATE_CLASS : $htmlBlockToUpdate,
        PARAMETERS :
        {
            PARAMETER : $parameter, //null
        } 
    };

    let data = new FormData();
    data.append('action', 'catalog_content_update');
    data.append('PARAMETERS', JSON.stringify($arParams));

    return data;
}