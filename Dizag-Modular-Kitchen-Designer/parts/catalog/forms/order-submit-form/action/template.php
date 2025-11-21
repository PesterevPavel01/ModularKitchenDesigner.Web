<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/ApprovalWorkflowsInitiatorProcessor.php';
?>
<?

global $approvalServiceUrl;

$orderCode = isset($args['ORDER_CODE']) ? $args['ORDER_CODE'] : null;

if(!$orderCode)
    return;

$errors = 0;

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$ApprovalWorkflowsInitiatorProcessor = new ApprovalWorkflowsInitiatorProcessor($approvalServiceUrl);

$Result = $ApprovalWorkflowsInitiatorProcessor->Process(sanitize_text_field($orderCode));

if(!$Result->isSuccess())
{
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => $Result->ErrorMessage,
        'MESSAGE' => $Result->data === 'Order Items not found!' ? "Не добавлено ни одного фасада!" : $Result->data
    ]);

    $errors++;
}

if ($errors !== 0 && isset($GLOBALS['set_template_data']) && is_callable($GLOBALS['set_template_data'])) {

    $GLOBALS['set_template_data']('ERRORS', true);

}
else{

    get_template_part("parts/catalog/orders/order-submit-form/template",null,
    [
        'ORDER_CODE' =>  $orderCode,
        'ACTIVE' => true,
        'USER' => $user,
        'ROLE' => $role,
        
    ]);

}
?>