<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderApprovalWorkflowLoaderProcessor.php';
require_once get_template_directory() . '/core/services/processors/catalog/workflows/WorkflowProvider.php';
?>
<?

global $approvalServiceUrl;

$orderCode = isset($args['ORDER_CODE']) ? sanitize_text_field($args['ORDER_CODE']) : null;

if(!$orderCode)
    return;

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$Result = new BaseResult();

$OrderApprovalWorkflowLoaderProcessor = new OrderApprovalWorkflowLoaderProcessor($approvalServiceUrl);

$Result = $OrderApprovalWorkflowLoaderProcessor->Process(sanitize_text_field($orderCode));

if(!$Result->isSuccess())
{

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => $Result->ErrorMessage,
            'MESSAGE' => $Result->data
        ]);

    $errors++;

    return;
}

$workflows = $Result->data;
?>
<?
if(empty($workflows) && $args['ACTIVE'] && $args['ROLE'] === 'customer') {?>
    
    <form class="d-flex flex-column justify-content-start align-items-center gap-1 flex-xl-row justify-content-xl-end m-0 w-100" data-ajax-default-content-updater="refresh" id = "order-submit-form">

        <input type="hidden" data-no-reset="true" name = "BLOCKED_ELEMENT" value = "#order-submit-form">
        <input type="hidden" data-no-reset="true" name = "TEMPLATE_PART" value = "parts/catalog/forms/order-submit-form/action/template">
        <input type="hidden" data-no-reset="true" name = "action" value="default_content_updater">
        <input type="hidden" data-no-reset="true" name = "TARGET_CONTAINER" value="#order-submit-block">
        <input type="hidden" data-no-reset="true" name="ERROR_CONTAINER" value="#catalog-order-item-list-errors">
        <input type="hidden" data-no-reset="true" name="DEPENDENT_FORM" value="#order-submit-reset-form">
        <input type="hidden" data-no-reset="true" name = "DEPENDENT_FORM_SECOND" value="#order-item-send-to-configurator-form-">
        <input type="hidden" name = "ORDER_CODE" value = "<?=$orderCode?>">
        <input type="hidden" data-no-reset="true" name="USER" value="<?=$user?>">
        <input type="hidden" data-no-reset="true" name="ROLE" value="<?=$role?>">
        <?// $args['ACTIVE'] = true - значит заказ запущен в работу?>

        <button type="submit" class="ajax-update-button btn btn-primary m-0 w-100 border"
            data-bs-toggle="tooltip" 
            data-bs-placement="top"    
            title="Заказать">
            Заказать
        </button>

    </form>

    <?}else if(!empty($workflows)){

        $activeWorkflows = [];

        $activeWorkflows = array_filter($workflows, function($item)
            {
                return $item['isCompleted'] === false;
            }
        );

        if(empty($activeWorkflows)){?>

            <small class="error-message black text-center border p-2 m-width-200 w-100">Заказ оформлен!</small>

        <?}else{?>

            <?if($user === ''){

                get_template_part("parts/catalog/errors/default-error-message/template", null, 
                [
                    'TITLE' => 'Не найден логин!',
                ]);

            }else{
                
                get_template_part("parts/catalog/workflow/approval-form/template", null,
                [
                    'WORKFLOWS' => $activeWorkflows,
                    'USER' =>  $user,
                    'ORDER_CODE' => $orderCode,
                    'ROLE' => $role
                ]);

            }?>
        <?}?>

    <?}?>