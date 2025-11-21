<?
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderRemovalProcessor.php';

global $orderServiceUrl;

$OrderRemovalProcessor = new OrderRemovalProcessor($orderServiceUrl);

if(!$args["ORDER_CODE"]){
    print_r('параметер "ORDER_CODE" не найден!');
    print_r("<br><br>");      
}

$orderCode = sanitize_text_field($args['ORDER_CODE']);

$result = $OrderRemovalProcessor->Process($orderCode);

if(!$result->isSuccess())
{
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => $Result->ErrorMessage,
        'MESSAGE' => $Result->data
    ]);

    return;
}

get_template_part("parts/catalog/account/customer-order-list/template", null, $args);
?>