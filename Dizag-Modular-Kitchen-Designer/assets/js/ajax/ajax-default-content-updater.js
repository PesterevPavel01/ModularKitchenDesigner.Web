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
    data = $form.serialize();

    //console.log(data);
    
    const $blockedElement = $form.find('input[name="BLOCKED_ELEMENT"]').val();

    const $targetContainer = $form.find('input[name="TARGET_CONTAINER"]').val(); //$form.find('#TARGET_CONTEINER').val();

    const $dependentForm =  $form.find('input[name="DEPENDENT_FORM"]').val(); //$form.find('#DEPENDENT_FORM').val();

    let $activateElement = $();
    
    const $successContainerSelector =  $form.find('input[name="SUCCESS_CONTAINER"]').val();//$form.find('#SUCCESS_CONTAINER').val() || '';

    console.log('$successContainerSelector: ' +$successContainerSelector);


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

    /*
    const serializedData = $form.serialize();

    console.log('Serialized data:', serializedData); */
 
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

                $($targetContainer).html( data );

                if ($dependentForm && $dependentForm !== '') {

                    $($dependentForm).trigger('submit');

                }

                if ($activateElement.length > 0) {

                    $($activateElement).addClass('active');

                }

                if ($successContainerSelector && $successContainerSelector.length > 0) {

                    $($successContainerSelector).addClass('success');

                }

                $($blockedElement).unblock();
            }
        }
    );  
}