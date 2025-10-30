<?
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderRemovalItemProcessor.php';
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderByCodeProcessor.php';

global $orderServiceUrl;

$OrderItemRemovalProcessor = new OrderItemRemovalProcessor($orderServiceUrl);

if(!$args["ORDER_ITEM_CODE"]){
    print_r('параметер "ORDER_ITEM_CODE" не найден!');
    print_r("<br><br>");      
}

$orderItemCode = sanitize_text_field($args['ORDER_ITEM_CODE']);

$result = $OrderItemRemovalProcessor->Process($orderItemCode);

if(!$result->isSuccess())
{?>
    <p class="error-message"><?=$result->ErrorMessage?></p>
    <?return;
}

$Result = new BaseResult();

$OrderByCodeProcessor = new OrderByCodeProcessor($orderServiceUrl);

$Result = $OrderByCodeProcessor->Process($code);

if(!$Result->isSuccess())
{?>
    <p><?=$Result->ErrorMessage?></p>
    <?return;
}

$Order = $Result->data[0];

get_template_part("parts/catalog/orders/order-specification/template", null,
[
    'MODULES' => $Order['modules']
]);
?>
