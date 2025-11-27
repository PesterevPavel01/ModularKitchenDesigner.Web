$(document).ready(AjaxCatalogDefaultContentUpdaterInit);

function  AjaxCatalogDefaultContentUpdaterInit()
{
    $(document).on('submit', '[data-ajax-default-content-updater]', function(e) {
        e.preventDefault();
        Handler($(this)); // this = элемент формы
    });
}

function Handler($form)
{
    //const data = $form.serialize();

    //console.log(data);
    
    const $blockedElement = $form.find('input[name="BLOCKED_ELEMENT"]').val();

    const $targetContainerMobile = $form.find('input[name="TARGET_CONTAINER_MOBILE"]').val(); //$form.find('#TARGET_CONTEINER').val();

    var $targetContainer = ( $targetContainerMobile && $targetContainerMobile!='' &&  window.innerWidth < 992) ? $targetContainerMobile : $form.find('input[name="TARGET_CONTAINER"]').val(); //$form.find('#TARGET_CONTEINER').val();

    const $dependentForm =  $form.find('input[name="DEPENDENT_FORM"]').val(); //$form.find('#DEPENDENT_FORM').val();

    const $dependentFormSecond =  $form.find('input[name="DEPENDENT_FORM_SECOND"]').val(); //$form.find('#DEPENDENT_FORM').val();
    
    const $errorContainer =  $form.find('input[name="ERROR_CONTAINER"]').val();
    
    //console.log($errorContainer);
    
    let $activateElement = $();
    
    const $successContainerSelector =  $form.find('input[name="SUCCESS_CONTAINER"]').val();//$form.find('#SUCCESS_CONTAINER').val() || '';
    
    //console.log('$successContainerSelector: ' +$successContainerSelector);
    
    
    //Если нужно выделить элемент этой формы классом 'active', а у других форм группы удалить класс active, при его наличии
    const $activateElementInput = $form.find('input[name="ACTIVATE_ELEMENT_GROUP"]');
    
    if ($activateElementInput.length) {
        
        const $activateElementValue = $activateElementInput.val();
        
        $activateElement = $form.find('[data-form-group="' + $activateElementValue + '"]');
        
        const $elements = $('[data-form-group="' + $activateElementValue + '"]');
        
        if ($elements.length > 0) {

            $elements.removeClass('active');
            
        }
    } 
    
    const $delay =  $form.find('input[name="DELAY"]').val(); //$form.find('#DEPENDENT_FORM').val();

    if ($delay && $delay !== '') {

        const delayMs = parseInt($delay, 10);

        setTimeout(executeAjax, delayMs);

    } else {

        executeAjax();

    }
    
    /*const serializedData = $form.serialize();

    console.log('Serialized data:', serializedData); */
    function executeAjax() {

        $.ajax(
            {
                type: 'POST',
                url: ar_params.ajax_url,
                data: $form.serialize(),
                beforeSend : function( xhr ){
                    $($blockedElement).block({
                        message : null,
                        overlayCSS:{
                            background:  `#fff url(${ar_params.preloader_url}) center center no-repeat`,
                            opacity: 0.8
                        }
                    })
                },
                success : function( data ){

                    var $arParams = JSON.parse(data);

                    if($arParams.ERRORS)
                    {
                        if($($errorContainer).length)
                            $($errorContainer).html( $arParams.HTML_CONTENT );
                        else 
                            $($targetContainer).html('<div class="alert alert-warning alert-dismissible fade show m-0 w-100" role="alert"><strong>Не найден контейнер для ошибок!</strong><button type="button" class="btn-close text-center p-0 pe-3 h-100" data-bs-dismiss="alert" aria-label="Close"></button></div>');

                    }else{

                        $($targetContainer).html( $arParams.HTML_CONTENT );

                        if ($dependentForm && $dependentForm !== '')
                            $($dependentForm).trigger('submit');

                        if ($dependentFormSecond && $dependentFormSecond !== '')
                            $($dependentFormSecond).trigger('submit');

                    }

                    if ($activateElement.length > 0) {

                        $($activateElement).addClass('active');

                    }

                    if ($successContainerSelector && $successContainerSelector.length > 0) {

                        $($successContainerSelector).addClass('success');

                    }

                    $($blockedElement).unblock();

                    console.log("success");
                }
            }
        );  
    }
}