<?
enqueue_template_part_styles_scripts( __DIR__, "remove-order-form");
?>
<form class="remove-order-modal modal fade" data-ajax-default-content-updater="refresh" id="remove-order-modal" tabindex="-1">

    <input type="hidden" data-no-reset="true" name = "BLOCKED_ELEMENT" value = "#remove-order-modal">
    <input type="hidden" data-no-reset="true" name = "TEMPLATE_PART" value = "parts/catalog/forms/remove-order-form/action/template">
    <input type="hidden" data-no-reset="true" name = "action" value="default_content_updater">
    <input type="hidden" data-no-reset="true" name = "TARGET_CONTAINER" value="#remove-order-result">
    <input type="hidden" data-no-reset="true" name = "SUCCESS_CONTAINERS[]" value="#remove-order-modal-dialog">
    <?/*<input type="hidden" data-no-reset="true" name = "SUCCESS_CONTAINERS[]" value="#второй элемент">*/?>
    <input type="hidden" data-no-reset="true" name = "POST_FORM_DELAY" value="3000">
    <input type="hidden" data-no-reset="true" name = "DEPENDENT_FORM" value="#order-list-parameters-form">
    <input type="hidden" data-no-reset="true" name = "DEPENDENT_FORM_SECOND" value="#catalog-last-events-reset-form">
    <input type="hidden" data-no-reset="true" name = "USER" value="">
    <input type="hidden" id="remove-order-code" name = "ORDER_CODE" value="">
    
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