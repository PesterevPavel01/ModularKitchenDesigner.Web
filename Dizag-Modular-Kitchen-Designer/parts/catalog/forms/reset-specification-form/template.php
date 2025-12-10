
<?
//отправка формы инициируется в скрипте в шаблоне facade-configurator

$orderCode = isset($args['ORDER_CODE']) ? sanitize_text_field($args['ORDER_CODE']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

if($orderCode === ""){

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => "Не указан код заказа"
    ]);

    return;
}

$activeModuleCode = isset($args['ACTIVE_MODULE_CODE']) ? sanitize_text_field($args['ACTIVE_MODULE_CODE']) : "";
?>

<form id = "catalog-order-item-specification-reset-form" data-ajax-default-content-updater>

<?/*<input type="hidden" data-no-reset="true" name="BLOCKED_ELEMENT" value="#catalog-order-item-messanger">*/?>
<input type="hidden" data-no-reset="true" name="TEMPLATE_PART" value="parts/catalog/orders/order-specification/template">
<input type="hidden" data-no-reset="true" name="action" value="default_content_updater">
<input type="hidden" data-no-reset="true" name="TARGET_CONTAINER" value="#catalog-order-specification-section">
<input type="hidden" data-no-reset="true" name= "DEPENDENT_FORM" value="#catalog-order-item-messenger-reset-form">
<input type="hidden" data-no-reset="true" name="ERROR_CONTAINER" value="#catalog-order-messenger-errors">
<input type="hidden" name = "ACTIVE_MODULE_CODE" value=<?=$activeModuleCode?>>
<input type="hidden" name = "ORDER_CODE" value=<?=$orderCode?>>
<input type="hidden" data-no-reset="true" name="USER" value="<?=esc_html($args['USER'])?>">
<input type="hidden" data-no-reset="true" name="ROLE" value="<?=esc_html($args['ROLE'])?>">

</form>