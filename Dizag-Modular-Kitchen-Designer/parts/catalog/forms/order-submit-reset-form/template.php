
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

}
?>

<form id = "order-submit-reset-form" data-ajax-default-content-updater="refresh">

    <input type="hidden" data-no-reset="true" name="BLOCKED_ELEMENT" value="#order-submit-block">

    <input type="hidden" data-no-reset="true" name="TEMPLATE_PART" value="parts/catalog/forms/order-submit-form/template">

    <input type="hidden" data-no-reset="true" name="action" value="default_content_updater">

    <input type="hidden" data-no-reset="true" name="DELAY" value="2000">

    <input type="hidden" data-no-reset="true" name="TARGET_CONTAINER" value="#order-submit-block">
    
    <input type="hidden" data-no-reset="true" name="ORDER_CODE" value="<?=$orderCode?>">

    <input type="hidden" data-no-reset="true" name="ACTIVE" value="<?=true?>">

    <input type="hidden" data-no-reset="true" name="USER" value="<?=$user?>">

    <input type="hidden" data-no-reset="true" name="ROLE" value="<?=$role?>">

    <input type="hidden" data-no-reset="true" name="NAME" value="RESET">

</form>