$(document).ready(CatalogAjaxTriggersInit);

function  CatalogAjaxTriggersInit()
{
    let $triggerForms = $('#catalog-order-list-ajax-trigger-conteiner');

    $triggerForms.each(function() {

        let $updateButtons = $(this).find('#order-list-parameters-button');

        $updateButtons.each(function() {
            $(this).off('click').on('click', function(e) {

                CatalogAjaxContentUpdate($(this));

            });
        });
    });
}

function CatalogAjaxContentUpdate($currentBtn) {

    let currentBtnId = $($currentBtn).attr('id');

    if ($('#' + currentBtnId).hasClass('process'))
    return;

    $('#' + currentBtnId).addClass('process');

    $orderListParamsCreatorPath = catalog_parts_url + "account/customer-account/order-list-parameters-creator.js";

    $.getScript($orderListParamsCreatorPath)

    .done(function() {

        let data = GetOrderListParams(currentBtnId); // Получаем объект

        performAjaxRequest(data, '#' + currentBtnId);
    })
}

function performAjaxRequest(data, unlockedElement) {
    $.ajax({
        type: 'POST',
        url: ajax_url,
        data: data,
        cache: false, //Обязательно указать false
        processData: false, //Обязательно указать false
        contentType: false, // Обязательно указать false
        
        success: function(data) {
            
            $arParams = JSON.parse(data);

            $('.' + $arParams.HTML_BLOCK).html($arParams.HTML_CONTENT);

            if(unlockedElement)
                $(unlockedElement).removeClass('process');
        }
    });
}