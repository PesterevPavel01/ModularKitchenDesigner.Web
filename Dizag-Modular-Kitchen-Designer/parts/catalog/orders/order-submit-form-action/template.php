<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/ApprovalWorkflowsInitiatorProcessor.php';
?>
<?

global $approvalServiceUrl;

$orderCode = isset($args['ORDER_CODE']) ? $args['ORDER_CODE'] : null;

if(!$orderCode)
    return;

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$ApprovalWorkflowsInitiatorProcessor = new ApprovalWorkflowsInitiatorProcessor($approvalServiceUrl);

$Result = $ApprovalWorkflowsInitiatorProcessor->Process(sanitize_text_field($orderCode));

if(!$Result->isSuccess())
{?>
    <p class = "black"><?=$Result->ErrorMessage?></p>
<?}

get_template_part("parts/catalog/orders/order-submit-form/template",null,
[
    'ORDER_CODE' =>  $orderCode,
    'ACTIVE' => true,
    'USER' => $user,
    'ROLE' => $role,
    
]);?>