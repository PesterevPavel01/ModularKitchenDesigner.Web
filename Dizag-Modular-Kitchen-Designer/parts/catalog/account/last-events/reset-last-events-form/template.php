
<?
//отправка формы инициируется в скрипте в шаблоне facade-configurator

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$activeModuleCode = isset($args['ACTIVE_MODULE_CODE']) ? sanitize_text_field($args['ACTIVE_MODULE_CODE']) : "";
?>

<form id = "catalog-last-events-reset-form" data-ajax-default-content-updater>

    <input type="hidden" data-no-reset="true" name="TEMPLATE_PART" value="parts/catalog/account/last-events/template">
    <input type="hidden" data-no-reset="true" name="action" value="default_content_updater">
    <input type="hidden" data-no-reset="true" name="TARGET_CONTAINER" value="#last-events-section">
    <input type="hidden" data-no-reset="true" name="USER" value="<?=esc_html($args['USER'])?>">
    <input type="hidden" data-no-reset="true" name="ROLE" value="<?=esc_html($args['ROLE'])?>">

</form>