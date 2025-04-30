
function GetParams($id) {

    let $currentBtn = $('#' + $id);

    let $parameter = $currentBtn.find('#value').val();
    
    let $currentTriggerContainer = $currentBtn.closest('.ajax-update-trigger');

    let $currentAction = $currentTriggerContainer.find('#action').val();
    let $subAction = $currentTriggerContainer.find('#sub-action').val();
    let $templatePartToUpdate = $currentTriggerContainer.find('#template_part_to_update').val();
    let $htmlBlockToUpdate = $currentTriggerContainer.find('#html_block_to_update').val();
    let $subTemplatePartToUpdate = $currentTriggerContainer.find('#sub_template_part_to_update').val();
    let $subHtmlBlockToUpdate = $currentTriggerContainer.find('#sub_html_block_to_update').val();
    
    $arParams = 
    {
        ACTION: $currentAction, //'content_update'
        TEMPLATE_PART_TO_UPDATE : $templatePartToUpdate, //"parts/main/kitchen-type/kitchen-type"
        HTML_BLOCK_TO_UPDATE_CLASS : $htmlBlockToUpdate, //'kitchen-type-section'
        PARAMETERS :
        {
            ACTION: $subAction, //'content_update'
            PARAMETER : $parameter, //null
            TEMPLATE_PART_TO_UPDATE : $subTemplatePartToUpdate, //parts/main/material/material
            HTML_BLOCK_TO_UPDATE_CLASS : $subHtmlBlockToUpdate //material-items-section'
        } 
    };

    let data = new FormData();
    data.append('action', $currentAction);
    data.append('PARAMETERS', JSON.stringify($arParams));

    return data;
}
