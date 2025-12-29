<?
$orderCode = isset($args['ORDER_CODE']) ? sanitize_text_field($args['ORDER_CODE']) : null;

if(!$orderCode)
    return;

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

if($args['ROLE'] === 'constructor') {?>
    
    <form class="d-flex flex-column justify-content-start align-items-center gap-1 flex-xl-row justify-content-xl-end m-0 w-100" data-ajax-default-content-updater="refresh" id = "order-approval-reject-form">

        <input type="hidden" data-no-reset="true" name = "BLOCKED_ELEMENT" value = "#catalog-section-order">
        <input type="hidden" data-no-reset="true" name = "TEMPLATE_PART" value = "parts/catalog/workflow/remove-workflows-form/action/template">
        <input type="hidden" data-no-reset="true" name = "action" value="default_content_updater">
        <input type="hidden" data-no-reset="true" name = "TARGET_CONTAINER" value="#catalog-section-order">
        <input type="hidden" data-no-reset="true" name="DEPENDENT_FORM" value="#order-submit-reset-form">
        <input type="hidden" data-no-reset="true" name="DEPENDENT_FORM_SECOND" value="#order-item-send-to-configurator-form-">
        <input type="hidden" name = "ORDER_CODE" value = "<?=$orderCode?>">
        <input type="hidden" data-no-reset="true" name="USER" value="<?=$user?>">
        <input type="hidden" data-no-reset="true" name="ROLE" value="<?=$role?>">

        <button type="submit" class="ajax-update-button btn btn-primary m-0 w-100 border"
            data-bs-toggle="tooltip" 
            data-bs-placement="top"    
            title="Удалить все процессы согласования у заказа!">
            Отменить
        </button>

    </form>
<?}