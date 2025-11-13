$(document).ready(AjaxCatalogFileContentUpdaterInit);

function  AjaxCatalogFileContentUpdaterInit()
{
    $(document).on('submit', '[data-ajax-file-content-updater]', function(e) {
        e.preventDefault();
        CatalogFileContentUpdaterHandler($(this));
    });
}

function CatalogFileContentUpdaterHandler($form) {
    const $blockedElement = $form.find('input[name="BLOCKED_ELEMENT"]').val();
    const $targetContainer = $form.find('input[name="TARGET_CONTAINER"]').val();
    const $dependentForm = $form.find('input[name="DEPENDENT_FORM"]').val();
    
    // Создаем FormData вместо serialize()
    const formData = new FormData($form[0]);
    
    // Добавляем nonce для безопасности (рекомендуется)
    formData.append('nonce', ar_params.ajax_nonce); // если у вас есть nonce
    
    console.log('FormData created, files count:', $form.find('input[type="file"]')[0].files.length);
    
    $.ajax({
        type: 'POST',
        url: ar_params.ajax_url,
        data: formData,
        processData: false, // Важно: не обрабатывать данные
        contentType: false, // Важно: не устанавливать contentType
        cache: false,
        beforeSend: function(xhr) {
            $($blockedElement).block({
                message: null,
                overlayCSS: {
                    background: `#fff url(${ar_params.preloader_url}) center center no-repeat`,
                    opacity: 0.6
                }
            });
        },
        success: function(data) {
            if ($dependentForm && $dependentForm !== '') {
                $($dependentForm).trigger('submit');
            }
            $($blockedElement).unblock();

            $($targetContainer).html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            $($blockedElement).unblock();
        }
    });
}