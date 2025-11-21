
<?
//отправка формы инициируется в скрипте в шаблоне facade-configurator
$componentType = isset($args['COMPONENT_TYPE']) ? sanitize_text_field($args['COMPONENT_TYPE']) : "";

if($componentType === "")
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => "Не указан тип компонента!"
    ]);
?>

<form id = "configurator-blueprints-<?=$componentType?>-reset-form" data-ajax-default-content-updater="refresh">

    <input type="hidden" data-no-reset="true" name="BLOCKED_ELEMENT" value="#custom-<?=$componentType?>-blueprints-form">

    <input type="hidden" data-no-reset="true" name="TEMPLATE_PART" value="parts/catalog/orders/configurator-blueprints/template">

    <input type="hidden" data-no-reset="true" name="action" value="default_content_updater">

    <input type="hidden" data-no-reset="true" name="TARGET_CONTAINER" value="#<?=strtolower($componentType)?>-collapse-content">

    <input type="hidden" data-no-reset="true" name="COMPONENT_TYPE" value="<?=$componentType?>">

</form>