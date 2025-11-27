<?
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderItemRemovalProcessor.php';
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderByCodeProcessor.php';

global $orderServiceUrl;

$OrderItemRemovalProcessor = new OrderItemRemovalProcessor($orderServiceUrl);

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

$OrderByCodeProcessor = new OrderByCodeProcessor($orderServiceUrl);

$Result = $OrderByCodeProcessor->Process($orderCode);

if(!$Result->isSuccess())
{
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => $Result->ErrorMessage,
            'MESSAGE' => $Result->data
        ]);
    return;
}

$order = $Result->data[0];

get_template_part("parts/catalog/orders/order-item-list/template",null,
[
    'ORDER_CODE' =>  $orderCode,
    'MODULES' =>  $order['modules'],
    'IS_COMPLETED' => $order['isCompleted'],
    'USER' => $args['USER'],
    'ROLE' => $args['ROLE'],
]);
