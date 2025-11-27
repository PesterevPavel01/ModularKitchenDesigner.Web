
<form id = "catalog-order-item-messenger-reset-form" data-ajax-default-content-updater>

    <?/*<input type="hidden" data-no-reset="true" name="BLOCKED_ELEMENT" value="#catalog-order-item-messanger">*/?>
    <input type="hidden" data-no-reset="true" name="TEMPLATE_PART" value="parts/catalog/forms/messenger-reset-form/action/template">
    <input type="hidden" data-no-reset="true" name="action" value="default_content_updater">
    <input type="hidden" data-no-reset="true" name="TARGET_CONTAINER" value="#catalog-order-item-messenger">
    <input type="hidden" data-no-reset="true" name="TARGET_CONTAINER_MOBILE" value="#catalog-order-item-messenger-mobile">
    <input type="hidden" data-no-reset="true" name= "DEPENDENT_FORM" value="#catalog-messenger-counter-reset-form">
    <input type="hidden" data-no-reset="true" name="ERROR_CONTAINER" value="#catalog-order-messenger-errors">
    <input type="hidden" name = "MODULE_CODE" value=<?=esc_html($args['MODULE_CODE'])?>>
    <input type="hidden" name = "ORDER_CODE" value=<?=esc_html($args['ORDER_CODE'])?>>
    <input type="hidden" name = "IS_COMPLETED" value=<?=sanitize_text_field($args['IS_COMPLETED'])?>>
    <input type="hidden" data-no-reset="true" name="USER" value="<?=esc_html($args['USER'])?>">
    <input type="hidden" data-no-reset="true" name="ROLE" value="<?=esc_html($args['ROLE'])?>">

</form>