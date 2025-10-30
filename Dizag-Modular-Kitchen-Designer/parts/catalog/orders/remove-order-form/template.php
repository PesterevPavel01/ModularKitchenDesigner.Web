<?
enqueue_template_part_styles_scripts( __DIR__, "remove-order-form");
?>
<form class="remove-order-modal modal fade" data-ajax-default-content-updater="refresh" id="remove-order-modal" tabindex="-1">
    
    <input type="hidden" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#remove-order-modal">
    <input type="hidden" id="TEMPLATE_PART" name = "TEMPLATE_PART" value = "parts/catalog/orders/remove-order-form-action/template">
    <input type="hidden" id="action" name = "action" value="default_content_updater">
    <input type="hidden" id="TARGET_CONTEINER"  name = "TARGET_CONTEINER" value="#remove-order-result">
    <input type="hidden" id="DEPENDENT_FORM"  name = "DEPENDENT_FORM" value="#order-list-parameters-form">
    <input type="hidden" id="remove-order-code" name = "ORDER_CODE" value="">
    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="title">Удаление заказа: <span id="remove-order-title"></span></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start m-0 gap-2">
                <p class="m-0">Вы собираетесь удалить заказ!</p>
                <!-- Дополнительные поля формы -->
                <div class="remove-order-result" id = 'remove-order-result'>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Удалить</button>
            </div>
        </div>
    </div>
</form>