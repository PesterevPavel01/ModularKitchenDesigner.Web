<?
enqueue_template_part_styles_scripts( __DIR__, "remove-customer-form");
?>
<form class="remove-modal-form  modal fade" data-ajax-default-content-updater="refresh" id="remove-customer-modal" tabindex="-1" <?/*onsubmit = "return save_сhanges(event)"*/?>>
    
    <input type="hidden" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#remove-customer-modal">
    <input type="hidden" id="TEMPLATE_PART" name = "TEMPLATE_PART" value = "parts/catalog/account/remove-customer-action/template">
    <input type="hidden" id="action" name = "action" value="default_content_updater">
    <input type="hidden" id="TARGET_CONTEINER"  name = "TARGET_CONTEINER" value="#remove-customer-result">
    <input type="hidden" id="DEPENDENT_FORM"  name = "DEPENDENT_FORM" value="#approval-customer-section">
    <input type="hidden" id="remove-customer-login" name = "CUSTOMER_LOGIN" value="">
    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="title">Удаление пользователя: <span id="remove-customer-name"></span></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start m-0 gap-2">
                <p class="m-0">Вы собираетесь удалить пользователя!</p>
                <!-- Дополнительные поля формы -->
                <div class="remove-customer-result w-100" id = 'remove-customer-result'>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Удалить</button>
            </div>
        </div>
    </div>
</form>