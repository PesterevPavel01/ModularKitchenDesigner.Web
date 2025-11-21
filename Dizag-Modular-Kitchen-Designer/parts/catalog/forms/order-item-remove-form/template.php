<?
enqueue_template_part_styles_scripts( __DIR__, "remove-order-item-form");
?>

<form class="remove-order-item-modal modal fade" data-ajax-default-content-updater="refresh" id="remove-order-item-modal" tabindex="-1">

    <input type="hidden" name = "BLOCKED_ELEMENT" value = "#catalog-order-item-list">
    <input type="hidden" name = "TEMPLATE_PART" value = "parts/catalog/forms/order-item-remove-form/action/template">
    <input type="hidden" name = "action" value="default_content_updater">
    <input type="hidden" name = "TARGET_CONTAINER" value="#catalog-section-order">
    <input type="hidden" name = "SUCCESS_CONTAINER" value="#remove-order-item-modal-dialog">
    <input type="hidden" id="DEPENDENT_FORM"  name = "DEPENDENT_FORM" value="#order-submit-reset-form">
    <input type="hidden" name = "ACTIVATE_ELEMENT_GROUP" value="remove-order-item-button">
    <input type="hidden" id="remove-order-item-code" name = "MODULE_CODE" value="">
    <input type="hidden" id="order-code" name = "ORDER_CODE" value = "">
    
    <div class="modal-dialog" id = "remove-order-item-modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <p class="title">Удаление элемента: <span id="remove-order-item-title"></span></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body d-flex flex-column justify-content-start align-items-start m-0 gap-2">
                <p class="m-0 message">Вы собираетесь удалить элемент!</p>
                <p class="m-0 success-message">Элемент удален!</p>
                <??>
                <!-- Дополнительные поля формы -->
                <div class="remove-order-result" id = 'remove-order-result'>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary" id = "remove-order-item-button">Удалить</button>  <?//id нужен для стилей?>
            </div>

        </div>

    </div>

</form>