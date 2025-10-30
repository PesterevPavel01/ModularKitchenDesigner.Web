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
    const $blockedElement = $form.find('#BLOCKED_ELEMENT').val();
    const $targetContainer = $form.find('#TARGET_CONTEINER').val();
    const $dependentForm = $form.find('#DEPENDENT_FORM').val();
    let $activateElement = $();

    //Если нужно выделить элемент этой формы классом 'active', а у других форм группы удалить класс active, при его наличии
    const $activateElementInput = $form.find('input[name="ACTIVATE_ELEMENT_GROUP"]');

    if ($activateElementInput.length) {
        const $activateElementValue = $activateElementInput.val();

        $activateElement = $form.find('[data-form-group="' + $activateElementValue + '"]');
        
        //console.log('Activate Element:', $activateElement);

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
            url: ajax_url,
            data: $form.serialize(),
            beforeSend : function( xhr ){
                $($blockedElement).block({
                    message : null,
                    overlayCSS:{
                        background:  `#fff url(${preloader_url}) center center no-repeat`,
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

                $($blockedElement).unblock();
            }
        }
    );  
}