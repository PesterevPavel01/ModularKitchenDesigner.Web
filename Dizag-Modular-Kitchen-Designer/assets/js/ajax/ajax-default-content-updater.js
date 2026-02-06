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

    const $blockedElement = $form.find('input[name="BLOCKED_ELEMENT"]').val();

    const $targetContainerMobile = $form.find('input[name="TARGET_CONTAINER_MOBILE"]').val(); //$form.find('#TARGET_CONTEINER').val();

    var $targetContainer = ( $targetContainerMobile && $targetContainerMobile!='' &&  window.innerWidth < 992) ? $targetContainerMobile : $form.find('input[name="TARGET_CONTAINER"]').val(); //$form.find('#TARGET_CONTEINER').val();

    const $dependentForm =  $form.find('input[name="DEPENDENT_FORM"]').val(); //$form.find('#DEPENDENT_FORM').val();

    const $dependentFormSecond =  $form.find('input[name="DEPENDENT_FORM_SECOND"]').val(); //$form.find('#DEPENDENT_FORM').val();
    
    var $errorContainer =  $form.find('input[name="ERROR_CONTAINER"]').val();

    const $errorMobileContainer =  $form.find('input[name="ERROR_CONTAINER_MOBILE"]').val();
    
    if(window.innerWidth < 992 && $errorMobileContainer && $errorMobileContainer !== '')
        $errorContainer = $errorMobileContainer;


    //console.log($errorContainer);
    
    let $activateElement = $();
    
    const $successContainerSelector =  $form.find('input[name="SUCCESS_CONTAINER"]').val();//$form.find('#SUCCESS_CONTAINER').val() || '';
    
    //console.log('$successContainerSelector: ' +$successContainerSelector);
    
    
    const $successContainerSelectors = $form.find('input[name="SUCCESS_CONTAINERS[]"]');

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

        setTimeout(ExecuteAjax, delayMs);

    } else {

        ExecuteAjax();

    }
    
    const $postFormDelay =  $form.find('input[name="POST_FORM_DELAY"]').val(); //$form.find('#DEPENDENT_FORM').val();

    function ExecuteAjax() {

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

                        if($($targetContainer).length){
                            $($targetContainer).html( $arParams.HTML_CONTENT );
                        } 

                        /*Применяем задержку непосредственно перед выполнением зависимых форм, если она задана*/
                        if ($postFormDelay && $postFormDelay !== '') {

                            const delayMs = parseInt($postFormDelay, 10);

                            setTimeout( function() {
                                submitDependentForms([$dependentForm, $dependentFormSecond], $errorContainer)
                            }, delayMs);
                    
                        }else{

                            submitDependentForms([$dependentForm, $dependentFormSecond]);

                        }

                    }

                    if ($activateElement.length > 0) {

                        $($activateElement).addClass('active');

                    }

                    if ($successContainerSelector && $successContainerSelector.length > 0) {

                        $($successContainerSelector).addClass('success');

                    }

                    if ($successContainerSelectors.length > 0) {

                        $successContainerSelectors.each(function() {

                            const selector = $(this).val();

                            console.log(this);

                            if (selector && selector.trim() !== '') {
                                const $element = $(selector);
                                if ($element.length > 0) {
                                    $element.addClass('success');
                                }
                            }

                        });
                    }

                    $($blockedElement).unblock();
                }
            }
        );  
    }
}

function submitDependentForms(dependentForms, errorContainer) {
    
    // Проверка на массив
    if (!Array.isArray(dependentForms)) {
        console.error('submitDependentForms: expected array, got', dependentForms);
        return;
    }

    const [$form1, $form2] = dependentForms;
    const $errorContainer = errorContainer;
    
    if ($form1 && $form1 !== '') {
        $($form1).trigger('submit');
    }
    if ($form2 && $form2 !== '') {
        $($form2).trigger('submit');
    }
    if($($errorContainer).length) {
        $($errorContainer).html("");
    }
}