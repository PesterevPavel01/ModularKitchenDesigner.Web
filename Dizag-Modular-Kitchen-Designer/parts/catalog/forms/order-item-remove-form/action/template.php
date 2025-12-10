<?
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderItemRemovalProcessor.php';
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderByCodeProcessor.php';

global $orderServiceUrl;

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$OrderItemRemovalProcessor = new OrderItemRemovalProcessor($orderServiceUrl, $user);

$moduleCode = sanitize_text_field($args['MODULE_CODE']);

$orderCode = sanitize_text_field($args['ORDER_CODE']);

$result = new BaseResult();

$result = $OrderItemRemovalProcessor->Process($orderCode, $moduleCode);

if(!$result->isSuccess())
{
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => $result->ErrorMessage,
        'MESSAGE' => $result->data,
    ]);
}

get_template_part("parts/catalog/orders/order-specification/template",null,
    [
        'USER' => $user,
        'ROLE' => $role,
        'ORDER_CODE' => $orderCode
    ]);
