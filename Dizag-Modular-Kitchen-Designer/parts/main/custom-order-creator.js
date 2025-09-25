
function GetParams($id) {

    let $currentBtn = $($id);
    
    let $currentTriggerContainer = $currentBtn.closest('.create-custom-order-btn');

    let $currentAction = $currentTriggerContainer.find('#action').val();
    let $templatePartToUpdate = $currentTriggerContainer.find('#template_part_to_update').val();
    let $htmlBlockToUpdate = $currentTriggerContainer.find('#html_block_to_update').val();

    let $retailPrice = $currentTriggerContainer.find('#retail-price-check-box').hasClass('bi-check-square');
    let $discountedPrice = $currentTriggerContainer.find('#discounted-price-check-box').hasClass('bi-check-square');
    
    let $typePricesArr = {
        "RETAIL" : $retailPrice,
        "DISCOUNTED" : $discountedPrice
    };


    let KITCHEN_TYPE_CODE = $currentTriggerContainer.find('#custom-order-kitchen-code').val();

   
    let $kitchenContainer = $currentBtn.closest('.material-items-section');

    let $materialsBlock = $kitchenContainer.find('#material-items')
    let $materialTopCheckedBox = $materialsBlock.find('.top.bi-check-square');
    
    let $moduleTypeTopTitle = $materialsBlock.find('.top-title').text();
    let $moduleTypeBottomTitle = $materialsBlock.find('.bottom-title').text();

    let $materialBottomCheckedBox = $materialsBlock.find('.bottom.bi-check-square');
    let $materialItemBotton = $materialBottomCheckedBox.closest('.block-material-item');
    let $materialItemBottomTitle = $materialItemBotton.find('.title').text();
    let $materialItemBottomCode = $materialItemBotton.find('.code').val();
    let $materialItemTop = $materialTopCheckedBox.closest('.block-material-item');
    let $materialItemTopTitle = $materialItemTop.find('.title').text();
    let $materialItemTopCode = $materialItemTop.find('.code').val();


    
    let sectionsArray = $('.modules-container').map(function() {
        let quantity = $(this).find('.quantity-value').val(); // Сохраняем значение quantity
        if (quantity === "") {
            quantity = "0"; // или оставить пустую строку? В зависимости от логики.
        } else {
            quantity = parseInt(quantity, 10).toString();
        }
        
        if (quantity > 0) { // Проверяем, что quantity больше 0
            return {
                moduleCode: $(this).find('.module-code').text(),
                moduleTitle: $(this).find('.module-title').text(),
                quantity: quantity
            };
        }
    }).get().filter(item => item !== undefined); 

    let $parameter = {
        "KITCHEN_TYPE_CODE": KITCHEN_TYPE_CODE,
        "SECTIONS": sectionsArray,
        "MATERIALS" : {
            "TOP" : 
            {
                'TITLE' : $moduleTypeTopTitle,
                'VALUE' :
                {
                    'TITLE' : $materialItemTopTitle,
                    'CODE' : $materialItemTopCode 
                }
            },
            "BOTTOM" : 
            {
                'TITLE' : $moduleTypeBottomTitle,
                'VALUE' :
                {
                    'TITLE' : $materialItemBottomTitle,
                    'CODE' : $materialItemBottomCode 
                }
            }
        },
        "PRICE_TYPES" : $typePricesArr
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