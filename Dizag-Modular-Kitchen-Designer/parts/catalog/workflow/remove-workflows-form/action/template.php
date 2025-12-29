<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderApprovalWorkflowLoaderProcessor.php';
require_once get_template_directory() . '/core/services/processors/catalog/workflows/WorkflowProvider.php';

global $approvalServiceUrl;
?>
<?$orderCode = isset($args['ORDER_CODE']) ? sanitize_text_field($args['ORDER_CODE']) : "";

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$Result = new BaseResult();

$workflowProvider = new WorkflowProvider($approvalServiceUrl);

$Result = $workflowProvider->RemoveOrderWorkflows($orderCode, $user);

if(!$Result->isSuccess())
{
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => $Result->ErrorMessage,
            'MESSAGE' => $Result->data
        ]);
}

get_template_part("parts/catalog/orders/order/template",null,
    [
        'USER' =>  $user,
        'ORDER_CODE' => $orderCode,
        'ROLE' => $role
    ]);?>