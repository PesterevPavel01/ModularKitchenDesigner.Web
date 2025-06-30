$(document).ready(AjaxTriggersInit);

function  AjaxTriggersInit()
{
    let $triggerForms = $('.ajax-update-trigger');

    $triggerForms.each(function() {

        let $updateButtons = $(this).find('.ajax-update-button');

        $updateButtons.each(function() {
            $(this).off('click').on('click', function(e) {
                AjaxContentUpdate($(this));
                Select($(this), $updateButtons);
            });
        });
    });

    let $biSquareList =  $(this).find('.check-square-list');
    
    $biSquareList.each(function() {

        let $checkSquareTop = $biSquareList.find('.bi-square.top , .bi-check-square.top')
        
        $checkSquareTop.each(function() {
            $(this).off('click').on('click', function(e) {
                CheckSquareClick($(this),$checkSquareTop)
            });
        });

        $checkSquareBottom = $biSquareList.find('.bi-square.bottom , .bi-check-square.bottom')
        
        $checkSquareBottom.each(function() {
            $(this).off('click').on('click', function(e) {
                CheckSquareClick($(this),$checkSquareBottom)
            });
        });
    });

    $('#create-custom-order-button').off('click').on('click', function(e) {
        AjaxCreateCustomOrder();
    });

    $ajax_generate_pdf_part = pdf_order_creator_url + "script.js";

    $.getScript($ajax_generate_pdf_part)
    .done(function() {
        InitializeCreatePdfOrderButton();
    })
}

function AjaxContentUpdate($currentBtn) {
    
    if ($currentBtn.hasClass('active'))
        return;
    
    let $currentTriggerContainer = $currentBtn.closest('.ajax-update-trigger');
    $currentTriggerContainer.off('click');
    $defaultCreatorPath = main_parts_url + "params-default-creator.js";

    $.getScript($defaultCreatorPath)
    .done(function() {
        let data = GetParams($($currentBtn).attr('id')); // Получаем объект
        performAjaxRequest(data, null);
    })
}

function AjaxCreateCustomOrder() {

    if ($('#create-custom-order-button').hasClass('process'))
        return;

    $('#create-custom-order-button').addClass('process');

    $.getScript(main_parts_url + "custom-order-creator.js")
    .done(function() {
        let data = GetParams('#create-custom-order-button');
        performAjaxRequest(data, '#create-custom-order-button');
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
        
            $.getScript($arParams.SCRIPT, function() {
        
                $(document).ready(function() {
                    AjaxTriggersInit();
                });
        
            });

            if(unlockedElement)
                $(unlockedElement).removeClass('process');
        }
    });
}

function Select($currentBtn, $updateButtons)
{
    $currentBtn.toggleClass('active');

    if(!$updateButtons)
        return;
    if ($updateButtons.length > 0) {
        $updateButtons.each(function() {
            if (!$(this).is($currentBtn))
                $(this).removeClass('active');
        });
    }
}

function CheckSquareClick($currentBtn, $updateButtons)
{
    if($currentBtn.hasClass('bi-square')){
        $currentBtn.addClass('bi-check-square').removeClass('bi-square');
        if(!$updateButtons)
            return;
        if ($updateButtons.length > 0) {
            $updateButtons.each(function() {
                if (!$(this).is($currentBtn))
                    $(this).addClass('bi-square').removeClass('bi-check-square');
            });
        }
    }
    else{
        $currentBtn.addClass('bi-square').removeClass('bi-check-square');
    }
}