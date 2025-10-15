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
    
    console.log($form.find('#TEMPLATE_PART').val());
    console.log($form.find('#TARGET_CONTEINER').val());
    const serializedData = $form.serialize();

    console.log('Serialized data:', serializedData);
    
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
                        opacity: 0.6
                    }
                })
            },
            success : function( data ){
                $($targetContainer).html( data );
                if ($dependentForm && $dependentForm !== '') {
                    $($dependentForm).trigger('submit');
                }
                $($blockedElement).unblock();
            }
        }
    );
}