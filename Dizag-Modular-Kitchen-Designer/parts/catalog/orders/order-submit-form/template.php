<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderApprovalWorkflowLoaderProcessor.php';
?>
<?
global $approvalServiceUrl;

$orderCode = isset($args['ORDER_CODE']) ? $args['ORDER_CODE'] : null;

if(!$orderCode)
    return;

$Result = new BaseResult();

$OrderApprovalWorkflowLoaderProcessor = new OrderApprovalWorkflowLoaderProcessor($approvalServiceUrl);

$Result = $OrderApprovalWorkflowLoaderProcessor->Process(sanitize_text_field($orderCode));

if(!$Result->isSuccess())
{?>
    <p><?=$Result->ErrorMessage?></p>
    <?return;
}
//Необходимо получить данные о состоянии заказа, если вернется пустой список, значит нет запущенных процессов согласования 
?>

<form class="d-flex flex-column justify-content-start align-items-center gap-1 flex-xl-row justify-content-xl-end m-0" data-ajax-default-content-updater="refresh" id = "order-submit-form">

    <input type="hidden" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#order-submit-form">
    <input type="hidden" id="TEMPLATE_PART" name = "TEMPLATE_PART" value = "parts/catalog/orders/order-submit-form-action/template">
    <input type="hidden" id="action" name = "action" value="default_content_updater">
    <input type="hidden" id="TARGET_CONTEINER"  name = "TARGET_CONTEINER" value="#order-submit-block">
    <input type="hidden" id="modules" name = "MODULES" value = "<?=$args['MODULES']?>">
    <input type="hidden" id="order-code" name = "ORDER_CODE" value = "<?=sanitize_text_field($orderCode)?>">

    <?if(empty($Result->data[0]) && !empty($args['MODULES']) ){?>

        <button type="submit" class="ajax-update-button btn btn-primary m-0"
            data-bs-toggle="tooltip" 
            data-bs-placement="top"    
            title="Заказать">
            Заказать
        </button>

    <?}else if(!empty($Result->data[0])){?>

        <p class="error-message black text-center border p-2">Заказ оформлен!</p>

    <?}?>
</form>