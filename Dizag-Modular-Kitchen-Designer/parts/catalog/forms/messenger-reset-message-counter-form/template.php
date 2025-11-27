<form id = "catalog-messenger-counter-reset-form" data-ajax-default-content-updater>

    <input type="hidden" data-no-reset="true" name="TEMPLATE_PART" value="parts/catalog/forms/messenger-reset-message-counter-form/action/template">
    <input type="hidden" data-no-reset="true" name="action" value="default_content_updater">
    <input type="hidden" data-no-reset="true" name="TARGET_CONTAINER" value="#catalog-order-item-message-counter">
    <input type="hidden" data-no-reset="true" name="TARGET_CONTAINER_MOBILE" value="#catalog-order-item-message-counter-mobile">
    <input type="hidden" data-no-reset="true" name="SUCCESS_CONTAINER" value="#catalog-order-item-messenger">
    <input type="hidden" name = "MESSEGE_COUNTER_VALUE" value=<?=sanitize_text_field($args['MESSEGE_COUNTER_VALUE'])?>>

</form>