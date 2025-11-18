<?
enqueue_template_part_styles_scripts( __DIR__, "remove-order-form");
?>
<form class="remove-order-modal modal fade" data-ajax-default-content-updater="refresh" id="remove-order-modal" tabindex="-1">
    
    <input type="hidden" name = "BLOCKED_ELEMENT" value = "#remove-order-modal">
    <input type="hidden" name = "TEMPLATE_PART" value = "parts/catalog/orders/remove-order-form-action/template">
    <input type="hidden" name = "action" value="default_content_updater">
    <input type="hidden" name = "TARGET_CONTAINER" value="#customer-account-order-list">
    <input type="hidden" name = "SUCCESS_CONTAINER" value="#remove-order-modal-dialog">
    <input type="hidden" id="remove-order-code" name = "ORDER_CODE" value="">
    <?//Актуальные параметры фильтра для шаблона?>
    <input type="hidden" name = "ASCENDING" value="">
    <input type="hidden" name = "INCOMPLETE_ONLY" value="">
    <input type="hidden" name = "CUSTOM_ONLY" value="">
    <input type="hidden" name = "PERIOD" value=30>
    
    <div class="modal-dialog" id = "remove-order-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="title">Удаление заказа: <span id="remove-order-title"></span></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start m-0 gap-2">
                <p class="m-0 message">Вы собираетесь удалить заказ!</p>
                <p class="m-0 success-message">Заказ удален!</p>
                <!-- Дополнительные поля формы -->
                <div class="remove-order-result" id = 'remove-order-result'>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary" id = "remove-order-item-button">Удалить</button> <?//id нужен для стилей?>
            </div>
        </div>
    </div>
</form>